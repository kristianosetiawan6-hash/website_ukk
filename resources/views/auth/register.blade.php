<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#20264f">
    <title>Buat akun | Ruang Gaji</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="login-page">
    <main class="login-layout">
        <section class="login-intro">
            <a class="login-brand" href="{{ route('login') }}"><span class="login-brand-mark">R</span><span>ruang<span>gaji</span></span></a>
            <div class="login-intro-copy"><span class="login-kicker">AKUN BARU</span><h1>Mulai kelola pekerjaan dengan lebih rapi.</h1><p>Buat akun User untuk menyimpan akses dan kembali kapan saja.</p></div>
            <div class="login-issue"><span></span> Akun baru mendapat akses User</div>
        </section>
        <section class="login-panel" aria-labelledby="registerTitle">
            <div class="login-panel-inner">
                <div class="login-heading"><span class="login-kicker">DAFTAR AKUN USER</span><h2 id="registerTitle">Buat akun Anda</h2><p>Gunakan email milik Anda dan buat kata sandi sendiri.</p></div>
                @if ($errors->any())<div class="login-error" role="alert">{{ $errors->first() }}</div>@endif
                <form method="POST" action="{{ route('register.store') }}" class="login-form">
                    @csrf
                    <label class="login-field"><span>Nama lengkap</span><input type="text" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Nama Anda" required autofocus></label>
                    <label class="login-field"><span>Email</span><input type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="nama@perusahaan.co.id" required></label>
                    <label class="login-field"><span>Kata sandi</span><input type="password" name="password" autocomplete="new-password" placeholder="Minimal 8 karakter" required></label>
                    <label class="login-field"><span>Ulangi kata sandi</span><input type="password" name="password_confirmation" autocomplete="new-password" placeholder="Masukkan lagi kata sandi" required></label>
                    <button class="login-submit" type="submit">Buat akun dan masuk <span aria-hidden="true">→</span></button>
                </form>
                <div class="login-alternatives"><span>Sudah memiliki akun?</span><a href="{{ route('login') }}">Kembali ke login</a></div>
                <form method="POST" action="{{ route('guest.start') }}">@csrf<button class="login-guest" type="submit">Lanjut tanpa login <span aria-hidden="true">→</span></button></form>
            </div>
        </section>
    </main>
</body>
</html>