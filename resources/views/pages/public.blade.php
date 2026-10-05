@include('layouts.navbar')

@php
    $pageContent = [
        'categories' => ['title' => 'Explore Categories', 'subtitle' => 'Find events that match what you love.'],
        'how-it-works' => ['title' => 'How Eventora Works', 'subtitle' => 'Discover an event, book your place, and enjoy the experience.'],
        'about' => ['title' => 'About Eventora', 'subtitle' => 'A simpler way to discover and book events.'],
        'contact' => ['title' => 'Contact Eventora', 'subtitle' => 'Find the right place to get help with an event or organization.'],
    ][$page];
@endphp

<style>
    .public-info-page { min-height:calc(100vh - 74px); padding:72px 20px 90px; color:#f4f6fb; background:radial-gradient(ellipse at 50% 0%,rgba(109,93,252,.16),transparent 48%),#0b0f19; font-family:Arial,Helvetica,sans-serif; }
    .public-info-container { width:min(1050px,100%); margin:0 auto; }
    .public-info-heading { margin:0 auto 42px; text-align:center; }
    .public-info-heading h1 { margin:0 0 12px; color:#f8fafc; font-size:clamp(34px,5vw,52px); line-height:1.1; letter-spacing:-1.4px; }
    .public-info-heading p { margin:0 auto; max-width:680px; color:#aab5c8; font-size:17px; line-height:1.7; }
    .public-info-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:18px; }
    .public-info-card { padding:25px; border:1px solid #29344c; border-radius:18px; background:#151b2b; box-shadow:0 12px 32px rgba(0,0,0,.12); }
    .public-info-card .step { display:inline-flex; width:38px; height:38px; align-items:center; justify-content:center; margin-bottom:18px; border-radius:12px; color:#fff; background:#6d5dfc; font-weight:800; }
    .public-info-card h2,.public-info-card h3 { margin:0 0 10px; color:#f8fafc; font-size:19px; }
    .public-info-card p { margin:0; color:#aab5c8; line-height:1.7; }
    .public-info-card a { color:#a69fff; font-weight:700; text-decoration:none; }
    .public-info-card a:hover { color:#c4bdff; text-decoration:underline; }
    .public-info-actions { display:flex; flex-wrap:wrap; justify-content:center; gap:12px; margin-top:30px; }
    .public-info-button { display:inline-flex; min-height:46px; align-items:center; justify-content:center; padding:0 20px; border:1px solid #303a52; border-radius:11px; color:#f8fafc; background:#151b2b; text-decoration:none; font-weight:700; }
    .public-info-button.primary { border-color:#6d5dfc; background:#6d5dfc; }
    .public-info-button:hover { transform:translateY(-1px); }
    .public-info-empty { grid-column:1/-1; padding:30px; text-align:center; }
    html[data-theme="light"] .public-info-page { color:#172033; background:radial-gradient(ellipse at 50% 0%,rgba(109,93,252,.10),transparent 48%),#f5f7fb; }
    html[data-theme="light"] .public-info-heading h1,html[data-theme="light"] .public-info-card h2,html[data-theme="light"] .public-info-card h3 { color:#172033; }
    html[data-theme="light"] .public-info-heading p,html[data-theme="light"] .public-info-card p { color:#5c6678; }
    html[data-theme="light"] .public-info-card,html[data-theme="light"] .public-info-button { border-color:#dce2ec; background:#fff; }
    html[data-theme="light"] .public-info-button { color:#172033; }
    html[data-theme="light"] .public-info-button.primary { color:#fff; background:#6d5dfc; }
    @media(max-width:760px) { .public-info-page { padding:50px 16px 65px; } .public-info-grid { grid-template-columns:1fr; } }
</style>

<main class="public-info-page">
    <div class="public-info-container">
        <header class="public-info-heading">
            <h1>{{ $pageContent['title'] }}</h1>
            <p>{{ $pageContent['subtitle'] }}</p>
        </header>

        @if($page === 'categories')
            <div class="public-info-grid">
                @forelse($categories as $category)
                    <article class="public-info-card">
                        <span class="step">{{ strtoupper(substr($category->category, 0, 1)) }}</span>
                        <h2>{{ $category->category }}</h2>
                        <p>{{ $category->events_count }} {{ \Illuminate\Support\Pluralizer::plural('event', $category->events_count) }} available.</p>
                        <p style="margin-top:16px"><a href="{{ route('events.index', ['category' => $category->category]) }}">Browse {{ $category->category }} events →</a></p>
                    </article>
                @empty
                    <article class="public-info-card public-info-empty"><h2>No event categories yet</h2><p>Approved events will appear here when they are available.</p></article>
                @endforelse
            </div>
        @elseif($page === 'how-it-works')
            <div class="public-info-grid">
                <article class="public-info-card"><span class="step">01</span><h2>Discover</h2><p>Browse upcoming events and filter by category, city, or date.</p></article>
                <article class="public-info-card"><span class="step">02</span><h2>Book</h2><p>Choose an event, select your ticket, and complete your booking.</p></article>
                <article class="public-info-card"><span class="step">03</span><h2>Attend</h2><p>Open your booking to view your ticket and present it at the event.</p></article>
            </div>
            <div class="public-info-actions"><a class="public-info-button primary" href="{{ route('events.index') }}">Explore Events</a><a class="public-info-button" href="{{ route('bookings.index') }}">My Bookings</a></div>
        @elseif($page === 'about')
            <div class="public-info-grid">
                <article class="public-info-card"><span class="step">E</span><h2>Discover more</h2><p>Eventora brings upcoming events from schools, colleges, companies, and other organizations into one place.</p></article>
                <article class="public-info-card"><span class="step">B</span><h2>Book with ease</h2><p>Explore event details, check availability, and keep your bookings and tickets together in your account.</p></article>
                <article class="public-info-card"><span class="step">H</span><h2>Host on Eventora</h2><p>Organizations can register and manage their events for people looking for their next experience.</p></article>
            </div>
            <div class="public-info-actions"><a class="public-info-button primary" href="{{ route('events.index') }}">Find Events</a><a class="public-info-button" href="{{ route('organizations.create') }}">Register an Organization</a></div>
        @else
            <div class="public-info-grid">
                <article class="public-info-card"><span class="step">?</span><h2>Event questions</h2><p>Open the event details to find its organizer and event information.</p><p style="margin-top:16px"><a href="{{ route('events.index') }}">Browse events →</a></p></article>
                <article class="public-info-card"><span class="step">O</span><h2>Organization support</h2><p>For organization registration or event hosting, start from the organization registration page.</p><p style="margin-top:16px"><a href="{{ route('organizations.create') }}">Register an organization →</a></p></article>
                <article class="public-info-card"><span class="step">A</span><h2>Account and bookings</h2><p>Sign in to review your profile and bookings or check the ticket details in your account.</p><p style="margin-top:16px"><a href="{{ route('login') }}">Sign in →</a></p></article>
            </div>
        @endif
    </div>
</main>

@include('layouts.footer')
