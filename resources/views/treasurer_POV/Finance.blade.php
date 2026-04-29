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
            --sidebar-width: 240px;
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

        a { text-decoration: none; color: inherit; }
        .app { display: flex; height: 100vh; overflow: hidden; position: relative; }

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
            padding: 11px 16px;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.55);
            transition: all 0.2s;
        }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .nav-item.active { background: rgba(42,157,143,0.18); color: #fff; border-left: 3px solid var(--accent); }

        .sidebar-logout { margin-top: auto; padding: 16px 12px; }
        .btn-logout {
            width: 100%;
            background: var(--logout-red);
            color: white;
            border: none;
            border-radius: 7px;
            padding: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
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
        }

        .header {
            background: var(--header-bg);
            padding: 30px 20px 50px;
            color: white;
        }
        .header h1 { font-size: 1.5rem; }

        .content { 
            padding: 20px; 
            flex: 1; 
            display: flex;
            justify-content: center;
        }

        .form-card {
            background: var(--card-bg);
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 24px;
            width: 100%;
            max-width: 900px;
            height: fit-content;
        }

        .form-card-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .split-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 8px;
        }

        .bottom-fields {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .split-panel {
            border-radius: 10px;
            padding: 20px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .split-panel.funds    { background: var(--funds-bg); border: 1.5px solid var(--funds-border); }
        .split-panel.expenses { background: var(--exp-bg);   border: 1.5px solid var(--exp-border); }

        /* Panel error highlight */
        .split-panel.panel-error {
            border-color: var(--error-red) !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }

        .field { margin-bottom: 14px; }
        .field label { display: block; font-size: 0.75rem; font-weight: 600; margin-bottom: 6px; }

        .field input, .field select, .field textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--input-border);
            border-radius: 7px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

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

        /* Global "fill at least one" banner */
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

        .buttons-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .btn-save, .btn-cancel {
            flex: 1;
            min-width: 140px;
            padding: 13px;
            border-radius: 8px;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
        }
        .btn-save { background: var(--accent); color: #fff; border: none; }
        .btn-cancel { background: #f0f2f5; border: 1px solid var(--border); }

        .input-prefix { position: relative; }
        .input-prefix span { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        .input-prefix input { padding-left: 30px; }

        .date-locked {
            background-color: #f3f4f6 !important;
            cursor: not-allowed !important;
            color: var(--text-muted);
        }

        @media (max-width: 1024px) {
            .sidebar { position: fixed; left: 0; transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .sidebar-overlay.active { display: block; }
            .mobile-nav-toggle { display: flex; }
            .content { padding: 15px; }
            .form-card { padding: 20px; }
        }

        @media (max-width: 600px) {
            .split-row { grid-template-columns: 1fr; }
            .buttons-row { flex-direction: column-reverse; }
            .btn-save, .btn-cancel { width: 100%; }
            .header h1 { font-size: 1.25rem; }
        }

        #toast-notification {
            position: fixed; top: 20px; right: 20px; left: 20px;
            max-width: 400px; margin: auto;
            background: #1a1a2e; color: #fff;
            padding: 14px; border-radius: 8px;
            opacity: 0; transition: 0.3s; pointer-events: none;
            z-index: 2000;
        }
        #toast-notification.toast-show { opacity: 1; }
    </style>
</head>
<body>

<div id="toast-notification"></div>
<div class="sidebar-overlay" id="overlay"></div>

<div class="app">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
<div class="brand-icon">
                <img src="{{ asset('images/image-removebg-preview (7).svg') }}"
                     alt=""
                     style="width: 38px; height: 38px; border-radius: 8px; object-fit: cover;">
            </div>            <div>
                <div class="brand-name">Church Finance</div>
                <div class="brand-sub">Financial System</div>
            </div>
        </div>

        <div class="sidebar-role">Treasurer</div>

        <nav>
            <div class="nav-label">Main</div>
            <a class="nav-item {{ Route::is('treasurer') ? 'active' : '' }}" href="{{ route('treasurer') }}">Dashboard</a>

            <div class="nav-label">Finance</div>
            <a class="nav-item {{ Route::is('treasurer.addfundexpenses') ? 'active' : '' }}" href="{{ route('treasurer.addfundexpenses') }}">
                Add Funds & Expenses
            </a>

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
            <div class="header-eyebrow">{{ isset($transaction) ? 'Edit Entry' : 'Add Money' }}</div>
            <h1>{{ isset($transaction) ? 'Edit Entry' : 'Add Funds & Expenses' }}</h1>
            <p>{{ isset($transaction) ? 'Update entry details' : 'Record new transaction' }}</p>
        </div>

        <div class="content">
            <div class="form-card">
                <div class="form-card-title">
                    {{ isset($transaction) ? 'Edit Entry #' . $transaction->treasurerTransactionsID : 'Transaction Center' }}
                </div>

                <form id="transactionForm" method="POST" action="{{ isset($transaction) ? route('treasurer.update', $transaction->treasurerTransactionsID) : route('treasurer.addfundexpenses.store') }}">
                    @csrf
                    @if(isset($transaction)) @method('PUT') @endif

                    <!-- Global error banner -->
                    <div class="global-error-banner" id="globalErrorBanner">
                        ⚠️ Please fill in at least one section — Funds or Expenses (Amount + Description both required per section).
                    </div>

                    <div class="split-row">

                        <!-- FUNDS PANEL -->
                        <div class="split-panel funds" id="fundsPanel">
                            <div class="panel-heading" style="color: var(--funds-green); font-size:0.7rem; font-weight:700; margin-bottom:15px;">
                                ADD FUNDS
                            </div>
                            <div class="field">
                                <label>Amount (₱)</label>
                                <div class="input-prefix">
                                    <span>₱</span>
                                    <input
                                        type="number"
                                        name="fund_amount"
                                        id="fund_amount"
                                        step="0.01"
                                        min="0"
                                        placeholder="0.00"
                                        value="{{ isset($transaction) ? $transaction->funds_amount : '' }}"
                                    />
                                </div>
                                <span class="error-msg" id="fund_amount_error">Amount is required if filling Funds.</span>
                            </div>
                            <div class="field">
                                <label>Description</label>
                                <input
                                    type="text"
                                    name="fund_description"
                                    id="fund_description"
                                    placeholder="Offering, Tithes..."
                                    value="{{ isset($transaction) ? $transaction->description : '' }}"
                                />
                                <span class="error-msg" id="fund_description_error">Description is required if filling Funds.</span>
                            </div>
                        </div>

                        <!-- EXPENSES PANEL -->
                        <div class="split-panel expenses" id="expensesPanel">
                            <div class="panel-heading" style="color: var(--exp-red); font-size:0.7rem; font-weight:700; margin-bottom:15px;">
                                ADD EXPENSES
                            </div>
                            <div class="field">
                                <label>Amount (₱)</label>
                                <div class="input-prefix">
                                    <span>₱</span>
                                    <input
                                        type="number"
                                        name="expenses_amount"
                                        id="expenses_amount"
                                        step="0.01"
                                        min="0"
                                        placeholder="0.00"
                                        value="{{ isset($transaction) ? $transaction->expenses_amount : '' }}"
                                    />
                                </div>
                                <span class="error-msg" id="expenses_amount_error">Amount is required if filling Expenses.</span>
                            </div>
                            <div class="field">
                                <label>Description</label>
                                <input
                                    type="text"
                                    name="expenses_description"
                                    id="expenses_description"
                                    placeholder="Utilities, Event..."
                                    value="{{ isset($transaction) ? $transaction->description : '' }}"
                                />
                                <span class="error-msg" id="expenses_description_error">Description is required if filling Expenses.</span>
                            </div>
                        </div>

                    </div>

                    <div class="bottom-fields">
                        <div class="field">
                            <label>Date <span style="font-size:0.65rem; color: var(--text-muted); font-weight:400;">(Today only)</span></label>
                            <input
                                type="date"
                                name="date"
                                id="dateInput"
                                class="date-locked"
                                value="{{ isset($transaction) ? $transaction->date : date('Y-m-d') }}"
                                min="{{ date('Y-m-d') }}"
                                max="{{ date('Y-m-d') }}"
                                readonly
                            />
                        </div>
                        <div class="field">
                            <label>Notes (Optional)</label>
                            <input type="text" name="notes" placeholder="Extra info..." value="{{ isset($transaction) ? $transaction->notes : '' }}" />
                        </div>
                    </div>

                    <div class="buttons-row">
                        <a href="{{ route('treasurer.addfundexpenses') }}" class="btn-cancel">Cancel</a>
                        <button type="submit" id="saveBtn" class="btn-save">
                            {{ isset($transaction) ? 'Update Entry' : 'Save Money Entry' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // ─── Sidebar ──────────────────────────────────────────────────
    const menuToggle = document.getElementById('menuToggle');
    const sidebar    = document.getElementById('sidebar');
    const overlay    = document.getElementById('overlay');
    menuToggle.addEventListener('click', () => { sidebar.classList.toggle('active'); overlay.classList.toggle('active'); });
    overlay.addEventListener('click',   () => { sidebar.classList.toggle('active'); overlay.classList.toggle('active'); });

    // ─── Toast ────────────────────────────────────────────────────
    function showToast(msg, isError = false) {
        const toast = document.getElementById('toast-notification');
        toast.style.borderLeft = `4px solid ${isError ? '#c0392b' : '#2a9d8f'}`;
        toast.textContent = msg;
        toast.classList.add('toast-show');
        setTimeout(() => toast.classList.remove('toast-show'), 3500);
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
    const form              = document.getElementById('transactionForm');
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

    function isFundFilled() {
        return fundAmountInput.value.trim() !== '' || fundDescInput.value.trim() !== '';
    }
    function isExpFilled() {
        return expAmountInput.value.trim() !== '' || expDescInput.value.trim() !== '';
    }

    // Clear global banner when user starts typing in either panel
    [fundAmountInput, fundDescInput, expAmountInput, expDescInput].forEach(el => {
        el.addEventListener('input', () => {
            // If either panel now has something, hide global banner
            if (isFundFilled() || isExpFilled()) {
                globalErrorBanner.classList.remove('show');
            }
            // Clear inline errors for fund panel if user is typing there
            if (el === fundAmountInput || el === fundDescInput) {
                if (isFundFilled()) clearPanel(fundsPanel, [fundAmountInput, fundDescInput], ['fund_amount_error', 'fund_description_error']);
            }
            // Clear inline errors for expense panel if user is typing there
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

        const fundStarted = fundAmt !== '' || fundDesc !== '';
        const expStarted  = expAmt  !== '' || expDesc  !== '';

        // ── Rule: at least one section must be filled ──
        if (!fundStarted && !expStarted) {
            globalErrorBanner.classList.add('show');
            fundsPanel.classList.add('panel-error');
            expensesPanel.classList.add('panel-error');
            showToast('Please fill in at least Funds or Expenses.', true);
            e.preventDefault();
            return;
        }

        globalErrorBanner.classList.remove('show');

        // ── Rule: if Funds section is partially filled, both fields are required ──
        if (fundStarted) {
            if (fundAmt === '' || parseFloat(fundAmt) <= 0) {
                setError(fundAmountInput, 'fund_amount_error', true);
                fundsPanel.classList.add('panel-error');
                isValid = false;
            } else {
                setError(fundAmountInput, 'fund_amount_error', false);
            }

            if (fundDesc === '') {
                setError(fundDescInput, 'fund_description_error', true);
                fundsPanel.classList.add('panel-error');
                isValid = false;
            } else {
                setError(fundDescInput, 'fund_description_error', false);
            }

            if (isValid || (!isValid && fundAmt !== '' && fundDesc !== '')) {
                fundsPanel.classList.remove('panel-error');
            }
        } else {
            clearPanel(fundsPanel, [fundAmountInput, fundDescInput], ['fund_amount_error', 'fund_description_error']);
        }

        // ── Rule: if Expenses section is partially filled, both fields are required ──
        if (expStarted) {
            let expValid = true;
            if (expAmt === '' || parseFloat(expAmt) <= 0) {
                setError(expAmountInput, 'expenses_amount_error', true);
                expensesPanel.classList.add('panel-error');
                isValid = false;
                expValid = false;
            } else {
                setError(expAmountInput, 'expenses_amount_error', false);
            }

            if (expDesc === '') {
                setError(expDescInput, 'expenses_description_error', true);
                expensesPanel.classList.add('panel-error');
                isValid = false;
                expValid = false;
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