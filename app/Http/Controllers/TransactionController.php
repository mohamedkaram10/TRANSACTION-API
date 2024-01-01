<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\MonthlyReportRequest;
use App\Http\Requests\RecordPaymentRequest;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // User Story 2: Admin enters new transactions
    public function createTransaction(CreateTransactionRequest $request)
    {
        $currentDateTime = Carbon::now();

        $transaction = Transaction::create([
            'amount' => $request->input('amount'),
            'payer' => $request->input('payer'),
            'due_on' => $request->input('due_on'),
            'vat' => $request->input('vat'),
            'is_vat_inclusive' => $request->input('is_vat_inclusive'),
            'status' => 'Outstanding', // Assuming a default status for a new transaction
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);

        // Update the status based on the current time
        $transaction->status = $transaction->calculateStatus();
        $transaction->save();

        // Return the created transaction
        return response()->json($transaction, 201);
    }

    // User Story 3: Admin records payments
    public function recordPayment(RecordPaymentRequest $request)
    {
        // Find the transaction
        $transaction = Transaction::findOrFail($request->input('transaction_id'));

        // Create a new payment record
        $payment = Payment::create([
            'transaction_id' => $transaction->id,
            'amount' => $request->input('amount'),
            'paid_on' => $request->input('paid_on'),
            'details' => $request->input('details'),
        ]);

        // Update the total_paid field in the transactions table
        $transaction->amount += $request->input('amount');
        $transaction->save();

        // Calculate and update the transaction status
        $transaction->status = $transaction->calculateStatus();
        $transaction->save();

        return response()->json(['message' => 'Payment recorded successfully', 'payment' => $payment]);
    }

    // User Story 4: User views transactions
    public function viewTransactions(Request $request)
    {
        $user = $request->user();

        // Retrieve transactions based on user type
        $transactions = $user->isAdmin()
            ? Transaction::all()  // Admin can view all transactions
            : $user->transactions; // Customer can view their transactions

        // Return the transactions
        return response()->json(['transactions' => $transactions, 'status' => 200]);
    }

    // User Story 5: Admin generates monthly reports
    public function generateMonthlyReport(MonthlyReportRequest $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // Parse input dates
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));

            // Initialize an array to store monthly reports
            $monthlyReports = [];

            // Generate reports for each month in the date range
            while ($startDate->lessThanOrEqualTo($endDate)) {
                $monthReport = [
                    'month' => $startDate->format('m'),
                    'year' => $startDate->format('Y'),
                    'paid' => Transaction::whereYear('due_on', $startDate->year)
                        ->whereMonth('due_on', $startDate->month)
                        ->where('status', 'Paid')
                        ->sum('amount'),
                    'outstanding' => Transaction::whereYear('due_on', $startDate->year)
                        ->whereMonth('due_on', $startDate->month)
                        ->where('status', 'Outstanding')
                        ->sum('amount'),
                    'overdue' => Transaction::whereYear('due_on', $startDate->year)
                        ->whereMonth('due_on', $startDate->month)
                        ->where('status', 'Overdue')
                        ->sum('amount'),
                ];

                // Add the report to the array
                $monthlyReports[] = $monthReport;

                // Move to the next month
                $startDate->addMonth();
            }
        }

        // Return the generated reports
        return response()->json($monthlyReports, 200);
    }
}
