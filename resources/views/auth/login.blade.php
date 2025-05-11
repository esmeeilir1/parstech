<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ورود به سیستم</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h2>ورود به حساب کاربری</h2>
            <div class="input-group">
                <label for="email">ایمیل</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="input-group">
                <label for="password">رمز عبور</label>
                <input type="password" name="password" id="password" required>
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="input-group remember">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">مرا به خاطر بسپار</label>
            </div>
            <button type="submit" class="btn">ورود</button>
            <div class="footer-link">
                <a href="{{ route('register') }}">حساب کاربری ندارید؟ ثبت‌نام کنید</a>
            </div>
        </form>
    </div>
    <script>
        window.laravelSession = {
            success: @json(session('success')),
            error: @json(session('error'))
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>
