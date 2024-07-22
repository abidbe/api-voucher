<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherClaimController extends Controller
{
    public function claim($id)
    {
        $voucher = Voucher::findOrFail($id);
        if (!$voucher->status) {
            return response()->json(['message' => 'Voucher is not available'], 400);
        }

        VoucherClaim::create([
            'id_voucher' => $voucher->id,
            'id_user' => Auth::id(),
            'tanggal_claim' => now(),
        ]);

        $voucher->update(['status' => false]);

        return response()->json(['message' => 'Voucher claimed successfully']);
    }

    public function history()
    {
        $claims = VoucherClaim::where('id_user', Auth::id())->with('voucher')->get();
        return response()->json($claims);
    }

    public function delete($id)
    {
        $claim = VoucherClaim::findOrFail($id);

        if ($claim->id_user != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $voucher = $claim->voucher;
        $claim->delete();
        $voucher->update(['status' => true]);

        return response()->json(['message' => 'Claim deleted successfully']);
    }
}
