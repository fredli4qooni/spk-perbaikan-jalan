@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        <i class="bi bi-person-gear text-brand-purple"></i> Kelola Profil
    </h2>
    <p class="text-sm text-gray-500 mt-1">Perbarui identitas akun Anda tanpa mengubah fitur lainnya.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <div class="lg:col-span-7">
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden h-full">
            <div class="p-6 md:p-8">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                        <div class="flex items-center gap-4 flex-wrap mb-3">
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="Foto profil" class="w-16 h-16 rounded-full border border-gray-200 bg-white object-cover" id="profile-photo-preview">
                            <div class="text-xs text-gray-500 max-w-xs leading-relaxed">Unggah foto wajah/ikon akun. Setelah dipilih, cukup geser foto dengan cursor pada area crop lalu simpan.</div>
                        </div>
                        <input type="file" name="profile_photo" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-purple/10 file:text-brand-purple hover:file:bg-brand-purple/20" accept="image/*" id="profile-photo-input">
                    </div>

                    <!-- Cropper Panel -->
                    <div class="mb-6 hidden" id="profile-photo-cropper-panel">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex justify-between items-start sm:items-center gap-3 flex-col sm:flex-row mb-4">
                                <div>
                                    <div class="font-bold text-sm text-gray-900">Atur Foto</div>
                                    <div class="text-xs text-gray-500 mt-1">Geser gambar untuk memindahkan posisi, lalu tarik pegangan di pojok untuk zoom.</div>
                                </div>
                                <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-purple" id="profile-photo-reset">
                                    Batal Pilih Foto
                                </button>
                            </div>

                            <div class="relative w-full aspect-square max-w-sm mx-auto overflow-hidden rounded-md bg-black mb-4">
                                <img id="profile-photo-cropper-image" alt="Crop foto profil" class="block max-w-full">
                                <button type="button" class="absolute bottom-4 right-4 bg-white/80 hover:bg-white text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow-lg transition-colors cursor-row-resize z-10" id="profile-photo-zoom-handle" aria-label="Atur zoom foto profil">
                                    <i class="bi bi-arrows-expand text-lg transform rotate-45"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border" placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border" placeholder="Ulangi password baru">
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-5 border-t border-gray-100">
                        <button type="submit" class="inline-flex justify-center items-center rounded-md border border-transparent bg-brand-purple px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2 transition-colors">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center rounded-md border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2 transition-colors">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="lg:col-span-5">
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden h-full">
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-2 mb-2 text-xl font-bold text-gray-900">
                    <i class="bi bi-person-badge text-brand-purple"></i> Informasi Akun
                </div>
                <p class="text-sm text-gray-500 mb-8">Ringkasan identitas akun yang sedang aktif.</p>

                <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100 mb-6">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="Foto profil" class="w-14 h-14 rounded-full border border-gray-200 bg-white object-cover">
                    <div>
                        <div class="font-bold text-gray-900">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="p-4 rounded-xl bg-white border border-gray-100 shadow-sm">
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama</div>
                        <div class="font-bold text-gray-900">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="p-4 rounded-xl bg-white border border-gray-100 shadow-sm">
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</div>
                        <div class="font-bold text-gray-900">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="p-4 rounded-xl bg-white border border-gray-100 shadow-sm">
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Role</div>
                        <div class="font-bold text-brand-purple">
                            {{ ucfirst(auth()->user()->role) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
/* Custom styling for cropper overrides if needed */
.cropper-view-box,
.cropper-face {
  border-radius: 50%;
}
</style>
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
        cropperPanel.classList.add('hidden');
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
        cropperPanel.classList.remove('hidden');

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