<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function edit($id)
    {
        $payment = Payment::where('property_id', $id)->firstOrFail();
        return view('property.payment-edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'total_price'             => 'nullable|numeric',
            'amount_deposited'       => 'nullable|numeric',
            'remaining_amount'       => 'nullable|numeric',
            'down_payment'            => 'nullable|numeric',
            'initial_notice_no'      => 'nullable',
            'initial_notice_date'    => 'nullable',
            'total_received_amount' => 'nullable|numeric',
            'received_amount_date'  => 'nullable',
            'allotment_order_no'    => 'nullable',
            'allotment_order_date'  => 'nullable|date',
            'possession_slip_no'    => 'nullable',
            'possession_slip_date'  => 'nullable|date',
            'boundary_wall_approval' => 'nullable',
            'map_approval_date'      => 'nullable|date',
            'transfer_order_no'      => 'nullable',
        ]);

        Payment::where('property_id', $id)->update($data);

        return redirect()->back()->with('success', 'Payment details updated.');
    }
}
