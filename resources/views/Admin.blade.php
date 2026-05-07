<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Church Finance – Admin</title>
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
            --gold:          #f5a623;
            --blue:          #4a90d9;
            --green:         #27ae60;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { font-family: 'Inter', sans-serif; height: 100%; background: var(--page-bg); color: var(--text-main); }
        .app { display: flex; min-height: 100vh; position: relative; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width); background: var(--sidebar-bg);
            display: flex; flex-direction: column; flex-shrink: 0;
            height: 100vh; overflow-y: auto; position: sticky; top: 0;
            transition: transform 0.25s ease; z-index: 200;
        }
        .sidebar nav { flex: 1; }

        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.45); z-index: 199;
        }
        .sidebar-overlay.open { display: block; }

        /* HAMBURGER */
        .hamburger {
            display: none; background: none; border: none;
            cursor: pointer; padding: 4px;
            flex-direction: column; gap: 5px; flex-shrink: 0;
        }
        .hamburger span {
            display: block; width: 22px; height: 2px;
            background: #fff; border-radius: 2px; transition: all 0.2s;
        }

        .sidebar-brand {
            display: flex; align-items: center; gap: 10px;
            padding: 18px 16px; border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .brand-icon { width: 38px; height: 38px; background: var(--accent); border-radius: 8px; flex-shrink: 0; }
        .brand-name { font-size: 0.85rem; font-weight: 700; color: #fff; }
        .brand-sub  { font-size: 0.68rem; color: rgba(255,255,255,0.45); }
        .sidebar-role {
            margin: 14px 12px 10px; background: rgba(255,255,255,0.07);
            border-radius: 6px; padding: 7px 12px;
            font-size: 0.72rem; font-weight: 600;
            color: rgba(255,255,255,0.65); letter-spacing: 0.05em;
        }
        .nav-label {
            font-size: 0.62rem; font-weight: 700; letter-spacing: 0.12em;
            text-transform: uppercase; color: rgba(255,255,255,0.3);
            padding: 14px 16px 6px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 16px; font-size: 0.8rem; font-weight: 500;
            color: rgba(255,255,255,0.55); cursor: pointer;
            position: relative; transition: background 0.15s, color 0.15s;
            border: none; background: none; width: 100%; text-align: left;
        }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.85); }
        .nav-item.active { background: rgba(42,157,143,0.18); color: #fff; }
        .nav-item.active::before {
            content: ''; position: absolute; left: 0; top: 4px; bottom: 4px;
            width: 3px; background: var(--accent); border-radius: 0 3px 3px 0;
        }
        .sidebar-logout {
            margin-top: auto; padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .btn-logout {
            width: 100%; background: var(--logout-red); color: white;
            border: none; border-radius: 7px; padding: 9px 12px;
            font-size: 0.78rem; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            transition: background 0.15s;
        }
        .btn-logout:hover { background: #a93226; }

        /* MAIN */
        .main { flex: 1; display: flex; flex-direction: column; min-height: 100vh; overflow-y: visible; min-width: 0; }
        .header { background: var(--header-bg); padding: 28px 36px 40px; color: white; }
        .header-top { display: flex; align-items: center; gap: 14px; margin-bottom: 4px; }
        .header h1 { font-size: 1.75rem; font-weight: 700; letter-spacing: -0.02em; }
        .header p  { font-size: 0.88rem; opacity: 0.75; }
        .content { padding: 28px 36px; flex: 1; }

        /* PAGES */
        .page { display: none; }
        .page.active { display: block; }

        /* TABLE CONTAINER FOR RESPONSIVENESS */
        .table-responsive { width: 100%; overflow-x: auto; }

        /* ALERT */
        .alert {
            padding: 10px 16px; border-radius: 8px; font-size: 0.82rem;
            margin-bottom: 18px; display: none; font-weight: 500;
        }
        .alert.show { display: block; }
        .alert-success { background: #eaf3de; color: #3b6d11; }
        .alert-error   { background: #fcebeb; color: #a32d2d; }

        /* STATS */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 22px; }
        .stat-card {
            background: var(--card-bg); border-radius: 12px;
            padding: 22px 24px 20px; border: 1px solid var(--border);
            position: relative; overflow: hidden;
        }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
        .stat-card.c-total::before     { background: var(--gold); }
        .stat-card.c-treasurer::before { background: var(--accent); }
        .stat-card.c-encoder::before   { background: var(--blue); }
        .stat-label {
            font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em;
            text-transform: uppercase; color: var(--text-muted); margin-bottom: 12px;
        }
        .stat-value {
            font-size: 1.9rem; font-weight: 700;
            letter-spacing: -0.02em; color: var(--text-main); margin-bottom: 4px;
            text-align: right;
        }
        .stat-desc { font-size: 0.76rem; color: var(--text-muted); }

        /* TABLE CARD */
        .card { background: var(--card-bg); border-radius: 12px; border: 1px solid var(--border); overflow: hidden; }
        .card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 22px 14px; border-bottom: 1px solid var(--border);
        }
        .card-header h2 { font-size: 0.95rem; font-weight: 700; color: var(--text-main); }
        table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
        thead { background: #f8f9fb; }
        th {
            padding: 11px 16px; text-align: left; font-weight: 600;
            color: var(--text-muted); font-size: 0.72rem; letter-spacing: 0.06em;
            text-transform: uppercase; border-bottom: 1px solid var(--border); white-space: nowrap;
        }
        td { padding: 12px 16px; border-bottom: 1px solid var(--border); color: var(--text-main); white-space: nowrap; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }

        /* BADGE */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; }
        .badge-treasurer { background: #e1f5ee; color: #0f6e56; }
        .badge-encoder   { background: #e6f1fb; color: #185fa5; }
        .badge-active    { background: #eaf3de; color: #3b6d11; }
        .badge-inactive  { background: #f1efe8; color: #5f5e5a; }

        /* AVATAR */
        .avatar { width: 30px; height: 30px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0; }
        .av-t { background: #e1f5ee; color: #0f6e56; }
        .av-e { background: #e6f1fb; color: #185fa5; }
        .name-cell { display: flex; align-items: center; gap: 10px; }

        /* ACTION BTNS */
        .action-btns { display: flex; gap: 6px; }
        .btn-edit   { padding: 4px 12px; font-size: 0.72rem; border-radius: 6px; cursor: pointer; background: #e6f1fb; color: #185fa5; border: none; font-weight: 500; }
        .btn-edit:hover   { background: #b5d4f4; }
        .btn-delete { padding: 4px 12px; font-size: 0.72rem; border-radius: 6px; cursor: pointer; background: #fcebeb; color: #a32d2d; border: none; font-weight: 500; }
        .btn-delete:hover { background: #f7c1c1; }

        /* PRIMARY BUTTON */
        .btn-primary {
            background: var(--accent); color: #fff; border: none;
            padding: 9px 18px; border-radius: 7px; font-size: 0.8rem;
            font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
            transition: background 0.15s;
        }
        .btn-primary:hover { background: #22867a; }

        /* MODAL */
        .modal-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.45); z-index: 100;
            align-items: center; justify-content: center;
        }
        .modal-backdrop.open { display: flex; }
        .modal {
            background: #fff; border-radius: 14px;
            padding: 28px; width: 460px; max-width: 90vw;
        }
        .modal h3 { font-size: 1rem; font-weight: 700; margin-bottom: 20px; color: var(--text-main); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display: block; font-size: 0.72rem; font-weight: 700;
            color: var(--text-muted); margin-bottom: 5px;
            text-transform: uppercase; letter-spacing: 0.06em;
        }
        .form-group input, .form-group select {
            width: 100%; padding: 9px 12px;
            border: 1px solid var(--border); border-radius: 7px;
            font-size: 0.82rem; background: #f8f9fb;
            color: var(--text-main); outline: none; font-family: 'Inter', sans-serif;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(42,157,143,0.12);
        }
        .modal-footer { display: flex; gap: 8px; justify-content: flex-end; margin-top: 22px; }
        .btn-cancel {
            padding: 9px 18px; background: #f0f2f5; border: none;
            border-radius: 7px; font-size: 0.8rem; cursor: pointer;
            color: var(--text-main); font-weight: 500; font-family: 'Inter', sans-serif;
        }
        .btn-cancel:hover { background: #e5e7eb; }
        .confirm-modal { text-align: center; }
        .confirm-modal .warning-icon { font-size: 38px; margin-bottom: 14px; }
        .confirm-modal p { font-size: 0.85rem; color: var(--text-muted); margin-top: 8px; }
        .confirm-modal strong { font-size: 0.95rem; color: var(--text-main); }

        /* TOAST */
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

        /* PAGINATION */
        .pagination-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 20px; border-top: 1px solid var(--border);
            background: white; flex-wrap: wrap; gap: 10px;
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

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed; left: 0; top: 0;
                transform: translateX(-100%); height: 100vh;
            }
            .sidebar.open { transform: translateX(0); }
            .hamburger { display: flex; }
            .header { padding: 20px 20px 32px; }
            .header h1 { font-size: 1.4rem; }
            .content { padding: 20px 16px; }
        }

        @media (max-width: 850px) {
            .stats-row { grid-template-columns: 1fr; }
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
        <div class="sidebar-role">Admin</div>
        <nav>
            <div class="nav-label">Main</div>
            <button class="nav-item active" onclick="showPage('dashboard', this)">Dashboard</button>
            <div class="nav-label">Accounts</div>
            <button class="nav-item" onclick="showPage('accounts', this)">Manage Accounts</button>
        </nav>
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:white;flex-shrink:0;"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
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
                <h1 id="page-title">Admin Dashboard</h1>
            </div>
            <p id="page-sub">Manage accounts and system users</p>
        </div>

        <div class="content">
            <div id="alert-box" class="alert alert-success"></div>

            <div class="page active" id="page-dashboard">
                <div class="stats-row">
                    <div class="stat-card c-total">
                        <div class="stat-label">Total Accounts</div>
                        <div class="stat-value" id="stat-total">0</div>
                        <div class="stat-desc">All system users</div>
                    </div>
                    <div class="stat-card c-treasurer">
                        <div class="stat-label">Treasurers</div>
                        <div class="stat-value" id="stat-tr">0</div>
                        <div class="stat-desc">Active treasurers</div>
                    </div>
                    <div class="stat-card c-encoder">
                        <div class="stat-label">Encoders</div>
                        <div class="stat-value" id="stat-en">0</div>
                        <div class="stat-desc">Active encoders</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><h2>All Accounts Overview</h2></div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr><th>Name</th><th>Username</th><th>Role</th><th>Status</th></tr>
                            </thead>
                            <tbody id="dashboard-table"></tbody>
                        </table>
                    </div>
                    <div class="pagination-bar" id="dashboard-pagination-bar">
                        <span class="pagination-info" id="dashboard-pagination-info"></span>
                        <div class="pagination-controls" id="dashboard-pagination-controls"></div>
                    </div>
                </div>
            </div>

            <div class="page" id="page-accounts">
                <div class="card">
                    <div class="card-header">
                        <h2>All Accounts</h2>
                        <button class="btn-primary" onclick="openCreate()">+ Add Account</button>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr><th>Name</th><th>Username</th><th>Role</th><th>Status</th><th>Actions</th></tr>
                            </thead>
                            <tbody id="accounts-table"></tbody>
                        </table>
                    </div>
                    <div class="pagination-bar" id="accounts-pagination-bar">
                        <span class="pagination-info" id="accounts-pagination-info"></span>
                        <div class="pagination-controls" id="accounts-pagination-controls"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="form-modal">
    <div class="modal">
        <h3 id="modal-title">Add New Account</h3>
        <div class="form-row">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" id="f-firstName" placeholder="First name" />
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" id="f-lastName" placeholder="Last name" />
            </div>
        </div>
        <div class="form-group">
            <label>Middle Name <span style="font-weight:400;text-transform:none;">(optional)</span></label>
            <input type="text" id="f-middleName" placeholder="Middle name" />
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" id="f-username" placeholder="Enter username" />
        </div>
        <div class="form-group">
            <label>Password <span id="pw-hint" style="font-weight:400;text-transform:none;display:none;">(leave blank to keep current)</span></label>
            <input type="password" id="f-password" placeholder="Enter password" />
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Role</label>
                <select id="f-role">
                    <option value="treasurer">Treasurer</option>
                    <option value="encoder">Encoder</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="f-status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('form-modal')">Cancel</button>
            <button class="btn-primary" onclick="saveAccount()">Save Account</button>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="delete-modal">
    <div class="modal confirm-modal">
        <div class="warning-icon">!!!</div>
        <strong id="delete-name">Delete Account</strong>
        <p>This will permanently remove this account.</p>
        <p>Are you sure you want to continue?</p>
        <div class="modal-footer" style="justify-content:center; margin-top:18px;">
            <button class="btn-cancel" onclick="closeModal('delete-modal')">Cancel</button>
            <button class="btn-primary" style="background:#c0392b;" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
let accounts = JSON.parse('<?php /** @var \Illuminate\Support\Collection $users */ echo addslashes(json_encode($users)); ?>');
let editId = null, deleteId = null;
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// ── PAGINATION STATE ──────────────────────────────────────────────
const ROWS_PER_PAGE = 6;
let dashboardPage = 1;
let accountsPage  = 1;

// ── SIDEBAR ──────────────────────────────────────────────────────
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

function fullName(a) { return [a.firstName, a.middleName, a.lastName].filter(Boolean).join(' '); }
function getInitials(a) { return (a.firstName[0] + a.lastName[0]).toUpperCase(); }

// ── PAGINATION RENDERER ───────────────────────────────────────────
function renderPagination(tableId, barId, infoId, controlsId, rows, currentPage, onPageChange) {
    const totalRows  = rows.length;
    const totalPages = Math.max(1, Math.ceil(totalRows / ROWS_PER_PAGE));
    const start      = (currentPage - 1) * ROWS_PER_PAGE;
    const end        = start + ROWS_PER_PAGE;
    const pageRows   = rows.slice(start, end);

    const infoEl = document.getElementById(infoId);
    infoEl.textContent = totalRows === 0
        ? 'No accounts found'
        : `Showing ${start + 1}–${Math.min(end, totalRows)} of ${totalRows} accounts`;

    const controlsEl = document.getElementById(controlsId);
    controlsEl.innerHTML = '';

    const prevBtn = document.createElement('button');
    prevBtn.className = 'page-btn';
    prevBtn.textContent = '‹';
    prevBtn.disabled = currentPage === 1;
    prevBtn.addEventListener('click', () => onPageChange(currentPage - 1));
    controlsEl.appendChild(prevBtn);

    const range = 2;
    for (let p = 1; p <= totalPages; p++) {
        if (p === 1 || p === totalPages || (p >= currentPage - range && p <= currentPage + range)) {
            const btn = document.createElement('button');
            btn.className = 'page-btn' + (p === currentPage ? ' active' : '');
            btn.textContent = p;
            btn.addEventListener('click', (pg => () => onPageChange(pg))(p));
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
    nextBtn.addEventListener('click', () => onPageChange(currentPage + 1));
    controlsEl.appendChild(nextBtn);

    document.getElementById(barId).style.display = totalRows === 0 ? 'none' : 'flex';

    return pageRows;
}

function renderDashboard() {
    const pageRows = renderPagination(
        'dashboard-table',
        'dashboard-pagination-bar',
        'dashboard-pagination-info',
        'dashboard-pagination-controls',
        accounts,
        dashboardPage,
        (pg) => { dashboardPage = pg; renderDashboard(); }
    );

    document.getElementById('dashboard-table').innerHTML = pageRows.map(a => `
        <tr>
            <td><div class="name-cell"><div class="avatar ${a.role==='Treasurer'?'av-t':'av-e'}">${getInitials(a)}</div>${fullName(a)}</div></td>
            <td style="color:var(--text-muted)">${a.username}</td>
            <td><span class="badge ${a.role==='Treasurer'?'badge-treasurer':'badge-encoder'}">${a.role}</span></td>
            <td><span class="badge ${a.status==='Active'?'badge-active':'badge-inactive'}">${a.status}</span></td>
        </tr>`).join('');

    document.getElementById('stat-total').textContent = accounts.length;
    document.getElementById('stat-tr').textContent = accounts.filter(a => a.role === 'Treasurer').length;
    document.getElementById('stat-en').textContent = accounts.filter(a => a.role === 'Encoder').length;
}

function renderAccounts() {
    const pageRows = renderPagination(
        'accounts-table',
        'accounts-pagination-bar',
        'accounts-pagination-info',
        'accounts-pagination-controls',
        accounts,
        accountsPage,
        (pg) => { accountsPage = pg; renderAccounts(); }
    );

    document.getElementById('accounts-table').innerHTML = pageRows.map(a => `
        <tr>
            <td><div class="name-cell"><div class="avatar ${a.role==='Treasurer'?'av-t':'av-e'}">${getInitials(a)}</div>${fullName(a)}</div></td>
            <td style="color:var(--text-muted)">${a.username}</td>
            <td><span class="badge ${a.role==='Treasurer'?'badge-treasurer':'badge-encoder'}">${a.role}</span></td>
            <td><span class="badge ${a.status==='Active'?'badge-active':'badge-inactive'}">${a.status}</span></td>
            <td>
                <div class="action-btns">
                    <button class="btn-edit" onclick="openEdit(${a.id})">Edit</button>
                    <button class="btn-delete" onclick="openDelete(${a.id})">Delete</button>
                </div>
            </td>
        </tr>`).join('');
}

function showPage(page, el) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    document.getElementById('page-' + page).classList.add('active');
    el.classList.add('active');

    // Close sidebar on mobile after clicking
    closeSidebar();

    const titles = {
        dashboard: ['Admin Dashboard', 'Manage accounts and system users'],
        accounts:  ['Manage Accounts', 'Create, update, and delete treasurer and encoder accounts']
    };
    document.getElementById('page-title').textContent = titles[page][0];
    document.getElementById('page-sub').textContent   = titles[page][1];
    if (page === 'dashboard') renderDashboard();
    if (page === 'accounts')  renderAccounts();
}

function openCreate() {
    editId = null;
    document.getElementById('modal-title').textContent = 'Add New Account';
    document.getElementById('pw-hint').style.display = 'none';
    ['f-firstName','f-middleName','f-lastName','f-username','f-password'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('f-role').value   = 'treasurer';
    document.getElementById('f-status').value = 'Active';
    document.getElementById('form-modal').classList.add('open');
}

function openEdit(id) {
    editId = id;
    const a = accounts.find(x => x.id === id);
    document.getElementById('modal-title').textContent    = 'Edit Account';
    document.getElementById('pw-hint').style.display      = 'inline';
    document.getElementById('f-firstName').value          = a.firstName;
    document.getElementById('f-middleName').value         = a.middleName;
    document.getElementById('f-lastName').value           = a.lastName;
    document.getElementById('f-username').value           = a.username;
    document.getElementById('f-password').value           = '';
    document.getElementById('f-role').value               = a.role.toLowerCase();
    document.getElementById('f-status').value             = a.status;
    document.getElementById('form-modal').classList.add('open');
}

async function saveAccount() {
    const firstName  = document.getElementById('f-firstName').value.trim();
    const middleName = document.getElementById('f-middleName').value.trim();
    const lastName   = document.getElementById('f-lastName').value.trim();
    const username   = document.getElementById('f-username').value.trim();
    const password   = document.getElementById('f-password').value;
    const role       = document.getElementById('f-role').value;
    const status     = document.getElementById('f-status').value;

    if (!firstName || !lastName || !username) { showAlert('Please fill in all required fields.', true); return; }
    if (!editId && !password) { showAlert('Password is required for new accounts.', true); return; }

    const body = { firstName, middleName, lastName, username, role, status };
    if (password) body.password = password;

    const url    = editId ? `/admin/accounts/${editId}` : '/admin/accounts';
    const method = editId ? 'PUT' : 'POST';

    try {
        const res  = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify(body)
        });
        const data = await res.json();

        if (!res.ok) {
            const errors = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Error saving account.');
            showAlert(errors, true); return;
        }

        if (editId) {
            const a = accounts.find(x => x.id === editId);
            Object.assign(a, { firstName, middleName, lastName, username, role: role.charAt(0).toUpperCase() + role.slice(1), status });
            showAlert('Account updated successfully.');
        } else {
            accounts.push({ id: data.id, firstName, middleName, lastName, username, role: role.charAt(0).toUpperCase() + role.slice(1), status });
            showAlert(`Successfully made account of ${role.charAt(0).toUpperCase() + role.slice(1)}.`);
        }
        closeModal('form-modal');
        renderAccounts();
        renderDashboard();
    } catch(e) { showAlert('Network error. Please try again.', true); }
}

function openDelete(id) {
    deleteId = id;
    const a = accounts.find(x => x.id === id);
    document.getElementById('delete-name').textContent = `Delete "${fullName(a)}"?`;
    document.getElementById('delete-modal').classList.add('open');
}

async function confirmDelete() {
    try {
        const res = await fetch(`/admin/accounts/${deleteId}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' } });
        const data = await res.json();
        if (!res.ok) { showAlert(data.message || 'Error deleting.', true); return; }
        accounts = accounts.filter(x => x.id !== deleteId);
        closeModal('delete-modal');
        showAlert('Account deleted successfully.');
        renderAccounts();
        renderDashboard();
    } catch(e) { showAlert('Network error. Please try again.', true); }
}

function closeModal(id) { document.getElementById(id).classList.remove('open'); }

function showAlert(msg, isError = false) {
    const toast = document.getElementById('toast-notification');
    toast.style.borderLeftColor = isError ? '#c0392b' : '#2a9d8f';
    toast.textContent = msg;
    toast.classList.add('toast-show');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => { toast.classList.remove('toast-show'); }, 3500);
}

renderDashboard();
</script>

</body>
</html>