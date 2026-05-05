<!-- Add Funds & Expenses -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Finance</title>
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

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            font-family: 'Inter', sans-serif;
            height: 100%;
            background: var(--page-bg);
            color: var(--text-main);
        }

        a { text-decoration: none; }

        .app { display: flex; height: 100vh; overflow: hidden; position: relative; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        /* MOBILE OVERLAY */
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
            width: 38px; height: 38px;
            background: var(--accent);
            border-radius: 8px;
            flex-shrink: 0;
        }
        .brand-name { font-size: 0.85rem; font-weight: 700; color: #fff; }
        .brand-sub  { font-size: 0.68rem; color: rgba(255,255,255,0.45); }

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
        .nav-item:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.85); }
        .nav-item.active { background: rgba(42,157,143,0.18); color: #fff; }
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
        .btn-logout svg { width: 14px; height: 14px; fill: white; }

        /* ── MOBILE NAV TOGGLE ── */
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
            font-family: inherit;
        }

        /* ── MAIN ── */
        .main { flex: 1; display: flex; flex-direction: column; height: 100vh; overflow-y: auto; min-width: 0; }

        .header { background: var(--header-bg); padding: 28px 36px 40px; color: white; }
        .header h1 { font-size: 1.75rem; font-weight: 700; letter-spacing: -0.02em; margin-bottom: 4px; }
        .header p  { font-size: 0.88rem; opacity: 0.75; }

        .content { padding: 28px 36px; flex: 1; }

        .table-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            overflow: hidden;
        }

        .table-filters {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
        }
        .filter-label { font-size: 0.9rem; font-weight: 700; color: var(--text-main); margin-right: 4px; }

        .filter-search {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 8px 12px;
            flex: 1;
            min-width: 160px;
        }
        .filter-search svg { width: 15px; height: 15px; fill: var(--text-muted); flex-shrink: 0; }
        .filter-search input {
            border: none; outline: none;
            font-size: 0.82rem; color: var(--text-main);
            font-family: inherit; width: 100%; background: transparent;
        }
        .filter-search input::placeholder { color: #c0c5cd; }

        .filter-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border: none;
            border-radius: 7px;
            font-size: 0.82rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
            white-space: nowrap;
            text-decoration: none;
        }
        .filter-btn:active { transform: scale(0.98); }
        .filter-btn svg { width: 15px; height: 15px; fill: currentColor; }

        .btn-search { background: #f0f2f5; color: var(--text-main); border: 1px solid var(--border); }
        .btn-search:hover { background: #e5e7eb; }

        .btn-add { background: var(--accent); color: #fff; }
        .btn-add:hover { background: #238a7e; }

        .table-wrap { overflow-x: auto; }

        .txn-table { width: 100%; border-collapse: collapse; }
        .txn-table thead tr { background: #f9fafb; border-bottom: 1px solid var(--border); }
        .txn-table th {
            padding: 11px 18px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
            text-align: left;
            white-space: nowrap;
        }
        .txn-table td {
            padding: 14px 18px;
            font-size: 0.83rem;
            color: var(--text-main);
            border-bottom: 1px solid var(--border);
        }
        .txn-table tbody tr:last-child td { border-bottom: none; }
        .txn-table tbody tr:hover td { background: #f9fafb; }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 20px;
            gap: 12px;
        }
        .empty-state svg { width: 48px; height: 48px; fill: #d1d5db; }
        .empty-state p { font-size: 0.85rem; color: var(--text-muted); }

        /* ── TOAST ── */
        #toast-notification {
            position: fixed; top: 24px; right: 24px; z-index: 9999;
            background: #1a1a2e; color: #fff;
            padding: 14px 22px; border-radius: 8px;
            font-size: 0.82rem; font-weight: 600;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            transition: opacity 0.3s ease, transform 0.3s ease;
            opacity: 0; pointer-events: none;
            border-left: 4px solid #2a9d8f;
            transform: translateY(-8px);
        }
        #toast-notification.toast-show {
            opacity: 1;
            transform: translateY(0);
        }

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

        /* ══════════════════════════
           RESPONSIVE
        ══════════════════════════ */
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                left: 0;
                transform: translateX(-100%);
            }
            .sidebar.active { transform: translateX(0); }
            .sidebar-overlay.active { display: block; }
            .mobile-nav-toggle { display: flex; }
            .content { padding: 20px 16px; }
            .header { padding: 22px 20px 32px; }
            .header h1 { font-size: 1.4rem; }
        }

        @media (max-width: 600px) {
            .header h1 { font-size: 1.25rem; }
            .content { padding: 14px 12px; }
            .table-filters { padding: 12px 14px; gap: 8px; }
            .filter-label { display: none; }
            .filter-btn span { display: none; }
        }
    </style>
</head>
<body>

<!-- Toast -->
<div id="toast-notification"></div>

<div class="sidebar-overlay" id="overlay"></div>

<div class="app">

    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <div class="brand-icon">
                <img src="{{ asset('images/image-removebg-preview (7).svg') }}"
                     alt=""
                     style="width: 38px; height: 38px; border-radius: 8px; object-fit: cover;">
            </div>
            <div>
                <div class="brand-name">Church Finance</div>
                <div class="brand-sub">Financial System</div>
            </div>
        </div>

        <div class="sidebar-role">Treasurer</div>

        <nav>
            <div class="nav-label">Main</div>
            <a class="nav-item {{ request()->routeIs('treasurer') ? 'active' : '' }}" href="{{ route('treasurer') }}">
                Dashboard
            </a>

            <div class="nav-label">Finance</div>
            <a class="nav-item {{ request()->routeIs('treasurer.addfundexpenses') ? 'active' : '' }}" href="{{ route('treasurer.addfundexpenses') }}">
                Add Funds & Expenses
            </a>

            <div class="nav-label">Records</div>
            <a class="nav-item {{ request()->routeIs('treasurer.transactions') ? 'active' : '' }}" href="{{ route('treasurer.transactions') }}">
                Transactions
            </a>
            <a class="nav-item {{ request()->routeIs('treasurer.reports') ? 'active' : '' }}" href="{{ route('treasurer.reports') }}">
                Reports
            </a>
        </nav>

        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <div class="main">

        <!-- Mobile topbar -->
        <div class="mobile-nav-toggle">
            <button class="menu-btn" id="menuToggle">Menu</button>
            <span style="font-weight:600; font-size: 0.9rem;">Church Finance</span>
        </div>

        <div class="header">
            <h1>Add Funds & Expenses</h1>
            <p>Review, filter, and manage fund and expense transactions</p>
        </div>

        <div class="content">
            <div class="table-card">

                <div class="table-filters">
                    <span class="filter-label">Filters</span>
                    <div class="filter-search">
                        <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        <input type="text" id="searchInput" placeholder="Search transactions..." onkeyup="filterTable()">
                    </div>
                    <button class="filter-btn btn-search" onclick="filterTable()">
                        <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        <span>Search</span>
                    </button>
                    <a href="{{ route('treasurer.finance') }}" class="filter-btn btn-add">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
                        <span>Add Funds/Expenses</span>
                    </a>
                </div>

                <div class="table-wrap">
                    <table class="txn-table" id="txnTable">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>TREASURER ID</th>
                                <th>TYPE</th>
                                <th>DESCRIPTION</th>
                                <th>EXPENSES</th>
                                <th>FUNDS</th>
                                <th>TOTAL AMOUNT</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $txn)
                        <tr data-search="{{ strtolower($txn->description . ' ' . ($txn->user ? $txn->user->firstName . ' ' . $txn->user->lastName : '') . ' ' . $txn->type . ' ' . $txn->status) }}">
                            <td>{{ \Carbon\Carbon::parse($txn->date)->format('M d, Y') }}</td>
                            <td>{{ $txn->user ? $txn->user->firstName . ' ' . $txn->user->lastName : '—' }}</td>
                            <td>{{ ucfirst($txn->type) }}</td>
                            <td>{{ $txn->description }}</td>
                            <td>{{ $txn->expenses_amount > 0 ? '₱' . number_format($txn->expenses_amount, 2) : '—' }}</td>
                            <td>{{ $txn->funds_amount > 0 ? '₱' . number_format($txn->funds_amount, 2) : '—' }}</td>
                            <td>₱{{ number_format($txn->total_amount, 2) }}</td>
                            <td>{{ ucfirst($txn->status) }}</td>
                            <td>
                                <div style="display:flex; gap:6px; flex-wrap:wrap;">

                                    {{-- EDIT --}}
                                    <a href="{{ route('treasurer.edit', $txn->treasurerTransactionsID) }}"
                                       style="display:inline-flex; align-items:center; gap:4px;
                                              padding:5px 10px; background:#f0fdf4; color:#16a34a;
                                              border:1px solid #86efac; border-radius:6px;
                                              font-size:0.73rem; font-weight:600; text-decoration:none;">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                        </svg>
                                    </a>

                                    {{-- APPROVE --}}
                                    @if($txn->status !== 'approved')
                                    <form method="POST" action="{{ route('treasurer.approve', $txn->treasurerTransactionsID) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                style="display:inline-flex; align-items:center; gap:4px;
                                                       padding:5px 10px; background:#f0fdf4; color:#15803d;
                                                       border:1px solid #86efac; border-radius:6px;
                                                       font-size:0.73rem; font-weight:600; cursor:pointer;">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif

                                    {{-- REJECT --}}
                                    @if($txn->status !== 'rejected')
                                    <form method="POST" action="{{ route('treasurer.reject', $txn->treasurerTransactionsID) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                style="display:inline-flex; align-items:center; gap:4px;
                                                       padding:5px 10px; background:#fff7ed; color:#c2410c;
                                                       border:1px solid #fdba74; border-radius:6px;
                                                       font-size:0.73rem; font-weight:600; cursor:pointer;">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif

                                    {{-- DELETE --}}
                                    <form method="POST" action="{{ route('treasurer.destroy', $txn->treasurerTransactionsID) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this entry?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="display:inline-flex; align-items:center; gap:4px;
                                                       padding:5px 10px; background:#fff5f5; color:#dc2626;
                                                       border:1px solid #fca5a5; border-radius:6px;
                                                       font-size:0.73rem; font-weight:600; cursor:pointer;">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                                    <p>No transactions found.</p>
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

</div>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    showToast("{{ session('success') }}");
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    showToast("{{ session('error') }}", true);
});
</script>
@endif

<script>
// ── SIDEBAR TOGGLE ─────────────────────────────────────────────────
const menuToggle = document.getElementById('menuToggle');
const sidebar    = document.getElementById('sidebar');
const overlay    = document.getElementById('overlay');

function toggleMenu() {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
}

menuToggle.addEventListener('click', toggleMenu);
overlay.addEventListener('click', toggleMenu);

// ── TOAST ──────────────────────────────────────────────────────────
function showToast(msg, isError = false) {
    const toast = document.getElementById('toast-notification');
    toast.style.borderLeftColor = isError ? '#c0392b' : '#2a9d8f';
    toast.textContent = msg;
    toast.classList.add('toast-show');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => toast.classList.remove('toast-show'), 3500);
}

// ── PAGINATION + SEARCH ────────────────────────────────────────────
const ROWS_PER_PAGE = 10;
let currentPage = 1;

function getVisibleRows() {
    const search = (document.getElementById('searchInput').value || '').toLowerCase();
    const rows   = Array.from(document.querySelectorAll('#txnTable tbody tr[data-search]'));
    return rows.filter(row => !search || row.dataset.search.includes(search));
}

function renderPage() {
    const allRows    = Array.from(document.querySelectorAll('#txnTable tbody tr[data-search]'));
    const visible    = getVisibleRows();
    const totalRows  = visible.length;
    const totalPages = Math.max(1, Math.ceil(totalRows / ROWS_PER_PAGE));

    if (currentPage > totalPages) currentPage = totalPages;

    const start = (currentPage - 1) * ROWS_PER_PAGE;
    const end   = start + ROWS_PER_PAGE;

    allRows.forEach(row => row.style.display = 'none');
    visible.forEach((row, i) => {
        row.style.display = (i >= start && i < end) ? '' : 'none';
    });

    // Info text
    const infoEl = document.getElementById('paginationInfo');
    if (totalRows === 0) {
        infoEl.textContent = 'No results';
    } else {
        infoEl.textContent = `Showing ${start + 1}–${Math.min(end, totalRows)} of ${totalRows} transactions`;
    }

    // Controls
    const controlsEl = document.getElementById('paginationControls');
    controlsEl.innerHTML = '';

    const prevBtn = document.createElement('button');
    prevBtn.className = 'page-btn';
    prevBtn.textContent = '‹';
    prevBtn.disabled = currentPage === 1;
    prevBtn.addEventListener('click', () => { currentPage--; renderPage(); });
    controlsEl.appendChild(prevBtn);

    const range = 2;
    for (let p = 1; p <= totalPages; p++) {
        if (p === 1 || p === totalPages || (p >= currentPage - range && p <= currentPage + range)) {
            const btn = document.createElement('button');
            btn.className = 'page-btn' + (p === currentPage ? ' active' : '');
            btn.textContent = p;
            btn.addEventListener('click', (pg => () => { currentPage = pg; renderPage(); })(p));
            controlsEl.appendChild(btn);
        } else if (p === currentPage - range - 1 || p === currentPage + range + 1) {
            const dots = document.createElement('span');
            dots.textContent = '…';
            dots.style.cssText = 'padding: 0 4px; color: var(--text-muted); font-size: 0.8rem; line-height: 32px;';
            controlsEl.appendChild(dots);
        }
    }

    const nextBtn = document.createElement('button');
    nextBtn.className = 'page-btn';
    nextBtn.textContent = '›';
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.addEventListener('click', () => { currentPage++; renderPage(); });
    controlsEl.appendChild(nextBtn);

    document.getElementById('paginationBar').style.display =
        allRows.length === 0 ? 'none' : 'flex';
}

function filterTable() {
    currentPage = 1;
    renderPage();
}

// Init on load
renderPage();
</script>

</body>
</html>