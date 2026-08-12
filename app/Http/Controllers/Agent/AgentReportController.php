<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class AgentReportController extends Controller
{
    public function index(Request $request): Response
    {
        $agent = $request->user()->agentProfile;
        
        $tab = $request->input('tab', 'income'); // income, commissions, test_bookings, withdrawals
        $dateFilter = $request->input('date_filter', 'all'); // all, daily, monthly, yearly, custom
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Data for Income tab (Summary)
        $incomeStats = [
            'total_commission' => (float) $agent->total_earned_commission,
            'total_withdrawn' => (float) $agent->total_withdrawn_commission,
            'current_balance' => (float) $agent->wallet_balance,
            'pending_withdrawals' => (float) $agent->withdrawals()->where('status', 'pending')->sum('amount'),
        ];
        
        $incomeList = null;
        $incomeTotal = 0;

        if ($tab === 'income') {
            $query = $agent->commissions()->with('source');
            
            if ($dateFilter === 'daily') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($dateFilter === 'monthly') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($dateFilter === 'yearly') {
                $query->whereYear('created_at', Carbon::now()->year);
            } elseif ($dateFilter === 'custom' && $startDate && $endDate) {
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            }

            // Clone query to get the sum before pagination
            $sumQuery = clone $query;
            $incomeTotal = (float) $sumQuery->sum('amount');

            $incomeList = $query->latest()->paginate(15)->withQueryString();
        }
        
        // Commissions
        $commissions = null;
        if ($tab === 'commissions') {
            $commissions = $agent->commissions()
                ->with('source')
                ->latest()
                ->paginate(15)
                ->withQueryString();
        }
        
        // Test Bookings
        $testBookings = null;
        if ($tab === 'test_bookings') {
            $testBookings = $agent->medicalTestBookings()
                ->with(['items.medicalTest'])
                ->latest()
                ->paginate(15)
                ->withQueryString();
        }
        
        // Withdrawals
        $withdrawals = null;
        if ($tab === 'withdrawals') {
            $withdrawals = $agent->withdrawals()
                ->latest()
                ->paginate(15)
                ->withQueryString();
        }
        
        return Inertia::render('Agent/Reports', [
            'activeTab' => $tab,
            'dateFilter' => $dateFilter,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'incomeStats' => $incomeStats,
            'incomeList' => $incomeList,
            'incomeTotal' => $incomeTotal,
            'commissions' => $commissions,
            'testBookings' => $testBookings,
            'withdrawals' => $withdrawals,
        ]);
    }

    public function printPdf(Request $request)
    {
        $agent = $request->user()->agentProfile;
        $dateFilter = $request->input('date_filter', 'all');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = $agent->commissions()->with('source');
        
        $filterLabel = 'All Time';
        if ($dateFilter === 'daily') {
            $query->whereDate('created_at', Carbon::today());
            $filterLabel = 'Daily (' . Carbon::today()->format('d M Y') . ')';
        } elseif ($dateFilter === 'monthly') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
            $filterLabel = 'Monthly (' . Carbon::now()->format('F Y') . ')';
        } elseif ($dateFilter === 'yearly') {
            $query->whereYear('created_at', Carbon::now()->year);
            $filterLabel = 'Yearly (' . Carbon::now()->format('Y') . ')';
        } elseif ($dateFilter === 'custom' && $startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
            $filterLabel = 'Custom Range (' . Carbon::parse($startDate)->format('d M Y') . ' - ' . Carbon::parse($endDate)->format('d M Y') . ')';
        }

        $commissions = $query->latest()->get();
        $total = $commissions->sum('amount');

        $pdf = Pdf::loadView('agent.reports.pdf', [
            'agent' => $agent,
            'commissions' => $commissions,
            'total' => $total,
            'filterLabel' => $filterLabel
        ]);

        return $pdf->download('income_report.pdf');
    }
}
