@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="card mb-2">
                    <div class="card-header">
                        <!-- 掲示板のタイトル -->
                        <h5 class="card-title mt-1">{{ $post->title }}</h5>
                        <!-- 投稿日時 -->
                        <small class="text-muted">投稿日時: {{ $post->created_at . ' @' . $post->user->name }}</small>
                    </div>
                    <div class="card-body">
                        <!-- 掲示板の内容 -->
                        @if (isset($post->image))
                            <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->title }}" width="600"
                                height="500">
                        @endif
                        <p class="mt-2 mb-0">{{ $post->content }}</p>
                        <div class="d-flex justify-content-end">
                            {{-- <span class="">
                                <a href="{{ route('home') }}" role="button" class="btn btn-outline-secondary me-2">戻る</a>
                            </span> --}}

                            @if (Auth::user()->id === $post->user_id)
                                <a href="{{ route('post.edit', ['post' => $post->id]) }}" role="button"
                                    class="btn btn-outline-secondary me-3">編集</a>
                                <form method="POST" action="{{ route('post.destroy', ['post' => $post->id]) }}"
                                    class="me-2" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">削除</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-auto">
                    @foreach ($comments as $index => $comment)
                        {{-- コメント --}}
                        <span class="text-muted d-flex justify-content-center">|</span>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-text">
                                    <div class="d-flex justify-content-start">
                                        {{-- 編集ボタン押下時に出る入力フォーム --}}
                                        <form id="js-edit-form_{{ $index }}" class="form-group" method="POST"
                                            action="{{ route('comment.update', ['comment' => $comment->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <label for="content">編集</label>
                                            <textarea class="form-control" name="content" id="content" cols="125" rows="3" required>{{ $comment->content }}</textarea>
                                            <div id="js-sending-button_{{ $index }}" class="">
                                                {{-- <input type="hidden" name="post_id" value={{ $post->id }}> --}}
                                                <button type="submit" value=""
                                                    class="btn btn-outline-primary">変更</button>
                                            </div>
                                        </form>
                                    </div>
                                    <h5 id="js-comment-content_{{ $index }}" class="card-title mt-1">
                                        {{ $comment->content }}</h5>
                                    <small class="text-muted">コメント日時:
                                        {{ $comment->created_at . ' @' . $comment->user->name }}</small>
                                </div>
                                {{-- コメントの編集ボタンと削除ボタン --}}
                                <div class="row">
                                    <div class="d-flex justify-content-between">
                                        {{-- 編集ボタンを押したら送信ボタンとフォームが出てくる --}}
                                        @if (Auth::user()->id === $comment->user_id)
                                            <div class="d-flex">
                                                <div id="js-edit-button" role="button"
                                                    class="btn btn-outline-secondary me-3"
                                                    onclick="showForm({{ $index }})">編集
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('comment.destroy', ['comment' => $comment->id]) }}"
                                                    class="me-2" onsubmit="return confirm('本当に削除しますか？');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">削除</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- コメントの新規投稿 --}}
                {{-- <span class="text-muted d-flex justify-content-center">|</span> --}}
                <div class="card mt-3">
                    <div class="card-header">コメントする</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('comment.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="content">内容</label>
                                <textarea name="content" id="content" class="form-control" rows="10" required></textarea>
                            </div>
                            <input type="hidden" name="post_id" value={{ $post->id }}>
                            <button type="submit" class="btn btn-primary mt-3">コメントする</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    console.log(comments);
    @php
        $json_array = json_encode($comments);
    @endphp
    <script>
        let comments = JSON.parse('<?php echo $json_array; ?>');
        console.log(comments);
        comments.forEach((comment, index) => {
            const js_edit_form = document.getElementById('js-edit-form_' + index);
            const js_sending_button = document.getElementById('js-sending-button_' + index);
            js_edit_form.style.display = "none";
            js_sending_button.style.display = "none";
        });

        function showForm(index) {
            // console.log(aaa);
            const js_edit_form = document.getElementById('js-edit-form_' + index);
            const js_sending_button = document.getElementById('js-sending-button_' + index);
            const js_comment_content = document.getElementById('js-comment-content_' + index);

            if (js_edit_form.style.display === "none") {
                js_edit_form.style.display = "block";
                js_sending_button.style.display = "block";
                js_comment_content.style.display = "none";
            } else {
                js_edit_form.style.display = "none";
                js_sending_button.style.display = "none";
                js_comment_content.style.display = "block";
            }

        };
    </script>
@endsection
