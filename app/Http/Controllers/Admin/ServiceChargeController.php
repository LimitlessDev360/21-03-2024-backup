<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceCharge;
use Brian2694\Toastr\Facades\Toastr;

class ServiceChargeController extends Controller
{
    public function index()
    {
        return view('admin-views.service-charges.add');
    }
    public function list()
    {
        $services = ServiceCharge::paginate(config('default_pagination'));
        return view('admin-views.service-charges.list', compact('services'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'tax_rate' => 'required',
        ]);
        if ($request->inclusive == '1') {
            $gst = 1;
        } else {
            $gst = 2;
        }

        ServiceCharge::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'tax_rate' => $request->tax_rate,
            'km' => $request->km,
            'inclusive' => $gst == 1 ? 1 : 0,
            'exclusive' => $gst == 2 ? 1 : 0,
            'taxable' => $request->taxable,
        ]);
        Toastr::success('Charges successfully added!');
        return redirect()->route('admin.service-list');
    }

    public function edit($id)
    {
        $service = ServiceCharge::findOrFail($id);
        return view('admin-views.service-charges.edit', compact('service'));
    }
    public function update(Request $request, $id)
    {
        if ($request->inclusive == '1') {
            $gst = 1;
        } else {
            $gst = 2;
        }

        $service = ServiceCharge::findOrFail($id);
        $service->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'tax_rate' => $request->tax_rate,
            'km' => $request->km,
            'inclusive' => $gst == 1 ? 1 : 0,
            'exclusive' => $gst == 2 ? 1 : 0,
            'taxable' => $request->taxable,
        ]);
        Toastr::success('ServiceCharge updated successfully');
        return redirect()->route('admin.service-list');
    }

    public function destroy($id)
    {
        $service = ServiceCharge::findOrFail($id);
        $service->delete();
        Toastr::success('Service Deleted successfully');
        return back();
    }
}
