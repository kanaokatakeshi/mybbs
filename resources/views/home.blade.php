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
        </div>
        @if ($posts->total() > 0)
            {{ $posts->appends(request()->query())->links() }}
        @endif
    </div>
@endsection
