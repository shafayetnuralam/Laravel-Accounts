<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ResponseController;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Payment;
use App\Models\Receive;


class AccountController extends ResponseController
{
    /**
     * Display a listing of accounts (JSON for AJAX)
     */
    public function allAccountsInfo()
    {
        $accounts = Account::select('id', 'accounts_name', 'category','sector_name')
        ->orderBy('accounts_name', 'ASC')
        ->orderBy('sector_name', 'ASC')
        ->orderBy('category', 'ASC')
        ->get();
        return response()->json($accounts);
    }

        public function receiveInfo()
    {
        $accounts = Account::select('id', 'accounts_name', 'category','sector_name')
        ->where('Status','Active')
        ->whereIn('category', ['Both', 'Receive'])
        ->orderBy('accounts_name', 'ASC')
        ->orderBy('sector_name', 'ASC')
        ->orderBy('category', 'ASC')
        ->get();
        return response()->json($accounts);
    }

      public function paymentInfo()
    {
        $accounts = Account::select('id', 'accounts_name', 'category','sector_name')
        ->where('Status','Active')
        ->whereIn('category', ['Both', 'Payment'])
        ->orderBy('accounts_name', 'ASC')
        ->orderBy('sector_name', 'ASC')
        ->orderBy('category', 'ASC')
        ->get();
        return response()->json($accounts);
    }
    /**
     * Handle DataTable AJAX requests for accounts list
     */
    public function getAccountsData(Request $request)
    {
        $query = Account::query();

        // Handle search
        if ($request->has('search') && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('accounts_name', 'like', "%{$searchValue}%")
                  ->orWhere('sector_name', 'like', "%{$searchValue}%")
                  ->orWhere('mobile_no', 'like', "%{$searchValue}%")
                  ->orWhere('credit_limit', 'like', "%{$searchValue}%")
                  ->orWhere('category', 'like', "%{$searchValue}%")
                  ->orWhere('opening_balance', 'like', "%{$searchValue}%")
                  ->orWhere('LastUpdate', 'like', "%{$searchValue}%")
                  ->orWhere('Status', 'like', "%{$searchValue}%");
            });
        }

        // Get total records before filtering
        $totalRecords = Account::count();
        $filteredRecords = $query->count();

        // Handle sorting
        if ($request->has('order') && !empty($request->order)) {
            $columns = [
                0 => 'id', // SL column (not sortable)
                1 => 'accounts_name',
                2 => 'sector_name',
                3 => 'mobile_no',
                4 => 'credit_limit',
                5 => 'category',
                6 => 'opening_balance',
                7 => 'CreateDate',
                8 => 'Status',
                9 => 'id' // Actions column (not sortable)
            ];
            
            $columnIndex = $request->order[0]['column'];
            $direction = $request->order[0]['dir'];
            
            if (isset($columns[$columnIndex]) && $columnIndex != 0 && $columnIndex != 9) {
                $query->orderBy($columns[$columnIndex], $direction);
            }
        } else {
            $query->orderBy('accounts_name', 'asc');
        }

        // Handle pagination
        if ($request->length != -1) {
            $query->skip($request->start)->take($request->length);
        }

        $accounts = $query->get();

        // Format data for DataTable
        $data = [];
        $sn = $request->start + 1;
        
        foreach ($accounts as $account) {
            $createDate = date("d/m/Y - h:i:s a", strtotime($account->CreateDate));
            $statusBadge = $account->Status == 'Active' 
                ? "<span class=\"badge badge-success\">Active</span>" 
                : "<span class=\"badge badge-danger\">Inactive</span>";

            $data[] = [
                $sn++,
                htmlspecialchars($account->accounts_name),
                htmlspecialchars($account->sector_name),
                htmlspecialchars($account->mobile_no),
                htmlspecialchars($account->credit_limit),
                htmlspecialchars($account->category),
                htmlspecialchars($account->opening_balance),
                "<details><summary>{$createDate}</summary><p>{$account->LastUpdate}</p></details>",
                $statusBadge,
                "<a href='#' class='btn btn-sm btn-info edit-btn' data-id='{$account->id}'>Edit</a>
                 <a href='#' class='btn btn-sm btn-danger delete-btn' data-id='{$account->id}'>Delete</a>"
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
     * Show the form for creating a new account
     */
    public function create()
    {
        return view('modalAccountsInsert');
    }

    /**
     * Show the form for editing the specified account
     */
    public function edit($id)
    {
        $account = Account::findOrFail($id);
        return view('modalAccountsUpdate', compact('account'));
    }

    /**
     * Store a newly created account
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'accounts_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('accounts_setup')->where(function ($query) use ($request) {
                    return $query->where('sector_name', $request->sector_name);
                })
            ],
            'sector_name' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:20',
            'credit_limit' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'opening_balance' => 'required|numeric',
            'Status' => 'required|in:Active,Inactive',
        ], [
            'accounts_name.unique' => 'An account with this name already exists in the selected sector.'
        ]);

        Account::create($validated);

        return $this->sendResponse(null, 'Account created successfully');
    }

    /**
     * Update the specified account
     */
    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $validated = $request->validate([
            'accounts_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('accounts_setup')->where(function ($query) use ($request) {
                    return $query->where('sector_name', $request->sector_name);
                })->ignore($id)
            ],
            'sector_name' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:20',
            'credit_limit' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'opening_balance' => 'required|numeric',
            'Status' => 'required|in:Active,Inactive',
        ], [
            'accounts_name.unique' => 'An account with this name already exists in the selected sector.'
        ]);

        $account->update($validated);

        return $this->sendResponse(null, 'Account updated successfully');
    }

    /**
     * Check for duplicate account name + sector name combination
     */
    public function checkDuplicate(Request $request)
    {
        $exists = Account::where('accounts_name', $request->accounts_name)
                        ->where('sector_name', $request->sector_name)
                        ->when($request->has('exclude_id'), function ($query) use ($request) {
                            return $query->where('id', '!=', $request->exclude_id);
                        })
                        ->exists();

        return response()->json(['exists' => $exists]);
    }

    /**
     * Remove the specified account
     */
    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();
        return $this->sendResponse(null, 'Account deleted successfully');
    }

    //accounts Balance
    public function accountsBalance($id)
    {
       $accounts_id = $id;
        
        $openiing_payments = Payment::
            where('accounts_id', $accounts_id)
            ->get();
        $total_openiing_payments = $openiing_payments->sum('amount');


        $openiing_receives = Receive::
            where('accounts_id', $accounts_id)
            ->get();
        $total_openiing_receives = $openiing_receives->sum('amount');

        $account = Account::select('id', 'accounts_name', 'mobile_no', 'credit_limit','opening_balance')
            ->where('id', $accounts_id)
            ->first();

        $credit_limit=$account->credit_limit;
        $accountBalance = (($account->opening_balance) + ($total_openiing_receives - $total_openiing_payments));


    return response()->json([
        'balance' => $accountBalance,
        'credit_limit' => $credit_limit
    ]);
    }
}
