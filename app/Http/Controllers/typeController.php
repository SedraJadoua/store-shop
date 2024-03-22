<?php

namespace App\Http\Controllers;

use App\Models\type;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\type;

class typeController extends Controller
{
    use ResponseJson;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return type::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = new type();
        $validator = Validator::make($request->all(), [
            'type' => 'required|unique:types,type',
        ]);
        if ($validator->fails()) {
            return $this->sendListError($validator->errors());
        }
        $type->type = $request->type;
        $result = $type->save();
        if ($result) {
            return $this->sendResponse($type);
        }
        return $this->returnError('something went wrong , please try again');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return type::where('id', $id)->first();
    }

    /**
     * Update the specified resource in storacolorge.
     */
    public function update(Request $request, string $id)
    {
        $type = type::where('id', $id)->first();
        if ($type) {
            $validator = Validator::make($request->all(), [
                'type' => 'required|string|unique:types,type,'.$id,
            ]);
            if ($validator->fails()) {
                return $this->sendListError($validator->errors());
            }
            $result =  $type->update([
                'type' => $request->type,
            ]);
            if ($result) {
                return $this->sendResponse($type);
            }
        }
        return $this->returnError('something went wrong, please try again');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = type::where('id' , $id)->first();
        if($type){
            $type->delete();
            return $this->sendResponse($type, 'deleted successfully');
        }
        return $this->returnError('something went wrong, please try again');
    }
}
