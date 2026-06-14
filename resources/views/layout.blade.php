<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polyphony</title>
    <style>
        body { font-family: system-ui, sans-serif; background-color: #fcfcfc; color: #18181b; margin: 0; padding: 0; }
        header { background-color: #ffffff; padding: 1rem 2rem; border-bottom: 1px solid #e4e4e7; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; text-decoration: none; color: #18181b; }
        .header-actions { display: flex; align-items: center; gap: 1rem; }
        .search-box { padding: 0.4rem; border: 1px solid #d4d4d8; border-radius: 4px; }
        nav a { text-decoration: none; color: #3f3f46; }
        nav a:hover { color: #000000; }
        .dashboard-container { max-width: 1000px; margin: 2rem auto; display: flex; gap: 2rem; padding: 0 1rem; }
        .main-content { flex: 3; }
        .sidebar { flex: 1; border-left: 1px solid #e4e4e7; padding-left: 2rem; }
        .post-card { background: #ffffff; border: 1px solid #e4e4e7; padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem; }
        .post-card h3 { margin-top: 0; }
        .tag { display: inline-block; background: #e4e4e7; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.8rem; margin-right: 0.4rem; margin-top: 0.5rem; }
        
        button { background-color: #18181b; color: #ffffff; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #3f3f46; }
        .btn-outline { background-color: transparent; color: #18181b; border: 1px solid #18181b; }
        .btn-outline:hover { background-color: #f4f4f5; }
    </style>
</head>
<body>

    <header>
        <a href="{{ route('home') }}" class="logo">Polyphony</a>
        <div class="header-actions">
            <div style="display: inline-flex; gap: 0.5rem; margin-right: 1rem;">
                <a href="{{ route('language.switch', 'en') }}" style="text-decoration: none; font-weight: {{ app()->getLocale() == 'en' ? 'bold' : 'normal' }};">EN</a>
                <span>|</span>
                <a href="{{ route('language.switch', 'lv') }}" style="text-decoration: none; font-weight: {{ app()->getLocale() == 'lv' ? 'bold' : 'normal' }};">LV</a>
            </div>
            @guest
            
                <a href="{{ route('login') }}">{{ __('app.login') }}</a>
                <a href="{{ route('register') }}">{{ __('app.register') }}</a>
            @endguest
            @auth
                <span>{{ __('app.welcome', ['name' => Auth::user()->name]) }}</span>
                <a href="{{ route('logs.index') }}" style="margin-left: 1rem; font-weight: bold;">{{ __('app.audit_logs') }}</a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.users') }}" style="margin-left: 1rem; font-weight: bold; color: #dc2626;">{{ __('app.admin_panel') }}</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="margin-left: 1rem; background-color: #f4f4f5; color: #18181b; border: 1px solid #d4d4d8;">{{ __('app.logout') }}</button>
                </form>
            @endauth
            <input type="text" id="searchInput" placeholder="{{ __('app.search_placeholder') }}" style="padding: 0.5rem; border: 1px solid #d4d4d8; border-radius: 4px;">
        </div>
    </header>

    @yield('content')

</body>
</html>