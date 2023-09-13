<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function edit()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        \DB::beginTransaction();
        try {
            $user = Auth()->user();
            $user->update($request->all());
            \DB::commit();
        } catch (\Exception $e) {
            report($e);
            \DB::rollback();
            return redirect()->back()->with('fail', '編集に失敗しました');
        }
        return redirect()->route('profile.edit');
    }
}
