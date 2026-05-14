<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
</head>
<body>
    <h1>Posts</h1>
    <ul>
        @foreach ($posts as $post)
            <li>
                {{ $post['title'] }}
                <a href="/posts/{{ $post['id'] }}">View Post</a>
            </li>
        @endforeach

    </ul>
</body>
</html>
