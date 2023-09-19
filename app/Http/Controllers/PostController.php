<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
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

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
                $data['image'] = $imageName; // 画像がアップロードされた場合、データに画像名を追加
            }

            $post = $user->posts()->create($data);
            DB::commit();

            return redirect()->route('home')->with('success', '投稿しました。');
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
            return redirect()->back()->with('fail', '投稿に失敗しました。エラー: ' . $e->getMessage());
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
    public function edit(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        return view('post.form', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();

            $post = Post::findOrFail($id);
            $post->update([
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
            ]);

            DB::commit();
            return redirect()->route('post.show', ['post' => $post->id])->with('success', '更新しました。');
        } catch (\Exception $e) {
            report($e);
            \DB::rollback();
            return redirect()->back()->with('fail', '編集に失敗しました');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $post = Post::findOrFail($id);
            $post->delete();

            \DB::commit();
            return redirect()->route('home')->with('success', '削除しました');
        } catch (\Exception $e) {
            report($e);
            \DB::rollBack();
            return redirect()->back()->with('fail', '削除に失敗しました。エラー:' . $e->getMessage());
        }
    }
}
