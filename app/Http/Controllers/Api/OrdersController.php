<?php

namespace App\Http\Controllers\Api;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'orders' => Order::with('customer')->orderBy('updated_at', 'DESC')->paginate(15),
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::with([
            'products' => function ($query) {
                $query->withoutGlobalScopes();
            },
            'customer',
            'coupon'
        ])->find($id);

        $order->products->each->append('link');

        return response()->json([
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->is_paid = $request->is_paid;
        $order->is_delivered = $request->is_delivered;
        $order->save();

        return response()->json([
            'message' => 'Narudžbina je uspešno izmenjena.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'message' => 'Narudžbina je uspešno obrisana'
        ]);
    }
}
