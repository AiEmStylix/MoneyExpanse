<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TransactionWebController extends Controller
{
    public function index(Request $request): Response
    {
        $perPage = $request->input('per_page', 20);
        $perPage = is_numeric($perPage) ? (int) $perPage : 20;
        $perPage = min($perPage, 100);

        $transactions = Transaction::where('user_id', $request->user()->id)
            ->with('category.group')
            ->orderBy('date', 'desc')
            ->paginate($perPage);

        return Inertia::render('transactions/Index', [
            'transactions' => $transactions,
        ]);
    }

    public function create(): Response
    {
        $categories = Category::with('group')->get();

        return Inertia::render('transactions/Form', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payee' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'inflow' => 'required|boolean',
        ]);

        Transaction::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully');
    }

    public function edit(Request $request, Transaction $transaction): Response
    {
        if ($transaction->user_id !== $request->user()->id) {
            abort(403);
        }

        $categories = Category::with('group')->get();

        return Inertia::render('transactions/Form', [
            'transaction' => $transaction,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'date' => 'sometimes|required|date',
            'amount' => 'sometimes|required|numeric|min:0',
            'payee' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'inflow' => 'sometimes|required|boolean',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully');
    }

    public function destroy(Request $request, Transaction $transaction): RedirectResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully');
    }
}
