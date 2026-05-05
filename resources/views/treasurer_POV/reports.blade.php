<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Finance - Reports</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg:       #0f2a2a;
            --sidebar-width:    200px;
            --accent:           #2a9d8f;
            --header-bg:        #1a6b6b;
            --page-bg:          #f0f2f5;
            --card-bg:          #ffffff;
            --border:           #e5e7eb;
            --text-main:        #1a1a2e;
            --text-muted:       #6b7280;
            --logout-red:       #c0392b;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            font-family: 'Inter', sans-serif;
            background: var(--page-bg);
            color: var(--text-main);
            /* Removed overflow: hidden to allow natural browser scrolling */
            height: 100%;
        }

        a { text-decoration: none; color: inherit; }

        .app {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .brand-icon {
            width: 38px;
            height: 38px;
            background: var(--accent);
            border-radius: 8px;
            flex-shrink: 0;
        }
        .brand-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
        }
        .brand-sub {
            font-size: 0.68rem;
            color: rgba(255,255,255,0.45);
        }

        .sidebar-role {
            margin: 14px 12px 10px;
            background: rgba(255,255,255,0.07);
            border-radius: 6px;
            padding: 7px 12px;
            font-size: 0.72rem;
            font-weight: 600;
            color: rgba(255,255,255,0.65);
            letter-spacing: 0.05em;
        }

        .nav-label {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 14px 16px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 16px;
            font-size: 0.8rem;
            font-weight: 500;
            color: rgba(255,255,255,0.55);
            cursor: pointer;
            position: relative;
            transition: background 0.15s, color 0.15s;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.85);
        }
        .nav-item.active {
            background: rgba(42,157,143,0.18);
            color: #fff;
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 4px; bottom: 4px;
            width: 3px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
        }

        .sidebar-logout {
            margin-top: auto;
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .btn-logout {
            width: 100%;
            background: var(--logout-red);
            color: white;
            border: none;
            border-radius: 7px;
            padding: 9px 12px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: background 0.15s;
        }
        .btn-logout:hover { background: #a93226; }

        /* ── MAIN ── */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Changed to allow natural document scroll */
            overflow-y: visible; 
            min-width: 0;
        }

        .mobile-nav-toggle {
            display: none;
            background: var(--header-bg);
            padding: 12px 20px;
            color: white;
            align-items: center;
            gap: 12px;
        }
        .menu-btn {
            background: none;
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .header {
            background: var(--header-bg);
            padding: 28px 36px 40px;
            color: white;
        }
        .header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }
        .header p {
            font-size: 0.88rem;
            opacity: 0.75;
        }

        /* ── TABLE STYLES ── */
        .transactions-wrapper {
            margin: 28px 36px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            overflow: hidden;
            margin-bottom: 50px; /* Space at bottom */
        }

        .filter-bar {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
        }
        .filter-bar-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
            margin-right: 4px;
        }

        .btn-export-pdf {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            background: #c0392b;
            color: #fff;
            border: none;
            border-radius: 7px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-export-pdf:hover  { background: #a93226; }
        .btn-export-pdf svg { width: 14px; height: 14px; fill: white; }

        .tx-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
        .tx-table thead tr { background: #f8fafb; border-bottom: 1px solid var(--border); }
        .tx-table thead th {
            padding: 11px 16px; text-align: left;
            font-size: 0.7rem; font-weight: 700;
            letter-spacing: 0.07em; text-transform: uppercase;
            color: var(--text-muted); white-space: nowrap;
        }
        .tx-table tbody tr { border-bottom: 1px solid #f0f2f5; }
        .tx-table tbody td { padding: 13px 16px; vertical-align: middle; }

        .badge { display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .badge-income  { background: #dcfce7; color: #15803d; }
        .badge-expense { background: #fee2e2; color: #b91c1c; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600;
        }
        .status-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .status-approved { background: #dcfce7; color: #15803d; }
        .status-pending  { background: #fef9c3; color: #a16207; }
        .status-declined { background: #fee2e2; color: #b91c1c; }

        .empty-state {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; padding: 56px 24px;
            color: var(--text-muted); gap: 12px;
        }
        .empty-state svg { width: 44px; height: 44px; fill: #d1d5db; }

        /* ── PAGINATION ── */
        .pagination-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: white;
            flex-wrap: wrap;
            gap: 10px;
        }
        .pagination-info {
            font-size: 0.78rem;
            color: var(--text-muted);
        }
        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .page-btn {
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            border: 1px solid var(--border);
            background: white;
            color: var(--text-main);
            border-radius: 6px;
            font-size: 0.78rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .page-btn:hover:not(:disabled) {
            background: #f0f2f5;
            border-color: #d1d5db;
        }
        .page-btn.active {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }
        .page-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        @media (max-width: 1024px) {
            .sidebar { position: fixed; left: 0; transform: translateX(-100%); height: 100vh; }
            .sidebar.active { transform: translateX(0); }
            .sidebar-overlay.active { display: block; }
            .mobile-nav-toggle { display: flex; }
            .transactions-wrapper { margin: 20px 16px; }
            .header { padding: 22px 20px 32px; }
            .main { overflow-y: visible; }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="overlay"></div>

<div class="app">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <img src="{{ asset('images/image-removebg-preview (7).svg') }}" alt="" style="width: 38px; height: 38px; border-radius: 8px; object-fit: cover;">
            </div>
            <div>
                <div class="brand-name">Church Finance</div>
                <div class="brand-sub">Financial System</div>
            </div>
        </div>

        <div class="sidebar-role">Treasurer</div>

        <nav>
            <div class="nav-label">Main</div>
            <a class="nav-item {{ Route::is('treasurer') ? 'active' : '' }}" href="{{ route('treasurer') }}">Dashboard</a>

            <div class="nav-label">Finance</div>
            <a class="nav-item" href="{{ route('treasurer.addfundexpenses') }}">Add Funds & Expenses</a>

            <div class="nav-label">Records</div>
            <a class="nav-item {{ Route::is('treasurer.transactions') ? 'active' : '' }}" href="{{ route('treasurer.transactions') }}">Transactions</a>
            <a class="nav-item {{ Route::is('treasurer.reports') ? 'active' : '' }}" href="{{ route('treasurer.reports') }}">Reports</a>
        </nav>

        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </aside>

    <div class="main">
        <div class="mobile-nav-toggle">
            <button class="menu-btn" id="menuToggle">Menu</button>
            <span style="font-weight:600; font-size: 0.9rem;">Church Finance</span>
        </div>

        <div class="header">
            <h1>Reports</h1>
            <p>View and export approved transaction reports</p>
        </div>

        <div class="transactions-wrapper">
            <div class="filter-bar">
                <span class="filter-bar-title">Reports</span>
                <button class="btn-export-pdf" id="exportPdfBtn">
                    <svg viewBox="0 0 24 24"><path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/></svg>
                    Export PDF
                </button>
            </div>

            <input type="hidden" id="reporterName" value="{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}">
            <input type="hidden" id="reporterRole" value="{{ ucfirst(auth()->user()->role) }}">

            <div style="overflow-x: auto;">
                <table class="tx-table" id="txTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Treasurer</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Expenses</th>
                            <th>Funds</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $tx)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($tx->date)->format('M d, Y') }}</td>
                            <td>{{ $tx->user ? $tx->user->firstName . ' ' . $tx->user->lastName : '—' }}</td>
                            <td>
                                <span class="badge {{ $tx->type == 'funds' ? 'badge-income' : 'badge-expense' }}">
                                    {{ ucfirst($tx->type) }}
                                </span>
                            </td>
                            <td>{{ $tx->description }}</td>
                            <td>{{ $tx->expenses_amount > 0 ? '₱' . number_format($tx->expenses_amount, 2) : '—' }}</td>
                            <td>{{ $tx->funds_amount > 0 ? '₱' . number_format($tx->funds_amount, 2) : '—' }}</td>
                            <td>₱{{ number_format($tx->total_amount, 2) }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($tx->status) }}">
                                    {{ ucfirst($tx->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                    <p>No approved transactions found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="pagination-bar" id="paginationBar">
                <span class="pagination-info" id="paginationInfo"></span>
                <div class="pagination-controls" id="paginationControls"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

<script>
    // Sidebar logic
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    function toggleMenu() { [sidebar, overlay].forEach(el => el.classList.toggle('active')); }
    menuToggle.addEventListener('click', toggleMenu);
    overlay.addEventListener('click', toggleMenu);

    // ── PAGINATION ──
    const ROWS_PER_PAGE = 10;
    let currentPage = 1;

    function getAllRows() {
        return Array.from(document.querySelectorAll('#txTable tbody tr'))
            .filter(tr => tr.querySelectorAll('td').length >= 8);
    }

    function renderPage() {
        const allRows   = getAllRows();
        const totalRows = allRows.length;
        const totalPages = Math.max(1, Math.ceil(totalRows / ROWS_PER_PAGE));

        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * ROWS_PER_PAGE;
        const end   = start + ROWS_PER_PAGE;

        allRows.forEach((row, i) => {
            row.style.display = (i >= start && i < end) ? '' : 'none';
        });

        // Info text
        const infoEl = document.getElementById('paginationInfo');
        if (totalRows === 0) {
            infoEl.textContent = 'No results';
        } else {
            const from = start + 1;
            const to   = Math.min(end, totalRows);
            infoEl.textContent = `Showing ${from}–${to} of ${totalRows} transactions`;
        }

        // Controls
        const controlsEl = document.getElementById('paginationControls');
        controlsEl.innerHTML = '';

        // Prev button
        const prevBtn = document.createElement('button');
        prevBtn.className = 'page-btn';
        prevBtn.textContent = '‹';
        prevBtn.disabled = currentPage === 1;
        prevBtn.addEventListener('click', () => { currentPage--; renderPage(); });
        controlsEl.appendChild(prevBtn);

        // Page number buttons
        const range = 2;
        for (let p = 1; p <= totalPages; p++) {
            if (
                p === 1 || p === totalPages ||
                (p >= currentPage - range && p <= currentPage + range)
            ) {
                const btn = document.createElement('button');
                btn.className = 'page-btn' + (p === currentPage ? ' active' : '');
                btn.textContent = p;
                btn.addEventListener('click', (pg => () => { currentPage = pg; renderPage(); })(p));
                controlsEl.appendChild(btn);
            } else if (
                p === currentPage - range - 1 ||
                p === currentPage + range + 1
            ) {
                const dots = document.createElement('span');
                dots.textContent = '…';
                dots.style.cssText = 'padding: 0 4px; color: var(--text-muted); font-size: 0.8rem; line-height: 32px;';
                controlsEl.appendChild(dots);
            }
        }

        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.className = 'page-btn';
        nextBtn.textContent = '›';
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.addEventListener('click', () => { currentPage++; renderPage(); });
        controlsEl.appendChild(nextBtn);

        // Hide pagination bar if no data rows
        document.getElementById('paginationBar').style.display = totalRows === 0 ? 'none' : 'flex';
    }

    // Init on load
    renderPage();

    // PDF Export logic — exports ALL rows regardless of pagination
    document.getElementById('exportPdfBtn').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });
        const W = doc.internal.pageSize.width;
        const H = doc.internal.pageSize.height;
        const now = new Date();
        const dateStr = now.toLocaleDateString('en-PH', { year: 'numeric', month: 'long', day: 'numeric' });
        
        const reporterName = document.getElementById('reporterName').value;
        const reporterRole = document.getElementById('reporterRole').value;

        // Export ALL rows (make all visible temporarily)
        const allRows = getAllRows();
        allRows.forEach(r => r.style.display = '');
        const rows = allRows.map(tr => Array.from(tr.querySelectorAll('td')).map(td => td.innerText.replace(/₱/g, 'PHP ').trim()));
        // Restore pagination display
        renderPage();

        function drawHeader() {
            doc.setFillColor(15, 42, 42); doc.rect(0, 0, W, 26, 'F');
            doc.setFillColor(42, 157, 143); doc.rect(0, 26, W, 2, 'F');
            doc.setFontSize(14); doc.setFont('helvetica', 'bold'); doc.setTextColor(255);
            doc.text('CHURCH FINANCE SYSTEM', 15, 12);
            doc.setFontSize(8); doc.setFont('helvetica', 'normal');
            doc.text('Prepared by: ' + reporterName + ' (' + reporterRole + ')', 15, 20);
            doc.text('Date: ' + dateStr, W - 15, 12, { align: 'right' });
        }

        drawHeader();
        doc.autoTable({
            startY: 35,
            head: [['Date', 'Treasurer', 'Type', 'Description', 'Expenses', 'Funds', 'Total', 'Status']],
            body: rows.length ? rows : [['—', '—', '—', 'No records found', '—', '—', '—', '—']],
            theme: 'striped',
            headStyles: { fillColor: [15, 42, 42] },
            styles: { fontSize: 8 },
            didDrawPage: (data) => {
                if (data.pageNumber > 1) drawHeader();
                doc.setFontSize(7);
                doc.text('Page ' + data.pageNumber, W - 15, H - 5);
            }
        });

        doc.save(`Report_${now.toISOString().split('T')[0]}.pdf`);
    });
</script>
</body>
</html>