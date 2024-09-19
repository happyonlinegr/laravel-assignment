<!DOCTYPE html>
<html>
<head>
    <title>Thanks for commenting.</title>
</head>
<body>
    <h1>Welcome to {{ config('app.name') }}</h1>
    <h2>Thank you for commenting on {{ $comment->post->title }}</h2>
    <h3>You commented :</h3>
    <p>{{$comment->content}}</p>
</body>
</html>