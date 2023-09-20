<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        \DB::beginTransaction();

        try {

            $user = Auth::user(); // ユーザーを認証済みのユーザーから取得

            $data = $request->all(); // バリデーション済みのデータを取得

            $comment = $user->comments()->create($data);
            if ($comment) {
                // コメントが保存されたユーザー（投稿者）を取得
                $postAuthor = $comment->post->user;

                // メール通知を送信
                Notification::send($postAuthor, new CommentNotification($comment));
            }
            DB::commit();

            return redirect()->route('post.show', ['post' => $comment->post_id])->with('success', '投稿しました。');
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
            return redirect()->back()->with('fail', '投稿に失敗しました。エラー: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, $id)
    {
        dd(3);
        DB::beginTransaction();
        try {
            $data = $request->all();

            $comment = Comment::findOrFail($id);
            $comment->update([
                'content' => $data['content'],
            ]);

            DB::commit();
            return redirect()->route('comment.show', ['comment' => $comment->id])->with('success', '更新しました。');
        } catch (\Exception $e) {
            report($e);
            \DB::rollback();
            return redirect()->back()->with('fail', '編集に失敗しました');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $comment = comment::findOrFail($id);
            $comment->delete();

            \DB::commit();
            return redirect()->route('post.show', ['post' => $comment->post_id])->with('success', '削除しました');
        } catch (\Exception $e) {
            report($e);
            \DB::rollBack();
            return redirect()->back()->with('fail', '削除に失敗しました。エラー:' . $e->getMessage());
        }
    }
}
