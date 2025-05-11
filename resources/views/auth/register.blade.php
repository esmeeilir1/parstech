<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام کاربر جدید</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h2>ثبت‌نام کاربر جدید</h2>
            <div class="input-group">
                <label for="name">نام کامل</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>
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
            <div class="input-group">
                <label for="password_confirmation">تکرار رمز عبور</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>
            <button type="submit" class="btn">ثبت‌نام</button>
            <div class="footer-link">
                <a href="{{ route('login') }}">حساب کاربری دارید؟ ورود</a>
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
