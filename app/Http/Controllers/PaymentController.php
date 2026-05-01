<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PaymentController extends Controller
{
    //

    //
     public function getPaymentsData(Request $request)
    {
        $query = Payment::query();
        $query->leftJoin('accounts_setup', 'account_payment.accounts_id', '=', 'accounts_setup.id')
              ->select('account_payment.*', 'accounts_setup.accounts_name', 'accounts_setup.sector_name', 'accounts_setup.mobile_no', 'accounts_setup.category', 'accounts_setup.opening_balance');

        // Handle search
        if ($request->has('search') && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('pay_mode', 'like', "%{$searchValue}%")
                  ->orWhere('amount', 'like', "%{$searchValue}%")
                  ->orWhere('remarks', 'like', "%{$searchValue}%")
                  ->orWhere('accounts_name', 'like', "%{$searchValue}%")
                  ->orWhere('sector_name', 'like', "%{$searchValue}%")
                  ->orWhere('invoice_no', 'like', "%{$searchValue}%");
            });
        }

        // Get total records before filtering
        $totalRecords = Payment::count();
        $filteredRecords = $query->count();

        // Handle sorting
        if ($request->has('order') && !empty($request->order)) {
            $columns = [
                0 => 'id', // SL column (not sortable)
                1 => 'invoice_no',
                2 => 'entryDate',
                3 => 'entryTime',
                4 => 'accounts_name',
                5 => 'pay_mode',
                6 => 'amount',
                7 => 'remarks'
            ];
            $columnIndex = $request->order[0]['column'];
            $direction = $request->order[0]['dir'];
            

            if (isset($columns[$columnIndex]) && $columnIndex != 0 && $columnIndex != 9) {
                $query->orderBy($columns[$columnIndex], $direction);
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        // Handle pagination
        if ($request->length != -1) {
            $query->skip($request->start)->take($request->length);
        }
        // Limit coluums
         $query->limit(100);
        $payments = $query->get();

        // Format data for DataTable
        $data = [];
        $sn = $request->start + 1;
        
        foreach ($payments as $payment) {
            $entryTime = date("h:i:s a", strtotime($payment->CreateDate));
            $entryDate = date("d/m/Y", strtotime($payment->entry_date));
            $accountsInfo =  "<span class=\"badge badge-warning\">{$payment->accounts_name}</span> <span class=\"badge badge-success\">{$payment->sector_name}</span> <span class=\"badge badge-info\">{$payment->mobile_no}</span>";

            $remarksSort = Str::words($payment->remarks, 10, '...');
            // continue after remarksSort words, if there are more words then show ... at the end of the string
            $remarksDetails = $payment->remarks;

            $remarks = "<details>
                        <summary>{$remarksSort}</summary>
                        <p>{$remarksDetails}</p>
                    </details>";

            $data[] = [
                $sn++,
                htmlspecialchars($payment->invoice_no),
                htmlspecialchars($entryDate),
                htmlspecialchars($entryTime),
                ($accountsInfo),
                htmlspecialchars($payment->pay_mode),
                htmlspecialchars($payment->amount),
                $remarks,
              
                "<a href='#' class='btn btn-sm btn-info edit-btn' data-id='{$payment->id}'>Edit</a>
                 <a href='#' class='btn btn-sm btn-danger delete-btn' data-id='{$payment->id}'>Delete</a>"
            ];
        }

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    
    /**
     * Check for duplicate invoice number
     */
    public function checkDuplicate(Request $request)
    {
        $exists = Payment::where('invoice_no', $request->invoice_no)
                        ->when($request->has('payment_id') && $request->payment_id, function ($query) use ($request) {
                            return $query->where('id', '!=', $request->payment_id);
                        })
                        ->exists();

        return response()->json([
            'exists' => $exists,
            'invoice_no' => $request->invoice_no,
            'message' => $exists ? 'A payment with this invoice number already exists.' : 'Invoice number is unique.'
        ]);
    }

      /**
     * Show the form for creating a new Payment
     */
    public function create()
    {
        return view('modalPaymentsInsert');
    }


    
    /**
     * Store a newly created payment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'accounts_id' => 'required|exists:accounts_setup,id',
            'pay_mode' => 'required|string|in:Cash,Bank,Cheque,Online',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
            'invoice_no' => 'nullable|unique:account_payment,invoice_no|string|max:255',
            'remarks' => 'nullable|string',
        ], [
            'invoice_no.unique' => 'This invoice number is already used. Please enter a different one.'
        ]);

        Payment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment created successfully'
        ]);
    }


    /**
     * Show the form for editing the specified Payment
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('modalPaymentsUpdate', compact('payment')); // view file name should be modalPaymentsUpdate.blade.php
    }

    /**
     * Update the specified payment
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'accounts_id' => 'required|exists:accounts_setup,id',
            'pay_mode' => 'required|string|in:Cash,Bank,Cheque,Online',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
            'invoice_no' => 'nullable|unique:account_payment,invoice_no,' . $id . '|string|max:255',
            'remarks' => 'nullable|string',

        ], [
            'invoice_no.unique' => 'This invoice number is already used. Please enter a different one.'
        ]);

        $payment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully'
        ]);
    }


    

    // Get Last invoice Use for auto generate invoice number
    public function getLastInvoice()
    {
        $lastPayment = Payment::orderBy('id', 'desc')->first();
        $lastInvoiceNo = $lastPayment ? $lastPayment->invoice_no : 0;
        $nextInvoiceNo = $lastInvoiceNo ? $lastInvoiceNo + 1 : 1;
        return response()->json([
            'last_invoice_no' => $nextInvoiceNo
        ]);
    }


        public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully'
        ]);
    }


}
