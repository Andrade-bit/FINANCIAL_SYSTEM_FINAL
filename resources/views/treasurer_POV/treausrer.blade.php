<!-- treasurer dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Finance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            --gold:             #f5a623;
            --blue:             #4a90d9;
            --pink:             #e05c7a;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            font-family: 'Inter', sans-serif;
            height: 100%;
            background: var(--page-bg);
            color: var(--text-main);
        }

        a { text-decoration: none; }
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
            transition: transform 0.25s ease;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .sidebar-overlay.active { display: block; }

        /* ── HAMBURGER ── */
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
            width: 22px;
            height: 2px;
            background: #fff;
            border-radius: 2px;
            transition: all 0.2s;
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
        .btn-logout svg { width: 14px; height: 14px; fill: white; }

        /* ── MAIN ── */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-y: visible;
            min-width: 0;
        }

        .header {
            background: var(--header-bg);
            padding: 28px 36px 40px;
            color: white;
        }
        .header-top {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 4px;
        }
        .header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .header p {
            font-size: 0.88rem;
            opacity: 0.75;
        }
        .content {
            padding: 28px 36px;
            flex: 1;
            padding-bottom: 50px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 22px;
        }

        /* ── KPI CARDS (clickable) ── */
        .stat-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 22px 24px 20px;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s, border-color 0.15s;
            user-select: none;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
            border-color: #c4c9d4;
        }
        .stat-card:active {
            transform: translateY(0);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }
        .stat-card.balance::before     { background: var(--gold); }
        .stat-card.collections::before { background: var(--blue); }
        .stat-card.expenses::before    { background: var(--pink); }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        .stat-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
        }
        .stat-click-hint {
            font-size: 0.62rem;
            color: var(--accent);
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.15s;
        }
        .stat-card:hover .stat-click-hint { opacity: 1; }

        .stat-value {
            font-size: 1.9rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-main);
            margin-bottom: 4px;
            text-align: right;
        }

        .bottom-row {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
            align-items: start;
        }

        .panel {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 24px;
        }

        .panel.quick-actions-panel {
            max-height: 70vh;
            overflow-y: auto;
        }
        .panel.quick-actions-panel::-webkit-scrollbar { width: 5px; }
        .panel.quick-actions-panel::-webkit-scrollbar-track { background: #f0f2f5; border-radius: 4px; }
        .panel.quick-actions-panel::-webkit-scrollbar-thumb { background: #c4c9d4; border-radius: 4px; }
        .panel-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
        }
        .panel-subtitle {
            font-size: 0.76rem;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        /* CHART LEGEND */
        .chart-legend {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        /* DONUT LAYOUT */
        .donut-layout {
            display: flex;
            align-items: center;
            gap: 28px;
            flex-wrap: wrap;
        }
        .donut-wrap {
            position: relative;
            width: 180px;
            height: 180px;
            flex-shrink: 0;
        }
        .donut-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }
        .donut-center-label {
            font-size: 0.65rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .donut-center-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.2;
        }

        /* PROGRESS BARS */
        .breakdown { flex: 1; min-width: 160px; }
        .breakdown-item { margin-bottom: 16px; }
        .breakdown-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.76rem;
            color: var(--text-muted);
            margin-bottom: 6px;
        }
        .breakdown-row span:last-child {
            font-weight: 600;
            color: var(--text-main);
        }
        .progress-bar {
            height: 6px;
            background: #f0f2f5;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.6s ease;
        }
        .net-balance {
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }
        .net-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin-bottom: 2px;
        }
        .net-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--accent);
        }

        /* ── QUICK ACTIONS ── */
        .qa-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #e05c7a;
            color: #fff;
            font-size: 0.68rem;
            font-weight: 700;
            margin-left: 6px;
            vertical-align: middle;
        }

        .qa-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .qa-item {
            border: 1px solid var(--border);
            border-radius: 9px;
            overflow: hidden;
            transition: border-color 0.15s;
        }
        .qa-item:hover { border-color: #c4c9d4; }

        .qa-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            cursor: pointer;
            background: #fff;
            transition: background 0.12s;
            user-select: none;
        }
        .qa-row:hover { background: #f8f9fb; }

        .qa-avatar {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #e8f2fc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            color: #185fa5;
            flex-shrink: 0;
            text-transform: uppercase;
        }
        .qa-avatar.expense { background: #fde8ed; color: #9b2039; }

        .qa-info { flex: 1; min-width: 0; }
        .qa-name {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .qa-desc {
            font-size: 0.71rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 1px;
        }

        .qa-amount {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
            white-space: nowrap;
            flex-shrink: 0;
        }
        .qa-amount.funds   { color: #16a34a; }
        .qa-amount.expense { color: #dc2626; }
        .qa-amount.both    { color: var(--text-main); }

        .qa-chevron {
            width: 16px;
            height: 16px;
            fill: var(--text-muted);
            flex-shrink: 0;
            transition: transform 0.2s;
        }
        .qa-item.open .qa-chevron { transform: rotate(180deg); }

        .qa-detail {
            display: none;
            padding: 12px 14px 14px;
            background: #f8f9fb;
            border-top: 1px solid var(--border);
        }
        .qa-item.open .qa-detail { display: block; }

        .qa-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px 16px;
            margin-bottom: 12px;
        }
        .qa-detail-field { }
        .qa-detail-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin-bottom: 2px;
        }
        .qa-detail-value {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .qa-type-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .qa-type-pill.funds    { background: #f0fdf4; color: #16a34a; }
        .qa-type-pill.expenses { background: #fff5f5; color: #dc2626; }
        .qa-type-pill.both     { background: #eff6ff; color: #185fa5; }

        .qa-actions {
            display: flex;
            gap: 8px;
        }
        .btn-approve, .btn-reject {
            flex: 1;
            border: none;
            border-radius: 7px;
            padding: 8px 10px;
            font-size: 0.76rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-approve:hover, .btn-reject:hover { opacity: 0.88; }
        .btn-approve:active, .btn-reject:active { transform: scale(0.97); }
        .btn-approve { background: #16a34a; color: #fff; }
        .btn-reject  { background: #f3f4f6; color: #dc2626; border: 1px solid #fca5a5; }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px 0 10px;
            gap: 12px;
        }
        .empty-icon {
            width: 56px;
            height: 56px;
            background: #f3f4f6;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .empty-icon svg { width: 28px; height: 28px; fill: #9ca3af; }
        .empty-text {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ══════════════════════════════════════════
           KPI MODAL
        ══════════════════════════════════════════ */
        .kpi-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 42, 42, 0.55);
            backdrop-filter: blur(3px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .kpi-modal-backdrop.active {
            display: flex;
        }

        .kpi-modal {
            background: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 820px;
            max-height: 88vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 24px 64px rgba(0,0,0,0.18);
            animation: modalIn 0.22s cubic-bezier(.34,1.36,.64,1) both;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(20px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .kpi-modal-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 24px 18px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }
        .kpi-modal-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .kpi-modal-icon svg { width: 22px; height: 22px; }

        .kpi-modal-icon.balance     { background: #fff8ec; }
        .kpi-modal-icon.balance svg { fill: var(--gold); }
        .kpi-modal-icon.collections     { background: #eef4fd; }
        .kpi-modal-icon.collections svg { fill: var(--blue); }
        .kpi-modal-icon.expenses     { background: #fdf0f4; }
        .kpi-modal-icon.expenses svg { fill: var(--pink); }

        .kpi-modal-titles { flex: 1; min-width: 0; }
        .kpi-modal-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
        }
        .kpi-modal-subtitle {
            font-size: 0.76rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .kpi-modal-total {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            white-space: nowrap;
        }
        .kpi-modal-total.balance     { color: var(--gold); }
        .kpi-modal-total.collections { color: var(--blue); }
        .kpi-modal-total.expenses    { color: var(--pink); }

        .kpi-modal-close {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.12s;
            flex-shrink: 0;
        }
        .kpi-modal-close:hover { background: #f3f4f6; }
        .kpi-modal-close svg { width: 18px; height: 18px; fill: var(--text-muted); }

        /* Search / filter bar */
        .kpi-modal-toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 24px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            flex-wrap: wrap;
        }
        .kpi-search-wrap {
            position: relative;
            flex: 1;
            min-width: 180px;
        }
        .kpi-search-wrap svg {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            fill: var(--text-muted);
            pointer-events: none;
        }
        .kpi-search {
            width: 100%;
            padding: 8px 10px 8px 32px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.8rem;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            outline: none;
            transition: border-color 0.15s;
        }
        .kpi-search:focus { border-color: var(--accent); }

        .kpi-count-badge {
            font-size: 0.75rem;
            color: var(--text-muted);
            white-space: nowrap;
            flex-shrink: 0;
        }
        .kpi-count-badge strong { color: var(--text-main); }

        /* Table */
        .kpi-modal-body {
            overflow-y: auto;
            flex: 1;
        }
        .kpi-modal-body::-webkit-scrollbar { width: 5px; }
        .kpi-modal-body::-webkit-scrollbar-track { background: #f0f2f5; }
        .kpi-modal-body::-webkit-scrollbar-thumb { background: #c4c9d4; border-radius: 4px; }

        .kpi-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }
        .kpi-table thead {
            position: sticky;
            top: 0;
            background: #f8f9fb;
            z-index: 1;
        }
        .kpi-table thead th {
            padding: 10px 16px;
            text-align: left;
            font-size: 0.67rem;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .kpi-table thead th:last-child { text-align: right; }

        .kpi-table tbody tr {
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.1s;
        }
        .kpi-table tbody tr:last-child { border-bottom: none; }
        .kpi-table tbody tr:hover { background: #f8f9fb; }

        .kpi-table td {
            padding: 11px 16px;
            color: var(--text-main);
            vertical-align: middle;
        }
        .kpi-table td:last-child { text-align: right; }

        .kpi-table .td-date {
            font-size: 0.75rem;
            color: var(--text-muted);
            white-space: nowrap;
        }
        .kpi-table .td-desc {
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 500;
        }
        .kpi-table .td-encoder {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        .kpi-table .td-amount {
            font-weight: 700;
            white-space: nowrap;
        }
        .kpi-table .td-amount.pos { color: #16a34a; }
        .kpi-table .td-amount.neg { color: #dc2626; }
        .kpi-table .td-amount.neu { color: var(--text-main); }

        /* type pill in table */
        .type-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }
        .type-pill.funds    { background: #f0fdf4; color: #16a34a; }
        .type-pill.expenses { background: #fff5f5; color: #dc2626; }
        .type-pill.both     { background: #eff6ff; color: #185fa5; }

        /* status pill */
        .status-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }
        .status-pill.approved { background: #f0fdf4; color: #16a34a; }
        .status-pill.pending  { background: #fffbeb; color: #d97706; }
        .status-pill.rejected { background: #fff5f5; color: #dc2626; }

        /* modal empty */
        .kpi-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            gap: 12px;
            color: var(--text-muted);
        }
        .kpi-empty svg { width: 36px; height: 36px; fill: #d1d5db; }
        .kpi-empty p { font-size: 0.82rem; font-weight: 500; }

        /* modal footer */
        .kpi-modal-footer {
            padding: 14px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            flex-shrink: 0;
        }
        .btn-close-modal {
            background: var(--sidebar-bg);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 22px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s;
        }
        .btn-close-modal:hover { background: #1a3d3d; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                left: 0; top: 0;
                transform: translateX(-100%);
                height: 100vh;
                z-index: 1000;
            }
            .sidebar.open { transform: translateX(0); }
            .hamburger { display: flex; }
            .header { padding: 20px 20px 32px; }
            .content { padding: 20px 16px 50px; }
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .bottom-row { grid-template-columns: 1fr; }
            .panel.quick-actions-panel { max-height: none; overflow-y: visible; }
            .stat-value { font-size: 1.5rem; }
            .kpi-modal { max-height: 92vh; }
        }

        @media (max-width: 600px) {
            .stats-row { grid-template-columns: 1fr; }
            .donut-layout { flex-direction: column; align-items: flex-start; }
            .donut-wrap { width: 160px; height: 160px; align-self: center; }
            .breakdown { width: 100%; }
            .stat-value { font-size: 1.4rem; }
            .kpi-modal { border-radius: 12px; }
            .kpi-modal-header { padding: 16px 18px; }
            .kpi-modal-toolbar { padding: 12px 16px; }
            .kpi-table thead th,
            .kpi-table td { padding: 10px 12px; }
            /* hide encoder col on small screens */
            .kpi-table .col-encoder { display: none; }
        }
    </style>
</head>
<body>

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

        <div class="sidebar-role">Treasurer</div>

        <nav>
            <div class="nav-label">Main</div>
            <a class="nav-item {{ Route::is('treasurer') ? 'active' : '' }}" href="{{ route('treasurer') }}">
                Dashboard
            </a>

            <div class="nav-label">Finance</div>
            <a class="nav-item" href="{{ route('treasurer.addfundexpenses') }}">
                Add Funds &amp; Expenses
            </a>

            <div class="nav-label">Records</div>
            <a class="nav-item {{ Route::is('treasurer.transactions') ? 'active' : '' }}" href="{{ route('treasurer.transactions') }}">
                Transactions
            </a>
            <a class="nav-item {{ Route::is('treasurer.reports') ? 'active' : '' }}" href="{{ route('treasurer.reports') }}">
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

        <div class="header">
            <div class="header-top">
                <button class="hamburger" id="hamburgerBtn" onclick="openSidebar()" aria-label="Open menu">
                    <span></span><span></span><span></span>
                </button>
                <h1>Treasurer Dashboard</h1>
            </div>
            <p>Manage all financial transactions</p>
        </div>

        <div class="content">

            <div class="stats-row">
                <!-- Total Balance KPI -->
                <div class="stat-card balance" data-kpi="balance" title="Click to view all transactions">
                    <div class="stat-top">
                        <div class="stat-label">Total Balance</div>
                        <div class="stat-click-hint">View all ↗</div>
                    </div>
                    <div class="stat-value">₱{{ number_format($treasurerData->total_balance ?? 0, 2) }}</div>
                </div>

                <!-- Total Collections KPI -->
                <div class="stat-card collections" data-kpi="collections" title="Click to view collections">
                    <div class="stat-top">
                        <div class="stat-label">Total Collections</div>
                        <div class="stat-click-hint">View all ↗</div>
                    </div>
                    <div class="stat-value">₱{{ number_format($treasurerData->total_collections ?? 0, 2) }}</div>
                </div>

                <!-- Total Expenses KPI -->
                <div class="stat-card expenses" data-kpi="expenses" title="Click to view expenses">
                    <div class="stat-top">
                        <div class="stat-label">Total Expenses</div>
                        <div class="stat-click-hint">View all ↗</div>
                    </div>
                    <div class="stat-value">₱{{ number_format($treasurerData->total_expenses ?? 0, 2) }}</div>
                </div>
            </div>

            <div class="bottom-row">

                <!-- FINANCE OVERVIEW PANEL -->
                <div class="panel">
                    <div class="panel-title">Finance Overview</div>
                    <div class="panel-subtitle">Collections and expenses breakdown</div>

                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-dot" style="background: #4a90d9;"></div>
                            Collections
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background: #e05c7a;"></div>
                            Expenses
                        </div>
                    </div>

                    <div class="donut-layout">
                        <div class="donut-wrap">
                            <canvas id="financeDonut"
                                role="img"
                                aria-label="Donut chart showing collections vs expenses breakdown">
                                Collections: ₱{{ number_format($treasurerData->total_collections ?? 0, 2) }},
                                Expenses: ₱{{ number_format($treasurerData->total_expenses ?? 0, 2) }}
                            </canvas>
                            <div class="donut-center">
                                <div class="donut-center-label">balance</div>
                                <div class="donut-center-value">
                                    ₱{{ number_format($treasurerData->total_balance ?? 0, 0) }}
                                </div>
                            </div>
                        </div>

                        <div class="breakdown">
                            @php
                                $collections = $treasurerData->total_collections ?? 0;
                                $expenses    = $treasurerData->total_expenses ?? 0;
                                $total       = $collections + $expenses;
                                $colPct      = $total > 0 ? round(($collections / $total) * 100, 1) : 0;
                                $expPct      = $total > 0 ? round(($expenses / $total) * 100, 1) : 0;
                            @endphp

                            <div class="breakdown-item">
                                <div class="breakdown-row">
                                    <span>Collections</span>
                                    <span>{{ $colPct }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="colBar" data-width="{{ $colPct }}" data-color="#4a90d9"></div>
                                </div>
                            </div>

                            <div class="breakdown-item">
                                <div class="breakdown-row">
                                    <span>Expenses</span>
                                    <span>{{ $expPct }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="expBar" data-width="{{ $expPct }}" data-color="#e05c7a"></div>
                                </div>
                            </div>

                            <div class="net-balance">
                                <div class="net-label">Total Balance</div>
                                <div class="net-value">
                                    ₱{{ number_format($treasurerData->total_balance ?? 0, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QUICK ACTIONS PANEL -->
                <div class="panel quick-actions-panel">
                    <div class="panel-title">
                        Quick Actions
                        @if($pendingTransactions->count() > 0)
                            <span class="qa-badge">{{ $pendingTransactions->count() }}</span>
                        @endif
                    </div>
                    <div class="panel-subtitle">Pending encoder requests needing your approval</div>

                    @if($pendingTransactions->isEmpty())
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                            </div>
                            <div class="empty-text">No pending approvals</div>
                        </div>
                    @else
                        <div class="qa-list">
                            @foreach($pendingTransactions as $txn)
                                @php
                                    $encoder   = $txn->user;
                                    $firstName = $encoder->firstName ?? 'Unknown';
                                    $lastName  = $encoder->lastName  ?? '';
                                    $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                                    $isExpense = $txn->type === 'expenses';
                                    $isBoth    = $txn->type === 'both';

                                    if ($isBoth) {
                                        $amountLabel = '₱' . number_format($txn->funds_amount, 2) . ' / ₱' . number_format($txn->expenses_amount, 2);
                                        $amountClass = 'both';
                                    } elseif ($isExpense) {
                                        $amountLabel = '-₱' . number_format($txn->expenses_amount, 2);
                                        $amountClass = 'expense';
                                    } else {
                                        $amountLabel = '+₱' . number_format($txn->funds_amount, 2);
                                        $amountClass = 'funds';
                                    }
                                @endphp

                                <div class="qa-item" id="qa-{{ $txn->treasurerTransactionsID }}">
                                    <div class="qa-row" data-id="{{ $txn->treasurerTransactionsID }}">
                                        <div class="qa-avatar {{ $isExpense ? 'expense' : '' }}">{{ $initials }}</div>
                                        <div class="qa-info">
                                            <div class="qa-name">{{ $firstName }} {{ $lastName }}</div>
                                            <div class="qa-desc">{{ $txn->description ?: 'No description' }}</div>
                                        </div>
                                        <div class="qa-amount {{ $amountClass }}">{{ $amountLabel }}</div>
                                        <svg class="qa-chevron" viewBox="0 0 24 24">
                                            <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
                                        </svg>
                                    </div>

                                    <div class="qa-detail">
                                        <div class="qa-detail-grid">
                                            <div class="qa-detail-field">
                                                <div class="qa-detail-label">Encoder</div>
                                                <div class="qa-detail-value">{{ $firstName }} {{ $lastName }}</div>
                                            </div>
                                            <div class="qa-detail-field">
                                                <div class="qa-detail-label">Date</div>
                                                <div class="qa-detail-value">{{ \Carbon\Carbon::parse($txn->date)->format('M d, Y') }}</div>
                                            </div>
                                            <div class="qa-detail-field">
                                                <div class="qa-detail-label">Type</div>
                                                <div class="qa-detail-value">
                                                    <span class="qa-type-pill {{ $txn->type }}">{{ ucfirst($txn->type) }}</span>
                                                </div>
                                            </div>
                                            <div class="qa-detail-field">
                                                <div class="qa-detail-label">Funds Amount</div>
                                                <div class="qa-detail-value" style="color: #16a34a;">₱{{ number_format($txn->funds_amount, 2) }}</div>
                                            </div>
                                            <div class="qa-detail-field">
                                                <div class="qa-detail-label">Expenses Amount</div>
                                                <div class="qa-detail-value" style="color: #dc2626;">₱{{ number_format($txn->expenses_amount, 2) }}</div>
                                            </div>
                                            <div class="qa-detail-field">
                                                <div class="qa-detail-label">Net Amount</div>
                                                <div class="qa-detail-value">₱{{ number_format($txn->total_amount, 2) }}</div>
                                            </div>
                                            @if($txn->notes)
                                            <div class="qa-detail-field" style="grid-column: 1 / -1;">
                                                <div class="qa-detail-label">Notes</div>
                                                <div class="qa-detail-value" style="font-weight: 400; color: var(--text-muted);">{{ $txn->notes }}</div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="qa-actions">
                                            <form method="POST" action="{{ route('treasurer.approve', $txn->treasurerTransactionsID) }}" style="flex:1;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-approve" style="width:100%;">
                                                    ✓ Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('treasurer.reject', $txn->treasurerTransactionsID) }}" style="flex:1;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-reject" style="width:100%;">
                                                    ✕ Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

<!-- ══════════════════════════════════════════
     KPI MODAL
══════════════════════════════════════════ -->
<div class="kpi-modal-backdrop" id="kpiModalBackdrop">
    <div class="kpi-modal" id="kpiModal">
        <div class="kpi-modal-header">
            <div class="kpi-modal-icon" id="kpiModalIcon">
                <!-- icon injected by JS -->
            </div>
            <div class="kpi-modal-titles">
                <div class="kpi-modal-title" id="kpiModalTitle">Transactions</div>
                <div class="kpi-modal-subtitle" id="kpiModalSubtitle">All approved transactions</div>
            </div>
            <div class="kpi-modal-total" id="kpiModalTotal"></div>
            <button class="kpi-modal-close" id="kpiModalClose" aria-label="Close">
                <svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>
        </div>

        <div class="kpi-modal-toolbar">
            <div class="kpi-search-wrap">
                <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                <input type="text" class="kpi-search" id="kpiSearch" placeholder="Search description, encoder…">
            </div>
            <div class="kpi-count-badge" id="kpiCountBadge"><strong>0</strong> records</div>
        </div>

        <div class="kpi-modal-body">
            <table class="kpi-table" id="kpiTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th class="col-encoder">Encoder</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="kpiTableBody">
                </tbody>
            </table>
            <div class="kpi-empty" id="kpiEmpty" style="display:none;">
                <svg viewBox="0 0 24 24"><path d="M20 6h-2.18c.07-.44.18-.88.18-1.33C18 2.1 15.9 0 13.33 0c-1.46 0-2.74.68-3.58 1.76L9 3 8.25 1.76C7.41.68 6.13 0 4.67 0 2.1 0 0 2.1 0 4.67c0 .45.11.89.18 1.33H0v2h20V6z"/></svg>
                <p>No transactions found</p>
            </div>
        </div>

        <div class="kpi-modal-footer">
            <button class="btn-close-modal" id="kpiModalCloseBtn">Close</button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════
     All approved transactions JSON for modal
     Pass $allApprovedTransactions from controller
══════════════════════════════════════════ -->
<script id="txn-data" type="application/json">
{!! json_encode($allApprovedTransactions->map(function($txn) {
    return [
        'id'               => $txn->treasurerTransactionsID,
        'date'             => \Carbon\Carbon::parse($txn->date)->format('M d, Y'),
        'date_raw'         => \Carbon\Carbon::parse($txn->date)->format('Y-m-d'),
        'description'      => $txn->description ?: 'No description',
        'encoder'          => trim(($txn->user->firstName ?? 'Unknown') . ' ' . ($txn->user->lastName ?? '')),
        'type'             => $txn->type ?? 'funds',
        'status'           => $txn->status ?? 'approved',
        'funds_amount'     => (float)($txn->funds_amount ?? 0),
        'expenses_amount'  => (float)($txn->expenses_amount ?? 0),
        'total_amount'     => (float)($txn->total_amount ?? 0),
    ];
})) !!}
</script>

<div id="chart-data"
     data-collections="{{ $treasurerData->total_collections ?? 0 }}"
     data-expenses="{{ $treasurerData->total_expenses ?? 0 }}"
     style="display:none;">
</div>

<script>
(function () {

    /* ── Sidebar open/close (hamburger style) ── */
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
    window.openSidebar  = openSidebar;
    window.closeSidebar = closeSidebar;

    /* ── QA expand/collapse ── */
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.qa-row').forEach(function (row) {
            row.addEventListener('click', function () {
                var id = this.dataset.id;
                var el = document.getElementById('qa-' + id);
                if (!el) return;
                var wasOpen = el.classList.contains('open');
                el.classList.toggle('open');
                if (!wasOpen) {
                    setTimeout(function () {
                        var list   = el.closest('.qa-list');
                        var detail = el.querySelector('.qa-detail');
                        if (list && detail) {
                            var detailBottom = el.offsetTop + el.offsetHeight;
                            list.scrollTo({ top: detailBottom - list.clientHeight + 20, behavior: 'smooth' });
                        }
                    }, 80);
                }
            });
        });
    });

    /* ── Chart & progress bars ── */
    (function () {
        const dataEl        = document.getElementById('chart-data');
        const jsCollections = parseFloat(dataEl.dataset.collections) || 0;
        const jsExpenses    = parseFloat(dataEl.dataset.expenses)    || 0;

        document.querySelectorAll('.progress-fill').forEach(function (el) {
            el.style.width      = (el.dataset.width || 0) + '%';
            el.style.background = el.dataset.color || '#ccc';
        });

        const donutCtx = document.getElementById('financeDonut');
        if (donutCtx) {
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Collections', 'Expenses'],
                    datasets: [{
                        data: [jsCollections, jsExpenses],
                        backgroundColor: ['#4a90d9', '#e05c7a'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '68%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    return ' ₱' + ctx.parsed.toLocaleString('en-PH', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    }
                }
            });
        }
    })();

    /* ══════════════════════════════════════════
       KPI MODAL LOGIC
    ══════════════════════════════════════════ */

    /* Parse transaction data embedded in page */
    var ALL_TRANSACTIONS = [];
    try {
        var raw = document.getElementById('txn-data');
        if (raw) ALL_TRANSACTIONS = JSON.parse(raw.textContent || raw.innerHTML);
    } catch (e) {
        console.warn('Could not parse transaction data', e);
    }

    /* KPI configs */
    var KPI_CONFIG = {
        balance: {
            title:    'Total Balance — All Transactions',
            subtitle: 'All approved transactions (funds & expenses)',
            iconClass: 'balance',
            totalClass: 'balance',
            icon: '<svg viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>',
            filter: function () { return ALL_TRANSACTIONS; }
        },
        collections: {
            title:    'Total Collections',
            subtitle: 'Approved funds and combined transactions',
            iconClass: 'collections',
            totalClass: 'collections',
            icon: '<svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/></svg>',
            filter: function () {
                return ALL_TRANSACTIONS.filter(function (t) {
                    return t.type === 'funds' || t.type === 'both';
                });
            }
        },
        expenses: {
            title:    'Total Expenses',
            subtitle: 'Approved expense and combined transactions',
            iconClass: 'expenses',
            totalClass: 'expenses',
            icon: '<svg viewBox="0 0 24 24"><path d="M20 3H4v10c0 2.21 1.79 4 4 4h6c2.21 0 4-1.79 4-4v-3h2c1.11 0 2-.89 2-2V5c0-1.11-.89-2-2-2zm0 5h-2V5h2v3zM4 19h16v2H4z"/></svg>',
            filter: function () {
                return ALL_TRANSACTIONS.filter(function (t) {
                    return t.type === 'expenses' || t.type === 'both';
                });
            }
        }
    };

    /* DOM refs */
    var backdrop    = document.getElementById('kpiModalBackdrop');
    var modal       = document.getElementById('kpiModal');
    var iconEl      = document.getElementById('kpiModalIcon');
    var titleEl     = document.getElementById('kpiModalTitle');
    var subtitleEl  = document.getElementById('kpiModalSubtitle');
    var totalEl     = document.getElementById('kpiModalTotal');
    var closeBtn    = document.getElementById('kpiModalClose');
    var closeBtnFtr = document.getElementById('kpiModalCloseBtn');
    var searchEl    = document.getElementById('kpiSearch');
    var tbody       = document.getElementById('kpiTableBody');
    var emptyEl     = document.getElementById('kpiEmpty');
    var countEl     = document.getElementById('kpiCountBadge');

    var currentRows = [];
    var currentKpi  = null;

    /* Format PHP peso */
    function peso(n) {
        return '₱' + parseFloat(n).toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    /* Build a single table row */
    function buildRow(txn, kpi) {
        var amountHTML, amountClass;

        if (kpi === 'collections') {
            amountClass = 'pos';
            amountHTML  = '+' + peso(txn.funds_amount);
        } else if (kpi === 'expenses') {
            amountClass = 'neg';
            amountHTML  = '-' + peso(txn.expenses_amount);
        } else {
            /* balance: show net */
            var net = parseFloat(txn.total_amount);
            if (net > 0)       { amountClass = 'pos'; amountHTML = '+' + peso(net); }
            else if (net < 0)  { amountClass = 'neg'; amountHTML = peso(net); }
            else               { amountClass = 'neu'; amountHTML = peso(net); }
        }

        var typePill   = '<span class="type-pill ' + txn.type + '">' + txn.type.charAt(0).toUpperCase() + txn.type.slice(1) + '</span>';
        var statusPill = '<span class="status-pill ' + (txn.status || 'approved') + '">' + (txn.status ? txn.status.charAt(0).toUpperCase() + txn.status.slice(1) : 'Approved') + '</span>';

        var tr = document.createElement('tr');
        tr.dataset.search = (txn.description + ' ' + txn.encoder + ' ' + txn.date).toLowerCase();
        tr.innerHTML =
            '<td class="td-date">' + txn.date + '</td>' +
            '<td class="td-desc" title="' + (txn.description || '') + '">' + (txn.description || '—') + '</td>' +
            '<td class="td-encoder col-encoder">' + txn.encoder + '</td>' +
            '<td>' + typePill + '</td>' +
            '<td>' + statusPill + '</td>' +
            '<td class="td-amount ' + amountClass + '">' + amountHTML + '</td>';
        return tr;
    }

    /* Compute totals for header display */
    function computeTotal(rows, kpi) {
        var sum = 0;
        rows.forEach(function (t) {
            if (kpi === 'collections') sum += parseFloat(t.funds_amount) || 0;
            else if (kpi === 'expenses') sum += parseFloat(t.expenses_amount) || 0;
            else sum += parseFloat(t.total_amount) || 0;
        });
        return sum;
    }

    /* Render table from rows, applying search filter */
    function renderTable(rows, kpi, searchVal) {
        var q = (searchVal || '').toLowerCase().trim();
        var filtered = q ? rows.filter(function (r) {
            return (r.description + ' ' + r.encoder + ' ' + r.date).toLowerCase().indexOf(q) !== -1;
        }) : rows;

        tbody.innerHTML = '';

        if (filtered.length === 0) {
            emptyEl.style.display = 'flex';
            document.getElementById('kpiTable').style.display = 'none';
        } else {
            emptyEl.style.display = 'none';
            document.getElementById('kpiTable').style.display = '';
            filtered.forEach(function (txn) {
                tbody.appendChild(buildRow(txn, kpi));
            });
        }

        countEl.innerHTML = '<strong>' + filtered.length + '</strong> record' + (filtered.length !== 1 ? 's' : '');
    }

    /* Open modal */
    function openModal(kpi) {
        var cfg  = KPI_CONFIG[kpi];
        if (!cfg) return;

        currentKpi  = kpi;
        currentRows = cfg.filter();

        /* Header */
        iconEl.className       = 'kpi-modal-icon ' + cfg.iconClass;
        iconEl.innerHTML       = cfg.icon;
        titleEl.textContent    = cfg.title;
        subtitleEl.textContent = cfg.subtitle;

        var total = computeTotal(currentRows, kpi);
        totalEl.className   = 'kpi-modal-total ' + cfg.totalClass;
        totalEl.textContent = peso(total);

        /* Clear search */
        searchEl.value = '';

        /* Render */
        renderTable(currentRows, kpi, '');

        /* Show */
        backdrop.classList.add('active');
        document.body.style.overflow = 'hidden';
        searchEl.focus();
    }

    /* Close modal */
    function closeModal() {
        backdrop.classList.remove('active');
        document.body.style.overflow = '';
        currentKpi  = null;
        currentRows = [];
    }

    /* KPI card click handlers */
    document.querySelectorAll('.stat-card[data-kpi]').forEach(function (card) {
        card.addEventListener('click', function () {
            openModal(this.dataset.kpi);
        });
    });

    /* Close buttons */
    if (closeBtn)    closeBtn.addEventListener('click', closeModal);
    if (closeBtnFtr) closeBtnFtr.addEventListener('click', closeModal);

    /* Close on backdrop click */
    backdrop.addEventListener('click', function (e) {
        if (e.target === backdrop) closeModal();
    });

    /* Close on Escape */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && backdrop.classList.contains('active')) closeModal();
    });

    /* Live search */
    searchEl.addEventListener('input', function () {
        if (currentKpi) renderTable(currentRows, currentKpi, this.value);
    });

})();
</script>
</body>
</html>