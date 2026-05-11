<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
                background: #f4f4f6;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                height: 100vh;
                padding: 1.5rem;
            }
            .page-logo {
                position: fixed;
                top: 2rem;
                left: 3rem;
                font-size: 1.25rem;
                font-weight: 700;
                color: #800020;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                z-index: 10;
            }
            .card {
                display: flex;
                width: 100%;
                max-width: 1400px;
                height: calc(100vh - 5rem);
                max-height: 900px;
                border-radius: 0.75rem;
                background: white;
                box-shadow: 0 8px 40px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(0, 0, 0, 0.05);
                overflow: hidden;
            }
            .left-panel {
                width: 48%;
                background: linear-gradient(135deg, #4a0011 0%, #6b0018 25%, #a04020 55%, #c87820 80%, #d4a030 100%);
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                justify-content: center;
                padding: 4rem;
                padding-left: 5rem;
                position: relative;
            }
            .left-panel-content {
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
                align-items: flex-start;
                text-align: left;
                width: 100%;
            }
            .left-panel h2 {
                font-size: 2.75rem;
                font-weight: 700;
                color: white;
                line-height: 1.15;
                letter-spacing: -0.02em;
            }
            .left-panel p {
                font-size: 1.0625rem;
                color: rgba(255, 255, 255, 0.75);
                line-height: 1.65;
            }
            .secure-badge {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-top: 0.25rem;
                font-size: 0.875rem;
                color: rgba(255, 255, 255, 0.6);
            }
            .secure-badge svg {
                width: 1rem;
                height: 1rem;
                flex-shrink: 0;
            }
            .right-panel {
                width: 52%;
                padding: 4rem 4rem 3rem;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            .right-panel .title {
                font-size: 1.5rem;
                font-weight: 700;
                color: #800020;
                line-height: 1.35;
                margin-bottom: 0.375rem;
            }
            .right-panel .subtitle {
                font-size: 1rem;
                color: #9ca3af;
                margin-bottom: 2rem;
            }
            .form-group {
                margin-bottom: 1.25rem;
            }
            .form-group label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                color: #374151;
                margin-bottom: 0.4rem;
            }
            .input-wrapper {
                position: relative;
            }
            .input-wrapper input {
                width: 100%;
                padding: 0.875rem 2.6rem 0.875rem 1.125rem;
                font-size: 1rem;
                border: 1.5px solid #d1d5db;
                border-radius: 0.5rem;
                background: #fff;
                color: #1a1a1a;
                outline: none;
                font-family: inherit;
                transition: border-color 0.15s ease, box-shadow 0.15s ease;
            }
            .input-wrapper input::placeholder {
                color: #9ca3af;
            }
            .input-wrapper input:focus {
                border-color: #800020;
                box-shadow: 0 0 0 3px rgba(128, 0, 32, 0.08);
            }
            .input-wrapper .icon {
                position: absolute;
                right: 0.875rem;
                top: 50%;
                transform: translateY(-50%);
                width: 1.25rem;
                height: 1.25rem;
                color: #9ca3af;
                pointer-events: none;
            }
            .options-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 1.75rem;
            }
            .remember {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.9375rem;
                color: #6b7280;
                cursor: pointer;
            }
            .remember input[type="checkbox"] {
                width: 1.125rem;
                height: 1.125rem;
                accent-color: #800020;
                cursor: pointer;
            }
            .forgot-link {
                font-size: 0.9375rem;
                font-weight: 500;
                color: #800020;
                text-decoration: none;
            }
            .forgot-link:hover {
                text-decoration: underline;
            }
            .btn-signin {
                width: 100%;
                padding: 1rem;
                font-size: 1.125rem;
                font-weight: 600;
                background: #800020;
                color: white;
                border: none;
                border-radius: 0.5rem;
                cursor: pointer;
                font-family: inherit;
                transition: background 0.15s ease;
                letter-spacing: 0.01em;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.4rem;
            }
            .btn-signin:hover {
                background: #66001a;
            }
            .btn-signin:active {
                background: #4d0014;
            }
            .bottom-text {
                text-align: center;
                margin-top: 1.75rem;
                font-size: 0.9375rem;
                color: #6b7280;
            }
            .bottom-text a {
                color: #b8860b;
                font-weight: 600;
                text-decoration: none;
            }
            .bottom-text a:hover {
                text-decoration: underline;
            }
            .page-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: #1a1a1a;
                text-align: center;
                padding: 1rem 1rem;
            }
            .page-footer span {
                font-size: 0.875rem;
                color: rgba(255, 255, 255, 0.7);
                letter-spacing: 0.02em;
            }
            /* Registration Flow */
            .reg-back {
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
                color: #800020;
                cursor: pointer;
                font-size: 0.9375rem;
                font-weight: 500;
                background: none;
                border: none;
                font-family: inherit;
                padding: 0;
                margin-bottom: 1.25rem;
                transition: opacity 0.15s ease;
            }
            .reg-back:hover { opacity: 0.75; }
            .reg-back svg { width: 1rem; height: 1rem; flex-shrink: 0; }
            .reg-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: #800020;
                line-height: 1.35;
                margin-bottom: 0.375rem;
            }
            .reg-subtitle {
                font-size: 1rem;
                color: #9ca3af;
                margin-bottom: 2rem;
            }
            .role-cards {
                display: flex;
                gap: 1.25rem;
                margin-bottom: 2rem;
            }
            .role-card {
                flex: 1;
                border: 2px solid #e5e7eb;
                border-radius: 0.75rem;
                padding: 2rem 1.25rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.75rem;
                cursor: pointer;
                transition: all 0.2s ease;
                background: #fff;
                text-align: center;
            }
            .role-card:hover {
                border-color: #800020;
                box-shadow: 0 4px 20px rgba(128, 0, 32, 0.1);
                transform: translateY(-3px);
            }
            .role-icon {
                width: 3rem;
                height: 3rem;
                color: #800020;
            }
            .role-label {
                font-size: 1.125rem;
                font-weight: 600;
                color: #1a1a1a;
            }
            .role-desc {
                font-size: 0.875rem;
                color: #9ca3af;
                margin-top: 0.125rem;
            }
            .form-select {
                width: 100%;
                padding: 0.875rem 2.6rem 0.875rem 1.125rem;
                font-size: 1rem;
                border: 1.5px solid #d1d5db;
                border-radius: 0.5rem;
                background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.875rem center;
                color: #1a1a1a;
                outline: none;
                font-family: inherit;
                transition: border-color 0.15s ease, box-shadow 0.15s ease;
                appearance: none;
                cursor: pointer;
            }
            .form-select:focus {
                border-color: #800020;
                box-shadow: 0 0 0 3px rgba(128, 0, 32, 0.08);
            }
            .error-msg {
                color: #dc2626;
                font-size: 0.8125rem;
                margin-top: 0.3rem;
                display: none;
            }
            .error-msg.visible { display: block; }
            .input-error { border-color: #dc2626 !important; }
            .right-panel.reg-active {
                justify-content: flex-start;
                overflow-y: auto;
                scrollbar-width: thin;
                scrollbar-color: #d1d5db transparent;
            }
            @media (max-width: 1024px) {
                .card { max-width: 95vw; }
                .left-panel { padding: 3rem 3rem 3rem 4rem; }
                .right-panel { padding: 3rem 3rem 2.5rem; }
            }
            @media (max-width: 768px) {
                body { padding: 1rem; }
                .card {
                    flex-direction: column;
                    height: auto;
                    max-height: none;
                    max-width: 100%;
                }
                .left-panel {
                    width: 100%;
                    padding: 2.5rem 2rem;
                    justify-content: center;
                    min-height: 220px;
                }
                .left-panel p { max-width: 100%; }
                .left-panel h2 { font-size: 2rem; }
                .right-panel {
                    width: 100%;
                    padding: 2.25rem 2rem;
                }
                .page-logo { left: 1.5rem; top: 1.25rem; font-size: 1rem; }
            }
            @media (max-width: 480px) {
                body { padding: 0.5rem; }
                .left-panel { padding: 1.75rem 1.5rem; min-height: 170px; }
                .left-panel h2 { font-size: 1.5rem; }
                .right-panel { padding: 1.5rem; }
                .right-panel .title { font-size: 1.125rem; }
                .options-row { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
            }
        </style>
    @endif
</head>
<body>
    <div class="page-logo">USANT</div>

    <div class="card">
        <div class="left-panel">
            <div class="left-panel-content">
                <h2>Welcome<br>Back</h2>
                <p>Access your USANT account to continue sending your communication letters efficiently.</p>
                <div class="secure-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Secure &amp; Encrypted
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div id="loginContent">
                <div class="title">CIBM Communication<br>Letter Tracker</div>
                <div class="subtitle">Enter your credentials to access your account</div>

                <div id="loginError" style="display:none; color:#dc2626; font-size:0.875rem; margin-bottom:1rem; padding:0.75rem 1rem; background:rgba(220,38,38,0.06); border-radius:0.5rem;"></div>
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <input id="email" type="email" name="email" placeholder="your@email.com" required autofocus>
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <input id="password" type="password" name="password" placeholder="··········" required>
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                    </div>

                    <div class="options-row">
                        <label class="remember">
                            <input type="checkbox" name="remember">
                            Remember me
                        </label>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn-signin">
                        Sign In <span style="font-size:1.2em;line-height:1;">→</span>
                    </button>
                </form>

                <div class="bottom-text">
                    Don't have an account? <a href="#" onclick="showRegistration(); return false;">Sign Up</a>
                </div>
            </div>

            <div id="registrationContent" style="display:none;">
                <div id="roleSelection">
                    <div class="reg-title">Register as</div>
                    <p class="reg-subtitle">Choose your account type to get started</p>
                    <div class="role-cards">
                        <div class="role-card" onclick="selectRole('student')">
                            <svg class="role-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                            </svg>
                            <div class="role-label">Student</div>
                            <div class="role-desc">For current students</div>
                        </div>
                        <div class="role-card" onclick="selectRole('official')">
                            <svg class="role-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            <div class="role-label">Official</div>
                            <div class="role-desc">For school personnel</div>
                        </div>
                    </div>
                    <button class="reg-back" onclick="showLogin()" style="margin-bottom:0;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"/>
                            <polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Back to Sign In
                    </button>
                </div>

                <div id="studentForm" style="display:none;">
                    <button class="reg-back" onclick="backToRoleSelection()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"/>
                            <polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Back
                    </button>
                    <div class="reg-title" style="margin-bottom:0.25rem;">Student Registration</div>
                    <p class="reg-subtitle" style="margin-bottom:1.5rem;">Create your student account</p>
                    <form id="studentRegForm" onsubmit="return validateStudentForm(event)">
                        <div class="form-group">
                            <label for="stud_name">Full Name</label>
                            <div class="input-wrapper">
                                <input id="stud_name" type="text" placeholder="Juan Dela Cruz" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stud_college">College</label>
                            <select id="stud_college" class="form-select" required>
                                <option value="">Select College</option>
                                <option value="CCS">College of Computer Studies</option>
                                <option value="CEA">College of Engineering and Architecture</option>
                                <option value="CBA">College of Business and Accountancy</option>
                                <option value="CAS">College of Arts and Sciences</option>
                                <option value="CED">College of Education</option>
                                <option value="CN">College of Nursing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stud_year">Year Level</label>
                            <select id="stud_year" class="form-select" required>
                                <option value="">Select Year Level</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                                <option value="5">5th Year</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stud_org">Student Organization</label>
                            <input id="stud_org" type="text" list="org-list" placeholder="Search or type organization" class="form-select">
                            <datalist id="org-list">
                                <option value="SSC - Supreme Student Council">
                                <option value="IT Society">
                                <option value="Engineering Society">
                                <option value="Business Organization">
                                <option value="Performing Arts Group">
                                <option value="Student Publication">
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="stud_email">Email Address</label>
                            <div class="input-wrapper">
                                <input id="stud_email" type="email" placeholder="your@email.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stud_password">Password</label>
                            <div class="input-wrapper">
                                <input id="stud_password" type="password" placeholder="··········" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stud_confirm_password">Confirm Password</label>
                            <div class="input-wrapper">
                                <input id="stud_confirm_password" type="password" placeholder="··········" required>
                            </div>
                            <div class="error-msg" id="stud_password_error">Passwords do not match</div>
                        </div>
                        <button type="submit" class="btn-signin">Create Student Account</button>
                    </form>
                </div>

                <div id="officialForm" style="display:none;">
                    <button class="reg-back" onclick="backToRoleSelection()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"/>
                            <polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Back
                    </button>
                    <div class="reg-title" style="margin-bottom:0.25rem;">Official Registration</div>
                    <p class="reg-subtitle" style="margin-bottom:1.5rem;">Create your official account</p>
                    <form id="officialRegForm" onsubmit="return validateOfficialForm(event)">
                        <div class="form-group">
                            <label for="off_name">Full Name</label>
                            <div class="input-wrapper">
                                <input id="off_name" type="text" placeholder="Juan Dela Cruz" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="off_office">Assigned Office / Room</label>
                            <select id="off_office" class="form-select" required>
                                <option value="">Select Office</option>
                                <option value="Adviser">Adviser</option>
                                <option value="Dean">Dean</option>
                                <option value="SPMO">SPMO</option>
                                <option value="OSAA">OSAA</option>
                                <option value="Budgeting Office">Budgeting Office</option>
                                <option value="OIC">OIC</option>
                                <option value="Vice President Office">Vice President Office</option>
                                <option value="President Office">President Office</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="off_email">Email Address</label>
                            <div class="input-wrapper">
                                <input id="off_email" type="email" placeholder="your@email.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="off_password">Password</label>
                            <div class="input-wrapper">
                                <input id="off_password" type="password" placeholder="··········" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="off_confirm_password">Confirm Password</label>
                            <div class="input-wrapper">
                                <input id="off_confirm_password" type="password" placeholder="··········" required>
                            </div>
                            <div class="error-msg" id="off_password_error">Passwords do not match</div>
                        </div>
                        <button type="submit" class="btn-signin">Create Official Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="page-footer">
        <span>&copy; 2024 USANT | All rights reserved</span>
    </div>
<script src="/js/auth.js"></script>
<script>
    if (USANTAuth.redirectIfAuthenticated()) {}

    function showRegistration() {
        document.getElementById('loginError').style.display = 'none';
        document.getElementById('loginContent').style.display = 'none';
        document.getElementById('registrationContent').style.display = 'block';
        document.getElementById('roleSelection').style.display = 'block';
        document.getElementById('studentForm').style.display = 'none';
        document.getElementById('officialForm').style.display = 'none';
        document.querySelector('.right-panel').classList.add('reg-active');
        document.querySelector('.right-panel').scrollTop = 0;
    }
    function showLogin() {
        document.getElementById('loginContent').style.display = '';
        document.getElementById('registrationContent').style.display = 'none';
        document.querySelector('.right-panel').classList.remove('reg-active');
        document.querySelector('.right-panel').scrollTop = 0;
    }
    function selectRole(role) {
        document.getElementById('roleSelection').style.display = 'none';
        if (role === 'student') {
            document.getElementById('studentForm').style.display = 'block';
        } else {
            document.getElementById('officialForm').style.display = 'block';
        }
        document.querySelector('.right-panel').scrollTop = 0;
    }
    function backToRoleSelection() {
        document.getElementById('studentForm').style.display = 'none';
        document.getElementById('officialForm').style.display = 'none';
        document.getElementById('roleSelection').style.display = 'block';
        document.querySelector('.right-panel').scrollTop = 0;
    }
    function validatePasswords(passwordId, confirmId, errorId) {
        var pw = document.getElementById(passwordId);
        var cpw = document.getElementById(confirmId);
        var err = document.getElementById(errorId);
        if (pw.value !== cpw.value) {
            cpw.classList.add('input-error');
            err.classList.add('visible');
            return false;
        }
        cpw.classList.remove('input-error');
        err.classList.remove('visible');
        return true;
    }
    function showLoginError(message) {
        var el = document.getElementById('loginError');
        el.textContent = message;
        el.style.display = 'block';
    }
    function showRegError(formId, message) {
        var el = document.getElementById(formId + '_general_error');
        if (!el) {
            var form = document.getElementById(formId);
            el = document.createElement('div');
            el.id = formId + '_general_error';
            el.className = 'error-msg';
            el.style.marginBottom = '1rem';
            form.insertBefore(el, form.firstChild);
        }
        el.textContent = message;
        el.classList.add('visible');
    }

    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value;
        var btn = this.querySelector('.btn-signin');
        var orig = btn.innerHTML;
        btn.innerHTML = 'Signing in...';
        btn.disabled = true;
        setTimeout(function () {
            var result = USANTAuth.login(email, password);
            if (result.success) {
                window.location.href = '/dashboard';
            } else {
                btn.innerHTML = orig;
                btn.disabled = false;
                showLoginError(result.error);
            }
        }, 600);
    });

    function validateStudentForm(e) {
        e.preventDefault();
        var pwOk = validatePasswords('stud_password', 'stud_confirm_password', 'stud_password_error');
        if (!pwOk) return false;
        var name = document.getElementById('stud_name').value.trim();
        var college = document.getElementById('stud_college').value;
        var year = document.getElementById('stud_year').value;
        var org = document.getElementById('stud_org').value.trim();
        var email = document.getElementById('stud_email').value.trim();
        var password = document.getElementById('stud_password').value;
        if (!name || !college || !year || !email || !password) {
            showRegError('studentRegForm', 'Please fill in all required fields.');
            return false;
        }
        var btn = document.querySelector('#studentRegForm .btn-signin');
        var orig = btn.textContent;
        btn.textContent = 'Creating account...';
        btn.disabled = true;
        setTimeout(function () {
            var result = USANTAuth.register({
                fullName: name,
                email: email,
                password: password,
                role: 'student',
                college: college,
                yearLevel: year,
                organization: org
            });
            if (result.success) {
                window.location.href = '/dashboard';
            } else {
                btn.textContent = orig;
                btn.disabled = false;
                showRegError('studentRegForm', result.error);
            }
        }, 600);
        return false;
    }
    function validateOfficialForm(e) {
        e.preventDefault();
        var pwOk = validatePasswords('off_password', 'off_confirm_password', 'off_password_error');
        if (!pwOk) return false;
        var name = document.getElementById('off_name').value.trim();
        var office = document.getElementById('off_office').value;
        var email = document.getElementById('off_email').value.trim();
        var password = document.getElementById('off_password').value;
        if (!name || !office || !email || !password) {
            showRegError('officialRegForm', 'Please fill in all required fields.');
            return false;
        }
        var btn = document.querySelector('#officialRegForm .btn-signin');
        var orig = btn.textContent;
        btn.textContent = 'Creating account...';
        btn.disabled = true;
        setTimeout(function () {
            var result = USANTAuth.register({
                fullName: name,
                email: email,
                password: password,
                role: 'official',
                office: office
            });
            if (result.success) {
                window.location.href = '/dashboard';
            } else {
                btn.textContent = orig;
                btn.disabled = false;
                showRegError('officialRegForm', result.error);
            }
        }, 600);
        return false;
    }
</script>
</body>
</html>
