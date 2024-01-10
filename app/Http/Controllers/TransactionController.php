<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Voucher;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        // asumsi user 1
        $user = 1;
        $vouchers = [];
        $totalPurchase = 0;

        // jika user ada voucher
        if ($request->has('vouchers')) {
            foreach ($request->input('vouchers') as $voucherData) {
                $voucherCode = $voucherData['voucher_code'];
                $voucher = Voucher::where('customer_id', $user)
                    ->where('voucher_code', $voucherCode)
                    ->where('redeemed_at', null)
                    ->first();

                if ($voucher) {
                    $totalPurchase -= 10000;
                    $voucher->redeemed_at = now();
                    $voucher->save();
                }
            }
        }

        // Create transaction instance
        $transaction = new Transaction([
            'customer_id' => $user,
            'total_spent' => $totalPurchase,
            'tenant_id' => $request->input('tenantId')
        ]);
        $transaction->save();

        // proses transaction cart
        foreach ($request->input('cart') as $cartItem) {
            $product = Product::findOrFail($cartItem['id']);
            $subtotal = $product->price * $cartItem['quantity'];
            $totalPurchase += $subtotal;

            $transactionDetail = new TransactionDetail([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'quantity' => $cartItem['quantity'],
                'subtotal' => $subtotal,
            ]);
            $transactionDetail->save();
        }

        // update total_spent of transaction
        $transaction->total_spent = $totalPurchase;
        $transaction->save();

        // give voucher jika kelipatan sejuta
        if ($totalPurchase >= 1000000) {
            $numberOfVouchers = floor($totalPurchase / 1000000);

            for ($i = 0; $i < $numberOfVouchers; $i++) {
                // buat voucher
                $voucherCode = fake()->unique()->regexify('[A-Za-z0-9]{7}');

                $voucher = new Voucher([
                    'customer_id' => $user,
                    'transaction_id' => $transaction->id,
                    'voucher_code' => $voucherCode,
                    'issued_at' => now(),
                    'expires_at' => now()->addMonths(3),
                ]);
                $voucher->save();
                $vouchers[] = $voucherCode;
            }
        }
        $response = ['message' => 'Checkout success'];

        if (!empty($vouchers)) {
            $response['vouchers'] = $vouchers;
        }
        return response()->json($response);
    }
}
