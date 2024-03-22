<?php

namespace App\Http\Controllers;

use App\Http\Requests\product\store;
use App\Models\color;
use App\Models\product;
use App\Models\type;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{
    use ResponseJson;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::with(['color', 'type', 'store'])
            ->whereHas('store', function ($query) {
                $query->where('blocked', 0);
            })->get();
    }


    public function typeIndex(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type_id' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return $this->sendListError($validate->errors());
        }

        return product::where('type_id', $request->type_id)->with(['color', 'type', 'store'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(store $request)
    {
        $image = $request->file('photo');
        $imageName = time() . '' . str_replace(' ', '', $request->photo->getClientOriginalName());
        $product = new product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->prod_detail = $request->prod_detail;
        $product->size = $request->size;
        $product->total_amount = $request->total_amount;
        $product->type_id = $request->type_id;
        $product->color_id = $request->color_id;
        $product->store_id = $request->store_id;
        $product->photo = $imageName;
        $result =  $product->save();
        if ($result) {

            $image->storeAs('product', $imageName, 'public');
            return $this->returnSuccessMessage("Product Data are added Successfuly", $product);
        }

        return $this->returnError("Something went wrong");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return product::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(store $request, string $id)
    {

        $product = product::findOrFail($id);
        $oldImage = $product->photo;
        $image = $request->file('photo');
        $imageName = time() . '' . str_replace(' ', '', $request->photo->getClientOriginalName());
        $product->name = $request->name;
        $product->price = $request->price;
        $product->prod_detail = $request->prod_detail;
        $product->size = $request->size;
        $product->total_amount = $request->total_amount;
        $product->type_id = $request->type_id;
        $product->color_id = $request->color_id;
        $product->store_id = $request->store_id;
        $product->photo = $imageName;
        $result =  $product->save();
        if ($result) {
            $parts = explode('storage/', $oldImage);
            if (count($parts) == 2) {

                Storage::delete('public/' . $parts[1]);
                $image->storeAs('product', $imageName, 'public');
                return $this->returnSuccessMessage("Product Data are updated Successfuly", $product);
            };
        }
        return $this->returnError("Something went wrong");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = product::findOrFail($id);
        $parts = explode('/storage', $product->photo);
        if (count($parts) == 2) {
            Storage::delete('public/' . $parts[1]);
        }
        $product->delete();
        return $this->sendResponse($product, 'product deleted successfully ');
    }



    public function search(Request $request)
    {
        $search = "%$request->search%";
        $search_result = array();

        $search_products = Product::where('name', 'LIKE', $search)
            ->orWhere('prod_detail', 'LIKE', $search)
            ->orWhere('price', 'LIKE', $search)
            ->get();


        foreach ($search_products as $product) {
            if (!in_array($product, $search_result)) {
                array_push($search_result, $product);
            }
        }

        $colors = color::where('color', 'LIKE', $search)->get();

        foreach ($colors as $color) {
            $products = product::where('color_id', $color->id)->get();
            foreach ($products as $product) {
                if (!in_array($product, $search_result))
                    array_push($search_result, $product);
            }
        }

        $types = type::where('type', 'LIKE', $search)->get();

        foreach ($types as $type) {
            $product = product::where('type_id', $type->id)->first();
            if (!in_array($product, $search_result)) {
                array_push($search_result, $product);
            }
        }
        return $search_result;
    }
}
