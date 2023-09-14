<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view('post.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        \DB::beginTransaction();

        try {
            $user = Auth::user(); // ユーザーを認証済みのユーザーから取得

            $data = $request->validated(); // バリデーション済みのデータを取得

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
                $data['image'] = $imageName; // 画像がアップロードされた場合、データに画像名を追加
            }

            $post = $user->posts()->create($data);

            DB::commit();

            return redirect()->route('home')->with('success', '投稿が成功しました。');
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
            return redirect()->back()->with('error', '投稿に失敗しました。エラー: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $comments = Comment::where('post_id', $id)->get();
        return  view('post.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
