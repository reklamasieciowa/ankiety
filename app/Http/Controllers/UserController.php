<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UpdateUser;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.user.index')->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //done in Auth/RegisterController
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //done in Auth/RegisterController
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $user = User::FindOrfail($user);

        return view('admin.user.edit')->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $user)
    {

        //dd($request->all());

        $user = User::FindOrfail($user);

        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);

        //check if !empty old & new pass
        if(isset($request['old_password']) && !empty($request['old_password']) && isset($request['password']) && !empty($request['password']) && isset($request['password_confirmation']) && !empty($request['password_confirmation'])) {
            //check if old pass is correct

            if(Hash::check($request['old_password'], $user->password)) {
                
                //set the new password
                $user->password = Hash::make($request['password']);
                $user->save();
            } else {
                $request->session()->flash('class', 'alert-danger');
                $request->session()->flash('info', 'Nieprawidłowe hasło.');

                return redirect()->route('admin.user.edit', ['user' => $user->id]);
            }
        }

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Użytkownik '.$user->name.' zaktualizowany.');

        return redirect()->route('admin.user.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user, Request $request)
    {
        $user = User::FindOrfail($user);

        $user->delete();

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Użytkownik '.$user->name.' usunięty.');

        return redirect()->route('admin.user.index');
    }
}
