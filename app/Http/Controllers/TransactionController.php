<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $transactions = Transaction::where('user_id', $request->user()->id)
            ->with('category')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payee' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'inflow' => 'required|boolean',
        ]);

        $transaction = Transaction::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($transaction->load('category'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Transaction $transaction): JsonResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($transaction->load('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction): JsonResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
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

        return response()->json($transaction->load('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Transaction $transaction): JsonResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}
