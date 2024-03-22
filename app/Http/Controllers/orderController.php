<?php

namespace App\Http\Controllers;

use App\Http\Requests\order\store;
use App\Models\order;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;

class orderController extends Controller
{

    use ResponseJson;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return order::get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(store $request)
    {
        $order = new order();
        $order->user_id = $request->user_id;
        $order->save();
        $productOrderController = new productOrderController();
        $result = $productOrderController->store($request, $order->id);

        if ($result)
            return $this->returnSuccessMessage("order Data are added Successfuly", $order);
        else
            return $this->returnError("Something went wrong");
    }
}
