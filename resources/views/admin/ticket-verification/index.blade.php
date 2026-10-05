@extends('layouts.admin')
@section('title', 'Ticket Verification - Eventora')
@section('heading', 'Ticket Verification')
@section('description', 'Search a booking and check its ticket status across Eventora.')
@section('content')
<section class="card" style="padding:22px;max-width:900px">
    <form id="ticketSearchForm" action="{{ route('admin.ticket-verification.index') }}" method="GET" class="toolbar" style="margin:0">
        <input id="ticketSearch" class="search" type="search" name="q" placeholder="Search booking number, participant, email or event..." autocomplete="off">
        <button type="submit">Search</button>
        <button id="openTicketScanner" type="button" class="export-btn">📷 Scan QR Ticket</button>
    </form>
    <div id="ticketResults" style="padding-top:14px;color:var(--muted);font-size:12px">Enter a booking number or participant details.</div>
</section>
<div id="ticketScannerModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:2000;align-items:center;justify-content:center;padding:18px">
    <div style="width:min(520px,100%);background:var(--card);border:1px solid var(--border);border-radius:16px;padding:18px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px"><strong>Scan ticket QR code</strong><button id="closeTicketScanner" type="button" class="export-btn">Close</button></div>
        <div id="adminQrReader"></div>
        <p id="ticketScanStatus" style="margin-top:10px;color:var(--muted);font-size:12px">Allow camera access and point it at a ticket QR code.</p>
    </div>
</div>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
(() => {
    const input = document.getElementById('ticketSearch');
    const form = document.getElementById('ticketSearchForm');
    const results = document.getElementById('ticketResults');
    let timer;
    let scanner = null;
    let scanning = false;
    let scannerStartPromise = null;
    let scanCancelled = false;
    const modal = document.getElementById('ticketScannerModal');
    const status = document.getElementById('ticketScanStatus');
    const stopScanner = async (hide = true) => {
        scanCancelled = true;
        const activeScanner = scanner;
        const pendingStart = scannerStartPromise;
        if (hide) modal.style.display = 'none';

        if (pendingStart) {
            try { await pendingStart; } catch (_) {}
        }
        if (activeScanner) {
            try { await activeScanner.stop(); } catch (_) {}
            try { activeScanner.clear(); } catch (_) {}
        }
        scanning = false; scanner = null;
        scannerStartPromise = null;
    };
    document.getElementById('openTicketScanner').addEventListener('click', async () => {
        if (scanner || scannerStartPromise) await stopScanner(false);
        scanCancelled = false;
        modal.style.display = 'flex';
        if (typeof Html5Qrcode === 'undefined') { status.textContent = 'QR scanner could not load. Use the booking search field instead.'; return; }
        try {
            scanner = new Html5Qrcode('adminQrReader');
            const activeScanner = scanner;
            scannerStartPromise = activeScanner.start({facingMode:'environment'}, {fps:10, qrbox:{width:250,height:250}}, async decoded => {
                status.textContent = 'QR detected. Checking ticket…';
                let bookingNumber = decoded.trim();
                try { if (/^https?:\/\//i.test(bookingNumber)) bookingNumber = new URL(bookingNumber).pathname.split('/').filter(Boolean).pop(); }
                catch (_) { bookingNumber = bookingNumber.split('/').filter(Boolean).pop(); }
                await stopScanner(false);
                window.location.href = `{{ url('/admin/ticket-verification') }}/${encodeURIComponent(bookingNumber)}`;
            }, () => {});
            await scannerStartPromise;
            scanning = true;
        } catch (_) {
            scanning = false;
            if (!scanCancelled) status.textContent = 'Camera access failed. Allow camera permission and try again.';
        }
    });
    document.getElementById('closeTicketScanner').addEventListener('click', () => stopScanner());
    modal.addEventListener('click', event => { if (event.target === modal) stopScanner(); });
    const search = async () => {
        const q = input.value.trim();
        if (!q) { results.textContent = 'Enter a booking number or participant details.'; return; }
        results.textContent = 'Searching…';
        try {
            const response = await fetch(`{{ route('admin.ticket-verification.search') }}?q=${encodeURIComponent(q)}`, {headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}});
            if (!response.ok) throw new Error();
            const items = await response.json();
            results.replaceChildren();
            if (!items.length) { results.textContent = 'No matching tickets found.'; return; }
            items.forEach(item => {
                const link = document.createElement('a');
                link.href = item.url;
                link.className = 'panel-row';
                link.style.cssText = 'display:flex;justify-content:space-between;gap:16px;padding:13px;border-bottom:1px solid var(--border)';
                const left = document.createElement('span');
                left.textContent = `${item.booking_number} · ${item.participant} · ${item.event} · ${item.organization}`;
                const right = document.createElement('strong');
                right.textContent = `${item.payment_status} / ${item.booking_status}`;
                link.append(left, right); results.append(link);
            });
        } catch (_) { results.textContent = 'Ticket search is unavailable right now.'; }
    };
    input.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(search, 250); });
    form.addEventListener('submit', event => { event.preventDefault(); search(); });
})();
</script>
@endsection
