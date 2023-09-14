@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="card mt-3">
                    <div class="card-header">新規投稿</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mt-2">
                                <label for="title">タイトル</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ isset($post) ? $post->title : old('title') }}" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="content">内容</label>
                                <textarea name="content" id="content" class="form-control" rows="15" required>
                                    {{ isset($post) ? $post->content : old('content') }}</textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="image">画像</label>
                                <input type="file" name="image" id="image" class="form-control-file">
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">投稿する</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
