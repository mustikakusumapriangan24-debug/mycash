<style>
    :root {
        --primary-maroon: #580a14;
        --dark-maroon: #38040b;
        --accent-gold: #e6c875;
        --bg-body: #f8fafc;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --card-bg: #ffffff;
        --border-color: #f1f5f9;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar Layout (Diperbarui Menjadi Maroon) */
    sidebar {
        width: 280px;
        background-color: var(--primary-maroon);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: fixed;
        height: 100vh;
        left: 0;
        top: 0;
        z-index: 100;
        color: #ffffff;
    }

    .sidebar-top {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .sidebar-header {
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-logo img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    .sidebar-title h4 {
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
    }

    .sidebar-title span {
        font-size: 11px;
        color: var(--accent-gold);
        font-weight: 600;
    }

    .sidebar-menu {
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        overflow-y: auto;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: rgba(255, 255, 255, 0.75);
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .menu-item:hover, .menu-item.active {
        background-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    .sidebar-profile-wrapper {
        padding: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: linear-gradient(180deg, rgba(56, 4, 11, 0.4) 0%, rgba(35, 2, 6, 0.8) 100%);
    }

    .user-avatar-box {
        width: 36px;
        height: 36px;
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .user-meta h5 {
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
    }

    .user-meta p {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.7);
    }

    .user-meta span {
        font-size: 11px;
        background: var(--accent-gold);
        color: var(--dark-maroon);
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 700;
        display: inline-block;
        margin-top: 4px;
    }

    .btn-profile-action, .btn-logout-sidebar {
        display: block;
        margin-top: 8px;
        text-align: center;
        padding: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 6px;
    }

    .btn-profile-action {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    .btn-logout-sidebar {
        background: rgba(239, 68, 68, 0.2);
        color: #fca5a5;
    }

    /* Main Content Layout */
    .main-content {
        margin-left: 280px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    topbar {
        background: var(--card-bg);
        padding: 20px 32px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .topbar-greeting h2 {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-main);
    }

    .topbar-greeting p {
        font-size: 13px;
        color: var(--text-muted);
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .btn-add-trx {
        background: var(--primary-maroon);
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .class-badge {
        background: #f1f5f9;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dashboard-body {
        padding: 32px;
    }

    .content-view {
        display: none;
    }

    .content-view.active {
        display: block;
    }

    /* Dashboard Grid Styles */
    .stats-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card-item {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
    }

    .stat-card-item.featured {
        background: linear-gradient(135deg, var(--dark-maroon), var(--primary-maroon));
        color: white;
        border: none;
    }

    .stat-card-item.featured .stat-header span,
    .stat-card-item.featured .stat-desc {
        color: rgba(255, 255, 255, 0.8);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 12px;
    }

    .stat-value {
        font-size: 22px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .stat-desc {
        font-size: 11px;
        color: var(--text-muted);
    }

    .dashboard-middle-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    .card-box {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
    }

    .card-box h3 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .chart-placeholder {
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 13px;
        border: 2px dashed var(--border-color);
        border-radius: 8px;
    }

    .info-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
        font-size: 13px;
    }

    .info-list li {
        display: flex;
        justify-content: space-between;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border-color);
    }

    .mt-15 {
        margin-top: 15px;
    }

    /* Table Styling */
    .table-responsive {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table th, .table td {
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-color);
        text-align: left;
    }

    .text-center {
        text-align: center !important;
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        z-index: 1000;
    }

    .modal-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }

    .modal-container {
        background: white;
        width: 100%;
        max-width: 500px;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .modal-header h3 {
        font-size: 18px;
        font-weight: 700;
    }

    .modal-header p {
        font-size: 12px;
        color: var(--text-muted);
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        color: var(--text-muted);
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 6px;
        color: var(--text-main);
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 13px;
        outline: none;
    }

    .form-control:focus {
        border-color: var(--primary-maroon);
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
    }

    .btn-secondary {
        background: #e2e8f0;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
    }

    .btn-primary {
        background: var(--primary-maroon);
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
    }
</style>