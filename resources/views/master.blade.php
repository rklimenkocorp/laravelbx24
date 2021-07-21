<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="//api.bitrix24.com/api/v1/"></script>
</head>
<body style="margin: 0; padding: 0;background: transparent;">
<div class="workarea">
    @yield('content')
</div>
</body>
</html>
