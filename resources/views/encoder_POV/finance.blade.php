<!--encoder_POV.finance -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Funds & Expenses – Church Finance</title>
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
            --funds-green:   #16a34a;
            --funds-bg:      #f0fdf4;
            --funds-border:  #86efac;
            --exp-red:       #dc2626;
            --exp-bg:        #fff5f5;
            --exp-border:    #fca5a5;
            --input-border:  #d1d5db;
            --input-focus:   #2a9d8f;
            --error-red:     #dc2626;
            --error-bg:      #fef2f2;
            --error-border:  #fca5a5;
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

        a { text-decoration: none; color: inherit; }

        .app { display: flex; height: 100vh; }

        @media (max-width: 768px) {
            .app { height: auto; min-height: 100vh; }
        }

        /* SIDEBAR */
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
        }

        /* MAIN */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            min-width: 0;
        }

        @media (max-width: 768px) {
            .main { height: auto; overflow-y: visible; }
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
            margin-bottom: 6px;
        }
        .header-eyebrow {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            opacity: 0.65;
            margin-bottom: 6px;
        }
        .header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }
        .header p { font-size: 0.88rem; opacity: 0.75; }

        .content { padding: 32px 36px; flex: 1; }

        /* FORM CARD */
        .form-card {
            background: var(--card-bg);
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 32px 32px 28px;
            max-width: 860px;
            margin-left: 180px;
        }

        .form-card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .split-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 8px;
        }

        .split-panel {
            border-radius: 10px;
            padding: 22px 20px 20px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .split-panel.funds    { background: var(--funds-bg); border: 1.5px solid var(--funds-border); }
        .split-panel.expenses { background: var(--exp-bg);   border: 1.5px solid var(--exp-border); }

        /* Panel error highlight */
        .split-panel.panel-error {
            border-color: var(--error-red) !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }

        .panel-heading {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .funds    .panel-heading { color: var(--funds-green); }
        .expenses .panel-heading { color: var(--exp-red); }

        /* FIELDS */
        .field { margin-bottom: 14px; }
        .field:last-child { margin-bottom: 0; }

        .field label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
            letter-spacing: 0.02em;
        }

        .field input,
        .field textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--input-border);
            border-radius: 7px;
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background: #fff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .field input::placeholder,
        .field textarea::placeholder { color: #b0b7c3; font-size: 0.82rem; }
        .field input:focus,
        .field textarea:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(42,157,143,0.12);
        }
        .field textarea { resize: vertical; min-height: 72px; }

        /* Input error state */
        .field input.input-error {
            border-color: var(--error-red) !important;
            background-color: var(--error-bg);
        }

        /* Inline error message */
        .error-msg {
            display: none;
            font-size: 0.7rem;
            color: var(--error-red);
            margin-top: 5px;
            font-weight: 600;
        }
        .error-msg.show { display: block; }

        /* Global error banner */
        .global-error-banner {
            display: none;
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.8rem;
            color: var(--error-red);
            font-weight: 600;
            margin-bottom: 16px;
            text-align: center;
        }
        .global-error-banner.show { display: block; }

        /* BOTTOM ROW */
        .bottom-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        /* Date locked */
        .date-locked {
            background-color: #f3f4f6 !important;
            cursor: not-allowed !important;
            color: var(--text-muted);
        }

        /* SAVE BUTTON */
        .btn-save {
            width: 100%;
            padding: 13px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.02em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s;
        }
        .btn-save:hover { background: #238a7e; }

        .btn-save::before {
            content: '';
            display: inline-block;
            width: 16px; height: 16px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
        }

        /* AMOUNT INPUT */
        .input-prefix { position: relative; }
        .input-prefix span {
            position: absolute;
            left: 11px; top: 50%;
            transform: translateY(-50%);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            pointer-events: none;
        }
        .input-prefix input { padding-left: 28px; }

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

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .form-card { margin-left: 0; }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0; left: 0;
                transform: translateX(-100%);
            }
            .sidebar.open { transform: translateX(0); }
            .hamburger { display: flex; }

            .header { padding: 20px 20px 32px; }
            .header h1 { font-size: 1.4rem; }

            .content { padding: 24px 20px; }

            .form-card {
                padding: 24px 20px 20px;
                margin-left: 0;
                border-radius: 12px;
            }
        }

        @media (max-width: 600px) {
            .split-row        { grid-template-columns: 1fr; gap: 16px; }
            .bottom-fields    { grid-template-columns: 1fr; gap: 14px; }
        }

        @media (max-width: 480px) {
            .header { padding: 16px 16px 28px; }
            .header h1 { font-size: 1.2rem; }
            .header p { font-size: 0.8rem; }
            .header-eyebrow { display: none; }
            .content { padding: 16px 12px; }
            .form-card { padding: 20px 16px 18px; border-radius: 10px; }
            .form-card-title { font-size: 0.9rem; margin-bottom: 18px; padding-bottom: 14px; }
            .split-panel { padding: 18px 16px 16px; }
            .btn-save { font-size: 0.85rem; padding: 12px; }
        }
    </style>
</head>
<body>

<!-- Toast -->
<div id="toast-notification"></div>

<!-- Sidebar overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="app">

    <!-- SIDEBAR -->
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
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">

        <div class="header">
            <div class="header-top">
                <button class="hamburger" id="hamburgerBtn" onclick="openSidebar()" aria-label="Open menu">
                    <span></span><span></span><span></span>
                </button>
                <div>
                    <div class="header-eyebrow">Add Money</div>
                    <h1>Add Funds and Expenses</h1>
                </div>
            </div>
            <p>Record a new money collection entry</p>
        </div>

        <div class="content">
            <div class="form-card">
                <div class="form-card-title">Add Funds And Expenses Center</div>

                <form id="encoderForm" method="POST" action="{{ route('encoder.finance.store') }}">
                    @csrf

                    <!-- Global error banner -->
                    <div class="global-error-banner" id="globalErrorBanner">
                        ⚠️ Please fill in at least one section — Funds or Expenses (Amount + Description both required per section).
                    </div>

                    <!-- GREEN + RED PANELS -->
                    <div class="split-row">

                        <!-- ADD FUNDS -->
                        <div class="split-panel funds" id="fundsPanel">
                            <div class="panel-heading">Add Funds</div>

                            <div class="field">
                                <label>Amount (₱)</label>
                                <div class="input-prefix">
                                    <span>₱</span>
                                    <input type="number" name="fund_amount" id="fund_amount" min="0" step="0.01" placeholder="0.00" />
                                </div>
                                <span class="error-msg" id="fund_amount_error">Amount is required if filling Funds.</span>
                            </div>

                            <div class="field">
                                <label>Description for Funds</label>
                                <input type="text" name="fund_description" id="fund_description" placeholder="e.g. Sunday Offering, Tithes, Donations" />
                                <span class="error-msg" id="fund_description_error">Description is required if filling Funds.</span>
                            </div>
                        </div>

                        <!-- ADD EXPENSES -->
                        <div class="split-panel expenses" id="expensesPanel">
                            <div class="panel-heading">Add Expenses</div>

                            <div class="field">
                                <label>Amount (₱)</label>
                                <div class="input-prefix">
                                    <span>₱</span>
                                    <input type="number" name="expenses_amount" id="expenses_amount" min="0" step="0.01" placeholder="0.00" />
                                </div>
                                <span class="error-msg" id="expenses_amount_error">Amount is required if filling Expenses.</span>
                            </div>

                            <div class="field">
                                <label>Description for Expenses</label>
                                <input type="text" name="expenses_description" id="expenses_description" placeholder="e.g. Utilities, Office Supplies, Event Costs" />
                                <span class="error-msg" id="expenses_description_error">Description is required if filling Expenses.</span>
                            </div>
                        </div>

                    </div>

                    <!-- DATE + NOTES -->
                    <div class="bottom-fields">
                        <div class="field">
                            <label>Date <span style="font-size:0.65rem; color: var(--text-muted); font-weight:400;">(Today only)</span></label>
                            {{-- min & max both set to today — no past, no future --}}
                            <input
                                type="date"
                                name="date"
                                id="dateInput"
                                class="date-locked"
                                value="{{ date('Y-m-d') }}"
                                min="{{ date('Y-m-d') }}"
                                max="{{ date('Y-m-d') }}"
                                readonly
                            />
                        </div>
                        <div class="field">
                            <label>Notes <span style="font-weight:400;color:#b0b7c3">(optional)</span></label>
                            <input type="text" name="notes" placeholder="Additional notes..." />
                        </div>
                    </div>

                    <!-- SAVE BUTTON -->
                    <button type="submit" id="saveBtn" class="btn-save">Save Money Entry</button>

                </form>
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
    // ─── Toast ────────────────────────────────────────────────────
    function showToast(msg, isError = false) {
        const toast = document.getElementById('toast-notification');
        toast.style.borderLeftColor = isError ? '#c0392b' : '#2a9d8f';
        toast.textContent = msg;
        toast.classList.add('toast-show');
        clearTimeout(toast._timer);
        toast._timer = setTimeout(() => toast.classList.remove('toast-show'), 3500);
    }

    // ─── Sidebar ─────────────────────────────────────────────────
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

    // ─── Date Lock ───────────────────────────────────────────────
    const dateInput = document.getElementById('dateInput');
    const today     = new Date().toISOString().split('T')[0];
    dateInput.addEventListener('change', function () {
        if (this.value !== today) {
            this.value = today;
            showToast("Only today's date is allowed.", true);
        }
    });

    // ─── Elements ────────────────────────────────────────────────
    const form              = document.getElementById('encoderForm');
    const fundAmountInput   = document.getElementById('fund_amount');
    const fundDescInput     = document.getElementById('fund_description');
    const expAmountInput    = document.getElementById('expenses_amount');
    const expDescInput      = document.getElementById('expenses_description');
    const fundsPanel        = document.getElementById('fundsPanel');
    const expensesPanel     = document.getElementById('expensesPanel');
    const globalErrorBanner = document.getElementById('globalErrorBanner');

    // ─── Helpers ─────────────────────────────────────────────────
    function setError(inputEl, errorId, show) {
        const msg = document.getElementById(errorId);
        inputEl.classList.toggle('input-error', show);
        msg.classList.toggle('show', show);
    }

    function clearPanel(panel, inputs, errorIds) {
        panel.classList.remove('panel-error');
        inputs.forEach((el, i) => setError(el, errorIds[i], false));
    }

    function isFundFilled()  { return fundAmountInput.value.trim() !== '' || fundDescInput.value.trim() !== ''; }
    function isExpFilled()   { return expAmountInput.value.trim()  !== '' || expDescInput.value.trim()  !== ''; }

    // Clear errors as user types
    [fundAmountInput, fundDescInput, expAmountInput, expDescInput].forEach(el => {
        el.addEventListener('input', () => {
            if (isFundFilled() || isExpFilled()) {
                globalErrorBanner.classList.remove('show');
            }
            if (el === fundAmountInput || el === fundDescInput) {
                if (isFundFilled()) clearPanel(fundsPanel, [fundAmountInput, fundDescInput], ['fund_amount_error', 'fund_description_error']);
            }
            if (el === expAmountInput || el === expDescInput) {
                if (isExpFilled()) clearPanel(expensesPanel, [expAmountInput, expDescInput], ['expenses_amount_error', 'expenses_description_error']);
            }
        });
    });

    // ─── Submit Validation ───────────────────────────────────────
    form.addEventListener('submit', function (e) {
        let isValid = true;

        const fundAmt  = fundAmountInput.value.trim();
        const fundDesc = fundDescInput.value.trim();
        const expAmt   = expAmountInput.value.trim();
        const expDesc  = expDescInput.value.trim();

        const fundStarted = fundAmt  !== '' || fundDesc !== '';
        const expStarted  = expAmt   !== '' || expDesc  !== '';

        // Rule: at least one section must be filled
        if (!fundStarted && !expStarted) {
            globalErrorBanner.classList.add('show');
            fundsPanel.classList.add('panel-error');
            expensesPanel.classList.add('panel-error');
            showToast('Please fill in at least Funds or Expenses.', true);
            e.preventDefault();
            return;
        }

        globalErrorBanner.classList.remove('show');

        // Rule: if Funds partially filled, both fields required
        if (fundStarted) {
            let fundValid = true;
            if (fundAmt === '' || parseFloat(fundAmt) <= 0) {
                setError(fundAmountInput, 'fund_amount_error', true);
                fundsPanel.classList.add('panel-error');
                isValid = false; fundValid = false;
            } else {
                setError(fundAmountInput, 'fund_amount_error', false);
            }
            if (fundDesc === '') {
                setError(fundDescInput, 'fund_description_error', true);
                fundsPanel.classList.add('panel-error');
                isValid = false; fundValid = false;
            } else {
                setError(fundDescInput, 'fund_description_error', false);
            }
            if (fundValid) fundsPanel.classList.remove('panel-error');
        } else {
            clearPanel(fundsPanel, [fundAmountInput, fundDescInput], ['fund_amount_error', 'fund_description_error']);
        }

        // Rule: if Expenses partially filled, both fields required
        if (expStarted) {
            let expValid = true;
            if (expAmt === '' || parseFloat(expAmt) <= 0) {
                setError(expAmountInput, 'expenses_amount_error', true);
                expensesPanel.classList.add('panel-error');
                isValid = false; expValid = false;
            } else {
                setError(expAmountInput, 'expenses_amount_error', false);
            }
            if (expDesc === '') {
                setError(expDescInput, 'expenses_description_error', true);
                expensesPanel.classList.add('panel-error');
                isValid = false; expValid = false;
            } else {
                setError(expDescInput, 'expenses_description_error', false);
            }
            if (expValid) expensesPanel.classList.remove('panel-error');
        } else {
            clearPanel(expensesPanel, [expAmountInput, expDescInput], ['expenses_amount_error', 'expenses_description_error']);
        }

        if (!isValid) {
            e.preventDefault();
            showToast('Please complete all started fields.', true);
        }
    });
</script>
</body>
</html>