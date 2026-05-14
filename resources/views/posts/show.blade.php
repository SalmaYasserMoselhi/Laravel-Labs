<!DOCTYPE html>
<html>
<head>
    <title>Show Post</title>
</head>
<body>
    <h1>Show Post</h1>
    <p>Post ID: {{ $post['id'] }}</p>
    <p>Post Title: {{ $post['title'] }}</p>
    <p>Post Content: {{ $post['content'] }}</p>
    <a href="/posts/{{ $post['id'] }}/edit">Edit</a>
    <form action="/posts/{{ $post['id'] }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    <br><br>
    <a href="/posts">Back to posts</a>
</body>
</html>