<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;

class accountController extends Controller
{
    use ResponseJson;

    public function index()
    {
        return account::all();
    }

    public function destroy($id)
    {
        $result = account::where('id', $id)->delete();
        if ($result)
            return $this->returnSuccessMessage("account Data are deleted Successfuly", true);
        else
            return $this->returnError("Something went wrong");
    }
}
