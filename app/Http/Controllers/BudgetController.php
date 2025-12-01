<?php

namespace App\Http\Controllers;

use App\Models\BudgetAssignment;
use App\Models\CategoryGroup;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BudgetController extends Controller
{
    // Show the main budget dashboard for a specific month
    public function index(Request $request, $year = null, $month = null)
    {
        if ($year && $month) {
            try {
                $date = Carbon::createFromDate($year, $month, 1);
            } catch (\Exception $e) {
                abort(404, $e->getMessage());
            }
        } else {
            $date = Carbon::now();
        }

        $monthStart = $date->copy()->startOfMonth();
        $monthEnd = $date->copy()->endOfMonth();

        // Start calculating

        $totalIncome = Transaction::income()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->sum('amount');

        $totalAssigned = BudgetAssignment::where('month', $monthStart)
            ->sum('amount');

        $leftToBudget = $totalIncome - $totalAssigned;

        $categoryGroups = CategoryGroup::with([
            'categories' => fn($q) => $q->withSum([
                'budgetAssignments as total_budget' => fn($q) => $q->where('month', $monthStart),
            ], 'amount'),
        ])->get()->toArray();



        return Inertia::render('Dashboard', [
            'dateContext' => $date,
            'categoryGroups' => $categoryGroups,
            'totalIncome' => $totalIncome,
            'totalAssigned' => $totalAssigned,
            'leftToBudget' => $leftToBudget,
        ]);
    }
}
