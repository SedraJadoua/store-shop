<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\orderProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class productOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return orderProduct::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $products = [];
        $order = order::findOrFail($id);
        foreach ($request->products as $product) {
            foreach ($product as $productId => $productDetails) {
                $products[$productId] = [
                    'amount' => $productDetails['amount'],
                ];
            }
        }
        $order->products()->syncWithoutDetaching($products);
        return true;
    }

}
