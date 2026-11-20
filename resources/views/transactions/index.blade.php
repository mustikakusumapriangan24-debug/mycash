@php
    $layout = auth()->user()->role === 'wali_kelas'
        ? 'layouts.wali-kelas'
        : 'layouts.bendahara';

    $studentData = collect($students ?? [])->map(function ($student) {
        return [
            'id' => $student->id,
            'name' => $student->name,
            'nis' => $student->nis ?? '-',
        ];
    })->values()->all();
@endphp

@extends($layout)

@section('content')

<style>
    .transactions-page {
        --maroon: #803E2F;
        --maroon-dark: #54251F;
        --maroon-deep: #1F1D20;
        --gold: #B59A63;
        --cream: #F1ECE4;
        --white: #FFFEFC;
        --text: #3E3D38;
        --text-soft: #756E69;
        --border: #DED6CC;
        --green: #56856c;
        --red: #a65353;
        width: 100%;
        color: var(--text);
    }

    .transactions-page *,
    .transactions-page *::before,
    .transactions-page *::after {
        box-sizing: border-box;
    }

    .transactions-page button,
    .transactions-page input,
    .transactions-page select,
    .transactions-page textarea {
        font-family: "Plus Jakarta Sans", sans-serif;
    }

    .page-header { margin-bottom: 25px; }

    .page-header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .page-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 31px;
        font-weight: 700;
    }

    .page-subtitle {
        margin: 8px 0 0;
        color: var(--text-soft);
        font-size: 13px;
    }

    .gold-line {
        width: 42px;
        height: 3px;
        margin-top: 15px;
        border-radius: 10px;
        background: var(--gold);
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .class-info {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 175px;
        padding: 11px 16px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: 0 5px 18px rgba(31,29,32,.04);
    }

    .class-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #f4eee5;
        color: var(--maroon);
    }

    .class-label {
        display: block;
        margin-bottom: 2px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .class-name {
        color: var(--maroon-deep);
        font-size: 12px;
        font-weight: 800;
    }

    .notification-button {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--white);
        color: var(--maroon);
        text-decoration: none;
        cursor: pointer;
    }

    .cash-settings-button {
        min-height: 42px;
        padding: 0 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--white);
        color: var(--maroon);
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .cash-settings-options {
        padding: 15px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: #fcfaf6;
    }

    .cash-mode-option {
        display: block;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: #fff;
        cursor: pointer;
    }

    .cash-mode-option input {
        width: auto;
        margin-right: 7px;
    }

    .cash-mode-option strong { font-size: 11px; }
    .cash-mode-option small {
        display: block;
        margin: 5px 0 0 23px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .cash-quick-amounts {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 8px;
    }

    .cash-quick-amount {
        padding: 6px 9px;
        border: 1px solid var(--border);
        border-radius: 7px;
        background: #fff;
        color: var(--text);
        font-size: 9px;
        font-weight: 700;
        cursor: pointer;
    }

    .cash-month-range {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .cash-settings-note {
        margin-top: 10px;
        color: var(--text-soft);
        font-size: 9px;
        line-height: 1.5;
    }

    .cash-reset-box {
        margin: 0 25px 20px;
        padding: 13px;
        border: 1px solid #e8d8ae;
        border-radius: 11px;
        background: #fffcf4;
    }

    .cash-reset-box strong {
        display: block;
        color: var(--maroon);
        font-size: 10px;
    }

    .cash-reset-box p {
        margin: 5px 0 9px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .cash-reset-button {
        padding: 8px 11px;
        border: 1px solid var(--gold);
        border-radius: 8px;
        background: #fff;
        color: var(--maroon);
        font-size: 9px;
        font-weight: 800;
        cursor: pointer;
    }

    .add-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 22px;
        padding: 11px 17px;
        border: 1px solid var(--maroon);
        border-radius: 11px;
        background: var(--maroon);
        color: #fff;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 7px 18px rgba(128,62,47,.16);
    }

    .add-button:hover,
    .submit-button:hover {
        background: var(--maroon-dark);
    }

    .alert {
        margin-bottom: 18px;
        padding: 13px 16px;
        border-radius: 11px;
        font-size: 12px;
    }

    .alert-success {
        color: #3f6d55;
        background: #edf4ef;
        border: 1px solid #d2e3d7;
    }

    .alert-error {
        color: #934c4c;
        background: #faf0ef;
        border: 1px solid #ead3d0;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 18px;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }

    .summary-card {
        min-height: 132px;
        padding: 21px 22px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 7px 22px rgba(31,29,32,.045);
    }

    .summary-card:first-child {
        background: linear-gradient(145deg,#6d3529,#54251F);
        border-color: transparent;
        color: #fff;
    }

    .summary-label {
        margin-bottom: 10px;
        color: var(--text-soft);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .summary-card:first-child .summary-label {
        color: rgba(255,255,255,.8);
    }

    .summary-value {
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 25px;
        font-weight: 700;
    }

    .summary-card:first-child .summary-value { color: #fff; }
    .summary-income .summary-value { color: var(--green); }
    .summary-expense .summary-value { color: var(--red); }

    .summary-note {
        margin-top: 8px;
        color: var(--text-soft);
        font-size: 10px;
    }

    .summary-card:first-child .summary-note {
        color: rgba(255,255,255,.72);
    }

    .history-card {
        overflow: hidden;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: 0 9px 28px rgba(31,29,32,.05);
    }

    .history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 23px 26px;
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap;
    }

    .history-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 20px;
    }

    .history-description {
        margin: 5px 0 0;
        color: var(--text-soft);
        font-size: 11px;
    }

    .history-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 29px;
        padding: 0 10px;
        border-radius: 9px;
        background: #f4eee5;
        border: 1px solid #e4d9c8;
        color: var(--maroon);
        font-size: 10px;
        font-weight: 800;
    }

    .report-tabs {
        display: flex;
        gap: 8px;
        max-width: 100%;
        margin-bottom: 16px;
        overflow-x: auto;
        padding-bottom: 4px;
        scrollbar-width: thin;
    }

    .report-tab {
        display: inline-flex;
        flex: 0 0 auto;
        align-items: center;
        gap: 8px;
        padding: 11px 15px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: var(--white);
        color: var(--text-soft);
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .report-tab.active {
        border-color: var(--maroon);
        background: var(--maroon);
        color: #fff;
    }

    .report-panel[hidden] {
        display: none;
    }

    .checklist-card {
        overflow: hidden;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: 0 9px 28px rgba(31,29,32,.05);
    }

    .checklist-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 23px 26px;
        border-bottom: 1px solid var(--border);
    }

    .checklist-year-form {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-soft);
        font-size: 11px;
        font-weight: 700;
    }

    .checklist-year-form select {
        min-height: 36px;
        padding: 0 10px;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: #fff;
        color: var(--maroon);
        font: inherit;
    }

    .checklist-search-form {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
    }

    .checklist-search-form label {
        color: var(--text-soft);
        font-size: 10px;
        font-weight: 700;
    }

    .checklist-search-field {
        width: min(100%, 300px);
        min-height: 36px;
        padding: 0 11px;
        border: 1px solid var(--border);
        border-radius: 9px;
        outline: none;
        background: #fff;
        color: var(--text);
        font-size: 11px;
    }

    .checklist-search-field:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(181,154,99,.12);
    }

    .checklist-table-scroll {
        width: 100%;
        overflow-x: auto;
        overscroll-behavior-x: contain;
        -webkit-overflow-scrolling: touch;
        scrollbar-color: var(--gold) #f1ece4;
        scrollbar-width: thin;
    }

    .checklist-table {
        width: 100%;
        min-width: 1120px;
        border-collapse: collapse;
    }

    .checklist-table th,
    .checklist-table td {
        padding: 11px 9px;
        border-bottom: 1px solid #eee9e2;
        font-size: 10px;
        text-align: center;
        white-space: nowrap;
    }

    .checklist-table th {
        background: #f7f3ed;
        color: var(--text-soft);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .checklist-table .checklist-student {
        min-width: 155px;
        text-align: left;
        white-space: normal;
    }

    .checklist-status {
        display: grid;
        justify-items: center;
        gap: 4px;
    }

    .checklist-status-icon.paid {
        color: var(--green);
    }

    .checklist-status-icon.unpaid {
        color: #b9b0a5;
    }

    .checklist-amount {
        color: var(--text-soft);
        font-size: 9px;
    }

    .checklist-amount.paid,
    .checklist-total {
        color: var(--maroon);
        font-weight: 800;
    }

    .checklist-pagination {
        justify-content: space-between;
        flex-wrap: nowrap;
        overflow-x: auto;
    }

    .checklist-page-links {
        display: flex;
        flex: 0 0 auto;
        align-items: center;
        gap: 7px;
    }

    .checklist-pagination .pagination-info {
        flex: 0 0 auto;
        width: auto;
        margin-left: auto;
        white-space: nowrap;
    }

    .checklist-empty {
        padding: 28px !important;
        color: var(--text-soft) !important;
        text-align: center !important;
    }

    .filter-form {
        display: flex;
        align-items: flex-end;
        gap: 9px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-field {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-label {
        color: var(--text-soft);
        font-size: 9px;
        font-weight: 800;
    }

    .search-input,
    .filter-select,
    .filter-date {
        min-width: 145px;
        max-width: 100%;
        padding: 10px 11px;
        border: 1px solid var(--border);
        border-radius: 9px;
        outline: none;
        background: #fff;
        color: var(--text);
        font-size: 10px;
    }

    .search-input { width: 230px; }

    .search-input:focus,
    .filter-select:focus,
    .filter-date:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(181,154,99,.12);
    }

    .search-button,
    .reset-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 13px;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .search-button {
        border: 1px solid var(--maroon);
        background: var(--maroon);
        color: white;
    }

    .reset-button {
        border: 1px solid var(--border);
        background: white;
        color: var(--text);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .transaction-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
    }

    .transaction-table th {
        padding: 13px 17px;
        background: #f7f3ed;
        color: var(--text-soft);
        border-bottom: 1px solid var(--border);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        text-align: left;
        white-space: nowrap;
    }

    .transaction-table td {
        padding: 14px 17px;
        border-bottom: 1px solid #eee9e2;
        color: var(--text);
        font-size: 11px;
        vertical-align: middle;
    }

    .transaction-table tbody tr:hover { background: #fbf8f4; }
    .transaction-table tbody tr:last-child td { border-bottom: none; }

    .date-main {
        color: var(--text);
        font-size: 11px;
        font-weight: 700;
    }

    .date-time {
        margin-top: 3px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .transaction-description {
        max-width: 260px;
        color: var(--text);
        font-size: 11px;
        font-weight: 600;
        line-height: 1.5;
    }

    .transaction-description.empty {
        color: var(--text-soft);
        font-weight: 400;
    }

    .receipt-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 9px;
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--maroon);
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .receipt-link:hover {
        border-color: var(--gold);
        background: #f6f1e9;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 8px;
        border-radius: 7px;
        background: #f6f1e9;
        border: 1px solid #e5dac9;
        color: var(--maroon);
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 8px;
        border-radius: 7px;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .type-income {
        color: var(--green);
        background: #edf4ef;
        border: 1px solid #d4e4d9;
    }

    .type-expense {
        color: var(--red);
        background: #faf0ef;
        border: 1px solid #ead5d1;
    }

    .amount {
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .amount-income { color: var(--green); }
    .amount-expense { color: var(--red); }

    .action-group {
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 9px;
        border-radius: 7px;
        font-size: 9px;
        font-weight: 800;
        cursor: pointer;
    }

    .edit-button {
        background: #f6f1e9;
        border: 1px solid #e5dac9;
        color: var(--maroon);
    }

    .delete-button {
        background: #faf0ef;
        border: 1px solid #ead5d1;
        color: var(--red);
    }

    .empty-state {
        padding: 60px 25px;
        text-align: center;
    }

    .empty-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        border-radius: 15px;
        background: #f6f1e9;
        border: 1px solid #e5dac9;
        color: var(--maroon);
        font-size: 22px;
    }

    .empty-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 17px;
    }

    .empty-description {
        margin: 7px 0 0;
        color: var(--text-soft);
        font-size: 11px;
    }

    /* PAGINATION */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
        padding: 18px;
        border-top: 1px solid var(--border);
    }

    .pagination-arrow,
    .pagination-page {
        min-width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: white;
        color: var(--maroon);
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .pagination-arrow:hover,
    .pagination-page:hover {
        background: #f6f1e9;
        border-color: var(--gold);
    }

    .pagination-page.active {
        background: var(--maroon);
        border-color: var(--maroon);
        color: white;
        cursor: default;
    }

    .pagination-arrow.disabled {
        opacity: .35;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination-info {
        margin-left: 8px;
        color: var(--text-soft);
        font-size: 10px;
    }

    /* MODAL */
    .transactions-modal {
        position: fixed;
        inset: 0;
        z-index: 5000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(31,29,32,.48);
        backdrop-filter: blur(4px);
    }

    .transactions-modal.show { display: flex; }

    .transactions-modal .modal {
        width: 100%;
        max-width: 610px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: 0 25px 70px rgba(31,29,32,.2);
    }

    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 25px 18px;
        border-bottom: 1px solid var(--border);
    }

    .modal-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 20px;
    }

    .modal-description {
        margin: 5px 0 0;
        color: var(--text-soft);
        font-size: 11px;
    }

    .close-button {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: #f7f3ed;
        color: var(--text-soft);
        font-size: 18px;
        cursor: pointer;
    }

    .modal-body { padding: 23px 25px 25px; }
    .form-group { margin-bottom: 17px; }

    .form-label {
        display: block;
        margin-bottom: 7px;
        color: var(--text);
        font-size: 11px;
        font-weight: 800;
    }

    .required { color: var(--maroon); }

    .transactions-modal input,
    .transactions-modal select,
    .transactions-modal textarea {
        width: 100%;
        padding: 11px 13px;
        outline: none;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: #fff;
        color: var(--text);
        font-size: 12px;
    }

    .transactions-modal input:focus,
    .transactions-modal select:focus,
    .transactions-modal textarea:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(181,154,99,.12);
    }

    .transactions-modal textarea {
        min-height: 90px;
        resize: vertical;
    }

    .transactions-modal input[type="file"] {
        padding: 9px;
        font-size: 10px;
    }

    .field-error {
        margin-top: 6px;
        color: #b42318;
        font-size: 10px;
    }

    .radio-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 9px;
    }

    .radio-option { position: relative; }

    .radio-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .radio-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 11px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: #fff;
        color: var(--text);
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .radio-option input:checked + .radio-label {
        border-color: var(--maroon);
        background: rgba(128,62,47,.06);
        color: var(--maroon);
    }

    .student-section { display: none; }
    .student-section.show { display: block; }

    .student-search-wrapper { position: relative; }

    .student-search { padding-left: 38px !important; }

    .search-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-soft);
        pointer-events: none;
    }

    .student-results {
        position: absolute;
        left: 0;
        right: 0;
        z-index: 50;
        display: none;
        max-height: 210px;
        overflow-y: auto;
        margin-top: 6px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        box-shadow: 0 12px 30px rgba(31,29,32,.1);
    }

    .student-results.show { display: block; }

    .student-result {
        padding: 11px 13px;
        border-bottom: 1px solid #eee9e2;
        cursor: pointer;
    }

    .student-result:hover { background: #f8f4ee; }

    .student-name {
        color: var(--text);
        font-size: 11px;
        font-weight: 800;
    }

    .student-nis {
        margin-top: 3px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .no-result {
        padding: 13px;
        color: var(--text-soft);
        font-size: 10px;
        text-align: center;
    }

    .selected-student {
        display: none;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 7px;
        padding: 11px 13px;
        border: 1px solid #e5dac9;
        border-radius: 10px;
        background: #f6f1e9;
    }

    .selected-student.show { display: flex; }

    .selected-name {
        color: var(--maroon-deep);
        font-size: 11px;
        font-weight: 800;
    }

    .selected-nis {
        margin-top: 3px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .change-student {
        border: none;
        background: transparent;
        color: var(--maroon);
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
    }

    .amount-wrapper { position: relative; }

    .amount-prefix {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-soft);
        font-size: 11px;
        font-weight: 800;
        pointer-events: none;
    }

    .amount-input { padding-left: 37px !important; }

    .helper-text {
        margin-top: 5px;
        color: var(--text-soft);
        font-size: 9px;
    }

    .edit-info {
        margin-bottom: 17px;
        padding: 12px 13px;
        border: 1px solid #e5dac9;
        border-radius: 10px;
        background: #f6f1e9;
    }

    .edit-info-label {
        margin-bottom: 4px;
        color: var(--text-soft);
        font-size: 8px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .edit-info-value {
        color: var(--maroon-deep);
        font-size: 11px;
        font-weight: 800;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 7px;
    }

    .cancel-button,
    .submit-button {
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .cancel-button {
        border: 1px solid var(--border);
        background: #fff;
        color: var(--text);
    }

    .submit-button {
        border: none;
        background: var(--maroon);
        color: #fff;
    }

    @media (max-width: 900px) {
        .summary-grid { grid-template-columns: 1fr; }
        .page-header-top { flex-direction: column; }
    }

    @media (max-width: 650px) {
        .page-title { font-size: 25px; }
        .header-actions { width: 100%; }
        .class-info { flex: 1; }
        .filter-form { align-items: stretch; }
        .filter-field { width: 100%; }
        .search-input,
        .filter-select,
        .filter-date { width: 100%; }
        .radio-group { grid-template-columns: 1fr; }
        .transactions-modal { padding: 10px; }
        .cash-reset-box { margin: 0 16px 16px; }
        .transactions-modal .modal {
            max-height: calc(100vh - 20px);
            border-radius: 15px;
        }
        .checklist-header {
            align-items: flex-start;
            flex-wrap: wrap;
            padding: 18px;
        }
        .checklist-search-form {
            align-items: stretch;
            padding: 14px;
        }
        .checklist-search-field {
            width: 100%;
            flex: 1 1 100%;
        }
        .modal-footer { flex-direction: column-reverse; }
        .cancel-button,
        .submit-button { width: 100%; }

        .pagination-wrapper {
            gap: 5px;
            padding: 15px 8px;
        }

        .pagination-arrow,
        .pagination-page {
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
        }

        .pagination-info {
            width: 100%;
            margin: 7px 0 0;
            text-align: center;
        }
    }
</style>

<div class="transactions-page">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-header-top">
            <div>
                <h1 class="page-title">Transaksi Kas</h1>
                <p class="page-subtitle">
                    Kelola dan pantau seluruh transaksi kas MyCash.
                </p>
                <div class="gold-line"></div>
            </div>

            <div class="header-actions">
                <div class="class-info">
                    <div class="class-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <span class="class-label">Kelas</span>
                        <span class="class-name">XI RPL 1</span>
                    </div>
                </div>

                <button
                    type="button"
                    class="cash-settings-button"
                    id="openCashSettingsButton"
                    aria-label="Pengaturan aturan kas kelas"
                    title="Pengaturan aturan kas kelas"
                >
                    <i class="fa-solid fa-gear"></i>
                    Aturan Kas
                </button>

                <a
                    href="{{ route('pengumuman.index') }}"
                    class="notification-button"
                    aria-label="Pengumuman dan notifikasi"
                    title="Pengumuman dan notifikasi"
                >
                    <i class="fa-regular fa-bell"></i>
                </a>
            </div>
        </div>

        <button type="button" class="add-button" id="openModalButton">
            <i class="fa-solid fa-plus"></i>
            Tambah Transaksi
        </button>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- RINGKASAN --}}
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Total Pemasukan</div>
            <div class="summary-value">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </div>
            <div class="summary-note">Total kas masuk</div>
        </div>

        <div class="summary-card summary-income">
            <div class="summary-label">Total Pengeluaran</div>
            <div class="summary-value">
                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
            </div>
            <div class="summary-note">Total kas keluar</div>
        </div>

        <div class="summary-card summary-expense">
            <div class="summary-label">Saldo Bersih</div>
            <div class="summary-value">
                Rp {{ number_format($totalSaldo, 0, ',', '.') }}
            </div>
            <div class="summary-note">Pemasukan − Pengeluaran</div>
        </div>
    </div>

    <nav class="report-tabs" role="tablist" aria-label="Pilih tampilan transaksi">
        <button
            type="button"
            class="report-tab {{ $activeReportTable === 'transactions' ? 'active' : '' }}"
            id="transactionsTab"
            role="tab"
            aria-controls="transactionReport"
            aria-selected="{{ $activeReportTable === 'transactions' ? 'true' : 'false' }}"
            onclick="showTransactionReport('transactions')"
        >
            <i class="fa-solid fa-list"></i>
            Riwayat Transaksi
        </button>
        <button
            type="button"
            class="report-tab {{ $activeReportTable === 'payments' ? 'active' : '' }}"
            id="paymentsTab"
            role="tab"
            aria-controls="paymentReport"
            aria-selected="{{ $activeReportTable === 'payments' ? 'true' : 'false' }}"
            onclick="showTransactionReport('payments')"
        >
            <i class="fa-solid fa-clipboard-check"></i>
            Ceklis Pembayaran Kas
        </button>
    </nav>

    {{-- RIWAYAT TRANSAKSI --}}
    <section
        class="report-panel"
        id="transactionReport"
        role="tabpanel"
        aria-labelledby="transactionsTab"
        @if($activeReportTable !== 'transactions') hidden @endif
    >
    <div class="history-card">
        <div class="history-header">
            <div>
                <h2 class="history-title">Riwayat Transaksi</h2>
                <p class="history-description">
                    Daftar pemasukan dan pengeluaran yang telah dicatat.
                </p>
            </div>

            <div class="history-count">
                {{ $transactions->total() }} Transaksi
            </div>

            {{-- FORM FILTER --}}
            <form
                action="{{ route('transactions.index') }}"
                method="GET"
                class="filter-form"
            >
                <input
                    type="hidden"
                    name="year"
                    value="{{ $selectedYear }}"
                >
                <input type="hidden" name="report_table" value="transactions">

                <div class="filter-field">
                    <label class="filter-label">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari kategori atau keterangan..."
                        value="{{ $search ?? '' }}"
                    >
                </div>

                <div class="filter-field">
                    <label class="filter-label">Jenis Transaksi</label>
                    <select name="type" class="filter-select">
                        <option value="">Semua Jenis</option>
                        <option value="in" {{ ($type ?? '') === 'in' ? 'selected' : '' }}>
                            Kas Masuk (+)
                        </option>
                        <option value="out" {{ ($type ?? '') === 'out' ? 'selected' : '' }}>
                            Kas Keluar (-)
                        </option>
                    </select>
                </div>

                <div class="filter-field">
                    <label class="filter-label">Kategori</label>
                    <select name="category" class="filter-select">
                        <option value="">Semua Kategori</option>

                        <optgroup label="Pemasukan">
                            @foreach($incomeCategories as $item)
                                <option
                                    value="{{ $item }}"
                                    {{ ($category ?? '') === $item ? 'selected' : '' }}
                                >
                                    {{ $item }}
                                </option>
                            @endforeach
                        </optgroup>

                        <optgroup label="Pengeluaran">
                            @foreach($expenseCategories as $item)
                                <option
                                    value="{{ $item }}"
                                    {{ ($category ?? '') === $item ? 'selected' : '' }}
                                >
                                    {{ $item }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <div class="filter-field">
                    <label class="filter-label">Dari Tanggal</label>
                    <input
                        type="date"
                        name="from_date"
                        class="filter-date"
                        value="{{ $fromDate ?? '' }}"
                    >
                </div>

                <div class="filter-field">
                    <label class="filter-label">Sampai Tanggal</label>
                    <input
                        type="date"
                        name="to_date"
                        class="filter-date"
                        value="{{ $toDate ?? '' }}"
                    >
                </div>

                <button type="submit" class="search-button">
                    <i class="fa-solid fa-filter"></i>
                    Filter
                </button>

                <a
                    href="{{ route('transactions.index', ['year' => $selectedYear, 'report_table' => 'transactions']) }}"
                    class="reset-button"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset Filter
                </a>
            </form>
        </div>

        {{-- TABEL TRANSAKSI --}}
        @if($transactions->count() > 0)
            <div class="table-wrapper">
                <table class="transaction-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Siswa / Keterangan</th>
                            <th>Bukti Nota / Kwitansi</th>
                            <th>Nominal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>
                                    <div class="date-main">
                                        {{ $transaction->created_at ? $transaction->created_at->format('d M Y') : '-' }}
                                    </div>
                                    <div class="date-time">
                                        {{ $transaction->created_at ? $transaction->created_at->format('H:i') : '-' }}
                                    </div>
                                </td>

                                <td>
                                    @if($transaction->type === 'in')
                                        <span class="type-badge type-income">
                                            ↑ Pemasukan
                                        </span>
                                    @else
                                        <span class="type-badge type-expense">
                                            ↓ Pengeluaran
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="category-badge">
                                        @if($transaction->category === 'Kas Siswa')
                                            Iuran Kas Siswa
                                        @elseif($transaction->category === 'Lainnya')
                                            Pemasukan Lainnya
                                        @else
                                            {{ $transaction->category ?? '-' }}
                                        @endif
                                    </span>
                                </td>

                                <td>
                                    @if($transaction->description)
                                        <div class="transaction-description">
                                            {{ $transaction->description }}
                                        </div>
                                    @else
                                        <div class="transaction-description empty">
                                            Tidak ada keterangan
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    @if($transaction->receipt_path)
                                        <a
                                            href="{{ asset('storage/' . $transaction->receipt_path) }}"
                                            class="receipt-link"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            <i class="fa-solid fa-image"></i>
                                            Lihat bukti
                                        </a>
                                    @else
                                        <span class="transaction-description empty">-</span>
                                    @endif
                                </td>

                                <td>
                                    @if($transaction->type === 'in')
                                        <span class="amount amount-income">
                                            + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="amount amount-expense">
                                            - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="action-group">
                                        <button
                                            type="button"
                                            class="action-button edit-button"
                                            onclick="openEditModal(
                                                {{ $transaction->id }},
                                                @js($transaction->type),
                                                @js($transaction->category),
                                                @js($transaction->amount),
                                                @js($transaction->description)
                                            )"
                                        >
                                            Edit
                                        </button>

                                        <form
                                            action="{{ route('transactions.destroy', $transaction->id) }}"
                                            method="POST"
                                            onsubmit="return confirmDelete(
                                                @js($transaction->category === 'Kas Siswa'
                                                    ? 'Transaksi Kas Siswa ini akan dihapus dan alokasi pembayaran yang terhubung akan dikosongkan.'
                                                    : 'Transaksi ini akan dihapus.')
                                            )"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-button delete-button"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>

                <h3 class="empty-title">
                    Transaksi Tidak Ditemukan
                </h3>

                <p class="empty-description">
                    Tidak ada transaksi yang sesuai dengan pencarian atau filter.
                </p>
            </div>
        @endif

        {{-- PAGINATION --}}
        @if($transactions->total() > 0)
            <div class="pagination-wrapper">

                {{-- TOMBOL SEBELUMNYA --}}
                @if($transactions->onFirstPage())
                    <span class="pagination-arrow disabled">
                        <i class="fa-solid fa-chevron-left"></i>
                    </span>
                @else
                    <a
                        href="{{ $transactions->previousPageUrl() }}"
                        class="pagination-arrow"
                        aria-label="Halaman sebelumnya"
                    >
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                {{-- NOMOR HALAMAN --}}
                @foreach(
                    $transactions->getUrlRange(
                        max(1, $transactions->currentPage() - 2),
                        min($transactions->lastPage(), $transactions->currentPage() + 2)
                    ) as $page => $url
                )
                    @if($transactions->currentPage() == $page)
                        <span
                            class="pagination-page active"
                            aria-current="page"
                        >
                            {{ $page }}
                        </span>
                    @else
                        <a
                            href="{{ $url }}"
                            class="pagination-page"
                            aria-label="Halaman {{ $page }}"
                        >
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- TOMBOL BERIKUTNYA --}}
                @if($transactions->hasMorePages())
                    <a
                        href="{{ $transactions->nextPageUrl() }}"
                        class="pagination-arrow"
                        aria-label="Halaman berikutnya"
                    >
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <span class="pagination-arrow disabled">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                @endif

                {{-- INFORMASI JUMLAH DATA --}}
                <span class="pagination-info">
                    Menampilkan
                    {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }}
                    dari {{ $transactions->total() }} transaksi
                </span>

            </div>
        @endif
    </div>
    </section>

    <section
        class="report-panel checklist-card"
        id="paymentReport"
        role="tabpanel"
        aria-labelledby="paymentsTab"
        @if($activeReportTable !== 'payments') hidden @endif
    >
        <div class="checklist-header">
            <div>
                <h2 class="history-title">Ceklis Pembayaran Kas Siswa</h2>
                <p class="history-description">
                    Lihat status pembayaran bulanan. Geser tabel ke samping untuk melihat semua bulan.
                </p>
            </div>

            <form
                action="{{ route('transactions.index') }}"
                method="GET"
                class="checklist-year-form"
            >
                <input type="hidden" name="report_table" value="payments">
                <label for="paymentYear">Tahun:</label>
                <select
                    id="paymentYear"
                    name="year"
                    onchange="this.form.submit()"
                >
                    @for($year = now()->year; $year >= now()->year - 5; $year--)
                        <option value="{{ $year }}" {{ $selectedYear === $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </form>
        </div>

        <form
            action="{{ route('transactions.index') }}"
            method="GET"
            class="checklist-search-form"
        >
            <input type="hidden" name="report_table" value="payments">
            <input type="hidden" name="year" value="{{ $selectedYear }}">
            <label for="paymentSearch">Cari nama atau NIS:</label>
            <input
                type="search"
                id="paymentSearch"
                name="payment_search"
                class="checklist-search-field"
                placeholder="Masukkan nama siswa atau NIS"
                value="{{ $paymentSearch }}"
            >
            <button type="submit" class="search-button">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>
            @if($paymentSearch !== '')
                <a
                    href="{{ route('transactions.index', ['year' => $selectedYear, 'report_table' => 'payments']) }}"
                    class="reset-button"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>
            @endif
        </form>

        <div
            class="checklist-table-scroll"
            role="region"
            aria-label="Daftar ceklis pembayaran kas siswa, geser ke samping untuk melihat semua periode"
            tabindex="0"
        >
            <table class="checklist-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th class="checklist-student">Nama Siswa</th>
                        @foreach($studentPayments->first()['periods'] ?? [] as $period)
                            <th title="{{ $period['month_label'] }}">{{ $period['label'] }}</th>
                        @endforeach
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studentPayments as $index => $data)
                        <tr>
                            <td>{{ ($paymentStudents->firstItem() ?? 1) + $index }}</td>
                            <td>{{ $data['student']->nis ?? '-' }}</td>
                            <td class="checklist-student">{{ $data['student']->name }}</td>
                            @foreach($data['periods'] as $period)
                                <td>
                                    <div class="checklist-status">
                                        <i
                                            class="fa-solid {{ $period['paid'] ? 'fa-circle-check checklist-status-icon paid' : 'fa-circle-minus checklist-status-icon unpaid' }}"
                                            aria-label="{{ $period['paid'] ? 'Lunas' : 'Belum lunas' }}"
                                        ></i>
                                        <span class="checklist-amount {{ $period['paid'] ? 'paid' : '' }}">
                                            Rp {{ number_format($period['amount'], 0, ',', '.') }}
                                        </span>
                                    </div>
                                </td>
                            @endforeach
                            <td class="checklist-total">
                                Rp {{ number_format($data['total'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($paymentPeriods) + 4 }}" class="checklist-empty">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($paymentStudents->total() > 0)
            <div class="pagination-wrapper checklist-pagination">
                <nav class="checklist-page-links" aria-label="Halaman ceklis pembayaran kas">
                    @if($paymentStudents->previousPageUrl())
                        <a
                            href="{{ $paymentStudents->previousPageUrl() }}"
                            class="pagination-arrow"
                            aria-label="Halaman sebelumnya"
                        >
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @else
                        <span class="pagination-arrow disabled" aria-disabled="true">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>
                    @endif

                    @foreach(
                        $paymentStudents->getUrlRange(
                            max(1, $paymentStudents->currentPage() - 2),
                            min($paymentStudents->lastPage(), $paymentStudents->currentPage() + 2)
                        ) as $page => $url
                    )
                        @if($paymentStudents->currentPage() === $page)
                            <span class="pagination-page active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-page" aria-label="Halaman {{ $page }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if($paymentStudents->nextPageUrl())
                        <a
                            href="{{ $paymentStudents->nextPageUrl() }}"
                            class="pagination-arrow"
                            aria-label="Halaman berikutnya"
                        >
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="pagination-arrow disabled" aria-disabled="true">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    @endif
                </nav>

                <span class="pagination-info">
                    Menampilkan {{ $paymentStudents->firstItem() ?? 0 }}–{{ $paymentStudents->lastItem() ?? 0 }}
                    dari {{ $paymentStudents->total() }} siswa
                </span>
            </div>
        @endif
    </section>
</div>

<script>
    function showTransactionReport(table) {
        const showPayments = table === 'payments';
        const transactionReport = document.getElementById('transactionReport');
        const paymentReport = document.getElementById('paymentReport');
        const transactionsTab = document.getElementById('transactionsTab');
        const paymentsTab = document.getElementById('paymentsTab');

        transactionReport.hidden = showPayments;
        paymentReport.hidden = !showPayments;

        transactionsTab.classList.toggle('active', !showPayments);
        transactionsTab.setAttribute('aria-selected', String(!showPayments));
        paymentsTab.classList.toggle('active', showPayments);
        paymentsTab.setAttribute('aria-selected', String(showPayments));

        const url = new URL(window.location.href);
        url.searchParams.set('report_table', showPayments ? 'payments' : 'transactions');
        window.history.replaceState({}, '', url);
    }
</script>

{{-- MODAL PENGATURAN ATURAN KAS --}}
<div class="transactions-modal" id="cashSettingsModal">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="cashSettingsTitle">
        <div class="modal-header">
            <div>
                <h2 class="modal-title" id="cashSettingsTitle">Pengaturan Aturan Kas Kelas</h2>
                <p class="modal-description">
                    Konfigurasi periode, nominal iuran, rentang bulan, dan reset aturan.
                </p>
            </div>
            <button type="button" class="close-button" id="closeCashSettingsButton" aria-label="Tutup">
                ×
            </button>
        </div>

        <form action="{{ route('cash-settings.bendahara.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Tipe Periode Tagihan</label>
                    <div class="cash-settings-options radio-group">
                        <label class="cash-mode-option">
                            <input
                                type="radio"
                                name="tipe_periode"
                                value="Bulanan"
                                {{ old('tipe_periode', $periodType) === 'Bulanan' ? 'checked' : '' }}
                            >
                            <strong>Mode Bulanan</strong>
                            <small>Tagihan 1x setiap bulan sesuai rentang aktif.</small>
                        </label>
                        <label class="cash-mode-option">
                            <input
                                type="radio"
                                name="tipe_periode"
                                value="Mingguan"
                                {{ old('tipe_periode', $periodType) === 'Mingguan' ? 'checked' : '' }}
                            >
                            <strong>Mode Mingguan</strong>
                            <small>Tagihan 1x per pekan (M1–M48 setahun).</small>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cashFee" class="form-label">Besaran Iuran per Periode</label>
                    <div class="amount-wrapper">
                        <span class="amount-prefix">Rp</span>
                        <input
                            type="number"
                            id="cashFee"
                            name="nominal_standar"
                            min="1"
                            step="1"
                            value="{{ old('nominal_standar', $periodFee) }}"
                            placeholder="Contoh: 5000"
                            required
                        >
                    </div>
                    @if($periodFee === null)
                        <div class="cash-settings-note">
                            Tarif kas belum ditentukan. Simpan nominal di sini sebelum mencatat pembayaran siswa.
                        </div>
                    @endif
                    <div class="cash-quick-amounts">
                        @foreach([2000, 5000, 10000, 20000] as $quickAmount)
                            <button type="button" class="cash-quick-amount" data-cash-amount="{{ $quickAmount }}">
                                Rp {{ number_format($quickAmount, 0, ',', '.') }}
                            </button>
                        @endforeach
                    </div>
                </div>

                @php
                    $monthNames = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                        10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                    ];
                @endphp
                <div class="form-group">
                    <label class="form-label">Rentang Periode Pembayaran Kas</label>
                    <div class="cash-month-range">
                        <div>
                            <label for="cashMonthStart" class="form-label">Bulan Awal (Mulai)</label>
                            <select id="cashMonthStart" name="bulan_mulai" required>
                                @foreach($monthNames as $monthNumber => $monthName)
                                    <option
                                        value="{{ $monthNumber }}"
                                        {{ (int) old('bulan_mulai', $cashSetting?->bulan_mulai ?? 7) === $monthNumber ? 'selected' : '' }}
                                    >{{ $monthName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="cashMonthEnd" class="form-label">Bulan Akhir (Selesai)</label>
                            <select id="cashMonthEnd" name="bulan_akhir" required>
                                @foreach($monthNames as $monthNumber => $monthName)
                                    <option
                                        value="{{ $monthNumber }}"
                                        {{ (int) old('bulan_akhir', $cashSetting?->bulan_akhir ?? 6) === $monthNumber ? 'selected' : '' }}
                                    >{{ $monthName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p class="cash-settings-note">
                        Rentang bawaan tahun ajaran adalah Juli–Juni. Mode mingguan menggunakan 4 periode per bulan, hingga M48.
                        Ceklis pembayaran akan menyesuaikan rentang dan jenis periode ini.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="cancel-button" id="cancelCashSettingsButton">Batal</button>
                <button type="submit" class="submit-button">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Aturan Kas
                </button>
            </div>
        </form>

        <div class="cash-reset-box">
            <strong><i class="fa-solid fa-rotate"></i> Reset Aturan Kas</strong>
            <p>Mengosongkan tarif kas dan mengembalikan periode ke Bulanan Juli–Juni. Data transaksi serta ceklis pembayaran tetap utuh.</p>
            <form
                action="{{ route('cash-settings.bendahara.reset') }}"
                method="POST"
                onsubmit="return confirm('Kosongkan tarif kas dan kembalikan periode ke Bulanan Juli–Juni? Data pembayaran tidak akan dihapus.')"
            >
                @csrf
                <button type="submit" class="cash-reset-button">Kosongkan Tarif &amp; Reset Periode</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH TRANSAKSI --}}
<div class="transactions-modal" id="transactionModal">
    <div class="modal" role="dialog" aria-modal="true">
        <div class="modal-header">
            <div>
                <h2 class="modal-title">Tambah Transaksi</h2>
                <p class="modal-description">
                    Masukkan data transaksi kas yang ingin dicatat.
                </p>
            </div>

            <button type="button" class="close-button" id="closeModalButton">
                ×
            </button>
        </div>

        <div class="modal-body">
            <form
                action="{{ route('transactions.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="transactionForm"
            >
                @csrf

                <div class="form-group">
                    <label class="form-label">Jenis Transaksi</label>

                    <div class="radio-group">
                        <div class="radio-option">
                            <input
                                type="radio"
                                name="type"
                                id="typeIn"
                                value="in"
                                {{ old('type', 'in') === 'in' ? 'checked' : '' }}
                            >
                            <label for="typeIn" class="radio-label">
                                Pemasukan
                            </label>
                        </div>

                        <div class="radio-option">
                            <input
                                type="radio"
                                name="type"
                                id="typeOut"
                                value="out"
                                {{ old('type') === 'out' ? 'checked' : '' }}
                            >
                            <label for="typeOut" class="radio-label">
                                Pengeluaran
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="incomeTypeSection" style="display: none;">
                    <label for="incomeType" class="form-label">
                        Jenis Pemasukan <span class="required">*</span>
                    </label>
                    <select name="income_type" id="incomeType">
                        <option
                            value="general"
                            {{ old('income_type', 'general') === 'general' ? 'selected' : '' }}
                        >
                            Pemasukan Umum
                        </option>
                        <option
                            value="student_cash"
                            {{ $periodFee === null ? 'disabled' : '' }}
                            {{ old('income_type') === 'student_cash' ? 'selected' : '' }}
                        >
                            Iuran Kas Siswa{{ $periodFee === null ? ' (tarif belum ditentukan)' : '' }}
                        </option>
                    </select>
                </div>

                <div class="form-group" id="categorySection" style="display: none;">
                    <label for="category" class="form-label">
                        Kategori <span class="required">*</span>
                    </label>
                    <select name="category" id="category" required></select>
                </div>

                {{-- PILIH SISWA --}}
                <div class="form-group student-section" id="studentSection">
                    <label class="form-label">
                        Siswa <span class="required">*</span>
                    </label>

                    <div class="student-search-wrapper">
                        <span class="search-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>

                        <input
                            type="text"
                            id="studentSearch"
                            class="student-search"
                            placeholder="Cari nama atau NIS siswa..."
                            autocomplete="off"
                        >

                        <div
                            class="student-results"
                            id="studentResults"
                        ></div>
                    </div>

                    <input
                        type="hidden"
                        name="student_id"
                        id="studentId"
                        value="{{ old('student_id') }}"
                    >

                    <div class="selected-student" id="selectedStudent">
                        <div>
                            <div class="selected-name" id="selectedStudentName"></div>
                            <div class="selected-nis" id="selectedStudentNis"></div>
                        </div>

                        <button
                            type="button"
                            class="change-student"
                            id="changeStudent"
                        >
                            Ganti
                        </button>
                    </div>
                </div>

                {{-- PERIODE PEMBAYARAN --}}
                <div class="form-group student-section" id="paymentMonthSection">
                    <input type="hidden" name="payment_year" value="{{ $selectedYear }}">

                    @if($periodType === 'Mingguan')
                        <label for="paymentWeek" class="form-label">
                            Mulai Periode Pembayaran <span class="required">*</span>
                        </label>
                        <select name="payment_week" id="paymentWeek">
                            @foreach($paymentPeriods as $period)
                                <option
                                    value="{{ $period['week_number'] }}"
                                    {{ (string) old('payment_week', $defaultPaymentWeek) === (string) $period['week_number'] ? 'selected' : '' }}
                                >
                                    {{ $period['label'] }} — {{ $period['month_label'] }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <label for="paymentMonth" class="form-label">
                            Mulai Bulan Pembayaran <span class="required">*</span>
                        </label>
                        <select name="payment_month" id="paymentMonth">
                            @foreach($paymentPeriods as $period)
                                <option
                                    value="{{ $period['key'] }}"
                                    {{ old('payment_month', $defaultPaymentMonth) === $period['key'] ? 'selected' : '' }}
                                >
                                    {{ $period['month_label'] }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    <div class="helper-text">
                        Pembayaran akan dialokasikan mulai periode yang dipilih, lalu ke periode aktif berikutnya bila masih ada sisa nominal.
                        Iuran per periode:
                        @if($periodFee !== null)
                            Rp {{ number_format($periodFee, 0, ',', '.') }}.
                        @else
                            belum ditentukan. Tetapkan tarif melalui Pengaturan Kas sebelum mencatat pembayaran.
                        @endif
                    </div>
                </div>

                {{-- NOMINAL --}}
                <div class="form-group">
                    <label for="amount" class="form-label">
                        Nominal <span class="required">*</span>
                    </label>

                    <div class="amount-wrapper">
                        <span class="amount-prefix">Rp</span>
                        <input
                            type="number"
                            name="amount"
                            id="amount"
                            class="amount-input"
                            min="1"
                            step="1"
                            value="{{ old('amount') }}"
                            placeholder="0"
                            required
                        >
                    </div>

                    <div class="helper-text">
                        Masukkan nominal uang yang benar-benar dibayarkan.
                    </div>
                </div>

                {{-- KETERANGAN --}}
                <div class="form-group" id="descriptionSection">
                    <label for="description" class="form-label">
                        Keterangan
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        placeholder="Masukkan keterangan transaksi..."
                    >{{ old('description') }}</textarea>
                </div>

                <div class="form-group" id="receiptSection" style="display: none;">
                    <label for="receipt" class="form-label">
                        Foto Bukti Nota / Kwitansi Kertas
                    </label>
                    <input
                        type="file"
                        name="receipt"
                        id="receipt"
                        accept="image/jpeg,image/png,image/webp"
                    >
                    <div class="helper-text">
                        Opsional. Format JPG, PNG, atau WEBP, maksimal 5 MB.
                    </div>
                    @error('receipt')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="cancel-button"
                        id="cancelButton"
                    >
                        Batal
                    </button>

                    <button type="submit" class="submit-button">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT TRANSAKSI --}}
<div class="transactions-modal" id="editModal">
    <div class="modal" role="dialog" aria-modal="true">
        <div class="modal-header">
            <div>
                <h2 class="modal-title">Edit Transaksi</h2>
                <p class="modal-description">
                    Perbarui data transaksi yang telah dicatat.
                </p>
            </div>

            <button
                type="button"
                class="close-button"
                id="closeEditModalButton"
            >
                ×
            </button>
        </div>

        <div class="modal-body">
            <form method="POST" id="editTransactionForm">
                @csrf
                @method('PUT')

                <div class="edit-info">
                    <div class="edit-info-label">Jenis Transaksi</div>
                    <div class="edit-info-value" id="editTransactionType">-</div>
                </div>

                <div class="form-group" id="editCategorySection">
                    <label for="editCategory" class="form-label">
                        Kategori <span class="required">*</span>
                    </label>

                    <select
                        name="category"
                        id="editCategory"
                        required
                    ></select>

                    <div class="helper-text" id="editCategoryHelp"></div>
                </div>

                <div class="form-group">
                    <label for="editAmount" class="form-label">
                        Nominal <span class="required">*</span>
                    </label>

                    <div class="amount-wrapper">
                        <span class="amount-prefix">Rp</span>
                        <input
                            type="number"
                            name="amount"
                            id="editAmount"
                            class="amount-input"
                            min="1"
                            step="1"
                            required
                        >
                    </div>
                </div>

                <div class="form-group" id="editDescriptionSection">
                    <label for="editDescription" class="form-label">
                        Keterangan
                    </label>

                    <textarea
                        name="description"
                        id="editDescription"
                        placeholder="Masukkan keterangan transaksi..."
                    ></textarea>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="cancel-button"
                        id="cancelEditButton"
                    >
                        Batal
                    </button>

                    <button type="submit" class="submit-button">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // DATA SISWA
    const students = @json($studentData);

    // KATEGORI TRANSAKSI
    const incomeCategories = [
        { value: 'Iuran Kas Siswa', label: 'Iuran Kas Siswa' },
        { value: 'Denda Piket Siswa', label: 'Denda Piket Siswa' },
        { value: 'Donasi & Sumbangan', label: 'Donasi & Sumbangan' },
        { value: 'Kas Awal / Saldo Awal', label: 'Kas Awal / Saldo Awal' },
        { value: 'Pemasukan Lainnya', label: 'Pemasukan Lainnya' }
    ];

    const expenseCategories = [
        { value: 'Alat & Perlengkapan Belajar', label: 'Alat & Perlengkapan Belajar' },
        { value: 'Fotokopi & Cetak Dokumen', label: 'Fotokopi & Cetak Dokumen' },
        { value: 'Kebersihan & Sanitasi Kelas', label: 'Kebersihan & Sanitasi Kelas' },
        { value: 'Konsumsi & Acara Kelas', label: 'Konsumsi & Acara Kelas' },
        { value: 'Pengeluaran Lainnya', label: 'Pengeluaran Lainnya' },
        { value: 'Sosial & Santunan Siswa', label: 'Sosial & Santunan Siswa' }
    ];

    // ELEMEN MODAL TAMBAH
    const modal = document.getElementById('transactionModal');
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');
    const cancelButton = document.getElementById('cancelButton');
    const cashSettingsModal = document.getElementById('cashSettingsModal');
    const openCashSettingsButton = document.getElementById('openCashSettingsButton');
    const closeCashSettingsButton = document.getElementById('closeCashSettingsButton');
    const cancelCashSettingsButton = document.getElementById('cancelCashSettingsButton');
    const cashFeeInput = document.getElementById('cashFee');

    function openCashSettings() {
        cashSettingsModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeCashSettings() {
        cashSettingsModal.classList.remove('show');
        document.body.style.overflow = '';
    }

    openCashSettingsButton.addEventListener('click', openCashSettings);
    closeCashSettingsButton.addEventListener('click', closeCashSettings);
    cancelCashSettingsButton.addEventListener('click', closeCashSettings);
    cashSettingsModal.addEventListener('click', function(event) {
        if (event.target === cashSettingsModal) {
            closeCashSettings();
        }
    });

    document.querySelectorAll('[data-cash-amount]').forEach(function(button) {
        button.addEventListener('click', function() {
            cashFeeInput.value = button.dataset.cashAmount;
        });
    });

    function openModal() {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    openModalButton.addEventListener('click', openModal);
    closeModalButton.addEventListener('click', closeModal);
    cancelButton.addEventListener('click', closeModal);

    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // ELEMEN FORM TAMBAH
    const typeIn = document.getElementById('typeIn');
    const typeOut = document.getElementById('typeOut');
    const incomeTypeSection = document.getElementById('incomeTypeSection');
    const incomeType = document.getElementById('incomeType');
    const category = document.getElementById('category');
    const categorySection = document.getElementById('categorySection');

    const studentSection = document.getElementById('studentSection');
    const paymentMonthSection = document.getElementById('paymentMonthSection');
    const paymentPeriodInput = document.getElementById('paymentMonth')
        || document.getElementById('paymentWeek');

    const studentSearch = document.getElementById('studentSearch');
    const studentResults = document.getElementById('studentResults');
    const studentId = document.getElementById('studentId');

    const selectedStudent = document.getElementById('selectedStudent');
    const selectedStudentName = document.getElementById('selectedStudentName');
    const selectedStudentNis = document.getElementById('selectedStudentNis');

    const changeStudent = document.getElementById('changeStudent');

    const descriptionSection = document.getElementById('descriptionSection');
    const description = document.getElementById('description');
    const receiptSection = document.getElementById('receiptSection');
    const receiptInput = document.getElementById('receipt');

    const oldCategory = @json(old('category'));

    // MEMPERBARUI PILIHAN KATEGORI TAMBAH
    function updateCategory() {
        const previousValue = category.value;
        category.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = 'Pilih kategori pengeluaran';

        category.appendChild(placeholder);

        const categories = typeOut.checked ? expenseCategories : [];

        categories.forEach(function(item) {
            const option = document.createElement('option');
            option.value = item.value;
            option.textContent = item.label;
            category.appendChild(option);
        });

        const desiredValue = oldCategory || previousValue;

        if (desiredValue === 'Kas Siswa') {
            category.value = 'Iuran Kas Siswa';
        } else if (desiredValue === 'Lainnya') {
            category.value = 'Pemasukan Lainnya';
        } else {
            category.value = desiredValue;
        }
    }

    // MEMPERBARUI FORM TAMBAH
    function updateForm() {
        const isIncome = typeIn.checked;
        const isExpense = typeOut.checked;
        const isStudentCash = isIncome &&
            incomeType.value === 'student_cash';

        receiptSection.style.display = isExpense ? 'block' : 'none';
        receiptInput.disabled = !isExpense;

        incomeTypeSection.style.display = isIncome ? 'block' : 'none';
        incomeType.disabled = !isIncome;
        incomeType.required = isIncome;

        categorySection.style.display = isExpense ? 'block' : 'none';
        category.disabled = !isExpense;
        category.required = isExpense;

        if (isStudentCash) {
            studentSection.classList.add('show');
            paymentMonthSection.classList.add('show');

            descriptionSection.style.display = 'none';
            description.disabled = true;

            studentId.required = true;
            paymentPeriodInput.required = true;
        } else {
            studentSection.classList.remove('show');
            paymentMonthSection.classList.remove('show');

            descriptionSection.style.display = 'block';
            description.disabled = false;

            studentId.required = false;
            paymentPeriodInput.required = false;
        }
    }

    typeIn.addEventListener('change', function() {
        updateCategory();
        updateForm();
        resetStudentSelection();
    });

    typeOut.addEventListener('change', function() {
        updateCategory();
        updateForm();
        resetStudentSelection();
    });

    incomeType.addEventListener('change', function() {
        updateForm();
        resetStudentSelection();
    });

    category.addEventListener('change', function() {
        updateForm();
    });

    // PENCARIAN SISWA
    studentSearch.addEventListener('input', function() {
        const keyword = this.value.toLowerCase().trim();

        studentResults.innerHTML = '';

        if (!keyword) {
            studentResults.classList.remove('show');
            return;
        }

        const filteredStudents = students.filter(function(student) {
            const name = String(student.name ?? '').toLowerCase();
            const nis = String(student.nis ?? '').toLowerCase();

            return name.includes(keyword) || nis.includes(keyword);
        });

        if (filteredStudents.length === 0) {
            studentResults.innerHTML =
                '<div class="no-result">Siswa tidak ditemukan.</div>';

            studentResults.classList.add('show');
            return;
        }

        filteredStudents.forEach(function(student) {
            const item = document.createElement('div');
            item.className = 'student-result';

            const name = document.createElement('div');
            name.className = 'student-name';
            name.textContent = student.name;

            const nis = document.createElement('div');
            nis.className = 'student-nis';
            nis.textContent = 'NIS: ' + student.nis;

            item.appendChild(name);
            item.appendChild(nis);

            item.addEventListener('click', function() {
                selectStudent(student);
            });

            studentResults.appendChild(item);
        });

        studentResults.classList.add('show');
    });

    function selectStudent(student) {
        studentId.value = student.id;

        selectedStudentName.textContent = student.name;
        selectedStudentNis.textContent = 'NIS: ' + student.nis;

        selectedStudent.classList.add('show');

        studentSearch.value = '';
        studentResults.innerHTML = '';
        studentResults.classList.remove('show');
    }

    function resetStudentSelection() {
        studentId.value = '';
        selectedStudentName.textContent = '';
        selectedStudentNis.textContent = '';

        selectedStudent.classList.remove('show');

        studentSearch.value = '';
        studentResults.innerHTML = '';
        studentResults.classList.remove('show');
    }

    changeStudent.addEventListener('click', function() {
        resetStudentSelection();
        studentSearch.focus();
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.student-search-wrapper')) {
            studentResults.classList.remove('show');
        }
    });

    // MODAL EDIT
    const editModal = document.getElementById('editModal');

    const closeEditModalButton =
        document.getElementById('closeEditModalButton');

    const cancelEditButton =
        document.getElementById('cancelEditButton');

    const editTransactionForm =
        document.getElementById('editTransactionForm');

    const editTransactionType =
        document.getElementById('editTransactionType');

    const editCategory =
        document.getElementById('editCategory');

    const editCategorySection =
        document.getElementById('editCategorySection');

    const editCategoryHelp =
        document.getElementById('editCategoryHelp');

    const editAmount =
        document.getElementById('editAmount');

    const editDescription =
        document.getElementById('editDescription');

    const editDescriptionSection =
        document.getElementById('editDescriptionSection');

    function fillEditCategories(type, selectedCategory) {
        editCategory.innerHTML = '';

        const categories = type === 'in'
            ? incomeCategories
            : expenseCategories;

        categories.forEach(function(item) {
            const option = document.createElement('option');
            option.value = item.value;
            option.textContent = item.label;

            editCategory.appendChild(option);
        });

        let normalizedCategory = selectedCategory;

        if (selectedCategory === 'Kas Siswa') {
            normalizedCategory = 'Iuran Kas Siswa';
        }

        if (selectedCategory === 'Lainnya') {
            normalizedCategory = 'Pemasukan Lainnya';
        }

        editCategory.value = normalizedCategory;
    }

    function openEditModal(id, type, categoryValue, amount, descriptionValue) {
        editTransactionForm.action =
            "{{ url('/transactions') }}/" + id;

        editTransactionType.textContent =
            type === 'in' ? 'Pemasukan' : 'Pengeluaran';

        editAmount.value = Number(amount);
        editDescription.value = descriptionValue || '';

        const isStudentCash = categoryValue === 'Kas Siswa';

        fillEditCategories(type, categoryValue);

        if (isStudentCash) {
            editCategorySection.style.display = 'block';
            editCategory.value = 'Iuran Kas Siswa';
            editCategory.disabled = true;
            editCategory.required = false;

            editCategoryHelp.textContent =
                'Kategori pembayaran kas siswa tidak dapat diubah karena terhubung dengan alokasi periode pembayaran.';

            editDescriptionSection.style.display = 'none';
            editDescription.disabled = true;
        } else {
            editCategorySection.style.display = 'block';
            editCategory.disabled = false;
            editCategory.required = true;
            editCategoryHelp.textContent = '';

            editDescriptionSection.style.display = 'block';
            editDescription.disabled = false;
        }

        editModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        editModal.classList.remove('show');
        document.body.style.overflow = '';
    }

    closeEditModalButton.addEventListener('click', closeEditModal);
    cancelEditButton.addEventListener('click', closeEditModal);

    editModal.addEventListener('click', function(event) {
        if (event.target === editModal) {
            closeEditModal();
        }
    });

    // KONFIRMASI HAPUS
    function confirmDelete(message) {
        return confirm(
            message + '\n\nApakah kamu yakin ingin melanjutkan?'
        );
    }

    // TUTUP MODAL DENGAN ESCAPE
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (modal.classList.contains('show')) {
                closeModal();
            }

            if (editModal.classList.contains('show')) {
                closeEditModal();
            }

            if (cashSettingsModal.classList.contains('show')) {
                closeCashSettings();
            }

        }
    });

    // INISIALISASI FORM
    updateCategory();
    updateForm();

    const oldStudentId = @json(old('student_id'));

    if (oldStudentId) {
        const oldStudent = students.find(function(student) {
            return String(student.id) === String(oldStudentId);
        });

        if (oldStudent) {
            selectStudent(oldStudent);
        }
    }

    // BUKA MODAL KEMBALI JIKA VALIDASI GAGAL
    @if(old('nominal_standar') !== null)
        openCashSettings();
    @elseif($errors->getBag('default')->any())
        openModal();
    @endif
</script>

@endsection
