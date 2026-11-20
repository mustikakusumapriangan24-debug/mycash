<style>
    .announcement-feedback {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 7000;
        max-width: min(420px, calc(100vw - 40px));
        padding: 13px 17px;
        border: 1px solid #cfe2d4;
        border-radius: 10px;
        background: #edf4ef;
        color: #356348;
        box-shadow: 0 8px 24px rgba(31, 29, 32, .12);
        font-size: 11px;
        font-weight: 700;
    }

    .announcement-modal {
        position: fixed;
        inset: 0;
        z-index: 6000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(31, 29, 32, .48);
        backdrop-filter: blur(4px);
    }

    .announcement-modal.show {
        display: flex;
    }

    .announcement-modal .announcement-dialog {
        width: 100%;
        max-width: 620px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        border: 1px solid var(--border);
        border-radius: 18px;
        background: var(--white);
        box-shadow: 0 25px 70px rgba(31, 29, 32, .2);
    }

    .announcement-modal .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 25px 18px;
        border-bottom: 1px solid var(--border);
    }

    .announcement-modal .modal-title {
        margin: 0;
        color: var(--maroon-deep);
        font-family: "Playfair Display", serif;
        font-size: 20px;
    }

    .announcement-modal .modal-description {
        margin: 5px 0 0;
        color: var(--text-soft);
        font-size: 11px;
    }

    .announcement-modal .close-button {
        width: 32px;
        height: 32px;
        display: flex;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: #f7f3ed;
        color: var(--text-soft);
        font-size: 18px;
        cursor: pointer;
    }

    .announcement-modal .modal-body {
        padding: 23px 25px 8px;
    }

    .announcement-modal .form-group {
        margin-bottom: 17px;
    }

    .announcement-modal .form-label {
        display: block;
        margin-bottom: 7px;
        color: var(--text);
        font-size: 11px;
        font-weight: 800;
    }

    .announcement-modal input:not([type="hidden"]):not([type="radio"]),
    .announcement-modal select,
    .announcement-modal textarea {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid var(--border);
        border-radius: 10px;
        outline: none;
        background: #fff;
        color: var(--text);
        font-family: inherit;
        font-size: 12px;
    }

    .announcement-modal input:focus,
    .announcement-modal select:focus,
    .announcement-modal textarea:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(181, 154, 99, .12);
    }

    .announcement-modal textarea {
        min-height: 105px;
        resize: vertical;
    }

    .announcement-modal .announcement-template-grid,
    .announcement-modal .announcement-target-options {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .announcement-modal .announcement-template {
        display: flex;
        min-height: 56px;
        flex-direction: column;
        justify-content: center;
        gap: 4px;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: #fff;
        color: var(--text);
        text-align: left;
        cursor: pointer;
        font-family: inherit;
    }

    .announcement-modal .announcement-template strong {
        font-size: 10px;
    }

    .announcement-modal .announcement-template span {
        color: var(--text-soft);
        font-size: 8px;
    }

    .announcement-modal .announcement-template.active {
        border-color: var(--maroon);
        background: #f8f4ec;
    }

    .announcement-modal .announcement-target-option {
        position: relative;
    }

    .announcement-modal .announcement-target-option input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .announcement-modal .announcement-target-label {
        display: flex;
        min-height: 42px;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: #fff;
        color: var(--text-soft);
        font-size: 10px;
        cursor: pointer;
    }

    .announcement-modal .announcement-target-option input:checked + .announcement-target-label {
        border-color: var(--maroon);
        background: #f8f4ec;
        color: var(--text);
    }

    .announcement-modal .announcement-target-student {
        margin-top: 10px;
    }

    .announcement-modal .announcement-errors {
        margin-bottom: 16px;
        padding: 11px 14px;
        border-radius: 9px;
        background: #fae9e7;
        color: #a65353;
        font-size: 10px;
    }

    .announcement-modal .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 0 25px 22px;
    }

    .announcement-modal .cancel-button,
    .announcement-modal .submit-button {
        padding: 10px 15px;
        border-radius: 10px;
        font-family: inherit;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .announcement-modal .cancel-button {
        border: 1px solid var(--border);
        background: #fff;
        color: var(--text);
    }

    .announcement-modal .submit-button {
        border: none;
        background: var(--maroon);
        color: #fff;
    }

    @media (max-width: 650px) {
        .announcement-modal {
            padding: 10px;
        }

        .announcement-modal .announcement-dialog {
            max-height: calc(100vh - 20px);
        }

        .announcement-modal .announcement-template-grid,
        .announcement-modal .announcement-target-options {
            grid-template-columns: 1fr;
        }

        .announcement-modal .modal-header,
        .announcement-modal .modal-body {
            padding-left: 18px;
            padding-right: 18px;
        }

        .announcement-modal .modal-footer {
            padding: 0 18px 18px;
        }
    }
</style>

@if(session('announcement_success'))
    <div class="announcement-feedback" role="status">
        {{ session('announcement_success') }}
    </div>
@endif

<div class="announcement-modal" id="announcementModal">
    <div class="announcement-dialog" role="dialog" aria-modal="true" aria-labelledby="announcementModalTitle">
        <div class="modal-header">
            <div>
                <h2 class="modal-title" id="announcementModalTitle">Tambah Catatan / Pengumuman</h2>
                <p class="modal-description">
                    Tulis catatan untuk seluruh siswa kelas atau siswa tertentu.
                </p>
            </div>
            <button type="button" class="close-button" id="closeAnnouncementModalButton" aria-label="Tutup">
                ×
            </button>
        </div>

        <form action="{{ route('pengumuman.store') }}" method="POST" id="announcementForm">
            @csrf

            <div class="modal-body">
                @if($errors->getBag('announcement')->any())
                    <div class="announcement-errors" role="alert">
                        <ul>
                            @foreach($errors->getBag('announcement')->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Pilih Cepat Template</label>
                    <input
                        type="hidden"
                        name="template"
                        id="announcementTemplate"
                        value="{{ old('template', 'free') }}"
                    >
                    <div class="announcement-template-grid">
                        <button type="button" class="announcement-template" data-template="free">
                            <strong><i class="fa-solid fa-pen"></i> Pesan Bebas</strong>
                            <span>Tulis pengumuman sendiri</span>
                        </button>
                        <button type="button" class="announcement-template" data-template="monthly_fee">
                            <strong><i class="fa-solid fa-calendar-days"></i> Iuran Awal Bulan</strong>
                            <span>Pengingat bayar kas awal bulan</span>
                        </button>
                        <button type="button" class="announcement-template" data-template="cash_bill">
                            <strong><i class="fa-solid fa-triangle-exclamation"></i> Tagihan Kas</strong>
                            <span>Pemberitahuan tunggakan</span>
                        </button>
                        <button type="button" class="announcement-template" data-template="cash_confirmation">
                            <strong><i class="fa-solid fa-circle-check"></i> Konfirmasi Kas</strong>
                            <span>Penerimaan iuran siswa</span>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="announcementTitle" class="form-label">Judul Pengumuman</label>
                    <input
                        type="text"
                        name="title"
                        id="announcementTitle"
                        maxlength="255"
                        value="{{ old('title') }}"
                        placeholder="Contoh: Pengingat Iuran Kas Minggu Ini"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Target Penerima</label>
                    <div class="announcement-target-options">
                        <label class="announcement-target-option">
                            <input
                                type="radio"
                                name="target"
                                value="all"
                                {{ old('target', 'all') === 'all' ? 'checked' : '' }}
                            >
                            <span class="announcement-target-label">
                                <i class="fa-solid fa-users"></i>
                                Seluruh Siswa
                            </span>
                        </label>
                        <label class="announcement-target-option">
                            <input
                                type="radio"
                                name="target"
                                value="specific"
                                {{ old('target') === 'specific' ? 'checked' : '' }}
                            >
                            <span class="announcement-target-label">
                                <i class="fa-solid fa-user"></i>
                                Siswa Tertentu
                            </span>
                        </label>
                    </div>
                    <div id="announcementStudentSection" class="announcement-target-student" style="display: none;">
                        <label for="announcementStudent" class="form-label">Pilih Siswa</label>
                        <select name="target_student_id" id="announcementStudent" disabled>
                            <option value="">Pilih siswa</option>
                            @foreach($notificationStudents as $student)
                                <option
                                    value="{{ $student->id }}"
                                    {{ (string) old('target_student_id') === (string) $student->id ? 'selected' : '' }}
                                >
                                    {{ $student->name }} — NIS {{ $student->nis ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="announcementPriority" class="form-label">Prioritas</label>
                    <select name="priority" id="announcementPriority" required>
                        <option value="normal" {{ old('priority', 'normal') === 'normal' ? 'selected' : '' }}>
                            Normal (Informasi biasa)
                        </option>
                        <option value="important" {{ old('priority') === 'important' ? 'selected' : '' }}>
                            Penting
                        </option>
                        <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>
                            Mendesak
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="announcementMessage" class="form-label">Isi Pesan</label>
                    <textarea
                        name="message"
                        id="announcementMessage"
                        maxlength="5000"
                        placeholder="Tuliskan isi pengumuman secara jelas di sini..."
                        required
                    >{{ old('message') }}</textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="cancel-button" id="cancelAnnouncementButton">
                    Batal
                </button>
                <button type="submit" class="submit-button">
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const announcementModal = document.getElementById('announcementModal');
    const closeAnnouncementModalButton =
        document.getElementById('closeAnnouncementModalButton');
    const cancelAnnouncementButton =
        document.getElementById('cancelAnnouncementButton');

    function openAnnouncementModal() {
        announcementModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeAnnouncementModal() {
        announcementModal.classList.remove('show');
        document.body.style.overflow = '';
    }

    window.openAnnouncementModal = openAnnouncementModal;

    closeAnnouncementModalButton.addEventListener('click', closeAnnouncementModal);
    cancelAnnouncementButton.addEventListener('click', closeAnnouncementModal);
    announcementModal.addEventListener('click', function(event) {
        if (event.target === announcementModal) {
            closeAnnouncementModal();
        }
    });

    const announcementTemplates = {
        free: { title: '', message: '' },
        monthly_fee: {
            title: 'Pengingat Iuran Awal Bulan',
            message: 'Jangan lupa membayar iuran kas untuk bulan ini. Terima kasih.'
        },
        cash_bill: {
            title: 'Tagihan Kas',
            message: 'Terdapat iuran kas yang belum tercatat lunas. Mohon segera lakukan pembayaran atau hubungi bendahara jika sudah membayar.'
        },
        cash_confirmation: {
            title: 'Konfirmasi Pembayaran Kas',
            message: 'Pembayaran iuran kas Anda telah kami terima dan catat. Terima kasih.'
        }
    };

    const announcementTemplateInput =
        document.getElementById('announcementTemplate');
    const announcementTitle =
        document.getElementById('announcementTitle');
    const announcementMessage =
        document.getElementById('announcementMessage');
    const announcementTemplateButtons =
        document.querySelectorAll('.announcement-template');

    function selectAnnouncementTemplate(template, fillFields) {
        const content = announcementTemplates[template];
        if (!content) {
            return;
        }

        announcementTemplateInput.value = template;
        announcementTemplateButtons.forEach(function(button) {
            button.classList.toggle(
                'active',
                button.dataset.template === template
            );
        });

        if (fillFields) {
            announcementTitle.value = content.title;
            announcementMessage.value = content.message;
        }
    }

    announcementTemplateButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            selectAnnouncementTemplate(button.dataset.template, true);
        });
    });

    selectAnnouncementTemplate(announcementTemplateInput.value, false);

    const announcementStudentSection =
        document.getElementById('announcementStudentSection');
    const announcementStudent =
        document.getElementById('announcementStudent');
    const announcementTargetInputs =
        document.querySelectorAll('input[name="target"]');

    function updateAnnouncementTarget() {
        const selectedTarget =
            document.querySelector('input[name="target"]:checked');
        const isSpecific = selectedTarget &&
            selectedTarget.value === 'specific';

        announcementStudentSection.style.display =
            isSpecific ? 'block' : 'none';
        announcementStudent.disabled = !isSpecific;
        announcementStudent.required = Boolean(isSpecific);

        announcementTargetInputs.forEach(function(input) {
            input.closest('.announcement-target-option').classList.toggle(
                'selected',
                input.checked
            );
        });
    }

    announcementTargetInputs.forEach(function(input) {
        input.addEventListener('change', updateAnnouncementTarget);
    });

    updateAnnouncementTarget();

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && announcementModal.classList.contains('show')) {
            closeAnnouncementModal();
        }
    });

    @if($errors->getBag('announcement')->any())
        openAnnouncementModal();
    @endif
</script>
