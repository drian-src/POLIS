<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - USANT Communication Letter Tracker</title>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f4f4f6;
            color: #1a1a1a;
            display: flex;
            min-height: 100vh;
        }
        a { text-decoration: none; color: inherit; }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: #1a1a1a;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }
        .sidebar-brand {
            padding: 1.5rem 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-brand h2 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .sidebar-brand span {
            display: block;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.35);
            letter-spacing: 0.04em;
            margin-top: 0.2rem;
        }
        .sidebar-nav {
            flex: 1;
            padding: 0.75rem 0.75rem;
            overflow-y: auto;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: rgba(255,255,255,0.6);
            font-size: 0.9375rem;
            font-weight: 500;
            transition: all 0.15s ease;
            margin-bottom: 0.15rem;
        }
        .sidebar-nav a:hover {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.9);
        }
        .sidebar-nav a.active {
            background: #800020;
            color: #fff;
        }
        .sidebar-nav a svg {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }
        .sidebar-nav a .badge {
            margin-left: auto;
            background: #800020;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.15rem 0.5rem;
            border-radius: 999px;
        }
        .sidebar-nav a.active .badge { background: rgba(255,255,255,0.2); }
        .sidebar-footer {
            padding: 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 99;
        }
        .sidebar-overlay.visible { display: block; }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            z-index: 50;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem;
            color: #6b7280;
        }
        .hamburger svg { width: 1.5rem; height: 1.5rem; }
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.875rem;
            color: #9ca3af;
        }
        .breadcrumb span { color: #6b7280; }
        .breadcrumb span.current { color: #800020; font-weight: 600; }
        .breadcrumb svg { width: 0.875rem; height: 0.875rem; }
        .header-right {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }
        .header-right .welcome {
            font-size: 0.8125rem;
            color: #9ca3af;
        }
        .header-right .welcome strong {
            display: block;
            color: #1a1a1a;
            font-weight: 600;
            font-size: 0.9375rem;
        }
        .notif-btn {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 0.25rem;
            transition: color 0.15s ease;
        }
        .notif-btn:hover { color: #800020; }
        .notif-btn svg { width: 1.375rem; height: 1.375rem; }
        .notif-btn .dot {
            position: absolute;
            top: 0;
            right: 0;
            width: 0.5rem;
            height: 0.5rem;
            background: #dc2626;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .profile-avatar {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 50%;
            background: #800020;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            cursor: pointer;
            flex-shrink: 0;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            margin-top: 64px;
            flex: 1;
            padding: 2rem;
            min-height: calc(100vh - 64px);
        }

        /* Page Content */
        .page-content { display: none; animation: fadeIn 0.25s ease; }
        .page-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

        .page-header {
            margin-bottom: 1.75rem;
        }
        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
        }
        .page-header p {
            font-size: 0.9375rem;
            color: #9ca3af;
            margin-top: 0.25rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }
        .stat-card {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            border-left: 4px solid #e5e7eb;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }
        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transform: translateY(-1px);
        }
        .stat-card .stat-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }
        .stat-card .stat-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-card .stat-icon svg { width: 1.25rem; height: 1.25rem; }
        .stat-card .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1;
        }
        .stat-card .stat-label {
            font-size: 0.875rem;
            color: #9ca3af;
            margin-top: 0.25rem;
        }
        .stat-card.total { border-left-color: #800020; }
        .stat-card.total .stat-icon { background: rgba(128,0,32,0.1); color: #800020; }
        .stat-card.pending { border-left-color: #f59e0b; }
        .stat-card.pending .stat-icon { background: rgba(245,158,11,0.1); color: #f59e0b; }
        .stat-card.approved { border-left-color: #10b981; }
        .stat-card.approved .stat-icon { background: rgba(16,185,129,0.1); color: #10b981; }
        .stat-card.rejected { border-left-color: #ef4444; }
        .stat-card.rejected .stat-icon { background: rgba(239,68,68,0.1); color: #ef4444; }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.25rem;
        }

        /* Card */
        .card {
            background: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            overflow: hidden;
        }
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1a1a;
        }
        .card-header .card-link {
            font-size: 0.875rem;
            color: #800020;
            font-weight: 500;
            cursor: pointer;
        }
        .card-header .card-link:hover { text-decoration: underline; }
        .card-body { padding: 1.25rem 1.5rem; }

        /* Activity Table */
        .activity-table {
            width: 100%;
            border-collapse: collapse;
        }
        .activity-table th {
            text-align: left;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f3f4f6;
        }
        .activity-table td {
            padding: 0.75rem 0;
            font-size: 0.9375rem;
            color: #374151;
            border-bottom: 1px solid #f9fafb;
        }
        .activity-table tr:last-child td { border-bottom: none; }
        .activity-table .letter-title {
            font-weight: 500;
            color: #1a1a1a;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.8125rem;
            font-weight: 500;
            padding: 0.2rem 0.625rem;
            border-radius: 999px;
        }
        .status-badge svg { width: 0.75rem; height: 0.75rem; }
        .status-badge.pending { background: rgba(245,158,11,0.1); color: #b45309; }
        .status-badge.approved { background: rgba(16,185,129,0.1); color: #047857; }
        .status-badge.rejected { background: rgba(239,68,68,0.1); color: #b91c1c; }
        .status-badge.in-review { background: rgba(59,130,246,0.1); color: #1d4ed8; }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .quick-action {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 1rem 1.25rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #fff;
        }
        .quick-action:hover {
            border-color: #800020;
            box-shadow: 0 2px 8px rgba(128,0,32,0.06);
            transform: translateX(3px);
        }
        .quick-action .qa-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            background: rgba(128,0,32,0.08);
            color: #800020;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .quick-action .qa-icon svg { width: 1.25rem; height: 1.25rem; }
        .quick-action .qa-text { flex: 1; }
        .quick-action .qa-text strong {
            display: block;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #1a1a1a;
        }
        .quick-action .qa-text span {
            font-size: 0.8125rem;
            color: #9ca3af;
        }
        .quick-action .qa-arrow { color: #d1d5db; }
        .quick-action .qa-arrow svg { width: 1.25rem; height: 1.25rem; }

        /* Letter History Page */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }
        .search-input {
            flex: 1;
            min-width: 200px;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            font-size: 0.9375rem;
            border: 1.5px solid #d1d5db;
            border-radius: 0.5rem;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E") no-repeat 0.75rem center;
            outline: none;
            font-family: inherit;
            transition: border-color 0.15s ease;
        }
        .search-input:focus { border-color: #800020; }
        .filter-select {
            padding: 0.625rem 2.25rem 0.625rem 0.875rem;
            font-size: 0.9375rem;
            border: 1.5px solid #d1d5db;
            border-radius: 0.5rem;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
            outline: none;
            font-family: inherit;
            cursor: pointer;
            appearance: none;
            transition: border-color 0.15s ease;
        }
        .filter-select:focus { border-color: #800020; }

        /* Full Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            text-align: left;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.875rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        .data-table td {
            padding: 0.875rem 1rem;
            font-size: 0.9375rem;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
        }
        .data-table tr:hover td { background: #fafafa; }
        .data-table .actions {
            display: flex;
            gap: 0.375rem;
        }
        .data-table .actions button {
            padding: 0.35rem 0.625rem;
            font-size: 0.8125rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background: #fff;
            color: #374151;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.15s ease;
        }
        .data-table .actions button:hover {
            border-color: #800020;
            color: #800020;
        }

        /* Pagination */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 1.25rem 0 0;
        }
        .pagination button {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background: #fff;
            color: #374151;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.15s ease;
        }
        .pagination button:hover { border-color: #800020; color: #800020; }
        .pagination button.active {
            background: #800020;
            color: #fff;
            border-color: #800020;
        }
        .pagination button:disabled {
            opacity: 0.4;
            cursor: default;
        }
        .pagination .info {
            font-size: 0.875rem;
            color: #9ca3af;
            margin: 0 0.5rem;
        }

        /* Upload Zone */
        .upload-zone {
            border: 2px dashed #d1d5db;
            border-radius: 1rem;
            padding: 3rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #fafafa;
        }
        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: #800020;
            background: rgba(128,0,32,0.03);
        }
        .upload-zone .upload-icon {
            width: 4rem;
            height: 4rem;
            color: #d1d5db;
            margin: 0 auto 1rem;
        }
        .upload-zone.dragover .upload-icon { color: #800020; }
        .upload-zone h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #374151;
        }
        .upload-zone p {
            font-size: 0.9375rem;
            color: #9ca3af;
            margin-top: 0.375rem;
        }
        .upload-zone .file-types {
            font-size: 0.8125rem;
            color: #d1d5db;
            margin-top: 0.75rem;
        }
        .upload-form {
            max-width: 640px;
            margin: 0 auto;
        }
        .upload-form .form-row {
            margin-bottom: 1.25rem;
        }
        .upload-form label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
        }
        .upload-form input[type="text"],
        .upload-form select {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: 1.5px solid #d1d5db;
            border-radius: 0.5rem;
            outline: none;
            font-family: inherit;
            transition: border-color 0.15s ease;
        }
        .upload-form input[type="text"]:focus,
        .upload-form select:focus { border-color: #800020; }
        .btn-primary {
            width: 100%;
            padding: 0.875rem;
            font-size: 1rem;
            font-weight: 600;
            background: #800020;
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-primary:hover { background: #66001a; }
        .btn-primary svg { width: 1.25rem; height: 1.25rem; }
        .btn-primary:disabled { opacity: 0.5; cursor: default; }

        .upload-success {
            display: none;
            text-align: center;
            padding: 2rem;
        }
        .upload-success.visible { display: block; }
        .upload-success .success-icon {
            width: 4rem;
            height: 4rem;
            color: #10b981;
            margin: 0 auto 1rem;
        }
        .upload-success h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a1a1a;
        }
        .upload-success p { color: #6b7280; margin-top: 0.25rem; }
        .upload-success .file-info {
            background: #f9fafb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            text-align: left;
            font-size: 0.9375rem;
        }
        .upload-success .file-info strong { color: #1a1a1a; }
        .upload-success .file-info span { color: #6b7280; }

        /* Progress Indicator */
        .progress-track {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-top: 1.5rem;
        }
        .progress-step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
        }
        .progress-step .step-dot {
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            border: 2px solid #d1d5db;
            color: #d1d5db;
            background: #fff;
        }
        .progress-step.completed .step-dot {
            background: #10b981;
            border-color: #10b981;
            color: #fff;
        }
        .progress-step.active .step-dot {
            background: #800020;
            border-color: #800020;
            color: #fff;
        }
        .progress-step .step-label { color: #9ca3af; }
        .progress-step.completed .step-label { color: #10b981; }
        .progress-step.active .step-label { color: #800020; font-weight: 600; }
        .progress-line {
            width: 4rem;
            height: 2px;
            background: #d1d5db;
            margin: 0 0.5rem;
        }
        .progress-line.completed { background: #10b981; }

        /* Notifications */
        .notif-list { display: flex; flex-direction: column; }
        .notif-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.15s ease;
        }
        .notif-item:hover { background: #fafafa; }
        .notif-item:last-child { border-bottom: none; }
        .notif-item .notif-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .notif-item .notif-icon svg { width: 1.25rem; height: 1.25rem; }
        .notif-item .notif-icon.approved { background: rgba(16,185,129,0.1); color: #10b981; }
        .notif-item .notif-icon.rejected { background: rgba(239,68,68,0.1); color: #ef4444; }
        .notif-item .notif-icon.info { background: rgba(59,130,246,0.1); color: #3b82f6; }
        .notif-item .notif-icon.forwarded { background: rgba(128,0,32,0.1); color: #800020; }
        .notif-item .notif-text { flex: 1; }
        .notif-item .notif-text p {
            font-size: 0.9375rem;
            color: #374151;
        }
        .notif-item .notif-text .notif-time {
            font-size: 0.8125rem;
            color: #9ca3af;
            margin-top: 0.2rem;
        }

        /* Profile Page */
        .profile-card {
            max-width: 640px;
        }
        .profile-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .profile-avatar-large {
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            background: #800020;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            flex-shrink: 0;
        }
        .profile-header h2 { font-size: 1.375rem; font-weight: 700; color: #1a1a1a; }
        .profile-header p { font-size: 0.9375rem; color: #9ca3af; }
        .profile-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 2rem;
        }
        .profile-details .detail-item {}
        .profile-details .detail-item label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.25rem;
        }
        .profile-details .detail-item span {
            font-size: 1rem;
            color: #1a1a1a;
            font-weight: 500;
        }

        /* Change Password */
        .password-section h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }
        .password-form .form-group {
            margin-bottom: 1rem;
        }
        .password-form .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
        }
        .password-form .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: 1.5px solid #d1d5db;
            border-radius: 0.5rem;
            outline: none;
            font-family: inherit;
            transition: border-color 0.15s ease;
        }
        .password-form .form-group input:focus { border-color: #800020; }
        .btn-secondary {
            padding: 0.75rem 2rem;
            font-size: 0.9375rem;
            font-weight: 600;
            background: #800020;
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s ease;
        }
        .btn-secondary:hover { background: #66001a; }

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.2s ease-in-out infinite;
            border-radius: 0.375rem;
        }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
        }
        .empty-state svg {
            width: 4rem;
            height: 4rem;
            color: #d1d5db;
            margin: 0 auto 1rem;
        }
        .empty-state h4 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #6b7280;
        }
        .empty-state p {
            font-size: 0.9375rem;
            color: #9ca3af;
            margin-top: 0.25rem;
        }

        /* Toast / Alert */
        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #1a1a1a;
            color: #fff;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            display: none;
            align-items: center;
            gap: 0.75rem;
            z-index: 200;
            animation: slideUp 0.3s ease;
        }
        .toast.visible { display: flex; }
        .toast svg { width: 1.25rem; height: 1.25rem; flex-shrink: 0; }
        .toast.success svg { color: #10b981; }
        .toast.error svg { color: #ef4444; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(1rem); } to { opacity: 1; transform: translateY(0); } }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .content-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open { transform: translateX(0); }
            .hamburger { display: block; }
            .header { left: 0; padding: 0 1.25rem; }
            .header-right .welcome { display: none; }
            .main-content { margin-left: 0; padding: 1.25rem; }
            .stats-grid { grid-template-columns: 1fr; }
            .profile-details { grid-template-columns: 1fr; }
            .data-table { font-size: 0.875rem; }
            .data-table th, .data-table td { padding: 0.625rem 0.75rem; }
            .progress-line { width: 2rem; }
            .breadcrumb { font-size: 0.8125rem; }
            .profile-header { flex-direction: column; text-align: center; }
        }
        @media (max-width: 480px) {
            .main-content { padding: 1rem; }
            .card-body { padding: 1rem; }
            .data-table .actions button { font-size: 0.75rem; padding: 0.25rem 0.5rem; }
            .progress-step .step-label { display: none; }
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h2>USANT</h2>
            <span>Communication Letter Tracker</span>
        </div>
        <nav class="sidebar-nav">
            <a href="#" class="active" data-page="dashboard" onclick="navigateTo('dashboard')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="#" data-page="send-letter" onclick="navigateTo('send-letter')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Send Letter
            </a>
            <a href="#" data-page="review-letters" onclick="navigateTo('review-letters')" style="display:none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M21.5 10.5a7.5 7.5 0 0 1-14 4.5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c5.5 0 10-4.5 10-10"/><path d="M12 22v-5"/></svg>
                Review Letters
            </a>
            <a href="#" data-page="letter-history" onclick="navigateTo('letter-history')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Letter History
            </a>
            <a href="#" data-page="notifications" onclick="navigateTo('notifications')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                Notifications
            </a>
            <a href="#" data-page="profile" onclick="navigateTo('profile')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Profile
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="#" id="logoutBtn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </a>
        </div>
    </aside>

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="hamburger" onclick="toggleSidebar()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="breadcrumb">
                <span>Dashboard</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="current" id="breadcrumbCurrent">Home</span>
            </div>
        </div>
        <div class="header-right">
            <div class="welcome">
                <strong id="welcomeName">Welcome back, Student</strong>
                <span id="welcomeRole">USANT Communication Tracker</span>
            </div>
            <button class="notif-btn" onclick="navigateTo('notifications')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="dot"></span>
            </button>
            <div class="profile-avatar" id="profileAvatar" onclick="navigateTo('profile')">JD</div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">

        <!-- ===================== DASHBOARD HOME ===================== -->
        <div class="page-content active" id="page-dashboard">
            <div class="page-header">
                <h1>Dashboard</h1>
                <p id="dashboardDesc">Overview of your letter activity and quick actions</p>
            </div>

            <div class="stats-grid" id="statsGrid">
                <div class="stat-card total">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div class="stat-number" id="statTotal">0</div>
                    </div>
                    <div class="stat-label" id="statLabelTotal">Total Letters Sent</div>
                </div>
                <div class="stat-card pending">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="stat-number" id="statPending">0</div>
                    </div>
                    <div class="stat-label" id="statLabelPending">Pending Letters</div>
                </div>
                <div class="stat-card approved">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <div class="stat-number" id="statApproved">0</div>
                    </div>
                    <div class="stat-label" id="statLabelApproved">Approved Letters</div>
                </div>
                <div class="stat-card rejected">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        </div>
                        <div class="stat-number" id="statRejected">0</div>
                    </div>
                    <div class="stat-label" id="statLabelRejected">Rejected Letters</div>
                </div>
            </div>

            <div class="content-grid">
                <div class="card">
                    <div class="card-header">
                        <h3>Recent Letter Activity</h3>
                        <span class="card-link" onclick="navigateTo('letter-history')">View All</span>
                    </div>
                    <div class="card-body">
                        <div id="loadingSkeleton" style="display:none;">
                            <div class="skeleton" style="height:2.5rem; margin-bottom:0.75rem;"></div>
                            <div class="skeleton" style="height:2.5rem; margin-bottom:0.75rem;"></div>
                            <div class="skeleton" style="height:2.5rem;"></div>
                        </div>
                        <div id="activityEmpty" class="empty-state" style="display:none;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            <h4>No letters yet</h4>
                            <p>Start by sending your first letter.</p>
                        </div>
                        <table class="activity-table" id="activityTable">
                            <thead><tr><th>Letter Title</th><th>Date</th><th>Office</th><th>Status</th></tr></thead>
                            <tbody id="activityBody"></tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <div class="quick-action" id="qaSendLetter" onclick="navigateTo('send-letter')">
                                <div class="qa-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                </div>
                                <div class="qa-text">
                                    <strong>Upload New Letter</strong>
                                    <span>Submit a PDF letter for processing</span>
                                </div>
                                <div class="qa-arrow">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                </div>
                            </div>
                            <div class="quick-action" id="qaReviewLetters" onclick="navigateTo('review-letters')" style="display:none;">
                                <div class="qa-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M21.5 10.5a7.5 7.5 0 0 1-14 4.5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c5.5 0 10-4.5 10-10"/><path d="M12 22v-5"/></svg>
                                </div>
                                <div class="qa-text">
                                    <strong>Review Pending Letters</strong>
                                    <span>Process incoming letters for your office</span>
                                </div>
                                <div class="qa-arrow">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                </div>
                            </div>
                            <div class="quick-action" onclick="navigateTo('letter-history')">
                                <div class="qa-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                </div>
                                <div class="qa-text">
                                    <strong>View Letter History</strong>
                                    <span>Browse all your letters</span>
                                </div>
                                <div class="qa-arrow">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                </div>
                            </div>
                            <div class="quick-action" onclick="navigateTo('letter-history')">
                                <div class="qa-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                                <div class="qa-text">
                                    <strong>Track Letter Status</strong>
                                    <span>Check the progress of your letters</span>
                                </div>
                                <div class="qa-arrow">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================== SEND LETTER ===================== -->
        <div class="page-content" id="page-send-letter">
            <div class="page-header">
                <h1>Send Letter</h1>
                <p>Upload a PDF letter to send to a recipient office</p>
            </div>

            <div class="card" style="max-width:680px;">
                <div class="card-body" style="padding:2rem;">
                    <div id="uploadFormContainer">
                        <div class="upload-form">
                            <div class="form-row">
                                <label for="letterTitle">Letter Title</label>
                                <input type="text" id="letterTitle" placeholder="e.g. Request for IT Equipment">
                            </div>
                            <div class="form-row">
                                <label for="recipientOffice">Recipient Office</label>
                                <select id="recipientOffice">
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
                            <div class="form-row">
                                <label>Upload PDF File</label>
                                <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
                                    <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <h3>Drag and drop your PDF letter here</h3>
                                    <p>or click to browse files</p>
                                    <div class="file-types">PDF files only &middot; Max 10MB</div>
                                </div>
                                <input type="file" id="fileInput" accept=".pdf" style="display:none;" onchange="handleFileSelect(event)">
                                <div id="fileInfo" style="display:none; margin-top:0.75rem; padding:0.75rem 1rem; background:#f9fafb; border-radius:0.5rem; font-size:0.9375rem;">
                                    <strong id="fileName"></strong><br>
                                    <span id="fileSize" style="color:#6b7280;"></span>
                                </div>
                                <div id="fileError" style="display:none; margin-top:0.5rem; color:#ef4444; font-size:0.875rem;"></div>
                            </div>
                            <button class="btn-primary" onclick="submitLetter()" id="submitLetterBtn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                Submit Letter
                            </button>
                        </div>
                    </div>

                    <div class="upload-success" id="uploadSuccess">
                        <svg class="success-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <h3>Letter Submitted Successfully!</h3>
                        <p>Your letter has been sent for processing.</p>
                        <div class="file-info">
                            <strong>Letter:</strong> <span id="successLetterTitle"></span><br>
                            <strong>Office:</strong> <span id="successOffice"></span><br>
                            <strong>File:</strong> <span id="successFileName"></span><br>
                            <strong>Date:</strong> <span id="successDate"></span><br>
                            <strong>Tracking #:</strong> <span id="successTracking"></span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-step completed">
                                <div class="step-dot">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <span class="step-label">Submitted</span>
                            </div>
                            <div class="progress-line completed"></div>
                            <div class="progress-step active">
                                <div class="step-dot">2</div>
                                <span class="step-label">Under Review</span>
                            </div>
                            <div class="progress-line"></div>
                            <div class="progress-step">
                                <div class="step-dot">3</div>
                                <span class="step-label">Final Decision</span>
                            </div>
                        </div>
                        <button class="btn-primary" style="margin-top:1.5rem;" onclick="resetUpload()">Send Another Letter</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================== REVIEW LETTERS (OFFICIAL) ===================== -->
        <div class="page-content" id="page-review-letters">
            <div class="page-header">
                <h1>Review Letters</h1>
                <p>Review and process incoming letters assigned to your office</p>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="toolbar">
                        <input class="search-input" type="text" id="reviewSearch" placeholder="Search letters..." oninput="renderReviewLetters()">
                        <select class="filter-select" id="reviewFilter" onchange="renderReviewLetters()">
                            <option value="">All Status</option>
                            <option value="Pending">Pending</option>
                            <option value="In Review">In Review</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <div id="reviewEmpty" class="empty-state" style="display:none;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M21.5 10.5a7.5 7.5 0 0 1-14 4.5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c5.5 0 10-4.5 10-10"/><path d="M12 22v-5"/></svg>
                        <h4>No letters to review</h4>
                        <p>All incoming letters have been processed.</p>
                    </div>
                    <table class="data-table" id="reviewTable">
                        <thead>
                            <tr>
                                <th>Letter Name</th>
                                <th>Submitted By</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="reviewBody"></tbody>
                    </table>
                    <div class="pagination" id="reviewPagination"></div>
                </div>
            </div>
        </div>

        <!-- ===================== LETTER HISTORY ===================== -->
        <div class="page-content" id="page-letter-history">
            <div class="page-header">
                <h1>Letter History</h1>
                <p>View and manage all your submitted letters</p>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="toolbar">
                        <input class="search-input" type="text" id="historySearch" placeholder="Search letters..." oninput="renderHistory()">
                        <select class="filter-select" id="historyFilter" onchange="renderHistory()">
                            <option value="">All Status</option>
                            <option value="Pending">Pending</option>
                            <option value="In Review">In Review</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <div id="historyEmpty" class="empty-state" style="display:none;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        <h4>No letters found</h4>
                        <p>Try adjusting your search or filter.</p>
                    </div>
                    <table class="data-table" id="historyTable">
                        <thead>
                            <tr>
                                <th>Letter Name</th>
                                <th>Date Submitted</th>
                                <th>Recipient Office</th>
                                <th>Submitted By</th>
                                <th>File Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="historyBody"></tbody>
                    </table>
                    <div class="pagination" id="historyPagination"></div>
                </div>
            </div>
        </div>

        <!-- ===================== NOTIFICATIONS ===================== -->
        <div class="page-content" id="page-notifications">
            <div class="page-header">
                <h1>Notifications</h1>
                <p>Stay updated on your letter status and responses</p>
            </div>
            <div class="card" style="max-width:680px;">
                <div class="card-header">
                    <h3>Recent Updates</h3>
                </div>
                <div class="notif-list" id="notifList">
                    <div id="notifEmpty" class="empty-state" style="display:none;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        <h4>No new notifications</h4>
                        <p>You're all caught up!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================== PROFILE ===================== -->
        <div class="page-content" id="page-profile">
            <div class="page-header">
                <h1>My Profile</h1>
                <p>Manage your personal information and account settings</p>
            </div>
            <div class="card profile-card">
                <div class="card-body" style="padding:2rem;">
                    <div class="profile-header">
                        <div class="profile-avatar-large">JD</div>
                        <div>
                            <h2>Juan Dela Cruz</h2>
                            <p>Student &middot; College of Computer Studies</p>
                        </div>
                    </div>
                    <div class="profile-details">
                        <div class="detail-item">
                            <label>Student Organization</label>
                            <span>IT Society</span>
                        </div>
                        <div class="detail-item">
                            <label>College</label>
                            <span>College of Computer Studies</span>
                        </div>
                        <div class="detail-item">
                            <label>Year Level</label>
                            <span>3rd Year</span>
                        </div>
                        <div class="detail-item">
                            <label>Email Address</label>
                            <span>juan.delacruz@usant.edu.ph</span>
                        </div>
                    </div>

                    <div class="password-section">
                        <h3>Change Password</h3>
                        <div class="password-form">
                            <div class="form-group">
                                <label for="currentPassword">Current Password</label>
                                <input type="password" id="currentPassword" placeholder="Enter current password">
                            </div>
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" id="newPassword" placeholder="Enter new password">
                            </div>
                            <div class="form-group">
                                <label for="confirmNewPassword">Confirm New Password</label>
                                <input type="password" id="confirmNewPassword" placeholder="Confirm new password">
                            </div>
                            <button class="btn-secondary" onclick="changePassword()">Update Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Toast -->
    <div class="toast" id="toast">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span id="toastMessage">Success!</span>
    </div>

    <script src="/js/auth.js"></script>
    <script>
        // ===================== AUTH GUARD =====================
        var currentUser = USANTAuth.getCurrentUser();
        if (!currentUser) { window.location.href = '/'; }

        var isStudent = currentUser.role === 'student';
        var isOfficial = currentUser.role === 'official';

        // ===================== USER SETUP =====================
        var nameParts = currentUser.fullName.split(' ');
        var initials = '';
        for (var ni = 0; ni < nameParts.length && ni < 2; ni++) { initials += nameParts[ni][0]; }
        initials = initials.toUpperCase();

        document.getElementById('profileAvatar').textContent = initials;
        document.getElementById('welcomeName').textContent = 'Welcome back, ' + nameParts[0];
        document.getElementById('welcomeRole').textContent = isStudent ? 'Student &middot; ' + (currentUser.college || '') : 'Official &middot; ' + (currentUser.office || '');

        // Role-specific sidebar and quick actions
        if (isOfficial) {
            var sendLink = document.querySelector('.sidebar-nav a[data-page="send-letter"]');
            if (sendLink) sendLink.style.display = 'none';
            var reviewLink = document.querySelector('.sidebar-nav a[data-page="review-letters"]');
            if (reviewLink) reviewLink.style.display = '';
            var qaSend = document.getElementById('qaSendLetter');
            if (qaSend) qaSend.style.display = 'none';
            var qaReview = document.getElementById('qaReviewLetters');
            if (qaReview) qaReview.style.display = '';
            document.getElementById('dashboardDesc').textContent = 'Overview of incoming letters to your office and review actions';
            document.getElementById('statLabelTotal').textContent = 'Total Received';
            document.getElementById('statLabelPending').textContent = 'Awaiting Review';
        } else {
            document.getElementById('dashboardDesc').textContent = 'Overview of your letter activity and quick actions';
        }

        // Logout
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();
            USANTAuth.logout();
            window.location.href = '/';
        });

        // Protected pages by role
        function protectPageAccess(page) {
            if (page === 'send-letter' && isOfficial) return true;
            if (page === 'review-letters' && isStudent) return true;
            return false;
        }

        // ===================== DATA =====================
        function loadLetters() {
            var stored = localStorage.getItem('usant_letters_all');
            if (stored) return JSON.parse(stored);
            var demo = [
                { id: 1, title: 'Request for IT Equipment', date: '2026-04-28', office: 'SPMO', status: 'Approved', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 2, title: 'Letter of Intent - Internship', date: '2026-04-25', office: 'Dean', status: 'Pending', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 3, title: 'Scholarship Application Support', date: '2026-04-22', office: 'OIC', status: 'In Review', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 4, title: 'Leave of Absence Request', date: '2026-04-20', office: 'Adviser', status: 'Approved', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 5, title: 'Organization Event Permit', date: '2026-04-18', office: 'OSAA', status: 'Rejected', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 6, title: 'Request for Lab Equipment', date: '2026-04-15', office: 'SPMO', status: 'Approved', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 7, title: 'Grade Inquiry Letter', date: '2026-04-12', office: 'Dean', status: 'Pending', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 8, title: 'Transfer Credential Request', date: '2026-04-10', office: 'OIC', status: 'In Review', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 9, title: 'Tutoring Program Proposal', date: '2026-04-08', office: 'Vice President Office', status: 'Pending', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 10, title: 'Financial Assistance Letter', date: '2026-04-05', office: 'Budgeting Office', status: 'Approved', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 11, title: 'Research Ethics Clearance', date: '2026-04-02', office: 'Dean', status: 'Rejected', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName },
                { id: 12, title: 'Capstone Project Endorsement', date: '2026-03-30', office: 'President Office', status: 'Pending', type: 'PDF', senderEmail: currentUser.email, senderName: currentUser.fullName }
            ];
            localStorage.setItem('usant_letters_all', JSON.stringify(demo));
            return demo;
        }

        var allLetters = loadLetters();
        var currentPage = 1;
        var pageSize = 5;
        var selectedFile = null;
        var nextLetterId = allLetters.length + 1;

        function getUserLetters() {
            if (isStudent) {
                return allLetters.filter(function(l) { return l.senderEmail === currentUser.email; });
            } else {
                return allLetters.filter(function(l) { return l.office === currentUser.office; });
            }
        }

        function saveAllLetters() {
            localStorage.setItem('usant_letters_all', JSON.stringify(allLetters));
        }

        var notifications = [
            { id: 1, message: 'Your letter "Request for IT Equipment" has been approved by SPMO.', time: '2 hours ago', type: 'approved' },
            { id: 2, message: 'Your letter "Organization Event Permit" was not approved by OSAA.', time: '1 day ago', type: 'rejected' },
            { id: 3, message: 'Your letter "Scholarship Application Support" is now under review by OIC.', time: '2 days ago', type: 'info' },
            { id: 4, message: 'Your letter "Leave of Absence Request" has been forwarded to the Dean\'s Office.', time: '3 days ago', type: 'forwarded' },
            { id: 5, message: 'Your letter "Letter of Intent - Internship" has been received by the Dean.', time: '4 days ago', type: 'info' }
        ];

        // ===================== HELPERS =====================
        function statusBadge(status) {
            var cls = status.toLowerCase().replace(' ', '-');
            return '<span class="status-badge ' + cls + '">' + status + '</span>';
        }

        function formatDate(dateStr) {
            var d = new Date(dateStr + 'T00:00:00');
            var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            return months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
        }

        // ===================== NAVIGATION =====================
        function navigateTo(page) {
            if (protectPageAccess(page)) {
                showToast('You do not have access to this page.', 'error');
                return;
            }
            document.querySelectorAll('.page-content').forEach(function(el) { el.classList.remove('active'); });
            var target = document.getElementById('page-' + page);
            if (target) target.classList.add('active');

            document.querySelectorAll('.sidebar-nav a').forEach(function(el) { el.classList.remove('active'); });
            var navLink = document.querySelector('.sidebar-nav a[data-page="' + page + '"]');
            if (navLink) navLink.classList.add('active');

            var names = { 'dashboard':'Home', 'send-letter':'Send Letter', 'letter-history':'Letter History', 'notifications':'Notifications', 'profile':'Profile', 'review-letters':'Review Letters' };
            document.getElementById('breadcrumbCurrent').textContent = names[page] || 'Home';

            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('visible');
            }

            if (page === 'dashboard') updateStats();
            if (page === 'letter-history') { currentPage = 1; renderHistory(); }
            if (page === 'review-letters') { currentPage = 1; renderReviewLetters(); }
            if (page === 'profile') updateProfilePage();
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('visible');
        }

        // ===================== STATS =====================
        function updateStats() {
            var myLetters = getUserLetters();
            var total = myLetters.length;
            var pending = myLetters.filter(function(l) { return l.status === 'Pending'; }).length;
            var approved = myLetters.filter(function(l) { return l.status === 'Approved'; }).length;
            var rejected = myLetters.filter(function(l) { return l.status === 'Rejected'; }).length;
            document.getElementById('statTotal').textContent = total;
            document.getElementById('statPending').textContent = pending;
            document.getElementById('statApproved').textContent = approved;
            document.getElementById('statRejected').textContent = rejected;
            renderActivity();
        }

        // ===================== ACTIVITY (Dashboard) =====================
        function renderActivity() {
            var tbody = document.getElementById('activityBody');
            var skeleton = document.getElementById('loadingSkeleton');
            var empty = document.getElementById('activityEmpty');
            var table = document.getElementById('activityTable');

            skeleton.style.display = 'block';
            table.style.display = 'none';
            empty.style.display = 'none';

            setTimeout(function() {
                skeleton.style.display = 'none';
                var myLetters = getUserLetters();
                var recent = myLetters.slice(-5).reverse();
                if (recent.length === 0) {
                    table.style.display = 'none';
                    empty.style.display = 'block';
                    return;
                }
                table.style.display = '';
                empty.style.display = 'none';
                tbody.innerHTML = '';
                recent.forEach(function(l) {
                    tbody.innerHTML += '<tr><td class="letter-title">' + l.title + '</td><td>' + formatDate(l.date) + '</td><td>' + l.office + '</td><td>' + statusBadge(l.status) + '</td></tr>';
                });
            }, 400);
        }

        // ===================== LETTER HISTORY =====================
        function renderHistory() {
            var search = document.getElementById('historySearch').value.toLowerCase();
            var filter = document.getElementById('historyFilter').value;
            var myLetters = getUserLetters();
            var filtered = myLetters.filter(function(l) {
                var matchSearch = l.title.toLowerCase().includes(search);
                var matchFilter = filter === '' || l.status === filter;
                return matchSearch && matchFilter;
            });

            var empty = document.getElementById('historyEmpty');
            var table = document.getElementById('historyTable');
            var tbody = document.getElementById('historyBody');
            var pagination = document.getElementById('historyPagination');

            if (filtered.length === 0) {
                table.style.display = 'none';
                pagination.innerHTML = '';
                empty.style.display = 'block';
                return;
            }
            table.style.display = '';
            empty.style.display = 'none';

            var totalPages = Math.ceil(filtered.length / pageSize);
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            var start = (currentPage - 1) * pageSize;
            var pageItems = filtered.slice(start, start + pageSize);
            tbody.innerHTML = '';
            pageItems.forEach(function(l) {
                tbody.innerHTML += '<tr><td class="letter-title">' + l.title + '</td><td>' + formatDate(l.date) + '</td><td>' + l.office + '</td><td>' + l.senderName + '</td><td>' + l.type + '</td><td>' + statusBadge(l.status) + '</td><td class="actions"><button onclick="showToast(\'Viewing details for ' + l.title.replace(/'/g,"\\'") + '\', \'success\')">View</button><button onclick="showToast(\'Downloading ' + l.title.replace(/'/g,"\\'") + '.pdf\', \'success\')">Download</button><button onclick="showToast(\'Tracking status for ' + l.title.replace(/'/g,"\\'") + '\', \'success\')">Track</button></td></tr>';
            });

            pagination.innerHTML = '';
            var prevDisabled = currentPage <= 1 ? 'disabled' : '';
            pagination.innerHTML += '<button ' + prevDisabled + ' onclick="goToPage(' + (currentPage - 1) + ')">Prev</button>';
            pagination.innerHTML += '<span class="info">Page ' + currentPage + ' of ' + totalPages + '</span>';
            for (var i = 1; i <= totalPages; i++) {
                var active = i === currentPage ? 'active' : '';
                pagination.innerHTML += '<button class="' + active + '" onclick="goToPage(' + i + ')">' + i + '</button>';
            }
            var nextDisabled = currentPage >= totalPages ? 'disabled' : '';
            pagination.innerHTML += '<button ' + nextDisabled + ' onclick="goToPage(' + (currentPage + 1) + ')">Next</button>';
        }

        function goToPage(page) {
            currentPage = page;
            renderHistory();
        }

        // ===================== REVIEW LETTERS (OFFICIAL) =====================
        function renderReviewLetters() {
            var search = (document.getElementById('reviewSearch').value || '').toLowerCase();
            var filter = document.getElementById('reviewFilter').value;
            var myLetters = getUserLetters();
            var filtered = myLetters.filter(function(l) {
                var matchSearch = l.title.toLowerCase().includes(search);
                var matchFilter = filter === '' || l.status === filter;
                return matchSearch && matchFilter;
            });

            var empty = document.getElementById('reviewEmpty');
            var table = document.getElementById('reviewTable');
            var tbody = document.getElementById('reviewBody');
            var pagination = document.getElementById('reviewPagination');

            if (filtered.length === 0) {
                table.style.display = 'none';
                pagination.innerHTML = '';
                empty.style.display = 'block';
                return;
            }
            table.style.display = '';
            empty.style.display = 'none';

            var totalPages = Math.ceil(filtered.length / pageSize);
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            var start = (currentPage - 1) * pageSize;
            var pageItems = filtered.slice(start, start + pageSize);
            tbody.innerHTML = '';
            pageItems.forEach(function(l) {
                var actionsHtml = '';
                if (l.status === 'Pending') {
                    actionsHtml = '<button onclick="updateLetterStatus(' + l.id + ',\'In Review\')" style="background:#3b82f6;color:#fff;border-color:#3b82f6;">Review</button>';
                } else if (l.status === 'In Review') {
                    actionsHtml = '<button onclick="updateLetterStatus(' + l.id + ',\'Approved\')" style="background:#10b981;color:#fff;border-color:#10b981;">Approve</button><button onclick="updateLetterStatus(' + l.id + ',\'Rejected\')" style="background:#ef4444;color:#fff;border-color:#ef4444;">Reject</button>';
                } else {
                    actionsHtml = '<button onclick="showToast(\'Viewing details for ' + l.title.replace(/'/g,"\\'") + '\', \'success\')">View</button>';
                }
                tbody.innerHTML += '<tr><td class="letter-title">' + l.title + '</td><td>' + l.senderName + '</td><td>' + formatDate(l.date) + '</td><td>' + statusBadge(l.status) + '</td><td class="actions">' + actionsHtml + '</td></tr>';
            });

            pagination.innerHTML = '';
            var prevDisabled = currentPage <= 1 ? 'disabled' : '';
            pagination.innerHTML += '<button ' + prevDisabled + ' onclick="goToReviewPage(' + (currentPage - 1) + ')">Prev</button>';
            pagination.innerHTML += '<span class="info">Page ' + currentPage + ' of ' + totalPages + '</span>';
            for (var i = 1; i <= totalPages; i++) {
                var active = i === currentPage ? 'active' : '';
                pagination.innerHTML += '<button class="' + active + '" onclick="goToReviewPage(' + i + ')">' + i + '</button>';
            }
            var nextDisabled = currentPage >= totalPages ? 'disabled' : '';
            pagination.innerHTML += '<button ' + nextDisabled + ' onclick="goToReviewPage(' + (currentPage + 1) + ')">Next</button>';
        }

        function goToReviewPage(page) {
            currentPage = page;
            renderReviewLetters();
        }

        function updateLetterStatus(letterId, newStatus) {
            for (var i = 0; i < allLetters.length; i++) {
                if (allLetters[i].id === letterId) {
                    allLetters[i].status = newStatus;
                    saveAllLetters();
                    var statusLabel = newStatus.toLowerCase();
                    showToast('Letter marked as "' + newStatus + '"', 'success');
                    renderReviewLetters();
                    return;
                }
            }
            showToast('Letter not found.', 'error');
        }

        // ===================== NOTIFICATIONS =====================
        function renderNotifications() {
            var list = document.getElementById('notifList');
            var empty = document.getElementById('notifEmpty');
            var iconSvgs = {
                approved: '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
                rejected: '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>',
                info: '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>',
                forwarded: '<path d="M22 2L11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>'
            };

            if (notifications.length === 0) {
                empty.style.display = 'block';
                return;
            }
            empty.style.display = 'none';

            var existing = list.querySelectorAll('.notif-item');
            existing.forEach(function(el) { el.remove(); });

            notifications.forEach(function(n) {
                var item = document.createElement('div');
                item.className = 'notif-item';
                item.innerHTML = '<div class="notif-icon ' + n.type + '"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + iconSvgs[n.type] + '</svg></div><div class="notif-text"><p>' + n.message + '</p><div class="notif-time">' + n.time + '</div></div>';
                list.appendChild(item);
            });
        }

        // ===================== FILE UPLOAD =====================
        function handleFileSelect(e) {
            var file = e.target.files[0];
            if (!file) return;
            if (file.type !== 'application/pdf') {
                document.getElementById('fileError').style.display = 'block';
                document.getElementById('fileError').textContent = 'Invalid file type. Please upload a PDF file only.';
                document.getElementById('fileInfo').style.display = 'none';
                selectedFile = null;
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                document.getElementById('fileError').style.display = 'block';
                document.getElementById('fileError').textContent = 'File is too large. Maximum size is 10MB.';
                document.getElementById('fileInfo').style.display = 'none';
                selectedFile = null;
                return;
            }
            document.getElementById('fileError').style.display = 'none';
            selectedFile = file;
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            document.getElementById('fileInfo').style.display = 'block';
        }

        var uploadZone = document.getElementById('uploadZone');
        if (uploadZone) {
            uploadZone.addEventListener('dragover', function(e) { e.preventDefault(); uploadZone.classList.add('dragover'); });
            uploadZone.addEventListener('dragleave', function() { uploadZone.classList.remove('dragover'); });
            uploadZone.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadZone.classList.remove('dragover');
                var file = e.dataTransfer.files[0];
                if (file) {
                    document.getElementById('fileInput').files = e.dataTransfer.files;
                    handleFileSelect({ target: { files: [file] } });
                }
            });
        }

        function submitLetter() {
            var title = document.getElementById('letterTitle').value.trim();
            var office = document.getElementById('recipientOffice').value;

            if (!title) { showToast('Please enter a letter title.', 'error'); return; }
            if (!office) { showToast('Please select a recipient office.', 'error'); return; }
            if (!selectedFile) { showToast('Please upload a PDF file.', 'error'); return; }

            allLetters.push({
                id: nextLetterId++,
                title: title,
                date: new Date().toISOString().slice(0,10),
                office: office,
                status: 'Pending',
                type: 'PDF',
                senderEmail: currentUser.email,
                senderName: currentUser.fullName
            });
            saveAllLetters();

            notifications.unshift({
                id: notifications.length + 1,
                message: 'Your letter "' + title + '" has been submitted to ' + office + '.',
                time: 'Just now',
                type: 'info'
            });

            document.getElementById('successLetterTitle').textContent = title;
            document.getElementById('successOffice').textContent = office;
            document.getElementById('successFileName').textContent = selectedFile.name;
            document.getElementById('successDate').textContent = new Date().toLocaleDateString('en-US', { year:'numeric', month:'long', day:'numeric' });
            document.getElementById('successTracking').textContent = 'USANT-' + String(Date.now()).slice(-8);

            document.getElementById('uploadFormContainer').style.display = 'none';
            document.getElementById('uploadSuccess').classList.add('visible');
            showToast('Letter submitted successfully!', 'success');
        }

        function resetUpload() {
            document.getElementById('letterTitle').value = '';
            document.getElementById('recipientOffice').value = '';
            document.getElementById('fileInput').value = '';
            document.getElementById('fileInfo').style.display = 'none';
            document.getElementById('fileError').style.display = 'none';
            selectedFile = null;
            document.getElementById('uploadFormContainer').style.display = 'block';
            document.getElementById('uploadSuccess').classList.remove('visible');
        }

        // ===================== PROFILE =====================
        function updateProfilePage() {
            document.querySelector('#page-profile .profile-avatar-large').textContent = initials;
            document.querySelector('#page-profile .profile-header h2').textContent = currentUser.fullName;
            var roleLabel = isStudent ? 'Student' : 'Official';
            var extraInfo = isStudent ? currentUser.college : currentUser.office;
            document.querySelector('#page-profile .profile-header p').innerHTML = roleLabel + ' &middot; ' + extraInfo;

            if (isStudent) {
                document.querySelector('#page-profile .detail-item:nth-child(1) label').textContent = 'STUDENT ORGANIZATION';
                document.querySelector('#page-profile .detail-item:nth-child(1) span').textContent = currentUser.organization || 'N/A';
                document.querySelector('#page-profile .detail-item:nth-child(2) label').textContent = 'COLLEGE';
                document.querySelector('#page-profile .detail-item:nth-child(2) span').textContent = currentUser.college || 'N/A';
                document.querySelector('#page-profile .detail-item:nth-child(3) label').textContent = 'YEAR LEVEL';
                document.querySelector('#page-profile .detail-item:nth-child(3) span').textContent = currentUser.yearLevel || 'N/A';
                document.querySelector('#page-profile .detail-item:nth-child(4) label').textContent = 'EMAIL ADDRESS';
                document.querySelector('#page-profile .detail-item:nth-child(4) span').textContent = currentUser.email;
            } else {
                document.querySelector('#page-profile .detail-item:nth-child(1) label').textContent = 'ASSIGNED OFFICE';
                document.querySelector('#page-profile .detail-item:nth-child(1) span').textContent = currentUser.office || 'N/A';
                document.querySelector('#page-profile .detail-item:nth-child(2) label').textContent = 'EMAIL ADDRESS';
                document.querySelector('#page-profile .detail-item:nth-child(2) span').textContent = currentUser.email;
                document.querySelector('#page-profile .detail-item:nth-child(3)').style.display = 'none';
                document.querySelector('#page-profile .detail-item:nth-child(4)').style.display = 'none';
            }
        }

        function changePassword() {
            var current = document.getElementById('currentPassword').value;
            var newPw = document.getElementById('newPassword').value;
            var confirm = document.getElementById('confirmNewPassword').value;

            if (!current || !newPw || !confirm) { showToast('Please fill in all password fields.', 'error'); return; }
            if (newPw !== confirm) { showToast('New passwords do not match.', 'error'); return; }
            if (newPw.length < 6) { showToast('Password must be at least 6 characters.', 'error'); return; }

            showToast('Password updated successfully!', 'success');
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmNewPassword').value = '';
        }

        // ===================== TOAST =====================
        function showToast(message, type) {
            var toast = document.getElementById('toast');
            var msg = document.getElementById('toastMessage');
            toast.className = 'toast';
            toast.classList.add('visible');
            if (type) toast.classList.add(type);
            msg.textContent = message;
            clearTimeout(toast._timeout);
            toast._timeout = setTimeout(function() { toast.classList.remove('visible'); }, 3000);
        }

        // ===================== INIT =====================
        updateStats();
        renderNotifications();
        renderHistory();
    </script>
</body>
</html>
