<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/auth.css">
</head>

<body>
    <div class="mobile-container">
        <div class="auth-container">
            @yield('content')
        </div>
    </div>
    
    @include('partials.native-alert')
</body>

</html>