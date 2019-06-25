<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
            ->join('roles', 'users.role_FK', '=', 'roles.id')
            ->select('users.*', 'roles.name as role')
            ->get();

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        // $user = DB::table('users')
        //     ->join('roles', 'users.role_FK', '=', 'roles.id')
        //     ->where('users.id', '=', $id)
        //     ->select('users.*', 'roles.name as role')
        //     ->get();

        return view('users.edit', ['user' => User::findOrFail($id)]);
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
        $user = User::findOrFail($id);

        $status = $user->update($request->all());

        if ($status) {
            Session::flash('success', 'Usuário alterado com sucesso!');
            return redirect('users');
        }

        Session::flash('error', 'Ocorreu um erro ao alterar o usuário!');
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id != Auth::id()) {
            User::destroy($id);
            Session::flash('success', 'Usuário excluído com sucesso!');
        } else {
            Session::flash('error', 'Você não pode excluir o próprio usuário!');
        }

        return redirect('users');
    }
}
