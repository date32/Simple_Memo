<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;



class MemoController extends Controller
{
    public function index()
    {
        $memos = Memo::where('status', true)->get();
        $user = Auth::user();
        return Inertia::render('Memo/Index', ['user' => $user, 'memos' => $memos]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $memo = new Memo();
        $memo->memo = $data['memo'];
        $memo->status = true;
        $memo->save();
        return response()->json($memo);
    }

    public function update(Request $request, string $id)
    {
        $memo = Memo::find($id);
        $data = $request->all();
        $memo->memo = $data['memo'];
        $memo->save();
        return response()->json($memo);
    }

    public function delete(Request $request, string $id)
    {
        $memo = Memo::find($id);
        $memo->status = false;
        $memo->save();
        return response()->json($memo);
    }

    public function welcome()
    {
        return Inertia::render('Memo/Welcome');
        
    }

    public function login()
    {
        return Inertia::render('Memo/Login');
        // $user = Auth::user();
        // if (!$user) {
        //     return Inertia::render('Memo/Login');
        // } else {
        //     return Redirect::route('index');
        // }
    }

    public function register()
    {

        return Inertia::render('Memo/Register');
        
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome');
    }
}
