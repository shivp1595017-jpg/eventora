<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Super Admin - Eventora')</title>

    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        :root{--bg:#070b14;--sidebar:#0b1220;--card:#0e1524;--card2:#111b2d;--text:#fff;--muted:#94a0b5;--border:#202b40;--primary:#6c63ff;--primary2:#8b5cf6;--success:#22c55e;--warning:#f59e0b;--danger:#ef4444}
        html[data-theme="light"]{--bg:#f5f7fb;--sidebar:#fff;--card:#fff;--card2:#f7f8fb;--text:#172033;--muted:#687386;--border:#dce2ec}
        body{font-family:Arial,Helvetica,sans-serif;background:var(--bg);color:var(--text);min-height:100vh;line-height:1.6}
        a{text-decoration:none;color:inherit}
        button,input,select{font:inherit}
        .admin-layout{min-height:100vh;display:flex}
        .sidebar{width:260px;height:100vh;background:#111827;color:#fff;border-right:1px solid #273247;padding:24px 16px;position:fixed;inset:0 auto 0 0;z-index:1000;display:flex;flex-direction:column;overflow-y:auto;overflow-x:hidden;scrollbar-width:thin;scrollbar-color:#4b5563 #111827;transition:transform .25s ease}
        .sidebar::-webkit-scrollbar{width:7px}.sidebar::-webkit-scrollbar-track{background:#111827}.sidebar::-webkit-scrollbar-thumb{background:#4b5563;border-radius:10px}
        .logo{display:block;font-size:27px;letter-spacing:-.5px;font-weight:800;padding:4px 12px 28px;color:#fff}.logo span{color:#6366f1}
        .small-label{color:#8b93a7;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;padding:0 12px;margin:14px 0 9px}
        .nav{display:flex;flex-direction:column;gap:5px}.nav a{display:flex;align-items:center;gap:12px;min-height:44px;color:#cbd5e1;padding:12px 13px;border-radius:10px;font-size:14px;font-weight:500;transition:all .2s ease}.nav a:hover{background:#1f2937;color:#fff;transform:translateX(2px)}.nav a.active{background:#6366f1;color:#fff;box-shadow:0 5px 15px rgba(99,102,241,.25)}
        .nav-icon{width:22px;min-width:22px;display:inline-flex;justify-content:center;align-items:center;font-size:17px}.logout-wrap{margin-top:auto;padding-top:20px;border-top:1px solid #273247}
        .logout{width:100%;border:1px solid rgba(239,68,68,.2);background:rgba(239,68,68,.08);color:#ff8585;border-radius:10px;padding:10px;cursor:pointer;font-weight:700}
        .main{margin-left:260px;width:calc(100% - 260px);padding:28px;min-width:0}
        .topbar{display:flex;justify-content:space-between;align-items:flex-end;gap:18px;margin-bottom:25px}.topbar h1{font-size:30px;line-height:1.2}.topbar p{color:var(--muted);font-size:12px;margin-top:5px}
        .admin-chip{display:flex;align-items:center;gap:9px;background:var(--card);border:1px solid var(--border);padding:8px 11px;border-radius:11px}.avatar{position:relative;width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;overflow:hidden;background:linear-gradient(135deg,var(--primary),var(--primary2));font-weight:800;color:#fff}.avatar img{position:absolute;inset:0;width:100%;height:100%;border-radius:inherit;object-fit:cover}.chip-name{font-size:12px;font-weight:700}.chip-role{font-size:9px;color:var(--muted);text-transform:capitalize}
        .flash{padding:12px 14px;border-radius:10px;margin-bottom:18px;font-size:13px;border:1px solid var(--border)}.flash.success{background:rgba(34,197,94,.08);color:#70e39a;border-color:rgba(34,197,94,.2)}.flash.error{background:rgba(239,68,68,.08);color:#ff8c8c;border-color:rgba(239,68,68,.2)}
        .toolbar{display:flex;align-items:center;gap:10px;flex-wrap:wrap;background:var(--card);border:1px solid var(--border);border-radius:15px;padding:14px;margin-bottom:16px}.toolbar input,.toolbar select{background:var(--card2);border:1px solid var(--border);color:var(--text);border-radius:9px;padding:10px 12px;outline:none}.toolbar input:focus,.toolbar select:focus{border-color:var(--primary)}.search{flex:1;min-width:200px}.filter{min-width:145px}.toolbar button{border:0;border-radius:9px;padding:10px 14px;background:linear-gradient(135deg,var(--primary),var(--primary2));color:#fff;font-weight:700;cursor:pointer}.clear-btn{background:var(--card2)!important;border:1px solid var(--border)!important;color:var(--text)!important}
        .export-group{margin-left:auto;display:flex;gap:7px;flex-wrap:wrap}.export-btn{border:1px solid var(--border);background:var(--card2);color:var(--text);padding:9px 11px;border-radius:8px;font-size:11px;font-weight:700}.export-btn:hover{border-color:var(--primary)}
        .table-card{background:var(--card);border:1px solid var(--border);border-radius:15px;overflow:hidden}.table-wrap{width:100%;overflow-x:auto}table{width:100%;border-collapse:collapse;min-width:900px}th{text-align:left;padding:13px 15px;font-size:10px;text-transform:uppercase;letter-spacing:.4px;color:var(--muted);background:var(--card2);border-bottom:1px solid var(--border)}td{padding:14px 15px;border-bottom:1px solid var(--border);font-size:12px;vertical-align:middle}tbody tr:last-child td{border-bottom:0}tbody tr:hover{background:rgba(108,99,255,.03)}
        .name{font-weight:700}.sub{color:var(--muted);font-size:10px;margin-top:2px;word-break:break-word}.badge{display:inline-flex;padding:5px 9px;border-radius:20px;font-size:9px;font-weight:800;text-transform:capitalize}.badge.approved,.badge.paid,.badge.confirmed,.badge.active{background:rgba(34,197,94,.12);color:#6fe195}.badge.pending{background:rgba(245,158,11,.12);color:#f7c55b}.badge.rejected,.badge.cancelled,.badge.failed{background:rgba(239,68,68,.12);color:#ff8686}.badge.other{background:rgba(108,99,255,.12);color:#a69fff}
        .actions{display:flex;gap:7px;flex-wrap:wrap}.action{border:0;border-radius:8px;padding:7px 9px;font-size:10px;font-weight:800;cursor:pointer}.action.success{background:rgba(34,197,94,.12);color:#6fe195}.action.danger{background:rgba(239,68,68,.12);color:#ff8686}.action.view{background:rgba(108,99,255,.12);color:#a69fff}
        .empty{padding:55px 20px;text-align:center;color:var(--muted);font-size:12px}.empty strong{display:block;color:var(--text);font-size:18px;margin-bottom:4px}.pagination-wrap{padding:15px;border-top:1px solid var(--border)}
        .pagination-wrap nav{display:flex;justify-content:center}.pagination-wrap a,.pagination-wrap span{display:inline-flex;min-width:34px;height:34px;align-items:center;justify-content:center;margin:0 3px;border:1px solid var(--border);border-radius:8px;font-size:11px;color:var(--muted);background:var(--card2)}.pagination-wrap span[aria-current="page"]{background:linear-gradient(135deg,var(--primary),var(--primary2));color:#fff;border-color:transparent}.pagination-wrap span[aria-disabled="true"]{opacity:.45}
        .stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}.stat{background:var(--card);border:1px solid var(--border);border-radius:15px;padding:18px}.stat small{color:var(--muted);font-size:10px}.stat strong{display:block;font-size:28px;margin-top:4px}
        .quick{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:25px}.quick a{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:17px}.quick a:hover{border-color:rgba(108,99,255,.45);transform:translateY(-2px)}.quick .icon{font-size:20px;margin-bottom:10px}.quick h3{font-size:14px;margin-bottom:3px}.quick p{font-size:10px;color:var(--muted)}
        .two-col{display:grid;grid-template-columns:1fr 1fr;gap:18px}.panel{background:var(--card);border:1px solid var(--border);border-radius:15px;overflow:hidden}.panel-head{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:17px;border-bottom:1px solid var(--border)}.panel-head h3{font-size:14px}.panel-head a{font-size:10px;color:var(--primary);font-weight:800}.panel-row{display:flex;justify-content:space-between;gap:12px;padding:13px 17px;border-bottom:1px solid var(--border)}.panel-row:last-child{border-bottom:0}.panel-row .left{min-width:0}.panel-row .right{white-space:nowrap}
        .admin-top-actions{display:flex;align-items:center;gap:10px}.notification-dropdown{position:relative}.notification-dropdown summary{position:relative;list-style:none;cursor:pointer;width:42px;height:42px;display:flex;align-items:center;justify-content:center;background:var(--card);border:1px solid var(--border);border-radius:10px}.notification-count{position:absolute;right:-5px;top:-5px;background:#ef4444;color:#fff;border-radius:20px;padding:2px 5px;font-size:9px}.notification-list{position:absolute;right:0;top:50px;width:320px;max-width:calc(100vw - 30px);z-index:500;background:var(--card);border:1px solid var(--border);border-radius:12px;padding:8px;box-shadow:0 12px 30px rgba(0,0,0,.2)}.notification-item{display:block;padding:10px;border-radius:8px;background:var(--card2);margin-bottom:4px}.notification-item.read{opacity:.62}.notification-item strong,.notification-item span{display:block}.notification-item strong{font-size:11px}.notification-item span,.notification-empty{font-size:10px;color:var(--muted);margin-top:3px}.notification-empty{padding:12px}
        .card{background:var(--card);border:1px solid var(--border);border-radius:15px}.filter-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.filter-control{width:100%;min-height:40px;padding:9px 11px;border-radius:9px;border:1px solid var(--border);background:var(--card2);color:var(--text);outline:none}.filter-control:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(108,99,255,.1)}.btn{display:inline-flex;align-items:center;justify-content:center;min-height:36px;border:0;border-radius:9px;padding:9px 13px;font-size:11px;font-weight:800;cursor:pointer;transition:filter .2s,transform .2s}.btn:hover{filter:brightness(1.08);transform:translateY(-1px)}.btn.primary{min-height:40px;padding:10px 14px;background:linear-gradient(135deg,var(--primary),var(--primary2));color:#fff}.btn.secondary,.btn.clear-btn{background:var(--card2);border:1px solid var(--border);color:var(--text)}.btn.approve{background:rgba(34,197,94,.14);color:#4acb76}.btn.reject{background:rgba(239,68,68,.12);color:#ef6670}.pagination-bar{padding:14px 16px;border-top:1px solid var(--border)}.pagination-bar nav{display:flex;justify-content:center}.pagination-bar a,.pagination-bar span{display:inline-flex;min-width:34px;height:34px;align-items:center;justify-content:center;margin:0 2px;border:1px solid var(--border);border-radius:7px;font-size:11px;color:var(--text);background:var(--card2)}.pagination-bar span[aria-current="page"]{background:var(--primary);color:#fff}
        @media(max-width:1100px){.stats{grid-template-columns:repeat(2,1fr)}.quick{grid-template-columns:repeat(2,1fr)}}
        .sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999}.mobile-menu-btn{display:none;width:40px;height:40px;border:1px solid var(--border);border-radius:10px;background:var(--card);color:var(--text);font-size:19px;cursor:pointer}
        .mobile-sidebar-close{display:none;position:absolute;top:16px;right:14px;width:36px;height:36px;border:1px solid #3b4659;border-radius:9px;background:#1f2937;color:#fff;font-size:22px;cursor:pointer}
        @media(max-width:850px){.sidebar{width:260px;max-width:84vw;transform:translateX(-100%);box-shadow:12px 0 35px rgba(0,0,0,.25)}.sidebar.open{transform:translateX(0)}.mobile-sidebar-close{display:block}body.sidebar-open{overflow:hidden}body.sidebar-open .sidebar-overlay{display:block}.main{margin-left:0;width:100%;padding:20px}.mobile-menu-btn{display:inline-flex;align-items:center;justify-content:center}.topbar{align-items:flex-start;flex-direction:column}.export-group{margin-left:0}.two-col{grid-template-columns:1fr}}
        @media(max-width:600px){.main{padding:14px}.stats,.quick{grid-template-columns:1fr}.toolbar{padding:10px}.search,.filter{width:100%;min-width:0}.toolbar button{width:100%}.export-group{width:100%}.export-btn{flex:1;text-align:center}.topbar h1{font-size:25px}.admin-top-actions{width:100%;justify-content:flex-end}.notification-list{right:0}}
    </style>
</head>
<body>
<div class="admin-layout">
    <aside class="sidebar" id="adminSidebar">
        <button type="button" class="mobile-sidebar-close" id="adminSidebarClose" aria-label="Close menu">×</button>
        <a href="{{ route('admin.dashboard') }}" class="logo">Event<span>ora</span></a>
        <div class="small-label">Super Admin</div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="nav-icon">🏠</span><span class="nav-text">Dashboard</span></a>
            @if(auth()->user()->role === 'super_admin' || in_array('organizations', auth()->user()->admin_permissions ?? [], true))
            <a href="{{ route('admin.organizations.index') }}" class="{{ request()->routeIs('admin.organizations.*') ? 'active' : '' }}"><span class="nav-icon">🏢</span><span class="nav-text">Organizations</span></a>
            @endif
            @if(auth()->user()->role === 'super_admin' || in_array('events', auth()->user()->admin_permissions ?? [], true))
            <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}"><span class="nav-icon">🎫</span><span class="nav-text">Events</span></a>
            @endif
            @if(auth()->user()->role === 'super_admin' || in_array('manage_staff', auth()->user()->admin_permissions ?? [], true))
            <a href="{{ route('admin.access-staff.index') }}" class="{{ request()->routeIs('admin.access-staff.*') ? 'active' : '' }}"><span class="nav-icon">🛡️</span><span class="nav-text">Super Admin Staff</span></a>
            <a href="{{ route('admin.staff.index') }}" class="{{ request()->routeIs('admin.staff.*') ? 'active' : '' }}"><span class="nav-icon">🧑‍💼</span><span class="nav-text">Organization Staff</span></a>
            @endif
            @if(auth()->user()->role === 'super_admin' || in_array('users', auth()->user()->admin_permissions ?? [], true))
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><span class="nav-icon">👥</span><span class="nav-text">Users</span></a>
            @endif
            @if(auth()->user()->role === 'super_admin' || in_array('bookings', auth()->user()->admin_permissions ?? [], true))
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"><span class="nav-icon">📋</span><span class="nav-text">Bookings</span></a>
            @endif
            @if(auth()->user()->role === 'super_admin' || in_array('payments', auth()->user()->admin_permissions ?? [], true))
            <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"><span class="nav-icon">💳</span><span class="nav-text">Payments</span></a>
            @endif
            @if(auth()->user()->role === 'super_admin' || in_array('ticket_verification', auth()->user()->admin_permissions ?? [], true))
            <a href="{{ route('admin.ticket-verification.index') }}" class="{{ request()->routeIs('admin.ticket-verification.*') ? 'active' : '' }}"><span class="nav-icon">🎟️</span><span class="nav-text">Ticket Verification</span></a>
            @endif
            @if(auth()->user()->role === 'super_admin' || in_array('settings', auth()->user()->admin_permissions ?? [], true))
            <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}"><span class="nav-icon">⚙️</span><span class="nav-text">Settings</span></a>
            @endif
            <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}"><span class="nav-icon">👤</span><span class="nav-text">Profile</span></a>
        </nav>
        <div class="logout-wrap">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout" type="submit">Logout</button>
            </form>
        </div>
    </aside>

    <div class="sidebar-overlay" id="adminSidebarOverlay"></div>

    <main class="main">
        <div class="topbar">
            <button class="mobile-menu-btn" id="adminSidebarOpen" type="button" aria-label="Open menu">☰</button>
            <div>
                <h1>@yield('heading', 'Super Admin')</h1>
                <p>@yield('description', 'Manage Eventora from one place.')</p>
            </div>
            <div class="admin-top-actions">
            @php($unreadCount = auth()->user()->unreadNotifications()->count())
            @php($latestNotifications = auth()->user()->notifications()->latest()->take(5)->get())
            <details class="notification-dropdown">
                <summary aria-label="Notifications">🔔 @if($unreadCount)<span class="notification-count">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>@endif</summary>
                <div class="notification-list">
                    @forelse($latestNotifications as $notification)
                        <a href="{{ route('admin.notifications.read', $notification->id) }}" class="notification-item {{ $notification->read_at ? 'read' : '' }}">
                            <strong>{{ $notification->data['title'] ?? 'Notification' }}</strong>
                            <span>{{ $notification->data['message'] ?? '' }}</span>
                        </a>
                    @empty
                        <div class="notification-empty">No new notifications.</div>
                    @endforelse
                </div>
            </details>
            <a class="admin-chip" href="{{ route('admin.profile') }}" aria-label="Open Super Admin profile">
                <div class="avatar">
                    <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    @if(auth()->user()->profilePhotoUrl())
                        <img src="{{ auth()->user()->profilePhotoUrl() }}" alt="" aria-hidden="true" referrerpolicy="no-referrer" onerror="this.remove()">
                    @endif
                </div>
                <div>
                    <div class="chip-name">{{ auth()->user()->name }}</div>
                    <div class="chip-role">{{ auth()->user()->role }}</div>
                </div>
            </a>
            </div>
        </div>

        @if(session('success'))
            <div class="flash success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    const html = document.documentElement;
    html.setAttribute('data-theme', localStorage.getItem('eventora-theme') || 'dark');

    function currentQuery(form) {
        const params = new URLSearchParams(new FormData(form));
        [...params.entries()].forEach(([key, value]) => {
            if (!value) params.delete(key);
        });
        return params;
    }

    function updateExportLinks(form) {
        const params = currentQuery(form);
        document.querySelectorAll('[data-export-base]').forEach(link => {
            const url = new URL(link.dataset.exportBase, window.location.origin);
            url.search = params.toString();
            link.href = url.toString();
        });
    }

    async function loadAdminPage(url, push = true) {
        const target = document.getElementById('dataArea');
        if (!target) return;
        target.style.opacity = '.55';

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            });

            if (!response.ok) throw new Error('Request failed');

            target.innerHTML = await response.text();

            if (push) history.pushState({}, '', url);

            document.querySelectorAll('.pagination-wrap a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    loadAdminPage(this.href, true);
                });
            });
        } catch (error) {
            window.location.href = url;
        } finally {
            target.style.opacity = '1';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminSidebarOverlay');
        const closeSidebar = () => { sidebar?.classList.remove('open'); document.body.classList.remove('sidebar-open'); };
        document.getElementById('adminSidebarOpen')?.addEventListener('click', () => { sidebar?.classList.add('open'); document.body.classList.add('sidebar-open'); });
        document.getElementById('adminSidebarClose')?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', event => { if (event.key === 'Escape') closeSidebar(); });
        sidebar?.querySelectorAll('.nav a').forEach(link => link.addEventListener('click', closeSidebar));

        const form = document.getElementById('filterForm');
        if (!form) return;

        let timer = null;
        updateExportLinks(form);

        const run = (push = true) => {
            const url = new URL(form.action, window.location.origin);
            url.search = currentQuery(form).toString();
            updateExportLinks(form);
            loadAdminPage(url.toString(), push);
        };

        form.addEventListener('submit', e => {
            e.preventDefault();
            run(true);
        });

        form.querySelectorAll('select,input[type="date"]').forEach(el => {
            el.addEventListener('change', () => run(true));
        });

        const search = form.querySelector('input[name="q"]');
        if (search) {
            search.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(() => run(true), 350);
            });
        }

        const clear = form.querySelector('[data-clear]');
        if (clear) {
            clear.addEventListener('click', () => {
                form.reset();
                run(true);
            });
        }

        document.querySelectorAll('.pagination-wrap a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                loadAdminPage(this.href, true);
            });
        });

        window.addEventListener('popstate', () => {
            const current = new URL(window.location.href);
            form.querySelectorAll('input,select').forEach(el => {
                el.value = current.searchParams.get(el.name) || '';
            });
            updateExportLinks(form);
            loadAdminPage(window.location.href, false);
        });
    });
</script>
</body>
</html>
