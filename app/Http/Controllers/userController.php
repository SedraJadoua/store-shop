<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\storeRequest;
use App\Http\Requests\user\updateRequest;
use App\Models\User;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;

class userController extends Controller
{

    use ResponseJson;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phoneNumber = $request->phoneNumber;
        $user->account_id = $request->account_id;
        $user->city = $request->city;
        $user->address = $request->address;
        $result =  $user->save();
        if ($result) {
            return $this->returnSuccessMessage("User Data are added Successfuly", $user);
        }
        return $this->returnError("Something went wrong");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::where('id' , $id)->with('account')->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request, string $id)
    {
        $user = User::where('id' , $id)->first();
        if ($user) {
            $user = $user->update($request->all());
            return $this->returnSuccessMessage("user Data are updated Successfuly", $user);
        }
        return $this->returnError("Something went wrong");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $user = User::where('id' , $id)->delete();
         if($user){
            return $this->returnSuccessMessage("User Data are deleted Successfuly",$user);
         }
         return $this->returnError( "Something went wrong");
    }
}
