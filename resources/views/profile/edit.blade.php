@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-3 flex-wrap">
    <div>
        <div class="page-title"><i class="bi bi-person-gear"></i> Kelola Profil</div>
        <p class="page-subtitle">Perbarui identitas akun Anda tanpa mengubah fitur lainnya.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-7">
        <div class="card form-shell h-100">
            <div class="card-body guest-card-inner">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Periksa kembali input.</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Foto Profil</label>
                        <div class="d-flex align-items-center gap-3 flex-wrap mb-2">
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="Foto profil" class="rounded-circle border bg-white profile-photo-preview" id="profile-photo-preview">
                            <div class="text-muted small">Unggah foto wajah/ikon akun. Setelah dipilih, cukup geser foto dengan cursor pada area crop lalu simpan.</div>
                        </div>
                        <input type="file" name="profile_photo" class="form-control" accept="image/*" id="profile-photo-input">
                    </div>

                    <div class="mb-3 d-none" id="profile-photo-cropper-panel">
                        <div class="profile-cropper-shell">
                            <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap mb-3">
                                <div>
                                    <div class="fw-bold">Atur Foto</div>
                                    <div class="text-muted small">Geser gambar untuk memindahkan posisi, lalu tarik pegangan di pojok untuk zoom.</div>
                                </div>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="profile-photo-reset">Batal Pilih Foto</button>
                            </div>

                            <div class="profile-cropper-stage mb-3">
                                <img id="profile-photo-cropper-image" alt="Crop foto profil">
                                <button type="button" class="profile-photo-zoom-handle" id="profile-photo-zoom-handle" aria-label="Atur zoom foto profil">
                                    <i class="bi bi-arrows-expand"></i>
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card h-100">
            <div class="card-body">
                <div class="page-title mb-2"><i class="bi bi-person-badge"></i> Informasi Akun</div>
                <p class="page-subtitle mb-4">Ringkasan identitas akun yang sedang aktif.</p>

                <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-white border mb-4">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="Foto profil" class="rounded-circle border bg-light profile-photo-current">
                    <div>
                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                        <div class="text-muted small">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="d-grid gap-3">
                    <div class="p-3 rounded-4 bg-white border">
                        <div class="text-muted small mb-1">Nama</div>
                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="p-3 rounded-4 bg-white border">
                        <div class="text-muted small mb-1">Email</div>
                        <div class="fw-bold">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="p-3 rounded-4 bg-white border">
                        <div class="text-muted small mb-1">Role</div>
                        <div class="fw-bold">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('profile-form');
    const input = document.getElementById('profile-photo-input');
    const preview = document.getElementById('profile-photo-preview');
    const cropperPanel = document.getElementById('profile-photo-cropper-panel');
    const cropperImage = document.getElementById('profile-photo-cropper-image');
    const resetButton = document.getElementById('profile-photo-reset');
    const zoomHandle = document.getElementById('profile-photo-zoom-handle');

    if (!form || !input || !preview || !cropperPanel || !cropperImage || !resetButton || !zoomHandle || typeof Cropper === 'undefined') {
        return;
    }

    let cropper = null;
    let selectedFile = null;
    let currentZoom = 1;
    let zoomModeActive = false;
    let zoomModeStartY = 0;
    let zoomModeStartZoom = 1;
    const originalPreviewSrc = preview.getAttribute('src');

    const clearCropper = () => {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        cropperPanel.classList.add('d-none');
        input.value = '';
        selectedFile = null;
        preview.src = originalPreviewSrc;
        currentZoom = 1;
        zoomModeActive = false;
    };

    const updateZoom = (zoomValue) => {
        const minZoom = 0.6;
        const maxZoom = 2.5;
        const safeZoom = Math.min(maxZoom, Math.max(minZoom, zoomValue));

        if (cropper) {
            cropper.zoomTo(safeZoom);
        }

        currentZoom = safeZoom;
    };

    input.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) {
            clearCropper();
            return;
        }

        selectedFile = file;
        const objectUrl = URL.createObjectURL(file);
        cropperImage.src = objectUrl;
        cropperPanel.classList.remove('d-none');

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(cropperImage, {
            aspectRatio: 1,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1,
            background: false,
            responsive: true,
            zoomOnWheel: false,
            toggleDragModeOnDblclick: false,
            cropBoxMovable: false,
            cropBoxResizable: false,
            ready() {
                    updateZoom(1);
            },
        });
    });

    zoomHandle.addEventListener('mousedown', function (event) {
        if (event.button !== 0) {
            return;
        }

        event.preventDefault();
        zoomModeActive = true;
        zoomModeStartY = event.clientY;
        zoomModeStartZoom = currentZoom;
    });

    document.addEventListener('mousemove', function (event) {
        if (!zoomModeActive) {
            return;
        }

        event.preventDefault();
        const delta = (zoomModeStartY - event.clientY) / 160;
        const zoomValue = zoomModeStartZoom + delta;
        updateZoom(zoomValue);
    });

    const stopZoomMode = function () {
        zoomModeActive = false;
    };

    document.addEventListener('mouseup', stopZoomMode);
    zoomHandle.addEventListener('mouseleave', function () {
        if (zoomModeActive) {
            stopZoomMode();
        }
    });

    resetButton.addEventListener('click', function () {
        clearCropper();
    });

    form.addEventListener('submit', function (event) {
        if (!cropper || !selectedFile) {
            return;
        }

        event.preventDefault();

        cropper.getCroppedCanvas({
            width: 512,
            height: 512,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        }).toBlob(function (blob) {
            if (!blob) {
                form.submit();
                return;
            }

            const croppedFile = new File([blob], selectedFile.name, { type: 'image/jpeg' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            input.files = dataTransfer.files;
            form.submit();
        }, 'image/jpeg', 0.92);
    });
});
</script>
@endpush