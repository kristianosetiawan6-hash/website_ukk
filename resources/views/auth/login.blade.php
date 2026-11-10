<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#20264f">
    <title>Masuk | Ruang Gaji</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="login-page">
    <main class="login-layout">
        <section class="login-intro">
            <a class="login-brand" href="{{ route('login') }}"><span class="login-brand-mark">R</span><span>ruang<span>gaji</span></span></a>
            <div class="login-intro-copy">
                <span class="login-kicker">PEOPLE & PAYROLL</span>
                <h1><span id="loginGreeting">Selamat datang</span>, Ruang Gaji.</h1>
                <p>Kelola penggajian dengan lebih tenang dalam satu ruang kerja.</p>
            </div>
            <div class="login-issue"><span></span> Akses aman untuk tim Anda</div>
        </section>
        <section class="login-panel" aria-labelledby="loginTitle">
            <div class="login-panel-inner">
                <div class="login-heading"><span class="login-kicker">AKSES FLEKSIBEL</span><h2 id="loginTitle">Masuk ke Ruang Gaji</h2><p>Pakai identitas dan kata sandi pilihan Anda, atau lanjut sebagai tamu.</p></div>
                @if ($errors->any())
                    <div class="login-error" role="alert">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('login.store') }}" class="login-form">
                    @csrf
                    <label class="login-field"><span>Email atau nama pengguna</span><input type="text" name="identifier" value="{{ old('identifier') }}" autocomplete="username" placeholder="Bebas, misalnya staf-01" required autofocus></label>
                    <label class="login-field"><span>Kata sandi pilihan Anda</span><input type="password" name="password" autocomplete="current-password" placeholder="Bebas, minimal satu karakter" required></label>
                    <label class="login-remember"><input type="checkbox" name="remember" value="1"> <span>Ingat saya di perangkat ini</span></label>
                    <button class="login-submit" type="submit">Masuk ke dashboard <span aria-hidden="true">→</span></button>
                </form>
                <div class="login-alternatives"><span>Akun baru akan dibuat sebagai User.</span><a href="{{ route('register') }}">Daftar dengan email</a></div>
                <a class="login-guest" href="{{ route('dashboard') }}">Batal, kembali ke website <span aria-hidden="true">→</span></a>
                <p class="login-footnote">Mode tamu hanya dapat melihat data dan laporan.</p>
            </div>
        </section>
    </main>
    <script>
        const loginHour = new Date().getHours();
        const loginGreeting = loginHour >= 4 && loginHour < 11
            ? 'Selamat pagi'
            : loginHour < 15 && loginHour >= 11
                ? 'Selamat siang'
                : loginHour < 19 && loginHour >= 15
                    ? 'Selamat sore'
                    : 'Selamat malam';
        document.querySelector('#loginGreeting').textContent = loginGreeting;
    </script>
</body>
</html>