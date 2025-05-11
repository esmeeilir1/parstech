<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>حسابیر | ورود / ثبت نام</title>
    <link rel="stylesheet" href="fonts/fonts.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                fontFamily: { 'sans': ['AnjomanMax', 'Tahoma', 'sans-serif'] },
                extend: {
                    colors: {
                        primary: '#2563eb', accent: '#f59e42', background: '#f9fafb', dark: '#18181b',
                    }
                },
            },
            rtl: true,
        }
    </script>
    <style>
        body { font-family: 'AnjomanMax', Tahoma, sans-serif !important; background: #f9fafb; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
