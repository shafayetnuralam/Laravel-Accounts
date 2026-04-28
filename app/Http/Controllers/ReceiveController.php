<?php

namespace App\Http\Controllers;

use App\Models\Receive;
use Illuminate\Http\Request;

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
                1 => 'date',
                2 => 'time',
                3 => 'accounts_info',
                4 => 'pay_mode',
                5 => 'amount',
                6 => 'remarks',
                7 => 'invoice_no',
                8 => 'CreateDate',
                9 => 'LastUpdate'
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

        $receives = $query->get();

        // Format data for DataTable
        $data = [];
        $sn = $request->start + 1;
        
        foreach ($receives as $receive) {
            $createDate = date("d/m/Y - h:i:s a", strtotime($receive->CreateDate));
            $lastUpdate = date("d/m/Y - h:i:s a", strtotime($receive->LastUpdate));
            $entryTime = date("h:i:s a", strtotime($receive->CreateDate));
            $entryDate = date("d/m/Y", strtotime($receive->entry_date));
            $accountsInfo =  "<span class=\"badge badge-warning\">{$receive->accounts_name}</span> <span class=\"badge badge-success\">{$receive->sector_name}</span> <span class=\"badge badge-info\">{$receive->mobile_no}</span>";

            // $accountsInfo = "{$receive->accounts_name} ({$receive->sector_name}, {$receive->mobile_no})";

            $data[] = [
                $sn++,
                htmlspecialchars($receive->invoice_no),
                htmlspecialchars($entryDate),
                htmlspecialchars($entryTime),
                ($accountsInfo),
                htmlspecialchars($receive->pay_mode),
                htmlspecialchars($receive->amount),
                htmlspecialchars($receive->remarks),
              
                "<a href='#' class='btn btn-sm btn-info edit-btn' data-id='{$receive->id}'>Edit</a>
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
}
