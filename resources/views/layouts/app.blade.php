<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Manajemen Siswa')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --primary:#2a24c8; --bg:#f3f4fa; --text:#1f2037; --muted:#9a9db2; --line:#eceef5; }
        * { font-family:'Inter',sans-serif; }
        body { background:var(--bg); color:var(--text); font-size:14px; }

        /* Sidebar */
        .sidebar { position:fixed; inset:0 auto 0 0; width:76px; background:#fff; border-right:1px solid var(--line);
                   display:flex; flex-direction:column; align-items:center; padding:20px 0; gap:10px; z-index:40; }
        .logo { width:40px; height:40px; border-radius:12px; background:var(--primary); color:#fff;
                display:grid; place-items:center; font-size:20px; margin-bottom:16px; }
        .side-link { width:42px; height:42px; border-radius:12px; display:grid; place-items:center;
                     color:#6b6e85; font-size:18px; text-decoration:none; }
        .side-link:hover { background:#f1f1fb; color:var(--primary); }
        .side-link.active { background:#e9e8fb; color:var(--primary); }

        /* Topbar */
        .main { margin-left:76px; min-height:100vh; }
        .topbar { display:flex; justify-content:space-between; align-items:center; padding:22px 32px; }
        .topbar h1 { font-size:20px; font-weight:800; margin:0; }
        .topbar-right { display:flex; align-items:center; gap:12px; }
        .icon-btn { width:38px; height:38px; border-radius:50%; background:#fff; border:1px solid var(--line);
                    display:grid; place-items:center; color:#6b6e85; }
        .avatar { width:38px; height:38px; border-radius:50%; background:var(--primary); color:#fff;
                  display:grid; place-items:center; font-weight:700; }
        .content { padding:0 32px 120px; }

        /* Tabs */
        .tabs-nav { display:flex; gap:6px; padding-left:12px; }
        .tab-item { padding:10px 18px; border-radius:14px 14px 0 0; background:#e9ebf4; color:var(--muted);
                    text-decoration:none; font-weight:600; font-size:13px; display:flex; gap:8px; align-items:center; }
        .tab-item .count { background:#d9dcea; border-radius:10px; padding:1px 8px; font-size:11px; }
        .tab-item.active { background:#fff; color:var(--primary); }
        .tab-item.active .count { background:var(--primary); color:#fff; }

        /* Panel */
        .panel { background:#fff; border-radius:18px; padding:20px; box-shadow:0 2px 12px rgba(30,32,80,.04); }
        .panel.has-tabs { border-top-left-radius:0; }
        .filter-box { position:relative; max-width:320px; flex:1; }
        .filter-box i { position:absolute; left:16px; top:50%; transform:translateY(-50%); color:var(--muted); }
        .filter-box input { width:100%; border:1px solid var(--line); border-radius:30px;
                            padding:10px 16px 10px 42px; outline:none; background:#fff; }
        .filter-box input:focus { border-color:var(--primary); }
        .btn-pill { background:var(--primary); color:#fff; border-radius:30px; padding:10px 22px;
                    font-weight:600; border:0; text-decoration:none; }
        .btn-pill:hover { background:#1f1aa8; color:#fff; }

        /* Tabel */
        .table-modern { width:100%; border-collapse:separate; border-spacing:0; }
        .table-modern thead th { background:#f4f5fa; color:var(--muted); font-size:11px; font-weight:600;
                                 padding:12px 14px; white-space:nowrap; }
        .table-modern thead th:first-child { border-radius:10px 0 0 10px; }
        .table-modern thead th:last-child { border-radius:0 10px 10px 0; }
        .table-modern td { padding:15px 14px; border-bottom:1px solid #f3f4f8; vertical-align:middle; white-space:nowrap; }
        .table-modern tbody tr:hover td { background:#fafaff; }
        .table-modern tr.selected td { background:#f5f5ff; }
        .table-modern tr.selected td:first-child { box-shadow:inset 3px 0 0 var(--primary); }
        .form-check-input:checked, .form-check-input:indeterminate { background-color:var(--primary); border-color:var(--primary); }
        .row-btn { background:none; border:0; color:var(--muted); font-size:16px; padding:4px 6px; text-decoration:none; }
        .row-btn:hover { color:var(--primary); }
        .row-btn.del:hover { color:#ef4a5e; }

        /* Badge */
        .chip { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:6px;
                font-size:10px; font-weight:700; text-transform:uppercase; }
        .chip::before { content:''; width:6px; height:6px; border-radius:50%; background:currentColor; }
        .chip-blue { background:#dff3fd; color:#1b9bd1; }
        .chip-orange { background:#fff1d6; color:#e8a317; }

        /* Bar aksi melayang */
        .bulk-bar { position:fixed; left:calc(50% + 38px); bottom:28px; transform:translate(-50%,120px);
                    opacity:0; pointer-events:none; transition:.25s; background:#26283a; color:#fff;
                    border-radius:40px; padding:12px 16px 12px 22px; display:flex; align-items:center;
                    gap:14px; z-index:50; box-shadow:0 10px 30px rgba(20,20,50,.3); }
        .bulk-bar.show { transform:translate(-50%,0); opacity:1; pointer-events:auto; }
        .bulk-x { background:none; border:0; color:#9a9db2; font-size:16px; }
        .bulk-count { background:#3a3d52; border-radius:10px; padding:2px 10px; font-weight:700; }
        .bulk-btn { background:#3a3d52; color:#fff; border:0; border-radius:30px; padding:10px 20px;
                    font-weight:600; text-decoration:none; display:inline-flex; gap:8px; align-items:center; }
        .bulk-btn:hover { background:#4a4e68; color:#fff; }
        .bulk-btn.danger { background:#ef4a5e; }
        .bulk-btn.danger:hover { background:#d93d51; }
        .bulk-btn.disabled { opacity:.4; pointer-events:none; }

        @media print { .sidebar, .topbar, .bulk-bar, .filter-row, .tabs-nav { display:none !important; } .main { margin:0; } }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo"><i class="bi bi-mortarboard-fill"></i></div>
        <a href="#" class="side-link"><i class="bi bi-grid"></i></a>
        <a href="{{ route('students.index') }}" class="side-link active"><i class="bi bi-people-fill"></i></a>
        <a href="#" class="side-link"><i class="bi bi-folder"></i></a>
        <a href="#" class="side-link"><i class="bi bi-box"></i></a>
        <a href="#" class="side-link"><i class="bi bi-gear"></i></a>
    </aside>

    <div class="main">
        <header class="topbar">
            <h1>@yield('heading', 'Moch nafis')</h1>
            <div class="topbar-right">
                <span class="icon-btn"><i class="bi bi-bell"></i></span>
                <span class="avatar">A</span>
            </div>
        </header>

        <div class="content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>