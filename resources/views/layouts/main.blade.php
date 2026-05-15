<!DOCTYPE html>
<html>
<head>
    <title>
        @yield('title', 'Main Layout')
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1 style="text-align: center;">My Blog</h1>
    @yield('content')
</body>
</html>
