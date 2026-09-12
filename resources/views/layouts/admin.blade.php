<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - {{ config('app.name', 'Agontara Foundation') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800|display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @php
        $favicon = $siteBranding['favicon'] ?? '/images/favicon.png';
    @endphp
    <link rel="icon" href="{{ $favicon }}" />
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: {{ $siteBranding['primary_color_hex'] ?? $siteBranding['primary_color'] ?? '#F53003' }};
            --primary-dark: {{ $siteBranding['primary_color_dark'] ?? $siteBranding['primary_color'] ?? '#D42000' }};
            --primary-light: {{ $siteBranding['primary_color_light'] ?? $siteBranding['primary_color'] ?? '#FF6B4A' }};
            --primary-glow: {{ $siteBranding['primary_color_glow'] ?? 'rgba(245, 48, 3, 0.2)' }};
            --secondary: {{ $siteBranding['secondary_color_hex'] ?? $siteBranding['secondary_color'] ?? '#1B1B18' }};
            --secondary-light: {{ $siteBranding['secondary_color_light'] ?? $siteBranding['secondary_color'] ?? '#2A2A27' }};
            --accent: {{ $siteBranding['accent_color_hex'] ?? $siteBranding['accent_color'] ?? '#F8B803' }};
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --info: #3B82F6;
            --dark: #111827;
            --light: #F9FAFB;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
            --surface: #FFFFFF;
            --surface-muted: #F8FAFC;
            --text-strong: #111827;
            --text-body: #374151;
            --text-muted: #6B7280;
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --header-height: 70px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--gray-100);
            color: var(--text-body);
            overflow-x: hidden;
            transition: var(--transition);
        }

        body.dark-mode {
            --gray-50: #111827;
            --gray-100: #1F2937;
            --gray-200: #374151;
            --gray-300: #4B5563;
            --surface: #111827;
            --surface-muted: #1F2937;
            --text-strong: #F9FAFB;
            --text-body: #E5E7EB;
            --text-muted: #D1D5DB;
            background: #0F172A;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(135deg, var(--secondary) 0%, #0a0a0a 100%);
            backdrop-filter: blur(10px);
            transition: var(--transition);
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar.collapsed .sidebar-header h3,
        .sidebar.collapsed .sidebar-header p,
        .sidebar.collapsed .menu-item span {
            display: none;
        }

        .sidebar.collapsed .menu-item {
            justify-content: center;
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .sidebar-header h3 {
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .sidebar-header h3 span {
            color: var(--primary);
        }

        .sidebar-header p {
            font-size: 0.7rem;
            opacity: 0.6;
            margin-top: 0.25rem;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
        }

        .menu-category {
            padding: 1rem 1.5rem 0.5rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.5);
        }

        .menu-item {
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            margin: 0.25rem 0;
        }

        .menu-item:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary);
            transform: scaleY(0);
            transition: var(--transition);
        }

        .menu-item:hover:before,
        .menu-item.active:before {
            transform: scaleY(1);
        }

        .menu-item:hover,
        .menu-item.active {
            background: linear-gradient(90deg, var(--primary-glow) 0%, transparent 100%);
            color: var(--primary);
        }

        .menu-item i {
            width: 24px;
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .menu-item span {
            flex: 1;
            font-weight: 500;
        }

        .menu-badge {
            background: var(--primary);
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: var(--transition);
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed);
        }

        /* Top Header */
        .top-header {
            background: color-mix(in srgb, var(--surface) 96%, transparent);
            backdrop-filter: blur(10px);
            height: var(--header-height);
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 999;
            transition: var(--transition);
        }

        body.dark-mode .top-header {
            background: color-mix(in srgb, var(--surface) 96%, transparent);
            color: white;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .menu-toggle {
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: var(--transition);
        }

        .menu-toggle:hover {
            background: var(--gray-100);
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .notification-btn {
            position: relative;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: var(--transition);
        }

        .notification-btn:hover {
            background: var(--gray-100);
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--danger);
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
            border-radius: 20px;
            min-width: 18px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: var(--transition);
        }

        .user-profile:hover {
            background: var(--gray-100);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
            min-width: 0;
            animation: fadeIn 0.5s ease;
        }

        .dashboard-page {
            max-width: 1320px;
            margin: 0 auto;
            display: grid;
            gap: 1.5rem;
        }

        .dashboard-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            background: rgba(255,255,255,0.92);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 25px 80px rgba(0,0,0,0.08);
            border: 1px solid rgba(245, 48, 3, 0.08);
        }

        body.dark-mode .dashboard-hero {
            background: rgba(31, 41, 55, 0.9);
        }

        .dashboard-hero h1 {
            font-size: clamp(2rem, 2.5vw, 3rem);
            line-height: 1.05;
            margin-bottom: 0.75rem;
        }

        .dashboard-hero p {
            max-width: 560px;
            color: var(--gray-600);
            font-size: 1rem;
            line-height: 1.8;
        }

        body.dark-mode .dashboard-hero p {
            color: var(--gray-300);
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .dashboard-panels {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }

        .panel-card {
            min-height: 100%;
        }

        .summary-card {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .summary-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .summary-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .summary-header p {
            margin: 0.25rem 0 0;
            color: var(--gray-500);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .summary-item {
            padding: 1rem 1.25rem;
            border-radius: 18px;
            background: var(--gray-50);
            box-shadow: inset 0 0 0 1px rgba(16, 185, 129, 0.06);
        }

        body.dark-mode .summary-item {
            background: rgba(255,255,255,0.04);
        }

        .summary-item span {
            display: block;
            color: var(--gray-500);
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        .summary-item strong {
            font-size: 1.4rem;
            display: block;
            margin-top: 0.25rem;
        }

        .progress-stack {
            display: grid;
            gap: 1rem;
        }

        .progress-stack div {
            display: grid;
            gap: 0.5rem;
        }

        .progress-stack span {
            font-weight: 600;
            color: var(--gray-700);
        }

        .progress-bar {
            background: var(--gray-200);
            border-radius: 999px;
            height: 12px;
            overflow: hidden;
        }

        .progress-bar div {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            box-shadow: 0 8px 18px rgba(245, 48, 3, 0.18);
        }

        .status-badge {
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .recent-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 100%;
        }

        .recent-table th,
        .recent-table td {
            padding: 1rem 0.75rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .recent-table thead th {
            background: transparent;
            color: var(--gray-600);
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .recent-table tbody tr:hover {
            background: var(--gray-50);
        }

        body.dark-mode .recent-table th,
        body.dark-mode .recent-table td {
            border-color: rgba(255,255,255,0.08);
        }

        body.dark-mode .recent-table tbody tr:hover {
            background: rgba(255,255,255,0.05);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        body.dark-mode .stat-card {
            background: var(--gray-800);
            color: white;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }

        .stat-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(245,48,3,0.1), rgba(245,48,3,0.05));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-icon i {
            font-size: 2rem;
            color: var(--primary);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0.5rem 0;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat-label {
            color: var(--gray-500);
            font-weight: 500;
        }

        .stat-trend {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        /* Data Table */
        .data-table {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        }

        body.dark-mode .data-table {
            background: var(--gray-800);
            color: white;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px var(--primary-glow);
        }

        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-700);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            background: var(--gray-300);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: white;
        }

        /* Table Styles */
        .dataTables_wrapper {
            overflow-x: auto;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        table.dataTable thead th {
            padding: 1rem;
            background: var(--gray-50);
            color: var(--gray-600);
            font-weight: 600;
            border-bottom: none;
        }

        body.dark-mode table.dataTable thead th {
            background: var(--gray-700);
            color: var(--gray-300);
        }

        table.dataTable tbody tr {
            background: white;
            transition: var(--transition);
        }

        body.dark-mode table.dataTable tbody tr {
            background: var(--gray-800);
        }

        table.dataTable tbody tr:hover {
            background: var(--gray-50);
            transform: scale(1.01);
        }

        table.dataTable tbody td {
            padding: 1rem;
            border: none;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .btn-edit {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .btn-edit:hover {
            background: var(--success);
            color: white;
            transform: scale(1.1);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
            transform: scale(1.1);
        }

        .btn-view {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }

        .btn-view:hover {
            background: var(--info);
            color: white;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-completed {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease;
        }

        body.dark-mode .modal-content {
            background: var(--gray-800);
            color: white;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background: white;
            z-index: 1;
        }

        body.dark-mode .modal-header {
            background: var(--gray-800);
            border-color: var(--gray-700);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            position: sticky;
            bottom: 0;
            background: white;
        }

        body.dark-mode .modal-footer {
            background: var(--gray-800);
            border-color: var(--gray-700);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        body.dark-mode .form-group label {
            color: var(--gray-300);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-family: inherit;
            transition: var(--transition);
            background: white;
        }

        body.dark-mode .form-group input,
        body.dark-mode .form-group select,
        body.dark-mode .form-group textarea {
            background: var(--gray-700);
            border-color: var(--gray-600);
            color: white;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .cms-form-container {
            border-top: 4px solid var(--primary);
            overflow: hidden;
        }

        .cms-form-container form {
            width: 100%;
        }

        .cms-form-container small {
            color: var(--text-muted);
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: .75rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .form-control {
            display: block;
        }

        input[type="checkbox"] {
            accent-color: var(--primary);
        }

        /* Loading Spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .dashboard-panels {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .content-area {
                padding: 1rem;
            }
            .top-header {
                padding: 0 1rem;
            }
            .header-title {
                font-size: 1.15rem;
            }
            .header-right {
                gap: .35rem;
            }
            .user-profile > div {
                display: none;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .dashboard-hero {
                flex-direction: column;
                text-align: center;
            }
            .dashboard-hero p {
                margin: 0 auto;
            }
            .hero-actions {
                justify-content: center;
            }
            .table-header {
                flex-direction: column;
                align-items: stretch;
            }
            .summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">
                <i class="fas fa-hand-holding-heart" style="font-size: 1.5rem; color: white;"></i>
            </div>
            <h3>Agontara <span>CMS</span></h3>
            <p>Content Management System</p>
        </div>
        <div class="sidebar-menu">
            <div class="menu-category">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.cms.index') }}" class="menu-item {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}">
                <i class="fas fa-edit"></i>
                <span>Manage CMS</span>
            </a>
            <a href="#" class="menu-item" data-page="projects">
                <i class="fas fa-project-diagram"></i>
                <span>Projects</span>
            </a>
            <a href="#" class="menu-item" data-page="donations">
                <i class="fas fa-heart"></i>
                <span>Donations</span>
                <span class="menu-badge">12</span>
            </a>
            <a href="#" class="menu-item" data-page="events">
                <i class="fas fa-calendar-alt"></i>
                <span>Events</span>
            </a>
            
            <div class="menu-category">Content</div>
            <a href="#" class="menu-item" data-page="gallery">
                <i class="fas fa-images"></i>
                <span>Gallery</span>
            </a>
            <a href="#" class="menu-item" data-page="blog">
                <i class="fas fa-blog"></i>
                <span>Blog/News</span>
            </a>
            <a href="#" class="menu-item" data-page="team">
                <i class="fas fa-users"></i>
                <span>Team Members</span>
            </a>
            <a href="#" class="menu-item" data-page="testimonials">
                <i class="fas fa-comments"></i>
                <span>Testimonials</span>
            </a>
            
            <div class="menu-category">System</div>
            <a href="{{ route('admin.settings') }}" class="menu-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
            <a href="{{ route('admin.messages.index') }}" class="menu-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <i class="fas fa-inbox"></i>
                <span>Messages</span>
            </a>
            <a href="{{ route('admin.heritage.index') }}" class="menu-item {{ request()->routeIs('admin.heritage.*') ? 'active' : '' }}">
                <i class="fas fa-landmark"></i>
                <span>Cultural Heritage</span>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="menu-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
            <a href="{{ route('admin.board.index') }}" class="menu-item {{ request()->routeIs('admin.board.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i>
                <span>Board Members</span>
            </a>
            <a href="#" class="menu-item" data-page="backup">
                <i class="fas fa-database"></i>
                <span>Backup</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="top-header">
            <div class="header-left">
                <div class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="header-title" id="pageTitle">{{ request()->routeIs('admin.cms.*') ? 'Manage CMS' : (request()->routeIs('admin.settings') ? 'Settings' : 'Dashboard') }}</div>
            </div>
            <div class="header-right">
                <div class="notification-btn" onclick="toggleNotifications()">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
                <div class="theme-toggle" onclick="toggleDarkMode()">
                    <i class="fas fa-moon"></i>
                </div>
                <div class="user-profile" onclick="toggleUserMenu()">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600;">{{ auth()->user()->name ?? 'Administrator' }}</div>
                        <div style="font-size: 0.7rem; opacity: 0.7;">{{ auth()->user()?->getRoleNames()->first() ?? 'Administrator' }}</div>
                    </div>
                    <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                </div>
            </div>
        </div>
        <div class="content-area" id="contentArea">
            @yield('content')
        </div>
    </div>

    <!-- Common Modal -->
    <div id="commonModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle" style="font-size: 1.25rem; font-weight: 700;">Modal Title</h3>
                <i class="fas fa-times" style="cursor: pointer; font-size: 1.25rem;" onclick="closeModal()"></i>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Dynamic form content -->
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal()">Cancel</button>
                <button class="btn-primary" onclick="saveData()">Save Changes</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000",
        };

        let currentPage = 'dashboard';
        let currentData = [];

        // Page configurations
        const pageConfigs = {
            projects: {
                title: 'Manage Projects',
                fields: ['title', 'description', 'goal_amount', 'location', 'status'],
                headers: ['Title', 'Goal Amount', 'Raised', 'Location', 'Status', 'Actions']
            },
            donations: {
                title: 'Manage Donations',
                fields: ['donor_name', 'donor_email', 'amount', 'payment_method', 'status'],
                headers: ['Donor Name', 'Email', 'Amount', 'Payment Method', 'Status', 'Actions']
            },
            events: {
                title: 'Manage Events',
                fields: ['title', 'description', 'date', 'location', 'capacity'],
                headers: ['Title', 'Date', 'Location', 'Capacity', 'Actions']
            },
            gallery: {
                title: 'Manage Gallery',
                fields: ['title', 'image_url', 'category'],
                headers: ['Title', 'Image', 'Category', 'Actions']
            },
            blog: {
                title: 'Manage Blog Posts',
                fields: ['title', 'excerpt', 'content', 'author', 'category'],
                headers: ['Title', 'Author', 'Category', 'Date', 'Actions']
            },
            team: {
                title: 'Manage Team Members',
                fields: ['name', 'role', 'bio', 'image_url', 'social_links'],
                headers: ['Name', 'Role', 'Bio', 'Actions']
            },
            testimonials: {
                title: 'Manage Testimonials',
                fields: ['name', 'role', 'message', 'rating'],
                headers: ['Name', 'Role', 'Message', 'Rating', 'Actions']
            }
        };

        // Enhanced Mock Data
        const mockData = {
            projects: [
                { id: 1, title: 'Clean Water Initiative', description: 'Providing clean water to rural communities', goal_amount: 100000, raised_amount: 45000, location: 'Africa', status: 'active', progress: 45 },
                { id: 2, title: 'School Building Project', description: 'Building schools for underprivileged children', goal_amount: 150000, raised_amount: 78000, location: 'Asia', status: 'active', progress: 52 },
                { id: 3, title: 'Medical Camps', description: 'Free healthcare camps', goal_amount: 80000, raised_amount: 32000, location: 'South America', status: 'active', progress: 40 }
            ],
            donations: [
                { id: 1, donor_name: 'John Doe', donor_email: 'john@example.com', amount: 500, payment_method: 'Credit Card', status: 'completed', date: '2024-03-15' },
                { id: 2, donor_name: 'Jane Smith', donor_email: 'jane@example.com', amount: 1000, payment_method: 'PayPal', status: 'completed', date: '2024-03-14' },
                { id: 3, donor_name: 'Mike Johnson', donor_email: 'mike@example.com', amount: 250, payment_method: 'Bank Transfer', status: 'pending', date: '2024-03-13' }
            ],
            events: [
                { id: 1, title: 'Charity Gala Dinner', description: 'Annual fundraising gala', date: '2024-03-15', location: 'Grand Hall', capacity: 200, registered: 150 },
                { id: 2, title: 'Volunteer Training', description: 'Training for new volunteers', date: '2024-03-22', location: 'Community Center', capacity: 50, registered: 45 },
                { id: 3, title: 'Virtual Marathon', description: 'Online fundraising event', date: '2024-04-05', location: 'Online', capacity: 1000, registered: 678 }
            ],
            gallery: [
                { id: 1, title: 'Community Outreach', image_url: 'https://picsum.photos/400/250', category: 'Events' },
                { id: 2, title: 'School Opening', image_url: 'https://picsum.photos/400/251', category: 'Projects' },
                { id: 3, title: 'Medical Camp', image_url: 'https://picsum.photos/400/252', category: 'Healthcare' }
            ],
            blog: [
                { id: 1, title: 'Clean Water Project Completed', excerpt: 'We have successfully completed...', content: 'Full content here...', author: 'Admin', category: 'Success Story', date: '2024-03-15', views: 1250 },
                { id: 2, title: 'New Partnership Announcement', excerpt: 'Exciting partnership with...', content: 'Full content here...', author: 'Admin', category: 'News', date: '2024-03-10', views: 890 }
            ],
            team: [
                { id: 1, name: 'Dr. James Wilson', role: 'Founder & CEO', bio: '20+ years experience in international development', image_url: 'https://randomuser.me/api/portraits/men/32.jpg', social_links: '{}' },
                { id: 2, name: 'Sarah Martinez', role: 'Programs Director', bio: 'Expert in program management with 15 years experience', image_url: 'https://randomuser.me/api/portraits/women/68.jpg', social_links: '{}' }
            ],
            testimonials: [
                { id: 1, name: 'Sarah Johnson', role: 'Community Leader', message: 'Agontara transformed our community', rating: 5 },
                { id: 2, name: 'Michael Omondi', role: 'Beneficiary', message: 'Their education program changed my life', rating: 5 }
            ]
        };

        // Load page content
        function loadPage(page) {
            currentPage = page;
            document.getElementById('pageTitle').innerHTML = pageConfigs[page]?.title || 'Dashboard';
            
            // Show loading state
            document.getElementById('contentArea').innerHTML = '<div style="text-align: center; padding: 3rem;"><div class="loading-spinner"></div></div>';
            
            setTimeout(() => {
                if (page === 'dashboard') {
                    loadDashboard();
                } else {
                    loadDataTable(page);
                }
            }, 500);
        }

        // Load Dashboard
        function loadDashboard() {
            const totalDonations = mockData.donations.reduce((sum, d) => sum + d.amount, 0);
            const completedProjects = mockData.projects.filter(p => p.status === 'completed').length;
            
            const stats = {
                totalProjects: mockData.projects.length,
                totalDonations: totalDonations,
                totalEvents: mockData.events.length,
                totalVolunteers: 1250,
                completedProjects: completedProjects,
                pendingDonations: mockData.donations.filter(d => d.status === 'pending').length
            };

            const html = `
                <div class="stats-grid">
                    <div class="stat-card" data-aos="fade-up">
                        <div class="stat-icon"><i class="fas fa-project-diagram"></i></div>
                        <div class="stat-number">${stats.totalProjects}</div>
                        <div class="stat-label">Active Projects</div>
                        <div class="stat-trend"><i class="fas fa-arrow-up"></i> +2 this month</div>
                    </div>
                    <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                        <div class="stat-number">$${stats.totalDonations.toLocaleString()}</div>
                        <div class="stat-label">Total Raised</div>
                        <div class="stat-trend"><i class="fas fa-arrow-up"></i> +15%</div>
                    </div>
                    <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-icon"><i class="fas fa-calendar"></i></div>
                        <div class="stat-number">${stats.totalEvents}</div>
                        <div class="stat-label">Upcoming Events</div>
                        <div class="stat-trend"><i class="fas fa-calendar-check"></i> 3 this week</div>
                    </div>
                    <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-number">${stats.totalVolunteers.toLocaleString()}</div>
                        <div class="stat-label">Active Volunteers</div>
                        <div class="stat-trend"><i class="fas fa-user-plus"></i> +45 new</div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="data-table">
                        <div class="table-header">
                            <h3 style="font-weight: 700;">Recent Donations</h3>
                            <button class="btn-secondary" onclick="loadPage('donations')">View All</button>
                        </div>
                        <table class="table" id="recentDonationsTable" width="100%">
                            <thead>
                                <tr><th>Donor</th><th>Amount</th><th>Status</th><th>Date</th></tr>
                            </thead>
                            <tbody>
                                ${mockData.donations.slice(0,5).map(d => `
                                    <tr>
                                        <td><strong>${d.donor_name}</strong><br><small style="color: var(--gray-500);">${d.donor_email}</small></td>
                                        <td><span style="font-weight: 700; color: var(--primary);">$${d.amount}</span></td>
                                        <td><span class="status-badge status-${d.status}">${d.status}</span></td>
                                        <td>${d.date}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                    <div class="data-table">
                        <div class="table-header">
                            <h3 style="font-weight: 700;">Project Progress</h3>
                            <button class="btn-secondary" onclick="loadPage('projects')">View All</button>
                        </div>
                        <canvas id="projectsChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 1.5rem;">
                    <div class="data-table">
                        <div class="table-header">
                            <h3 style="font-weight: 700;">Upcoming Events</h3>
                            <button class="btn-secondary" onclick="loadPage('events')">View All</button>
                        </div>
                        ${mockData.events.slice(0,3).map(event => `
                            <div style="padding: 1rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong>${event.title}</strong><br>
                                    <small style="color: var(--gray-500);"><i class="fas fa-calendar"></i> ${event.date} | <i class="fas fa-map-marker-alt"></i> ${event.location}</small>
                                </div>
                                <span class="status-badge status-active">${event.registered}/${event.capacity} Registered</span>
                            </div>
                        `).join('')}
                    </div>
                    <div class="data-table">
                        <div class="table-header">
                            <h3 style="font-weight: 700;">Recent Blog Posts</h3>
                            <button class="btn-secondary" onclick="loadPage('blog')">View All</button>
                        </div>
                        ${mockData.blog.slice(0,3).map(blog => `
                            <div style="padding: 1rem; border-bottom: 1px solid var(--gray-200);">
                                <strong>${blog.title}</strong><br>
                                <small style="color: var(--gray-500);"><i class="fas fa-user"></i> ${blog.author} | <i class="fas fa-eye"></i> ${blog.views} views</small>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
            
            document.getElementById('contentArea').innerHTML = html;
            
            // Load chart
            const ctx = document.getElementById('projectsChart')?.getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: mockData.projects.map(p => p.title),
                        datasets: [{
                            data: mockData.projects.map(p => (p.raised_amount / p.goal_amount) * 100),
                            backgroundColor: ['#F53003', '#FF6B4A', '#FF8F6A'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        }

        // Load Data Table
        function loadDataTable(page) {
            const config = pageConfigs[page];
            const data = mockData[page];
            
            let tableHtml = `
                <div class="data-table">
                    <div class="table-header">
                        <h3 style="font-weight: 700;">${config.title}</h3>
                        <button class="btn-primary" onclick="openAddModal('${page}')">
                            <i class="fas fa-plus"></i> Add New
                        </button>
                    </div>
                    <table class="table" id="dataTable" width="100%">
                        <thead>
                            <tr>
                                ${config.headers.map(h => `<th>${h}</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody>
                            ${data.map(item => `
                                <tr>
                                    ${config.fields.map(field => {
                                        if (field === 'status') {
                                            return `<td><span class="status-badge status-${item[field]}">${item[field]}</span></td>`;
                                        } else if (field === 'image_url') {
                                            return `<td><img src="${item[field]}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;"></td>`;
                                        } else {
                                            return `<td>${item[field] || '-'}</td>`;
                                        }
                                    }).join('')}
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon btn-view" onclick="viewItem('${page}', ${item.id})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-icon btn-edit" onclick="openEditModal('${page}', ${item.id})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-delete" onclick="deleteItem('${page}', ${item.id})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
            
            document.getElementById('contentArea').innerHTML = tableHtml;
            
            // Initialize DataTable with enhanced options
            $('#dataTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries"
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
            });
        }

        // Open Add Modal
        function openAddModal(page) {
            const config = pageConfigs[page];
            const fields = config.fields;
            
            let formHtml = '';
            fields.forEach(field => {
                if (field === 'description' || field === 'content' || field === 'bio' || field === 'message') {
                    formHtml += `
                        <div class="form-group">
                            <label>${field.replace('_', ' ').toUpperCase()}</label>
                            <textarea name="${field}" rows="4" placeholder="Enter ${field}..."></textarea>
                        </div>
                    `;
                } else {
                    formHtml += `
                        <div class="form-group">
                            <label>${field.replace('_', ' ').toUpperCase()}</label>
                            <input type="text" name="${field}" placeholder="Enter ${field}...">
                        </div>
                    `;
                }
            });
            
            document.getElementById('modalTitle').innerHTML = `<i class="fas fa-plus-circle"></i> Add New ${page.slice(0, -1)}`;
            document.getElementById('modalBody').innerHTML = formHtml;
            document.getElementById('commonModal').style.display = 'flex';
            window.currentAction = { type: 'add', page: page };
        }

        // Open Edit Modal
        function openEditModal(page, id) {
            const data = mockData[page].find(item => item.id === id);
            const config = pageConfigs[page];
            
            let formHtml = '';
            config.fields.forEach(field => {
                const value = data[field] || '';
                if (field === 'description' || field === 'content' || field === 'bio' || field === 'message') {
                    formHtml += `
                        <div class="form-group">
                            <label>${field.replace('_', ' ').toUpperCase()}</label>
                            <textarea name="${field}" rows="4">${value}</textarea>
                        </div>
                    `;
                } else {
                    formHtml += `
                        <div class="form-group">
                            <label>${field.replace('_', ' ').toUpperCase()}</label>
                            <input type="text" name="${field}" value="${value}">
                        </div>
                    `;
                }
            });
            
            document.getElementById('modalTitle').innerHTML = `<i class="fas fa-edit"></i> Edit ${page.slice(0, -1)}`;
            document.getElementById('modalBody').innerHTML = formHtml;
            document.getElementById('commonModal').style.display = 'flex';
            window.currentAction = { type: 'edit', page: page, id: id };
        }

        // View Item
        function viewItem(page, id) {
            const item = mockData[page].find(i => i.id === id);
            let detailsHtml = '<div style="line-height: 2;">';
            for (let [key, value] of Object.entries(item)) {
                detailsHtml += `<strong>${key.replace('_', ' ').toUpperCase()}:</strong> ${value}<br>`;
            }
            detailsHtml += '</div>';
            
            document.getElementById('modalTitle').innerHTML = `<i class="fas fa-info-circle"></i> ${page.slice(0, -1)} Details`;
            document.getElementById('modalBody').innerHTML = detailsHtml;
            document.getElementById('commonModal').style.display = 'flex';
            document.querySelector('.modal-footer').style.display = 'none';
            
            // Restore footer after modal closes
            const closeHandler = () => {
                document.querySelector('.modal-footer').style.display = 'flex';
                document.getElementById('commonModal').removeEventListener('click', closeHandler);
            };
            document.getElementById('commonModal').addEventListener('click', closeHandler);
        }

        // Save Data
        function saveData() {
            const form = document.querySelector('#modalBody');
            const inputs = form.querySelectorAll('input, textarea, select');
            const data = {};
            
            inputs.forEach(input => {
                data[input.name] = input.value;
            });
            
            if (window.currentAction.type === 'add') {
                data.id = mockData[window.currentAction.page].length + 1;
                data.created_at = new Date().toISOString().split('T')[0];
                mockData[window.currentAction.page].push(data);
                toastr.success('Item added successfully!');
            } else {
                const index = mockData[window.currentAction.page].findIndex(i => i.id === window.currentAction.id);
                if (index !== -1) {
                    mockData[window.currentAction.page][index] = { ...mockData[window.currentAction.page][index], ...data };
                    toastr.success('Item updated successfully!');
                }
            }
            
            closeModal();
            loadPage(window.currentAction.page);
        }

        // Delete Item
        function deleteItem(page, id) {
            if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                const index = mockData[page].findIndex(i => i.id === id);
                if (index !== -1) {
                    mockData[page].splice(index, 1);
                    toastr.success('Item deleted successfully!');
                    loadPage(page);
                }
            }
        }

        // Close Modal
        function closeModal() {
            document.getElementById('commonModal').style.display = 'none';
            document.querySelector('.modal-footer').style.display = 'flex';
        }

        // Toggle Sidebar
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        // Toggle Dark Mode
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
            toastr.info(`Dark mode ${document.body.classList.contains('dark-mode') ? 'enabled' : 'disabled'}`);
        }

        // Load saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }

        // Toggle Notifications
        function toggleNotifications() {
            toastr.info('You have 3 unread notifications');
        }

        // Toggle User Menu
        function toggleUserMenu() {
            toastr.info('User menu would open here');
        }

        // Initialize
        document.querySelectorAll('.menu-item').forEach(item => {
            const href = item.getAttribute('href');
            if (!href || href === '#') {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    document.querySelectorAll('.menu-item').forEach(m => m.classList.remove('active'));
                    item.classList.add('active');
                    loadPage(item.dataset.page);
                });
            }
        });
    </script>
</body>
</html>
