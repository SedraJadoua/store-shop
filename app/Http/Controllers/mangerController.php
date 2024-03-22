<?php

namespace App\Http\Controllers;

use App\Http\Requests\manger\storeRequest;
use App\Http\Requests\manger\updateRequest;
use App\Mail\MangerAccept;
use App\Mail\MangerBlock;
use App\Models\manger;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class mangerController extends Controller
{
    use ResponseJson;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return manger::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $result  = manger::create($request->all());
        if ($result)
            return $this->returnSuccessMessage("manger Data are added Successfuly", $result);
        else
            return $this->returnError("Something went wrong");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $manger = manger::where('id', $id)->with('account')->first();
        if ($manger)
            return $this->returnSuccessMessage("manger Data are deliverd Successfuly", $manger);
        else
            return $this->returnError("Something went wrong");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request, string $id)
    {
        $manger = manger::where('id', $id)->first();
        if ($manger) {
            $manger = $manger->update($request->all());
            return $this->returnSuccessMessage("manger Data are updated Successfuly", $manger);
        }
        return $this->returnError("Something went wrong");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $manger = manger::where('id', $id)->delete();
        if ($manger) {
            return $this->returnSuccessMessage("manger Data are deleted Successfuly", $manger);
        }
        return $this->returnError("Something went wrong");
    }


    public function block(Request $request)
    {
        $manger = Manger::with('account')->where('id', $request->id)->first();
        if ($manger) {
            try {
                Mail::to($manger->account->email)->send(new MangerBlock());
            } catch (\Throwable $th) {
                return response()->json($th->getMessage());
            }
            $result =  $manger->delete();
            if ($result)
                return $this->returnSuccessMessage("manger Data are deleted Successfuly", $result);
        }
        return $this->returnError("Something went wrong");
    }


    public function accept(Request $request)
    {
        $manger = manger::with('account')->where('id', $request->id)->first();
        $manger->isAccepted = 1;
        $result = $manger->save();
        if ($result) {
            try {
                Mail::to($manger->account->email)->send(new MangerAccept());
            } catch (\Throwable $th) {
                return response()->json($th->getMessage());
            }
            return $this->sendResponse($manger, "manger Data are accepted Successfuly");
        }
        return $this->returnError("Something went wrong");
    }


    public function mangersAccepted()
    {
        return manger::Accept()->with('store')->get();
    }
}
