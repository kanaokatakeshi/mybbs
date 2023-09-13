@extends('layouts.app')
@section('title', 'プロフィール')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-4">
                @forelse ($posts as $post)
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
                @empty
                    <tr>
                        <td colspan="12">データがありません</td>
                    </tr>
                @endforelse
            </div>
            {{-- ここは後でちゃんとする --}}
            <div class="col-md-4">
                @for ($i = 0; $i < 10; $i++)
                    <div class="card mb-4">
                        <div class="card-header">{{ __('コメント') }}</div>

                        <div class="card-body">
                            <ul style="padding-left: 0; list-style: none;">
                                <li>うおおおおおおおおおおおおおおお</li>
                            </ul>
                        </div>
                    </div>
                @endfor
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
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
@endsection
