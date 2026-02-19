<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title></title>
    @vite('resources/css/app.css')
</head>
<body>
<main id="main-content" class="max-w-7xl mx-auto px-6 py-12 space-y-12">
    {{ $slot }}
</main>
</body>
</html>
