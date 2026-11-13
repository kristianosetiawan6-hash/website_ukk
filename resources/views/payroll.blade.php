<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#20264f">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ruang Gaji | Sistem Penggajian</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<svg xmlns="http://www.w3.org/2000/svg" style="position:absolute;width:0;height:0;overflow:hidden" aria-hidden="true">
    <symbol id="i-grid" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
    <symbol id="i-wallet" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="15" rx="2"/><path d="M3 9h18M16 15h.01M7 5V3h12"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></symbol>
    <symbol id="i-chart" viewBox="0 0 24 24"><path d="M3 3v18h18M18 17V9M13 17V5M8 17v-3"/></symbol>
    <symbol id="i-settings" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="m19.4 15 .1.1a1.7 1.7 0 1 1-2.4 2.4l-.1-.1a1.7 1.7 0 0 0-2.9 1.2v.3a1.7 1.7 0 1 1-3.4 0v-.2a1.7 1.7 0 0 0-2.9-1.2l-.1.1a1.7 1.7 0 1 1-2.4-2.4l.1-.1a1.7 1.7 0 0 0-1.2-2.9h-.3a1.7 1.7 0 1 1 0-3.4h.2a1.7 1.7 0 0 0 1.2-2.9l-.1-.1a1.7 1.7 0 1 1 2.4-2.4l.1.1a1.7 1.7 0 0 0 2.9-1.2v-.3a1.7 1.7 0 1 1 3.4 0v.2a1.7 1.7 0 0 0 2.9 1.2l.1-.1a1.7 1.7 0 1 1 2.4 2.4l-.1.1a1.7 1.7 0 0 0 1.2 2.9h.3a1.7 1.7 0 1 1 0 3.4h-.2a1.7 1.7 0 0 0-1.2 2.9Z"/></symbol>
    <symbol id="i-bell" viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></symbol>
    <symbol id="i-menu" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></symbol>
    <symbol id="i-plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
    <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></symbol>
    <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14m-7-7 7 7-7 7"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><path d="m5 12 4 4L19 6"/></symbol>
    <symbol id="i-file" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h8"/></symbol>
    <symbol id="i-calendar" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 11h18"/></symbol>
    <symbol id="i-close" viewBox="0 0 24 24"><path d="m18 6-12 12M6 6l12 12"/></symbol>
    <symbol id="i-help" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M9.6 9a2.5 2.5 0 1 1 4.4 1.6c-1 1.1-2 1.2-2 3M12 17h.01"/></symbol>
    <symbol id="i-download" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></symbol>
</svg>
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <a href="#dashboard" class="brand" data-page-link="dashboard" style="text-decoration:none">
            <span class="brand-mark"><svg class="icon"><use href="#i-wallet"/></svg></span>
            <span>ruang<span style="color:#8ee8d0">gaji</span><small>PEOPLE & PAYROLL</small></span>
        </a>
        <div class="side-label">Menu utama</div>
        <nav class="side-nav" aria-label="Navigasi utama">
            <button class="nav-link active" data-page-link="dashboard"><svg class="icon"><use href="#i-grid"/></svg>Ringkasan</button>
            @if ($isAdmin)
            <button class="nav-link" data-page-link="employees"><svg class="icon"><use href="#i-users"/></svg>Data pegawai</button>
            @endif
            <button class="nav-link" data-page-link="payroll"><svg class="icon"><use href="#i-wallet"/></svg>Penggajian<span class="nav-count">0</span></button>
            @if ($isAdmin)
            <button class="nav-link" data-page-link="attendance"><svg class="icon"><use href="#i-clock"/></svg>Absensi</button>
            @endif
            <button class="nav-link" data-page-link="reports"><svg class="icon"><use href="#i-chart"/></svg>Laporan</button>
        </nav>
        @if ($isAdmin)
        <div class="side-label">Preferensi</div>
        <nav class="side-nav" aria-label="Preferensi"><button class="nav-link" data-page-link="settings"><svg class="icon"><use href="#i-settings"/></svg>Pengaturan</button></nav>
        @endif
        <div class="side-spacer"></div>
        <div class="sidebar-help"><svg class="icon"><use href="#i-help"/></svg><div><strong>Butuh bantuan?</strong><span>Tim kami siap membantu Anda.</span></div></div>
        <div class="profile"><div class="avatar" style="background:#e1ead7;color:#506c41">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($currentUser?->displayName() ?? 'Tamu', 0, 2)) }}</div><div class="profile-copy"><strong>{{ $currentUser?->displayName() ?? 'Tamu' }}</strong><span class="role-tag {{ $isAdmin ? 'admin' : ($isGuest ? 'guest' : 'user') }}">{{ $isAdmin ? 'ADMINISTRATOR' : ($isGuest ? 'AKSES TAMU' : 'USER') }}</span></div><form method="POST" action="{{ $isGuest ? route('guest.exit') : route('logout') }}">@csrf<button class="logout-button" type="submit" aria-label="{{ $isGuest ? 'Keluar dari mode tamu' : 'Keluar dari akun' }}">Keluar</button></form></div>
    </aside>
    <div class="sidebar-scrim" id="sidebarScrim"></div>
    <main class="main-area">
        <header class="topbar">
            <button class="icon-button mobile-menu" id="menuToggle" aria-label="Buka navigasi"><svg class="icon"><use href="#i-menu"/></svg></button>
            <div class="breadcrumb"><span>Ruang Gaji</span><span>/</span><strong id="breadcrumbTitle">Ringkasan</strong></div>
            <div class="top-actions">
                <label class="sr-only" for="monthSelect">Periode</label>
                <select class="period-select" id="monthSelect" aria-label="Pilih periode"><option>September 2026</option><option>Agustus 2026</option><option>Juli 2026</option></select>
                @auth
                <form class="topbar-logout-form" method="POST" action="{{ route('logout') }}">@csrf<button class="button secondary topbar-logout" type="submit" aria-label="Keluar dari akun">Keluar</button></form>
                @endauth
                <button class="icon-button" id="notificationButton" aria-label="Notifikasi"><svg class="icon"><use href="#i-bell"/></svg><span class="notification-dot"></span></button>
            </div>
        </header>
        <div class="content">
            <section class="page-view active" data-page="dashboard">
                <div class="page-heading"><div><div class="eyebrow">Rabu, 30 September 2026</div><h1><span id="dashboardGreeting">Selamat datang</span>, {{ explode(' ', $currentUser?->displayName() ?? 'Tamu')[0] }}</h1><p>{{ $isAdmin ? 'Kelola pegawai dan operasional penggajian perusahaan.' : 'Ringkasan penggajian dan laporan perusahaan.' }}</p></div>@if ($isAdmin)<button class="button" data-open-modal="employeeModal"><svg class="icon"><use href="#i-plus"/></svg>Tambah pegawai</button>@endif</div>
                <div class="stats-grid">
                    <article class="stat-card"><div class="stat-top">Total pegawai <span class="stat-icon"><svg class="icon"><use href="#i-users"/></svg></span></div><strong class="stat-value" id="employeeCount">0</strong><div class="stat-foot"><span class="trend">0%</span> dibanding bulan lalu</div></article>
                    <article class="stat-card"><div class="stat-top">Total penggajian <span class="stat-icon orange"><svg class="icon"><use href="#i-wallet"/></svg></span></div><strong class="stat-value" id="dashboardPayrollSummaryTotal">{{ $processedPayroll ? 'Rp'.number_format($processedPayroll['total'], 0, ',', '.') : 'Rp0' }}</strong><div class="stat-foot">{{ $processedPayroll ? $processedPayroll['count'].' pegawai diproses' : '0% dari periode lalu' }}</div></article>
                    <article class="stat-card"><div class="stat-top">Hadir hari ini <span class="stat-icon yellow"><svg class="icon"><use href="#i-clock"/></svg></span></div><strong class="stat-value" id="attendanceSummaryCount">0 <span style="font-size:14px;color:#859087;font-weight:500">/ 0</span></strong><div class="stat-foot"><span class="trend" id="attendanceSummaryRate">0%</span> tingkat kehadiran</div></article>
                    <article class="stat-card"><div class="stat-top">Menunggu persetujuan <span class="stat-icon blue"><svg class="icon"><use href="#i-calendar"/></svg></span></div><strong class="stat-value" id="pendingApprovalsCount">0</strong><div class="stat-foot"><span class="trend down">Tidak ada yang menunggu</span></div></article>
                </div>
                <div class="dashboard-grid">
                    <section class="panel"><div class="panel-header"><div><h2>Ringkasan penggajian</h2><p>Perbandingan total gaji enam bulan terakhir</p></div><button class="text-button" data-page-link="reports">Lihat laporan <svg class="icon"><use href="#i-arrow"/></svg></button></div>
                        <div class="chart-wrap"><div class="chart" aria-label="Grafik perbandingan penggajian bulanan">
                            <div class="chart-column"><div class="bar-pair"><i class="bar" style="height:48%"></i><i class="bar current" style="height:58%"></i></div><span class="chart-label">Apr</span></div>
                            <div class="chart-column"><div class="bar-pair"><i class="bar" style="height:61%"></i><i class="bar current" style="height:65%"></i></div><span class="chart-label">Mei</span></div>
                            <div class="chart-column"><div class="bar-pair"><i class="bar" style="height:54%"></i><i class="bar current" style="height:63%"></i></div><span class="chart-label">Jun</span></div>
                            <div class="chart-column"><div class="bar-pair"><i class="bar" style="height:68%"></i><i class="bar current" style="height:72%"></i></div><span class="chart-label">Jul</span></div>
                            <div class="chart-column"><div class="bar-pair"><i class="bar" style="height:65%"></i><i class="bar current" style="height:78%"></i></div><span class="chart-label">Agu</span></div>
                            <div class="chart-column"><div class="bar-pair"><i class="bar" style="height:72%"></i><i class="bar current" style="height:88%"></i></div><span class="chart-label">Sep</span></div>
                        </div><div class="chart-legend"><span class="legend-key">Gaji pokok</span><span class="legend-key current">Total penggajian</span></div></div>
                    </section>
                    <section class="panel payroll-card"><div class="eyebrow">Periode berjalan</div><h2>Penggajian September 2026</h2><p class="payroll-amount" id="dashboardPayrollCardTotal">{{ $processedPayroll ? 'Rp'.number_format($processedPayroll['total'], 0, ',', '.') : 'Rp0' }}</p><div class="payroll-meta"><div>Pegawai<strong id="dashboardPayrollCardCount">{{ $processedPayroll ? $processedPayroll['count'].' orang' : '0 orang' }}</strong></div><div>Tanggal bayar<strong>30 Sep 2026</strong></div></div>@if ($isAdmin)<button class="button lime" data-open-modal="payrollModal"><svg class="icon"><use href="#i-check"/></svg><span id="processButtonLabel">Proses penggajian</span></button>@else<button class="button lime" data-page-link="payroll">Lihat penggajian</button>@endif</section>
                </div>
                @if ($isAdmin)
                <section class="panel table-panel"><div class="panel-header"><div><h2>Pegawai terbaru</h2><p>Data pegawai yang baru bergabung di perusahaan</p></div><button class="text-button" data-page-link="employees">Semua pegawai <svg class="icon"><use href="#i-arrow"/></svg></button></div>
                    <div class="table-scroll"><table><thead><tr><th>NAMA PEGAWAI</th><th>DEPARTEMEN</th><th>TANGGAL BERGABUNG</th><th>GAJI POKOK</th><th>STATUS</th></tr></thead><tbody id="recentEmployees">
                        <tr><td><div class="person-cell"><div class="avatar" style="background:#f2e1d5;color:#8a5539">AP</div><span><strong>Andi Pratama</strong><small>EMP-0128</small></span></div></td><td>Teknologi</td><td>12 Sep 2026</td><td>Rp12.500.000</td><td><span class="status">Aktif</span></td></tr>
                        <tr><td><div class="person-cell"><div class="avatar" style="background:#e1ead7;color:#506c41">SL</div><span><strong>Siti Lestari</strong><small>EMP-0127</small></span></div></td><td>Keuangan</td><td>08 Sep 2026</td><td>Rp9.800.000</td><td><span class="status">Aktif</span></td></tr>
                        <tr><td><div class="person-cell"><div class="avatar" style="background:#dce8eb;color:#456875">RW</div><span><strong>Rizky Wijaya</strong><small>EMP-0126</small></span></div></td><td>Pemasaran</td><td>02 Sep 2026</td><td>Rp8.500.000</td><td><span class="status">Aktif</span></td></tr>
                        <tr><td><div class="person-cell"><div class="avatar" style="background:#efe2e9;color:#83596b">DN</div><span><strong>Dewi Novitasari</strong><small>EMP-0125</small></span></div></td><td>Operasional</td><td>28 Agu 2026</td><td>Rp7.750.000</td><td><span class="status">Aktif</span></td></tr>
                    </tbody></table></div>
                </section>
                <div class="bottom-grid">
                    <section class="panel"><div class="panel-header"><div><h2>Aktivitas terbaru</h2><p>Pembaruan aktivitas tim HR</p></div><button class="text-button" data-page-link="reports">Lihat semua</button></div><div class="activity-list">
                        <div class="activity"><span class="activity-icon"><svg class="icon"><use href="#i-users"/></svg></span><div class="activity-copy"><strong>Andi Pratama</strong> ditambahkan sebagai pegawai baru</div><time>2 jam lalu</time></div>
                        <div class="activity"><span class="activity-icon orange"><svg class="icon"><use href="#i-file"/></svg></span><div class="activity-copy"><strong>Penggajian Agustus</strong> berhasil diselesaikan</div><time>Kemarin</time></div>
                        <div class="activity"><span class="activity-icon"><svg class="icon"><use href="#i-check"/></svg></span><div class="activity-copy"><strong>12 pengajuan cuti</strong> menunggu persetujuan</div><time>26 Sep</time></div>
                    </div></section>
                    <section class="panel"><div class="panel-header"><div><h2>Agenda tim</h2><p>Pengingat penting bulan ini</p></div><button class="icon-button" aria-label="Kalender"><svg class="icon"><use href="#i-calendar"/></svg></button></div><div class="birthday-card"><div class="birthday-date"><strong>02</strong><span>Okt</span></div><div class="birthday-copy"><strong>Batas persetujuan lembur</strong>Pastikan seluruh lembur September telah ditinjau.</div></div><div class="birthday-card" style="margin-top:-8px"><div class="birthday-date" style="background:#fae8dd;color:#b46548"><strong>03</strong><span>Okt</span></div><div class="birthday-copy"><strong>Transfer gaji bulanan</strong>Jadwal pembayaran untuk periode September.</div></div></section>
                </div>
                @endif
            </section>

            @if ($isAdmin)
            <section class="page-view" data-page="employees">
                <div class="page-heading"><div><div class="eyebrow">Manajemen tim</div><h1>Data pegawai</h1><p>Kelola informasi, departemen, dan status seluruh pegawai.</p></div>@if ($isAdmin)<button class="button" data-open-modal="employeeModal"><svg class="icon"><use href="#i-plus"/></svg>Tambah pegawai</button>@endif</div>
                <div class="stats-grid">
                    <article class="stat-card"><div class="stat-top">Total pegawai<span class="stat-icon"><svg class="icon"><use href="#i-users"/></svg></span></div><strong class="stat-value" id="employeeCountSecondary">0</strong><div class="stat-foot">Seluruh departemen</div></article>
                    <article class="stat-card"><div class="stat-top">Pegawai aktif<span class="stat-icon"><svg class="icon"><use href="#i-check"/></svg></span></div><strong class="stat-value" id="employeeActiveCount">0</strong><div class="stat-foot"><span id="employeeActivePercent">0%</span> dari total pegawai</div></article>
                    <article class="stat-card"><div class="stat-top">Pegawai baru<span class="stat-icon orange"><svg class="icon"><use href="#i-plus"/></svg></span></div><strong class="stat-value" id="newEmployeeCount">0</strong><div class="stat-foot">Bergabung bulan ini</div></article>
                    <article class="stat-card"><div class="stat-top">Departemen<span class="stat-icon blue"><svg class="icon"><use href="#i-grid"/></svg></span></div><strong class="stat-value" id="departmentCount">0</strong><div class="stat-foot">Tim aktif</div></article>
                </div>
                <section class="panel table-panel section-table"><div class="table-toolbar"><h2>Direktori pegawai</h2><div class="table-tools"><label class="search-field"><svg class="icon"><use href="#i-search"/></svg><input id="employeeSearch" type="search" placeholder="Cari nama atau ID..." aria-label="Cari pegawai"></label><select class="filter-select" id="departmentFilter" aria-label="Filter departemen"><option value="">Semua departemen</option><option>Teknologi</option><option>Keuangan</option><option>Pemasaran</option><option>Operasional</option><option>Sumber Daya Manusia</option></select><select class="filter-select" id="statusFilter" aria-label="Filter status"><option value="">Semua status</option><option>Aktif</option><option>Cuti</option></select></div></div>
                    <div class="table-scroll"><table><thead><tr><th>NAMA PEGAWAI</th><th>DEPARTEMEN</th><th>TANGGAL BERGABUNG</th><th>GAJI POKOK</th><th>STATUS</th><th></th></tr></thead><tbody id="employeeTable">
                        <tr data-name="andi pratama" data-department="Teknologi" data-status="Aktif"><td><div class="person-cell"><div class="avatar" style="background:#f2e1d5;color:#8a5539">AP</div><span><strong>Andi Pratama</strong><small>EMP-0128</small></span></div></td><td>Teknologi</td><td>12 Sep 2026</td><td>Rp12.500.000</td><td><span class="status">Aktif</span></td><td><button class="row-menu" aria-label="Opsi Andi Pratama">···</button></td></tr>
                        <tr data-name="siti lestari" data-department="Keuangan" data-status="Aktif"><td><div class="person-cell"><div class="avatar" style="background:#e1ead7;color:#506c41">SL</div><span><strong>Siti Lestari</strong><small>EMP-0127</small></span></div></td><td>Keuangan</td><td>08 Sep 2026</td><td>Rp9.800.000</td><td><span class="status">Aktif</span></td><td><button class="row-menu" aria-label="Opsi Siti Lestari">···</button></td></tr>
                        <tr data-name="rizky wijaya" data-department="Pemasaran" data-status="Aktif"><td><div class="person-cell"><div class="avatar" style="background:#dce8eb;color:#456875">RW</div><span><strong>Rizky Wijaya</strong><small>EMP-0126</small></span></div></td><td>Pemasaran</td><td>02 Sep 2026</td><td>Rp8.500.000</td><td><span class="status">Aktif</span></td><td><button class="row-menu" aria-label="Opsi Rizky Wijaya">···</button></td></tr>
                        <tr data-name="dewi novitasari" data-department="Operasional" data-status="Aktif"><td><div class="person-cell"><div class="avatar" style="background:#efe2e9;color:#83596b">DN</div><span><strong>Dewi Novitasari</strong><small>EMP-0125</small></span></div></td><td>Operasional</td><td>28 Agu 2026</td><td>Rp7.750.000</td><td><span class="status">Aktif</span></td><td><button class="row-menu" aria-label="Opsi Dewi Novitasari">···</button></td></tr>
                        <tr data-name="bima saputra" data-department="Teknologi" data-status="Aktif"><td><div class="person-cell"><div class="avatar" style="background:#e7e3d5;color:#6b603a">BS</div><span><strong>Bima Saputra</strong><small>EMP-0124</small></span></div></td><td>Teknologi</td><td>24 Agu 2026</td><td>Rp11.200.000</td><td><span class="status">Aktif</span></td><td><button class="row-menu" aria-label="Opsi Bima Saputra">···</button></td></tr>
                        <tr data-name="maya putri" data-department="Sumber Daya Manusia" data-status="Cuti"><td><div class="person-cell"><div class="avatar" style="background:#f3e4d7;color:#8a6139">MP</div><span><strong>Maya Putri</strong><small>EMP-0123</small></span></div></td><td>Sumber Daya Manusia</td><td>19 Agu 2026</td><td>Rp8.200.000</td><td><span class="status leave">Cuti</span></td><td><button class="row-menu" aria-label="Opsi Maya Putri">···</button></td></tr>
                        <tr data-name="farhan akbar" data-department="Keuangan" data-status="Aktif"><td><div class="person-cell"><div class="avatar" style="background:#dfebe7;color:#4c7165">FA</div><span><strong>Farhan Akbar</strong><small>EMP-0122</small></span></div></td><td>Keuangan</td><td>15 Agu 2026</td><td>Rp9.000.000</td><td><span class="status">Aktif</span></td><td><button class="row-menu" aria-label="Opsi Farhan Akbar">···</button></td></tr>
                    </tbody></table></div><div class="empty-state" id="emptyEmployees">Tidak ada pegawai yang cocok dengan pencarian.</div></section>
            </section>
            @endif

            <section class="page-view" data-page="payroll">
                <div class="page-heading"><div><div class="eyebrow">Kompensasi & tunjangan</div><h1>Penggajian</h1><p>Ringkasan pembayaran gaji dan status proses setiap periode.</p></div>@if ($isAdmin)<button class="button" data-open-modal="payrollModal"><svg class="icon"><use href="#i-check"/></svg>Proses penggajian</button>@endif</div>
                <div class="payroll-summary"><div class="summary-item"><span>Total penggajian periode ini</span><strong id="payrollPeriodTotal">{{ $processedPayroll ? 'Rp'.number_format($processedPayroll['total'], 0, ',', '.') : 'Rp0' }}</strong></div><div class="summary-item"><span>Pegawai dalam penggajian</span><strong id="payrollPeriodCount">{{ $processedPayroll ? $processedPayroll['count'].' orang' : '0 orang' }}</strong></div><div class="summary-item"><span>Status periode</span><strong id="payrollStatus" style="color:#bb7f35">{{ $processedPayroll['status'] ?? 'Menunggu proses' }}</strong></div></div>
                <section class="panel table-panel section-table"><div class="panel-header"><div><h2>Riwayat penggajian</h2><p>Rekap pembayaran gaji bulanan perusahaan</p></div><div class="report-actions"><button class="button secondary" data-export><svg class="icon"><use href="#i-download"/></svg>Excel</button><button class="button secondary" data-print><svg class="icon"><use href="#i-file"/></svg>PDF</button></div></div><div class="table-scroll"><table><thead><tr><th>PERIODE</th><th>JUMLAH PEGAWAI</th><th>TOTAL GAJI</th><th>TANGGAL BAYAR</th><th>STATUS</th></tr></thead><tbody id="payrollHistory"><tr><td><strong>{{ $processedPayroll['period'] ?? 'September 2026' }}</strong></td><td>{{ $processedPayroll ? $processedPayroll['count'].' orang' : '128 orang' }}</td><td>{{ $processedPayroll ? 'Rp'.number_format($processedPayroll['total'], 0, ',', '.') : 'Rp842.500.000' }}</td><td>30 Sep 2026</td><td><span class="{{ $processedPayroll ? 'status' : 'status leave' }}" id="payrollHistoryStatus">{{ $processedPayroll['status'] ?? 'Menunggu proses' }}</span></td></tr><tr><td><strong>Agustus 2026</strong></td><td>122 orang</td><td>Rp823.100.000</td><td>31 Agu 2026</td><td><span class="status">Selesai</span></td></tr><tr><td><strong>Juli 2026</strong></td><td>121 orang</td><td>Rp806.400.000</td><td>31 Jul 2026</td><td><span class="status">Selesai</span></td></tr><tr><td><strong>Juni 2026</strong></td><td>119 orang</td><td>Rp798.750.000</td><td>30 Jun 2026</td><td><span class="status">Selesai</span></td></tr><tr><td><strong>Mei 2026</strong></td><td>117 orang</td><td>Rp781.200.000</td><td>30 Mei 2026</td><td><span class="status">Selesai</span></td></tr></tbody></table></div></section>
            </section>

            @if ($isAdmin)
            <section class="page-view" data-page="attendance">
                <div class="page-heading"><div><div class="eyebrow">Kehadiran tim</div><h1>Absensi</h1><p>Pantau kehadiran dan tindak lanjut tim hari ini.</p></div><button class="button secondary" data-export><svg class="icon"><use href="#i-download"/></svg>Ekspor absensi</button></div>
                <div class="attendance-banner"><div><div class="eyebrow">Rabu, 30 September 2026</div><h2>Kehadiran berjalan baik hari ini</h2><p>0 pegawai belum mencatatkan kehadiran. Periksa daftar sebelum akhir hari.</p></div><div class="attendance-rate" id="attendanceRate">0%</div></div>
                <div class="stats-grid" style="margin-top:15px"><article class="stat-card"><div class="stat-top">Hadir tepat waktu<span class="stat-icon"><svg class="icon"><use href="#i-check"/></svg></span></div><strong class="stat-value" id="attendanceOnTimeCount">0</strong><div class="stat-foot">0% dari seluruh pegawai</div></article><article class="stat-card"><div class="stat-top">Terlambat<span class="stat-icon orange"><svg class="icon"><use href="#i-clock"/></svg></span></div><strong class="stat-value" id="attendanceLateCount">0</strong><div class="stat-foot">Perlu ditinjau oleh HR</div></article><article class="stat-card"><div class="stat-top">Cuti<span class="stat-icon yellow"><svg class="icon"><use href="#i-calendar"/></svg></span></div><strong class="stat-value" id="attendanceLeaveCount">0</strong><div class="stat-foot">Disetujui untuk hari ini</div></article><article class="stat-card"><div class="stat-top">Belum absen<span class="stat-icon blue"><svg class="icon"><use href="#i-users"/></svg></span></div><strong class="stat-value" id="attendanceMissingCount">0</strong><div class="stat-foot">Menunggu konfirmasi</div></article></div>
            </section>
            @endif

            <section class="page-view" data-page="reports">
                <div class="page-heading"><div><div class="eyebrow">Analitik perusahaan</div><h1>Laporan</h1><p>Unduh laporan berkala untuk kebutuhan administrasi dan evaluasi.</p></div><div class="report-actions"><button class="button secondary" data-export="payroll"><svg class="icon"><use href="#i-download"/></svg>Excel</button><button class="button" data-print><svg class="icon"><use href="#i-file"/></svg>Cetak PDF</button></div></div>
                <div class="report-grid"><article class="report-card"><span class="stat-icon"><svg class="icon"><use href="#i-wallet"/></svg></span><div><h2>Laporan penggajian</h2><p>Rekap gaji dan tunjangan bulanan</p></div><button class="icon-button" style="margin-left:auto" data-export="payroll" aria-label="Unduh laporan penggajian"><svg class="icon"><use href="#i-download"/></svg></button></article>@if ($isAdmin)<article class="report-card"><span class="stat-icon orange"><svg class="icon"><use href="#i-users"/></svg></span><div><h2>Direktori pegawai</h2><p>Daftar pegawai dan departemen</p></div><button class="icon-button" style="margin-left:auto" data-export="employees" aria-label="Unduh direktori pegawai"><svg class="icon"><use href="#i-download"/></svg></button></article><article class="report-card"><span class="stat-icon yellow"><svg class="icon"><use href="#i-clock"/></svg></span><div><h2>Laporan absensi</h2><p>Rekap kehadiran dan keterlambatan</p></div><button class="icon-button" style="margin-left:auto" data-export="attendance" aria-label="Unduh laporan absensi"><svg class="icon"><use href="#i-download"/></svg></button></article>@endif<article class="report-card"><span class="stat-icon blue"><svg class="icon"><use href="#i-chart"/></svg></span><div><h2>Analisis biaya SDM</h2><p>Tren biaya tenaga kerja perusahaan</p></div><button class="icon-button" style="margin-left:auto" data-export="costs" aria-label="Unduh analisis biaya SDM"><svg class="icon"><use href="#i-download"/></svg></button></article></div>
            </section>

            @if ($isAdmin)
            <section class="page-view" data-page="settings"><div class="page-heading"><div><div class="eyebrow">Preferensi aplikasi</div><h1>Pengaturan</h1><p>Pengaturan perusahaan dan preferensi sistem penggajian.</p></div></div><section class="panel" style="padding:22px"><h2 style="font-size:13px">Informasi perusahaan</h2><p style="margin:7px 0;color:#87928a;font-size:11px">PT Ruang Karya Indonesia · Zona waktu WIB · Mata uang Rupiah (IDR)</p><button class="button secondary" id="settingsButton" style="margin-top:8px">Kelola pengaturan</button></section></section>
            @endif
        </div>
    </main>
</div>

@if ($isAdmin)
<div class="modal-backdrop" id="employeeModal" role="dialog" aria-modal="true" aria-labelledby="employeeModalTitle">
    <form class="modal" id="employeeForm"><div class="modal-header"><div><h2 id="employeeModalTitle">Tambah pegawai</h2><p>Lengkapi data pegawai baru untuk direktori perusahaan.</p></div><button type="button" class="modal-close" data-close-modal aria-label="Tutup"><svg class="icon"><use href="#i-close"/></svg></button></div>
        <div class="form-grid"><div class="form-field"><label for="employeeName">Nama lengkap</label><input id="employeeName" name="name" required placeholder="Nama pegawai"></div><div class="form-field"><label for="employeeDepartment">Departemen</label><select id="employeeDepartment" name="department" required><option value="">Pilih departemen</option><option>Teknologi</option><option>Keuangan</option><option>Pemasaran</option><option>Operasional</option><option>Sumber Daya Manusia</option></select></div><div class="form-field"><label for="employeeSalary">Gaji pokok (Rp)</label><input id="employeeSalary" name="salary" type="number" min="1" required placeholder="8000000"></div><div class="form-field"><label for="employeeJoinDate">Tanggal bergabung</label><input id="employeeJoinDate" name="joinDate" type="date" required value="2026-09-30"></div><div class="form-field full"><label for="employeeEmail">Email kerja</label><input id="employeeEmail" name="email" type="email" placeholder="nama@perusahaan.co.id"></div></div>
        <div class="modal-actions"><button type="button" class="button secondary" data-close-modal>Batal</button><button type="submit" class="button">Simpan pegawai</button></div>
    </form>
</div>
<div class="modal-backdrop" id="payrollModal" role="dialog" aria-modal="true" aria-labelledby="payrollModalTitle">
    <div class="modal"><div class="modal-header"><div><h2 id="payrollModalTitle">Proses penggajian</h2><p>Pilih dataset pegawai untuk menghitung pembayaran.</p></div><button class="modal-close" data-close-modal aria-label="Tutup"><svg class="icon"><use href="#i-close"/></svg></button></div>
        <div class="dataset-picker"><label for="payrollDataset"><svg class="icon"><use href="#i-file"/></svg><span><strong>Pilih file dataset</strong><small>CSV dengan kolom nama dan gaji_pokok</small></span><span class="dataset-browse">Pilih file</span></label><input id="payrollDataset" type="file" accept=".csv,text/csv"><p id="datasetFileName">Belum ada file dipilih</p></div>
        <p class="dataset-status" id="datasetStatus" role="status" aria-live="polite">Kolom opsional: tunjangan dan potongan. Perhitungan: gaji pokok + tunjangan - potongan.</p>
        <div class="confirm-box"><div class="confirm-line"><span>Periode</span><strong>September 2026</strong></div><div class="confirm-line"><span>Pegawai dalam dataset</span><strong id="datasetEmployeeCount">-</strong></div><div class="confirm-line"><span>Total gaji bersih</span><strong id="datasetPayrollTotal">-</strong></div><div class="confirm-line"><span>Tanggal pembayaran</span><strong>30 September 2026</strong></div></div>
        <div class="modal-actions"><button class="button secondary" data-close-modal>Batal</button><button class="button" id="confirmPayroll" disabled><svg class="icon"><use href="#i-check"/></svg>Konfirmasi proses</button></div>
    </div>
</div>
@endif
<div class="toast" id="toast" role="status" aria-live="polite"><svg class="icon"><use href="#i-check"/></svg><span id="toastMessage">Berhasil.</span></div>
</body>
</html>