<!DOCTYPE html>
<html lang="id" class="login-html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasterIP — Login Portal EDP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page-body">
    <div id="login-root" data-props="{{ json_encode([
        'csrfToken' => csrf_token(),
        'loginUrl' => route('login.post'),
        'registerUrl' => route('register'),
        'oldNik' => old('NIK', ''),
        'errorMessage' => session('error') ?? ($errors->any() ? $errors->first() : null),
        'successMessage' => session('success'),
    ]) }}"></div>
</body>
</html>