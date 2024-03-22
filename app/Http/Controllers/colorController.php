<?php

namespace App\Http\Controllers;

use App\Models\color;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class colorController extends Controller
{
    use ResponseJson;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return color::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $color = new color();
        $validator = Validator::make($request->all(), [
            'color' => 'required|string|unique:colors,color',
        ]);
        if ($validator->fails()) {
            return $this->sendListError($validator->errors());
        }
        $color->color = $request->color;
        $result = $color->save();
        if ($result) {
            return $this->sendResponse($color);
        }
        return $this->returnError('something went wrong , please try again');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return color::where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $color = color::where('id', $id)->first();
        if ($color) {
            $validator = Validator::make($request->all(), [
                'color' => 'required|string|unique:colors,color,' . $id,
            ]);
            if ($validator->fails()) {
                return $this->sendListError($validator->errors());
            }
            $result =  $color->update([
                'color' => $request->color,
            ]);
            if ($result) {
                return $this->sendResponse($color);
            }
        }
        return $this->returnError('something went wrong, please try again');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = color::where('id' , $id)->first();
        if($color){
            $color->delete();
            return $this->sendResponse($color, 'deleted successfully');
        }
        return $this->returnError('something went wrong, please try again');
    }
}
