<!--encoder_POV.transactions -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions – Church Finance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg:    #0f2a2a;
            --sidebar-width: 200px;
            --accent:        #2a9d8f;
            --header-bg:     #1a6b6b;
            --page-bg:       #f0f2f5;
            --card-bg:       #ffffff;
            --border:        #e5e7eb;
            --text-main:     #1a1a2e;
            --text-muted:    #6b7280;
            --logout-red:    #c0392b;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            font-family: 'Inter', sans-serif;
            height: 100%;
            background: var(--page-bg);
            color: var(--text-main);
        }

        @media (min-width: 769px) {
            html, body { overflow: hidden; }
        }

        a { text-decoration: none; }
        .app { display: flex; height: 100vh; }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.25s ease;
            z-index: 200;
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
            border-radius: 8px; flex-shrink: 0;
        }
        .brand-name { font-size: 0.85rem; font-weight: 700; color: #fff; }
        .brand-sub  { font-size: 0.68rem; color: rgba(255,255,255,0.45); }

        .sidebar-role {
            margin: 14px 12px 10px;
            background: rgba(255,255,255,0.07);
            border-radius: 6px;
            padding: 7px 12px;
            font-size: 0.72rem; font-weight: 600;
            color: rgba(255,255,255,0.65);
            letter-spacing: 0.05em;
        }
        .nav-label {
            font-size: 0.62rem; font-weight: 700;
            letter-spacing: 0.12em; text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 14px 16px 6px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 16px;
            font-size: 0.8rem; font-weight: 500;
            color: rgba(255,255,255,0.55);
            cursor: pointer; position: relative;
            transition: background 0.15s, color 0.15s;
        }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.85); }
        .nav-item.active { background: rgba(42,157,143,0.18); color: #fff; }
        .nav-item.active::before {
            content: ''; position: absolute;
            left: 0; top: 4px; bottom: 4px;
            width: 3px; background: var(--accent);
            border-radius: 0 3px 3px 0;
        }
        .sidebar-logout { margin-top: auto; padding: 16px 12px; border-top: 1px solid rgba(255,255,255,0.07); }
        .btn-logout {
            width: 100%; background: var(--logout-red); color: white;
            border: none; border-radius: 7px; padding: 9px 12px;
            font-size: 0.78rem; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            transition: background 0.15s;
        }
        .btn-logout:hover { background: #a93226; }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 199;
        }
        .sidebar-overlay.open { display: block; }

        .hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            flex-direction: column;
            gap: 5px;
            flex-shrink: 0;
        }
        .hamburger span {
            display: block;
            width: 22px; height: 2px;
            background: #fff;
            border-radius: 2px;
            transition: all 0.2s;
        }

        .main { flex: 1; display: flex; flex-direction: column; height: 100vh; overflow-y: auto; min-width: 0; }

        .header { background: var(--header-bg); padding: 28px 36px 40px; color: white; }
        .header-top { display: flex; align-items: center; gap: 14px; margin-bottom: 4px; }
        .header h1 { font-size: 1.75rem; font-weight: 700; letter-spacing: -0.02em; }
        .header p  { font-size: 0.88rem; opacity: 0.75; }

        .transactions-wrapper {
            margin: 28px 36px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            overflow: hidden;
        }

        .filter-bar {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
        }
        .filter-bar-title { font-size: 0.88rem; font-weight: 700; color: var(--text-main); margin-right: 4px; }
        .filter-search { flex: 1; min-width: 180px; }
        .filter-search input {
            width: 100%; padding: 8px 12px;
            border: 1px solid var(--border); border-radius: 7px;
            font-size: 0.8rem; font-family: inherit; color: var(--text-main);
            outline: none; transition: border-color 0.2s;
        }
        .filter-search input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(42,157,143,0.12); }
        .filter-search input::placeholder { color: #c0c5cd; }
        .filter-select {
            padding: 8px 12px; border: 1px solid var(--border); border-radius: 7px;
            font-size: 0.8rem; font-family: inherit; color: var(--text-main);
            background: #fff; outline: none; cursor: pointer; min-width: 120px;
        }
        .filter-select:focus { border-color: var(--accent); }

        .tx-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
        .tx-table thead tr { background: #f8fafb; border-bottom: 1px solid var(--border); }
        .tx-table thead th {
            padding: 11px 16px; text-align: left;
            font-size: 0.7rem; font-weight: 700;
            letter-spacing: 0.07em; text-transform: uppercase;
            color: var(--text-muted); white-space: nowrap;
        }
        .tx-table tbody tr { border-bottom: 1px solid #f0f2f5; transition: background 0.12s; }
        .tx-table tbody tr:last-child { border-bottom: none; }
        .tx-table tbody tr:hover { background: #f8fafb; }
        .tx-table tbody td { padding: 13px 16px; vertical-align: middle; color: var(--text-main); font-size: 0.83rem; }

        .empty-state {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; padding: 56px 24px;
            color: var(--text-muted); gap: 12px;
        }
        .empty-state svg { width: 44px; height: 44px; fill: #d1d5db; }
        .empty-state p { font-size: 0.85rem; }

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
        .pagination-info { font-size: 0.78rem; color: var(--text-muted); }
        .pagination-controls { display: flex; align-items: center; gap: 4px; }
        .page-btn {
            min-width: 32px; height: 32px; padding: 0 8px;
            border: 1px solid var(--border); background: white; color: var(--text-main);
            border-radius: 6px; font-size: 0.78rem; font-family: 'Inter', sans-serif;
            font-weight: 500; cursor: pointer;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .page-btn:hover:not(:disabled) { background: #f0f2f5; border-color: #d1d5db; }
        .page-btn.active { background: var(--accent); border-color: var(--accent); color: white; }
        .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

        @media (max-width: 768px) {
            .app { height: auto; min-height: 100vh; }
            .main { height: auto; overflow-y: visible; }
            .sidebar {
                position: fixed; top: 0; left: 0;
                height: 100vh; transform: translateX(-100%);
            }
            .sidebar.open { transform: translateX(0); }
            .hamburger { display: flex; }
            .header { padding: 20px 20px 32px; }
            .header h1 { font-size: 1.4rem; }
            .transactions-wrapper { margin: 20px 16px; }
            .filter-bar { flex-direction: column; align-items: stretch; }
            .filter-search { min-width: unset; }
            .filter-select { min-width: unset; width: 100%; }
            .filter-bar-title { margin-right: 0; }
        }

        @media (max-width: 480px) {
            .header { padding: 16px 16px 28px; }
            .header h1 { font-size: 1.2rem; }
            .header p { font-size: 0.8rem; }
            .transactions-wrapper { margin: 16px 12px; border-radius: 10px; }
            .filter-bar { padding: 12px 14px; gap: 8px; }
            .tx-table thead th,
            .tx-table tbody td { padding: 10px 10px; }
            .col-expenses, .col-funds { display: none; }
            .tx-table { font-size: 0.75rem; }
        }

        @media (max-width: 360px) {
            .col-treasureid { display: none; }
        }
    </style>
</head>
<body>

<div id="toast-notification"></div>
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

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

        <div class="sidebar-role">Encoder</div>

        <nav>
            <div class="nav-label">Finance</div>
            <a class="nav-item {{ Route::is('encoder.finance') ? 'active' : '' }}" href="{{ route('encoder.finance') }}">
                Add Funds &amp; Expenses
            </a>

            <div class="nav-label">Records</div>
            <a class="nav-item {{ Route::is('encoder.transactions') ? 'active' : '' }}" href="{{ route('encoder.transactions') }}">
                Transactions
            </a>
        </nav>

        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="white">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="main">
        <div class="header">
            <div class="header-top">
                <button class="hamburger" id="hamburgerBtn" onclick="openSidebar()" aria-label="Open menu">
                    <span></span><span></span><span></span>
                </button>
                <h1>All Transactions</h1>
            </div>
            <p>View all your submitted fund and expense transactions</p>
        </div>

        <div class="transactions-wrapper">
            <div class="filter-bar">
                <span class="filter-bar-title">Filters</span>
                <div class="filter-search">
                    <input type="text" id="searchInput" placeholder="Search transactions..." onkeyup="filterTable()">
                </div>
                <select class="filter-select" id="typeFilter" onchange="filterTable()">
                    <option value="">All Types</option>
                    <option value="fund">Fund</option>
                    <option value="expense">Expense</option>
                </select>
                <select class="filter-select" id="statusFilter" onchange="filterTable()">
                    <option value="">All Status</option>
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                    <option value="declined">Declined</option>
                </select>
            </div>

            <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                <table class="tx-table" id="txTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="col-treasureid">TREASURE ID</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th class="col-expenses">Expenses</th>
                            <th class="col-funds">Funds</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $tx)
                        <tr
                            data-type="{{ strtolower($tx->type) }}"
                            data-status="{{ strtolower($tx->status) }}"
                            data-search="{{ strtolower($tx->description . ' ' . ($tx->user ? $tx->user->firstName . ' ' . $tx->user->lastName : '')) }}"
                        >
                            <td>{{ \Carbon\Carbon::parse($tx->date)->format('M d, Y') }}</td>
                            <td class="col-treasureid">{{ $tx->user ? $tx->user->firstName . ' ' . $tx->user->lastName : '—' }}</td>
                            <td>{{ ucfirst($tx->type) }}</td>
                            <td>{{ $tx->description }}</td>
                            <td class="col-expenses">{{ $tx->expenses_amount > 0 ? '₱' . number_format($tx->expenses_amount, 2) : '—' }}</td>
                            <td class="col-funds">{{ $tx->funds_amount > 0 ? '₱' . number_format($tx->funds_amount, 2) : '—' }}</td>
                            <td>₱{{ number_format($tx->total_amount, 2) }}</td>
                            <td>{{ ucfirst($tx->status) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                    <p>No transactions found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-bar" id="paginationBar">
                <span class="pagination-info" id="paginationInfo"></span>
                <div class="pagination-controls" id="paginationControls"></div>
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
function showToast(msg, isError = false) {
    const toast = document.getElementById('toast-notification');
    toast.style.borderLeftColor = isError ? '#c0392b' : '#2a9d8f';
    toast.textContent = msg;
    toast.classList.add('toast-show');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => toast.classList.remove('toast-show'), 3500);
}

function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebarOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

const ROWS_PER_PAGE = 6;
let currentPage = 1;

function getVisibleRows() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const type   = document.getElementById('typeFilter').value.toLowerCase();
    const status = document.getElementById('statusFilter').value.toLowerCase();
    const rows   = Array.from(document.querySelectorAll('#txTable tbody tr[data-type]'));

    return rows.filter(row => {
        const matchSearch = !search || row.dataset.search.includes(search);
        const matchType   = !type   || row.dataset.type === type;
        const matchStatus = !status || row.dataset.status === status;
        return matchSearch && matchType && matchStatus;
    });
}

function renderPage() {
    const allRows    = Array.from(document.querySelectorAll('#txTable tbody tr[data-type]'));
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

    const infoEl = document.getElementById('paginationInfo');
    if (totalRows === 0) {
        infoEl.textContent = 'No results';
    } else {
        infoEl.textContent = `Showing ${start + 1}–${Math.min(end, totalRows)} of ${totalRows} transactions`;
    }

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

renderPage();
</script>
</body>
</html>