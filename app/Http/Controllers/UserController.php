<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){
        $filters = $request->all();
        $users = User::with([]);
        if (!empty($filters['email'])){
            $users = $users->where('email', 'LIKE', '%'.$filters['email'].'%');
        }
        $users = $users->get();
        return view('user', compact('users'));
    }

    public function store(Request $request, $id = null){
        if ($id == null){
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        }else{
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }
        return redirect(url('user'));
    }

    public function delete($id){
        User::find($id)->delete();
        return redirect()->back();
    }
}
