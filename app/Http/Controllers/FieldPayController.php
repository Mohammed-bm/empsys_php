<?php

namespace App\Http\Controllers;

use App\Models\Payslip;
use Illuminate\Http\Request;

class FieldPayController extends Controller
{
    // GET /field-pay
    public function index()
    {
        $type0 = Payslip::where('type', 0)->get(); // Earnings (AEF)
        $type1 = Payslip::where('type', 1)->get(); // Deductions (ADF)

        return view('field_pay.index', compact('type0', 'type1'));
    }

    // POST /field-pay
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'percentage' => 'required|numeric|between:0,100',
            'type'       => 'required|in:0,1',
        ]);

        Payslip::create($validated);

        return redirect()->route('field-pay.index')->with('success', 'Payslip field saved successfully!');
    }

    // PUT /field-pay/{id}
    public function update(Request $request, $id)
    {
        $payslip = Payslip::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'percentage' => 'required|numeric|between:0,100',
            'type'       => 'required|in:0,1',
        ]);

        $payslip->update($validated);

        return redirect()->route('field-pay.index')->with('success', 'Payslip field updated successfully!');
    }

    // PATCH /field-pay/{id}/status
    public function toggleStatus($id)
    {
        $payslip = Payslip::findOrFail($id);
        $payslip->is_active = !$payslip->is_active;
        $payslip->save();

        $status = $payslip->is_active ? 'enabled' : 'disabled';
        return redirect()->route('field-pay.index')->with('success', "Payslip field {$status} successfully!");
    }

    // DELETE /field-pay/{id}
    public function destroy($id)
    {
        $payslip = Payslip::findOrFail($id);
        $payslip->delete();

        return redirect()->route('field-pay.index')->with('success', 'Payslip field deleted successfully!');
    }
}