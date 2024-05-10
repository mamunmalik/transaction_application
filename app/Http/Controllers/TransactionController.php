<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function getMockRespnses(Request $request)
    {
        if ($request->header("X-Mock-Status")) {
            $value = $request->header("X-Mock-Status");
            if ($value == "accepted") {
                return response()->json(['status' => "accepted"]);
            } elseif ($value == "failed") {
                return response()->json(['status' => "failed"]);
            }
        }

        return response()->json(['status' => "failed"]);
    }

    public function createPayment(Request $request)
    {
        $response = $this->getMockRespnses($request);
        $status = $response->getData()->status;
        try {
            $validated = $request->validate([
                'amount' => ['required'],
                'user_id' => ['required'],
            ]);
            $validated['status'] = $status;
            $item = Transaction::create($validated);
            return response()->json(['transaction_id' => $item->id], 201);
        } catch (\Throwable $th) {
            return response()->json([$th->getMessage()], 422);
        }
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'transaction_id' => ['required'],
            'status' => ['required']
        ]);
        $item = Transaction::find($request->transaction_id);
        $item->update(['status' => $request->status]);
    }
}
