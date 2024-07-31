<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Models\discount_code;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discountCodes = discount_code::all();
        return view('admin.discount.discount', compact('discountCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $discount = new discount_code();
        $code = $request->input('code');
        $discount_percentage = $request->input('discount_percentage');
        $expiry_date = $request->input('expiry_date');

        $discount->code = $code;
        $discount->discount_percentage = $discount_percentage;
        $discount->expiry_date = $expiry_date;
        $discount->save();
        return redirect()->back()->with('success', 'Mã đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(discount_code $discount_code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(discount_code $discount_code)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, discount_code $discount_code)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(discount_code $discount_code)
    {
        //
    }
}
