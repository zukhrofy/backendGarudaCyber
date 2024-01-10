<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function checkVoucher(Request $request, $voucherCode)
    {

        $voucher = Voucher::where('voucher_code', $voucherCode)
            ->whereNull('redeemed_at')
            ->where('expires_at', '>', now())
            ->first();

        if ($voucher) {
            return response()->json([
                'success' => true,
                'voucher' => $voucher,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Voucher tidak valid.',
            ], 422);
        }
    }
}
