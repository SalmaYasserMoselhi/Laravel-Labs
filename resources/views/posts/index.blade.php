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
                <a href="/posts/{{ $post['id'] }}/edit">Edit</a>
                <form action="/posts/{{ $post['id'] }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach

    </ul>
</body>
</html>
