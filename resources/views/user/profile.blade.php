@extends('layouts.app')
@section('title', 'プロフィール')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            {{-- 過去の投稿 --}}
            <div class="col-lg-4">
                @forelse ($posts as $post)
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- 掲示板のタイトル -->
                            <h5 class="card-title mt-1"><a class="text-decoration-none"
                                    href="{{ route('post.show', ['post' => $post->id]) }}">
                                    {{ $post->title }}
                                    @if ($post->image)
                                        <span class="text-primary">【画像あり】</span>
                                    @endif
                                </a></h5>
                            <!-- 投稿日時 -->
                            <small class="text-muted">投稿日時: {{ $post->created_at . ' @' . $post->user->name }}</small>
                        </div>
                        <div class="card-body">
                            <!-- 掲示板の内容 -->
                            <p class="card-text">{{ $post->content }}</p>
                            <small class="text-muted">返信数:
                                {{ isset($post->comments) ? "{$post->comments->count()} 件" : '0件' }}</small>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="12">過去にした投稿がありません</td>
                    </tr>
                @endforelse
            </div>
            {{-- 過去にしたコメントとコメント先の投稿 --}}
            <div class="col-lg-4">
                @forelse ($comments as $index => $comment)
                    {{-- 過去にしたコメント --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="card-text">
                                <h5 class="card-title mt-1">{{ $comment->content }}</h5>
                                <small class="text-muted">コメント日時:
                                    {{ $comment->created_at . ' @' . $comment->user->name }}</small>
                            </div>
                        </div>
                    </div>
                    <span class="text-muted d-flex justify-content-center">|</span>
                    {{-- コメント先の投稿 --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- コメント先の投稿のタイトル -->
                            <h5 class="card-title mt-1"><a class="text-decoration-none"
                                    href="{{ route('post.show', ['post' => $comment->post_id]) }}">
                                    {{ $comment->post->title }}
                                    @if ($comment->post->image)
                                        <span class="text-primary">【画像あり】</span>
                                    @endif
                                </a></h5>
                            <!-- 投稿日時 -->
                            <small class="text-muted">投稿日時:
                                {{ $comment->post->created_at . ' @' . $comment->post->user->name }}</small>
                        </div>
                        <div class="card-body">
                            <!-- コメント先の投稿の内容 -->
                            <p class="card-text">{{ $comment->post->content }}</p>
                            <small class="text-muted">返信数:
                                {{ isset($comment->post->comments) ? "{$comment->post->comments->count()} 件" : '0件' }}</small>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="12">過去にしたコメントがありません</td>
                    </tr>
                @endforelse
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('ユーザー情報の編集') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ auth()->user()->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ auth()->user()->email }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        minlength="8" autocomplete="new-password">

                                    {{-- @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>
                            </div>

                            {{-- <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div> --}}

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('更新') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="button" class="btn btn-primary">haha</button>
    <script>
        const url = '/api/my-comments';

        const getMyComments = async () => {
            const res = await fetch(url);
            const posts = await res.json();
            console.log(posts);
        }

        document.querySelector('#button').addEventListener('click', (e) => {
            getMyComments();
        })
    </script>
@endsection
