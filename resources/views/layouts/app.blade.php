<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — MasterIP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navy:   #0f172a;
            --blue:   #3b82f6;
            --cyan:   #06b6d4;
            --glass:  rgba(255,255,255,0.55);
            --glass-border: rgba(255,255,255,0.35);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background: url('{{ asset('aset/bgwhite.jpg') }}') center/cover no-repeat fixed;
        }

        /* ─── PAGE TRANSITION ─────────────────────── */
        #page-transition {
            position: fixed; inset: 0; z-index: 9999;
            background: linear-gradient(135deg, #0f172a 0%, #1e40af 50%, #06b6d4 100%);
            pointer-events: none;
            clip-path: circle(0% at 50% 50%);
            transition: clip-path 0.55s cubic-bezier(0.77,0,0.18,1);
        }
        #page-transition.active  { clip-path: circle(150% at 50% 50%); }
        #page-transition.fade-out {
            clip-path: circle(0% at 50% 50%);
            transition: clip-path 0.45s cubic-bezier(0.77,0,0.18,1) 0.05s;
        }

        /* ─── HEADER ─────────────────────────────── */
        #navbar {
            position: fixed; top: 0; left: 0; width: 100%;
            z-index: 50;
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1),
                        background 0.3s ease, box-shadow 0.3s ease;
        }
        #navbar.hidden-bar { transform: translateY(-100%); }

        .nav-inner {
            margin: 12px 24px;
            background: var(--glass);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: 18px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 8px 32px rgba(15,23,42,0.10), 0 1.5px 6px rgba(59,130,246,0.07);
            transition: box-shadow 0.3s ease;
        }
        .nav-inner:hover {
            box-shadow: 0 12px 40px rgba(15,23,42,0.15), 0 2px 8px rgba(59,130,246,0.10);
        }

        /* Brand */
        .nav-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 3px 10px rgba(59,130,246,0.35);
        }
        .brand-icon svg { width: 18px; height: 18px; color: #fff; }
        .brand-text {
            font-family: 'Syne', sans-serif;
            font-size: 1.15rem; font-weight: 700;
            background: linear-gradient(135deg, var(--navy), #2563eb);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }
        .brand-badge {
            font-size: 0.55rem; font-weight: 600;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            color: #fff; border-radius: 5px;
            padding: 1px 5px; letter-spacing: 0.05em;
            transform: translateY(-4px);
        }

        /* Nav links */
        .nav-links {
            display: flex; align-items: center; gap: 4px;
            list-style: none;
        }
        .nav-links a {
            position: relative;
            display: flex; align-items: center; gap: 6px;
            padding: 7px 13px;
            border-radius: 10px;
            font-size: 0.875rem; font-weight: 500;
            color: #334155;
            text-decoration: none;
            transition: color 0.2s ease, background 0.2s ease;
            white-space: nowrap;
        }
        .nav-links a svg { width: 15px; height: 15px; flex-shrink: 0; }
        .nav-links a:hover { color: var(--blue); background: rgba(59,130,246,0.08); }
        .nav-links a.active {
            color: var(--blue);
            background: rgba(59,130,246,0.10);
            font-weight: 600;
        }
        .nav-links a::after {
            content: '';
            position: absolute; bottom: 3px; left: 50%;
            width: 0; height: 2px;
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            border-radius: 2px;
            transform: translateX(-50%);
            transition: width 0.25s cubic-bezier(0.4,0,0.2,1);
        }
        .nav-links a:hover::after,
        .nav-links a.active::after { width: 50%; }

        /* Nav — live dot indicator for network page */
        .nav-net-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 6px rgba(34,197,94,0.7);
            animation: navDotPulse 2s infinite;
            flex-shrink: 0;
        }
        @keyframes navDotPulse {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:.5; transform:scale(1.5); }
        }

        .nav-divider {
            width: 1px; height: 20px;
            background: rgba(148,163,184,0.35);
            margin: 0 6px;
        }

        .nav-logout {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px;
            border-radius: 10px;
            font-size: 0.875rem; font-weight: 500;
            color: #ef4444;
            text-decoration: none;
            transition: background 0.2s ease, color 0.2s ease;
        }
        .nav-logout svg { width: 15px; height: 15px; }
        .nav-logout:hover { background: rgba(239,68,68,0.08); color: #dc2626; }

        /* User chip */
        .user-chip {
            display: flex; align-items: center; gap: 8px;
            background: rgba(15,23,42,0.06);
            border: 1px solid rgba(15,23,42,0.08);
            border-radius: 40px;
            padding: 4px 12px 4px 4px;
            cursor: default;
        }
        .user-avatar {
            width: 28px; height: 28px; border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 0.7rem; font-weight: 700;
            color: #fff; flex-shrink: 0;
        }
        .user-name { font-size: 0.8rem; font-weight: 600; color: #1e293b; line-height: 1; }
        .user-role { font-size: 0.68rem; font-weight: 400; color: #64748b; }

        /* ─── CONTENT ─────────────────────────────── */
        main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 100px 24px 40px;
        }

        /* ─── FOOTER ─────────────────────────────── */
        footer { margin-top: 60px; position: relative; overflow: hidden; }
        .footer-inner {
            background: linear-gradient(180deg, rgba(15,23,42,0.88) 0%, rgba(15,23,42,0.97) 100%);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 40px 24px 24px;
        }
        .footer-grid {
            max-width: 1280px;
            margin: 0 auto 28px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
        }
        .footer-brand .brand-text-footer {
            font-family: 'Syne', sans-serif;
            font-size: 1.3rem; font-weight: 800;
            background: linear-gradient(90deg, #60a5fa, #06b6d4);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }
        .footer-brand p { font-size: 0.8rem; color: #94a3b8; line-height: 1.6; max-width: 240px; }
        .footer-col h4 {
            font-family: 'Syne', sans-serif;
            font-size: 0.75rem; font-weight: 700;
            color: #60a5fa; letter-spacing: 0.1em;
            text-transform: uppercase; margin-bottom: 14px;
        }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .footer-col ul a {
            font-size: 0.82rem; color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s ease, padding-left 0.2s ease;
            display: inline-block;
        }
        .footer-col ul a:hover { color: #e2e8f0; padding-left: 5px; }
        .footer-dots { display: flex; gap: 6px; align-items: center; margin-top: 16px; }
        .footer-dot {
            width: 6px; height: 6px; border-radius: 50%;
            animation: pulse-dot 2s infinite ease-in-out;
        }
        .footer-dot:nth-child(1) { background: #3b82f6; animation-delay: 0s; }
        .footer-dot:nth-child(2) { background: #06b6d4; animation-delay: 0.3s; }
        .footer-dot:nth-child(3) { background: #8b5cf6; animation-delay: 0.6s; }
        @keyframes pulse-dot {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50%       { opacity: 1; transform: scale(1.3); }
        }
        .footer-bottom {
            max-width: 1280px; margin: 0 auto;
            padding-top: 18px;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 10px;
        }
        .footer-bottom span { font-size: 0.75rem; color: #475569; }
        .footer-bottom .footer-by { font-size: 0.75rem; color: #475569; display: flex; align-items: center; gap: 6px; }
        .footer-by strong { font-family: 'Syne', sans-serif; color: #60a5fa; font-weight: 700; }
        .footer-version {
            background: rgba(59,130,246,0.15);
            color: #60a5fa; font-size: 0.65rem; font-weight: 600;
            padding: 2px 7px; border-radius: 5px;
            border: 1px solid rgba(59,130,246,0.25);
        }
        .footer-ticker {
            overflow: hidden; width: 100%;
            border-top: 1px solid rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding: 8px 0; margin-bottom: 28px;
        }
        .ticker-track {
            display: flex; gap: 40px;
            animation: ticker 25s linear infinite;
            white-space: nowrap;
        }
        .ticker-track span {
            font-family: 'Syne', sans-serif;
            font-size: 0.7rem; font-weight: 600;
            color: rgba(96,165,250,0.4);
            letter-spacing: 0.15em; text-transform: uppercase;
        }
        @keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        @media (max-width: 768px) {
            .nav-inner { margin: 8px 12px; padding: 8px 14px; }
            .nav-links { gap: 0; }
            .nav-links a span { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .footer-brand { grid-column: 1 / -1; }
        }
        @media (max-width: 480px) {
            .user-name, .user-role { display: none; }
            .nav-divider { display: none; }
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div id="page-transition"></div>

    <header id="navbar">
        <div class="nav-inner">

            <a href="/spekpc" class="nav-brand">
                <div class="brand-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="2" y="3" width="20" height="14" rx="2"/>
                        <path d="M8 21h8M12 17v4"/>
                    </svg>
                </div>
                <span class="brand-text">MasterIP</span>
                <span class="brand-badge">BETA</span>
            </a>

            <ul class="nav-links">
  <li>
    <a href="/dashboard" class="{{ request()->is('dashboard*') ? 'active' : '' }}" data-nav>
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
            <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>
        <span>Dashboard</span>
    </a>
</li>
                {{-- Spek PC --}}
                <li>
                    <a href="/spekpc" class="{{ request()->is('spekpc*') ? 'active' : '' }}" data-nav>
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="3" width="20" height="14" rx="2"/>
                            <path d="M8 21h8M12 17v4"/>
                        </svg>
                        <span>Spek PC</span>
                    </a>
                </li>
              

                {{-- ★ NETWORK (baru) ★ --}}
                <li>
                    <a href="/network" class="{{ request()->is('network*') ? 'active' : '' }}" data-nav>
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M2 12h20"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                        <span>Network</span>
                        <span class="nav-net-dot"></span>
                    </a>
                </li>

                {{-- Data --}}
                <li>
                    <a href="/data" class="{{ request()->is('data*') ? 'active' : '' }}" data-nav>
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <ellipse cx="12" cy="5" rx="9" ry="3"/>
                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                        </svg>
                        <span>Data</span>
                    </a>
                </li>

                {{-- Clipboard --}}
                <li>
                    <a href="/clip" class="{{ request()->is('clip*') ? 'active' : '' }}" data-nav>
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                        </svg>
                        <span>Clipboard</span>
                    </a>
                </li>

                <li><div class="nav-divider"></div></li>

                <li>
                    <div class="user-chip">
                        <div class="user-avatar">
                            {{ strtoupper(substr(session('user_nama', 'U'), 0, 2)) }}
                        </div>
                        <div>
                            <div class="user-name">{{ session('user_nama', 'User') }}</div>
                            <div class="user-role">{{ session('user_nik', '-') }}</div>
                        </div>
                    </div>
                </li>

                <li><div class="nav-divider"></div></li>

                <li>
                    <a href="/logout" class="nav-logout" id="logout-link">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-inner">

            <div class="footer-ticker">
                <div class="ticker-track">
                    <span>MasterIP</span><span>◆</span>
                    <span>MONITORING IP</span><span>◆</span>
                    <span>MONITORING SPEC</span><span>◆</span>
                    <span>Network Monitor</span><span>◆</span>
                    <span>MasterIP</span><span>◆</span>
                    <span>MONITORING IP</span><span>◆</span>
                    <span>MONITORING SPEC</span><span>◆</span>
                    <span>Network Monitor</span><span>◆</span>
                </div>
            </div>

            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="brand-text-footer">MasterIP</div>
                    <p>WEBSITE Manajemen Spec Komputer, Monitoring IP, dan Akses Monitoring EDP.</p>
                    <div class="footer-dots">
                        <div class="footer-dot"></div>
                        <div class="footer-dot"></div>
                        <div class="footer-dot"></div>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="/spekpc" data-nav>Spek PC</a></li>
                        <li><a href="/network" data-nav>Network</a></li>
                        <li><a href="/data" data-nav>Data All</a></li>
                        <li><a href="/clip" data-nav>Clipboard</a></li>
                        <li><a href="/home" data-nav>Home</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Sistem</h4>
                    <ul>
                        <li><a href="#">Export Excel</a></li>
                        <li><a href="#">Export CSV</a></li>
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span>© {{ date('Y') }} MasterIP — All rights reserved.</span>
                <div class="footer-by">
                    <span>Crafted by</span>
                    <strong>Zmie</strong>
                    <span class="footer-version">v1.0 Beta</span>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>

<script>
(function () {
    let lastScroll = 0;
    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        const cur = window.pageYOffset;
        if (cur <= 10)              navbar.classList.remove('hidden-bar');
        else if (cur > lastScroll + 5) navbar.classList.add('hidden-bar');
        else if (cur < lastScroll - 5) navbar.classList.remove('hidden-bar');
        lastScroll = cur;
    }, { passive: true });

    document.addEventListener('mousemove', e => {
        if (e.clientY < 60) navbar.classList.remove('hidden-bar');
    });

    const overlay = document.getElementById('page-transition');

    function animateOut(href) {
        overlay.classList.add('active');
        setTimeout(() => { window.location.href = href; }, 520);
    }

    overlay.classList.add('active');
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            overlay.classList.remove('active');
            overlay.classList.add('fade-out');
        });
    });

    document.querySelectorAll('[data-nav]').forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (!href || href === '#') return;
            e.preventDefault();
            overlay.classList.remove('fade-out');
            animateOut(href);
        });
    });

    const logoutLink = document.getElementById('logout-link');
    if (logoutLink) {
        logoutLink.addEventListener('click', function (e) {
            e.preventDefault();
            overlay.classList.remove('fade-out');
            animateOut(this.getAttribute('href'));
        });
    }
})();
</script>