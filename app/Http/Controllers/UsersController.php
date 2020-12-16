<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $method = 'CREATE';

        return view('admin.users.create', compact('method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $role_user = Role::where('name', 'user')->first();
        $user->roles()->attach($role_user);

        flash('User successfully created.')->success()->important();

        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->get()->first();
        $method = 'EDIT';

        return view('admin.users.edit', compact('user', 'method'));
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (isset($request->c_password)) {
            if ($request->password == $request->c_password) {
                $user = User::where('id', $id)->get()->first();
                $user->password = bcrypt($request->password);
                $user->save();

                flash('Contraseña actualizada correctamente.')->success()->important();

                return redirect('admin');
            } else {
                flash('No coincide la contraseña repetida. Inténtalo de nuevo.')->error()->important();

                return redirect('admin');
            }
        } else {
            $user = User::where('id', $id)->get()->first();
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->udg_code = $request->udg_code;
            $user->career = $request->career;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
            $user->save();

            flash('Usuario editado correctamente.')->success()->important();

            return redirect('admin/users');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        flash('Usuario eliminado correctamente.')->success()->important();

        return redirect()->back();
    }
}
