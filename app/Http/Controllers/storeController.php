<?php

namespace App\Http\Controllers;

use App\Http\Requests\store\storeRequest;
use App\Http\Requests\store\update;
use App\Models\store;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class storeController extends Controller
{
    use ResponseJson;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return store::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $image = $request->file('photo');
        $imageName = time() . '' . str_replace(' ', '', $request->photo->getClientOriginalName());
        $store = new store();
        $store->store_name = $request->store_name;
        $store->store_detail = $request->store_detail;
        $store->address = $request->address;
        $store->photo = $imageName;
        $store->manger_id = $request->manger_id;
        $result =  $store->save();
        if ($result) {

            $image->storeAs('store', $imageName, 'public');
            return $this->returnSuccessMessage("Store Data are added Successfuly", $store);
        } else
            return $this->returnError("Something went wrong");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return store::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(update $request, string $id)
    {
        $image = $request->photo;
        $imageName = time() . '' . str_replace(' ', '', $request->photo->getClientOriginalName());
        $store = store::findOrFail($id);
        $oldImage = $store->photo;
        $store->store_name = $request->store_name;
        $store->store_detail = $request->store_detail;
        $store->address = $request->address;
        $store->photo = $imageName;
        $store->manger_id = $request->manger_id;
        $result = $store->save();
        if ($result) {
            $parts = explode('storage/', $oldImage);
            if (count($parts) === 2) {
                $path = 'public/' . $parts[1];
                Storage::delete($path);
                $image->storeAs('store', $imageName, 'public');
                return $this->returnSuccessMessage("Store Data are updated Successfuly", $store);
            }
        }
        return $this->returnError("Something went wrong");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $store = store::where('id', $id)->with('products')->first();
        if ($store) { 
           foreach ($store->products as $product) {
                $parts = explode('/storage', $product->photo);
                if (count($parts) == 2)
                    Storage::delete('public' . $parts[1]);
            }
            $parts = explode('/storage', $store->photo);
            if (count($parts) == 2) {
                Storage::delete('public/' . $parts[1]);
            }
            $store->delete();
            return $this->returnSuccessMessage("store Data are deleted Successfuly", $store);
        }
        return $this->returnError("Something went wrong");
    }

    public function blockStore(Request $request)
    {

        $store = store::findOrFail($request->id);
        $store->blocked = 1;
        $result =  $store->save();
        if ($result)
            return $this->returnSuccessMessage("Store Data are bolcked Successfuly", $store);
        else
            return $this->returnError("Something went wrong");
    }

    public function unblockStore(Request $request)
    {
        $store = store::findOrFail($request->id);
        $store->blocked = 0;
        $result =  $store->save();
        if ($result)
            return $this->returnSuccessMessage("Store Data are bolcked Successfuly", $store);
        else
            return $this->returnError("Something went wrong");
    }
}
