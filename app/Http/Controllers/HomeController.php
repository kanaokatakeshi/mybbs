<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $query = Post::query();
        $posts = $query->latest()->paginate(10);

        return view('home', compact('posts'));
    }

    public function edit(Request $request)
    {
        $query = Post::query();

        // dd($request->user());
        if ($request->user()) {
            $query->where('user_id', $request->user()->id);
        }

        $posts = $query->latest()->get();

        return view('user.profile', compact('posts'));
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
