<!DOCTYPE html>
<html>

<head>
    <title>コメント通知</title>
</head>

<body>
    <p>投稿に新しいコメントが追加されました。</p>
    <p>コメント内容: {{ $commentText }}</p>
    <p>投稿のリンク: <a href="{{ $postLink }}">{{ $postTitle }}</a></p>
</body>

</html>
