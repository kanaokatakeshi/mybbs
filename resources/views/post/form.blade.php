@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="card mb-4">
                    <div class="card-header">
                        <!-- 掲示板のタイトル -->
                        <h5 class="card-title mt-1">{{ $post->title }}</h5>
                        <!-- 投稿日時 -->
                        <small class="text-muted">投稿日時: {{ $post->created_at . ' @' . $post->user->name }}</small>
                    </div>
                    <div class="card-body">
                        <!-- 掲示板の内容 -->
                        <p class="card-text">{{ $post->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
