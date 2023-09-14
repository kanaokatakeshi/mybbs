@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($posts->total() > 0)
            {{ $posts->appends(request()->query())->links() }}
        @endif
        <div class="row">
            <div class="col-lg-10">
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
                            <small class="text-muted">返信数: {{ isset($post->comments) ? "{$post->comments->count()} 件" : '0件' }}</small>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="12">データがありません</td>
                    </tr>
                @endforelse
            </div>
        </div>
        @if ($posts->total() > 0)
            {{ $posts->appends(request()->query())->links() }}
        @endif
    </div>
@endsection
