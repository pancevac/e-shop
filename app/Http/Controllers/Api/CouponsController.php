<?php

namespace App\Http\Controllers\Api;

use App\Coupon;
use App\Http\Requests\CreateCouponRequest;
use App\Http\Requests\EditCouponRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'coupons' => Coupon::paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCouponRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCouponRequest $request)
    {
        $coupon = Coupon::create($request->all());

        return response()->json([
            'message' => 'Kupon uspešno kreiran',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return response()->json([
            'coupon' => $coupon,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditCouponRequest $request
     * @param Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(EditCouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->all());

        return response()->json([
            'message' => 'Kupon je uspešno izmenjen',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Coupon $coupon
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->json([
            'message' => 'Kupon je uspešno izbrisan',
        ]);
    }
}
