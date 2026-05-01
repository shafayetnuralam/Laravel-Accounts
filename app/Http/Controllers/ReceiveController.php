<?php

namespace App\Http\Controllers;

use App\Models\Receive;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ReceiveController extends Controller
{
    //
     public function getReceivesData(Request $request)
    {
        $query = Receive::query();
        $query->leftJoin('accounts_setup', 'account_receive.accounts_id', '=', 'accounts_setup.id')
              ->select('account_receive.*', 'accounts_setup.accounts_name', 'accounts_setup.sector_name', 'accounts_setup.mobile_no', 'accounts_setup.category', 'accounts_setup.opening_balance');

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
        $totalRecords = Receive::count();
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
        $receives = $query->get();

        // Format data for DataTable
        $data = [];
        $sn = $request->start + 1;
        
        foreach ($receives as $receive) {
            $entryTime = date("h:i:s a", strtotime($receive->CreateDate));
            $entryDate = date("d/m/Y", strtotime($receive->entry_date));
            $accountsInfo =  "<span class=\"badge badge-warning\">{$receive->accounts_name}</span> <span class=\"badge badge-success\">{$receive->sector_name}</span> <span class=\"badge badge-info\">{$receive->mobile_no}</span>";

            $remarksSort = Str::words($receive->remarks, 10, '...');
            // continue after remarksSort words, if there are more words then show ... at the end of the string
            $remarksDetails = $receive->remarks;

            $remarks = "<details>
                        <summary>{$remarksSort}</summary>
                        <p>{$remarksDetails}</p>
                    </details>";

            $data[] = [
                $sn++,
                htmlspecialchars($receive->invoice_no),
                htmlspecialchars($entryDate),
                htmlspecialchars($entryTime),
                ($accountsInfo),
                htmlspecialchars($receive->pay_mode),
                htmlspecialchars($receive->amount),
                $remarks,
              
                "<a href='#' class='btn btn-sm btn-info edit-btn' data-id='{$receive->id}'>Edit {$receive->id}</a>
                 <a href='#' class='btn btn-sm btn-danger delete-btn' data-id='{$receive->id}'>Delete</a>"
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
     * Show the form for creating a new Receive
     */
    public function create()
    {
        return view('modalReceivesInsert');
    }

    /**
     * Show the form for editing the specified Receive
     */
    public function edit($id)
    {
        $receive = Receive::findOrFail($id);
        // return view('modalReceivesUpdate', $id);
        return view('modalReceivesUpdate', compact('receive'));
    }

    /**
     * Store a newly created receive
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'accounts_id' => 'required|exists:accounts_setup,id',
            'pay_mode' => 'required|string|in:Cash,Bank,Cheque,Online',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
            'invoice_no' => 'nullable|unique:account_receive,invoice_no|string|max:255',
            'remarks' => 'nullable|string',
        ], [
            'invoice_no.unique' => 'This invoice number is already used. Please enter a different one.'
        ]);

        Receive::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Receive created successfully'
        ]);
    }

    /**
     * Update the specified receive
     */
    public function update(Request $request, $id)
    {
        $receive = Receive::findOrFail($id);

        $validated = $request->validate([
            'accounts_id' => 'required|exists:accounts_setup,id',
            'pay_mode' => 'required|string|in:Cash,Bank,Cheque,Online',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
            'invoice_no' => 'nullable|unique:account_receive,invoice_no,' . $id . '|string|max:255',
            'remarks' => 'nullable|string',

        ], [
            'invoice_no.unique' => 'This invoice number is already used. Please enter a different one.'
        ]);

        $receive->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Receive updated successfully'
        ]);
    }

    /**
     * Check for duplicate invoice number
     */
    public function checkDuplicate(Request $request)
    {
        $exists = Receive::where('invoice_no', $request->invoice_no)
                        ->when($request->has('receive_id') && $request->receive_id, function ($query) use ($request) {
                            return $query->where('id', '!=', $request->receive_id);
                        })
                        ->exists();

        return response()->json([
            'exists' => $exists,
            'invoice_no' => $request->invoice_no,
            'message' => $exists ? 'A receive with this invoice number already exists.' : 'Invoice number is unique.'
        ]);
    }

    // Get Last invoice Use for auto generate invoice number
    public function getLastInvoice()
    {
        $lastReceive = Receive::orderBy('id', 'desc')->first();
        $lastInvoiceNo = $lastReceive ? $lastReceive->invoice_no : 0;
        $nextInvoiceNo = $lastInvoiceNo ? $lastInvoiceNo + 1 : 1;
        return response()->json([
            'last_invoice_no' => $nextInvoiceNo
        ]);
    }


        public function destroy($id)
    {
        $receive = Receive::findOrFail($id);
        $receive->delete();

        return response()->json([
            'success' => true,
            'message' => 'Receive deleted successfully'
        ]);
    }
}
