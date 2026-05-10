<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Payment;
use App\Models\Receive;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AccountReportController extends Controller
{

    // Accounts Report View
    public function AccountReportView()
    {
        return view('AccountReportView');
    }

    public function AccountReportViewData(Request $request)
    {
        $start = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
        $end   = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');

        $accounts_id = $request->accounts_id;

     

            $payments = Payment::select(
            'id',
            'amount',
            'accounts_id',
            'invoice_no',
            'remarks',
            'entry_date'
            )
            ->whereBetween('entry_date', [$start, $end])
            ->get()
            ->map(function ($row) {
            $row->type = 'Payment';
            return $row;
            });

            $receives = Receive::select(
            'id',
            'amount',
            'accounts_id',
            'invoice_no',
            'remarks',
            'entry_date'
            )
            ->whereBetween('entry_date', [$start, $end])
            ->get()
            ->map(function ($row) {
            $row->type = 'Receive';
            return $row;
            });

            $transactions = $payments
            ->merge($receives)
            ->sortBy('entry_date');

        
            // Default value
    $accountsInfo = "All Accounts";

    if ($accounts_id != 'All') {

        $account = Account::select('id', 'accounts_name', 'mobile_no', 'sector_name')
            ->where('id', $accounts_id)
            ->first();

        if ($account) {
            $accountsInfo =
                $account->accounts_name .
                ' - ' . $account->mobile_no .
                ' - ' . $account->sector_name;
        }
    }
    
        return view('AccountReportView', [
        'type' => $request->type,
        'accounts_id' => $accounts_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'transactions' => $transactions,
        'accountsInfo' => $accountsInfo,
        ]);
    }
}