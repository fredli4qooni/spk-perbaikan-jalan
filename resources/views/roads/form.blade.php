@php
$labelClass = "block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5";
$inputClass = "block w-full rounded-xl border border-gray-200 shadow-xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 text-sm py-2.5 px-3.5 bg-white transition-all";
$selectClass = "block w-full rounded-xl border border-gray-200 shadow-xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 text-sm py-2.5 px-3.5 bg-white transition-all cursor-pointer";
@endphp

<!-- Leaflet CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div x-data="roadMultiStepForm()" class="space-y-6">

    <!-- ======================================================== -->
    <!-- STEP PROGRESS BAR & TABS (HORIZONTAL WIZARD)            -->
    <!-- ======================================================== -->
    <div class="border-b border-gray-100 pb-5">
        <!-- Progress Bar Line -->
        <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden mb-4">
            <div 
                class="bg-brand-purple h-full transition-all duration-300 rounded-full"
                :style="`width: ${(currentStep / 3) * 100}%`"
            ></div>
        </div>

        <!-- 3 Step Buttons -->
        <div class="grid grid-cols-3 gap-2 sm:gap-3">
            <!-- Step 1 Tab -->
            <button 
                type="button" 
                @click="goToStep(1)" 
                class="flex items-center gap-2 p-2 sm:p-2.5 rounded-xl transition-all text-left min-h-[44px]"
                :class="currentStep === 1 ? 'bg-brand-purple/10 text-brand-purple ring-1 ring-brand-purple' : (currentStep > 1 ? 'bg-emerald-50 text-emerald-800' : 'bg-gray-50 text-gray-400')"
            >
                <div 
                    class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0"
                    :class="currentStep === 1 ? 'bg-brand-purple text-white' : (currentStep > 1 ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-500')"
                >
                    <template x-if="currentStep > 1">
                        <i class="bi bi-check-lg"></i>
                    </template>
                    <template x-if="currentStep <= 1">
                        <span>1</span>
                    </template>
                </div>
                <div class="truncate">
                    <span class="block text-[9px] sm:text-[10px] font-bold uppercase tracking-wider opacity-70">Langkah 1</span>
                    <span class="block text-xs font-bold truncate">Lokasi & Peta</span>
                </div>
            </button>

            <!-- Step 2 Tab -->
            <button 
                type="button" 
                @click="goToStep(2)" 
                class="flex items-center gap-2 p-2 sm:p-2.5 rounded-xl transition-all text-left min-h-[44px]"
                :class="currentStep === 2 ? 'bg-brand-purple/10 text-brand-purple ring-1 ring-brand-purple' : (currentStep > 2 ? 'bg-emerald-50 text-emerald-800' : 'bg-gray-50 text-gray-400')"
            >
                <div 
                    class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0"
                    :class="currentStep === 2 ? 'bg-brand-purple text-white' : (currentStep > 2 ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-500')"
                >
                    <template x-if="currentStep > 2">
                        <i class="bi bi-check-lg"></i>
                    </template>
                    <template x-if="currentStep <= 2">
                        <span>2</span>
                    </template>
                </div>
                <div class="truncate">
                    <span class="block text-[9px] sm:text-[10px] font-bold uppercase tracking-wider opacity-70">Langkah 2</span>
                    <span class="block text-xs font-bold truncate">Kondisi Jalan</span>
                </div>
            </button>

            <!-- Step 3 Tab -->
            <button 
                type="button" 
                @click="goToStep(3)" 
                class="flex items-center gap-2 p-2 sm:p-2.5 rounded-xl transition-all text-left min-h-[44px]"
                :class="currentStep === 3 ? 'bg-brand-purple/10 text-brand-purple ring-1 ring-brand-purple' : 'bg-gray-50 text-gray-400'"
            >
                <div 
                    class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0"
                    :class="currentStep === 3 ? 'bg-brand-purple text-white' : 'bg-gray-200 text-gray-500')"
                >
                    <span>3</span>
                </div>
                <div class="truncate">
                    <span class="block text-[9px] sm:text-[10px] font-bold uppercase tracking-wider opacity-70">Langkah 3</span>
                    <span class="block text-xs font-bold truncate">Dokumentasi</span>
                </div>
            </button>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- STEP 1: LOKASI RUAS JALAN & TITIK KOORDINAT PETA        -->
    <!-- ======================================================== -->
    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-8 h-8 rounded-lg bg-brand-purple/10 text-brand-purple flex items-center justify-center font-bold">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-bold text-gray-900">Langkah 1: Identitas Lokasi & Koordinat Peta</h3>
                <p class="text-xs text-gray-400">Tentukan alamat dan titik lokasi kerusakan pada peta.</p>
            </div>
        </div>

        <!-- Alamat & Tahun Survei -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <label class="{{ $labelClass }}">
                    Lokasi / Alamat Ruas Jalan <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="location" 
                    id="location_input" 
                    x-model="formData.location"
                    class="{{ $inputClass }}" 
                    placeholder="Contoh: Jl. Raden Intan No. 12, Enggal" 
                    required
                >
            </div>
            <div>
                <label class="{{ $labelClass }}">
                    Tahun Survei <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    name="survey_year" 
                    x-model="formData.survey_year"
                    class="{{ $inputClass }}" 
                    required
                >
            </div>
        </div>

        <!-- Peta Interaktif & Pencarian Geocoding -->
        <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50 border border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-3">
                <label class="text-xs font-bold text-gray-700 flex items-center gap-1.5">
                    <i class="bi bi-pin-map-fill text-brand-purple"></i> Pencarian Lokasi & Peta
                </label>
                <template x-if="userLocation">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        GPS Terhubung
                    </span>
                </template>
            </div>

            <!-- Live Search Bar -->
            <div class="relative mb-3">
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="bi" :class="isSearching ? 'bi-arrow-repeat animate-spin text-brand-purple' : 'bi-search'"></i>
                        </div>
                        <input 
                            type="text" 
                            x-model="searchQuery" 
                            @input.debounce.300ms="onSearchInput()"
                            @keydown.enter.prevent="searchLocation()"
                            placeholder="Ketik nama jalan / kelurahan untuk mencari..." 
                            class="pl-9 pr-8 block w-full rounded-xl border border-gray-200 shadow-xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 text-xs sm:text-sm py-2 px-3 bg-white"
                            autocomplete="off"
                        >
                        <button 
                            type="button" 
                            x-show="searchQuery" 
                            @click="searchQuery = ''; searchResults = []; isSearching = false;" 
                            class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-gray-600"
                        >
                            <i class="bi bi-x-circle-fill text-sm"></i>
                        </button>
                    </div>
                    <button 
                        type="button" 
                        @click="detectUserLocation(true)" 
                        :disabled="isLocating"
                        class="inline-flex items-center gap-1.5 px-3 py-2 border border-gray-200 rounded-xl shadow-xs text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all"
                        title="Gunakan Lokasi GPS Saat Ini"
                    >
                        <i class="bi bi-crosshair text-brand-purple" :class="isLocating ? 'animate-spin' : ''"></i>
                        <span class="hidden sm:inline">Lokasi Saya</span>
                    </button>
                </div>

                <!-- Dropdown Saran Pencarian Terdekat -->
                <div 
                    x-show="searchResults.length > 0" 
                    @click.away="searchResults = []" 
                    class="absolute left-0 right-0 mt-1.5 bg-white border border-gray-200 rounded-xl shadow-xl max-h-60 overflow-y-auto z-50 divide-y divide-gray-100"
                    x-cloak
                >
                    <template x-for="(result, index) in searchResults" :key="index">
                        <button 
                            type="button" 
                            @click="selectSearchResult(result)" 
                            class="w-full text-left px-3.5 py-2.5 hover:bg-purple-50/50 transition-colors flex items-center justify-between gap-3 text-xs text-gray-800"
                        >
                            <div class="flex items-center gap-2 min-w-0">
                                <i class="bi bi-pin-map-fill text-brand-purple flex-shrink-0"></i>
                                <div class="truncate">
                                    <span class="font-bold text-gray-900 block truncate" x-text="result.name || result.display_name.split(',')[0]"></span>
                                    <span class="text-gray-400 text-[11px] truncate block" x-text="result.display_name"></span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <template x-if="result.distanceFormatted">
                                    <span 
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold"
                                        :class="index === 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600'"
                                    >
                                        <span x-text="result.distanceFormatted"></span>
                                    </span>
                                </template>
                            </div>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Map Box -->
            <div class="relative mb-3">
                <div 
                    id="map" 
                    :class="isFullscreenMap ? 'fixed inset-0 z-50 h-screen w-screen rounded-none' : 'h-60 sm:h-64 w-full rounded-xl'" 
                    class="border border-gray-200 shadow-inner relative transition-all"
                ></div>

                <!-- Floating Map Controls -->
                <div class="absolute top-2.5 right-2.5 z-20 flex flex-col gap-1.5">
                    <button 
                        type="button" 
                        @click="toggleFullscreenMap()" 
                        class="w-8 h-8 rounded-lg bg-white/95 text-gray-700 shadow-sm border border-gray-200 flex items-center justify-center hover:bg-white hover:text-brand-purple transition-all"
                        :title="isFullscreenMap ? 'Tutup Layar Penuh' : 'Perbesar Peta'"
                    >
                        <i class="bi text-sm" :class="isFullscreenMap ? 'bi-fullscreen-exit text-red-600' : 'bi-arrows-fullscreen'"></i>
                    </button>
                </div>

                <div x-show="isFullscreenMap" class="fixed top-4 left-4 z-50 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-xl shadow-md border border-gray-200 flex items-center gap-2" x-cloak>
                    <span class="text-xs font-bold text-gray-800">Mode Peta Layar Penuh</span>
                    <button type="button" @click="toggleFullscreenMap()" class="text-xs font-semibold px-2 py-0.5 bg-red-100 text-red-700 rounded-lg">
                        Tutup
                    </button>
                </div>
            </div>

            <!-- Koordinat Latitude & Longitude -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Latitude</label>
                    <input type="text" id="latitude" name="latitude" x-model="formData.latitude" class="{{ $inputClass }} bg-white font-mono text-xs py-2" readonly placeholder="-5.397140">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Longitude</label>
                    <input type="text" id="longitude" name="longitude" x-model="formData.longitude" class="{{ $inputClass }} bg-white font-mono text-xs py-2" readonly placeholder="105.266792">
                </div>
            </div>
        </div>

        <!-- Kecamatan & Kelurahan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $labelClass }}">
                    Kecamatan <span class="text-red-500">*</span>
                </label>
                <select name="kecamatan" x-model="formData.kecamatan" @change="onKecamatanChange()" class="{{ $selectClass }}" required>
                    <option value="">-- Pilih Kecamatan --</option>
                    <template x-for="kec in kecamatanList" :key="kec">
                        <option :value="kec" x-text="kec" :selected="formData.kecamatan === kec"></option>
                    </template>
                </select>
            </div>
            <div>
                <label class="{{ $labelClass }}">
                    Kelurahan <span class="text-red-500">*</span>
                </label>
                <select name="kelurahan" x-model="formData.kelurahan" class="{{ $selectClass }}" required>
                    <option value="">-- Pilih Kelurahan --</option>
                    <template x-for="kel in availableKelurahans" :key="kel">
                        <option :value="kel" x-text="kel" :selected="formData.kelurahan === kel"></option>
                    </template>
                </select>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- STEP 2: PARAMETER KONDISI KERUSAKAN JALAN (MOORA)       -->
    <!-- ======================================================== -->
    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5" style="display: none;">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-8 h-8 rounded-lg bg-brand-purple/10 text-brand-purple flex items-center justify-center font-bold">
                <i class="bi bi-sliders"></i>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-bold text-gray-900">Langkah 2: Parameter Kondisi Kerusakan Jalan</h3>
                <p class="text-xs text-gray-400">Pilih rentang kondisi fisik sesuai hasil survei lapangan.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            <!-- C1: Panjang Kerusakan Jalan -->
            <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/80 border border-gray-200 transition-all hover:border-gray-300">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <label class="text-xs sm:text-sm font-bold text-gray-800 flex items-center gap-1.5">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-black bg-purple-100 text-brand-purple">C1</span>
                        <span>Panjang Kerusakan</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <template x-if="formData.c1_panjang">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-purple-100 text-brand-purple">
                            Skala <span x-text="formData.c1_panjang" class="ml-0.5"></span>
                        </span>
                    </template>
                </div>
                <select name="c1_panjang" x-model="formData.c1_panjang" class="{{ $selectClass }}" required>
                    <option value="">-- Pilih Panjang Kerusakan --</option>
                    @foreach(\App\Models\Road::getC1Options() as $val => $text)
                        <option value="{{ $val }}">
                            Skala {{ $val }} : {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- C2: Lebar Jalan -->
            <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/80 border border-gray-200 transition-all hover:border-gray-300">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <label class="text-xs sm:text-sm font-bold text-gray-800 flex items-center gap-1.5">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-black bg-blue-100 text-blue-700">C2</span>
                        <span>Lebar Jalan</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <template x-if="formData.c2_lebar">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-blue-100 text-blue-700">
                            Skala <span x-text="formData.c2_lebar" class="ml-0.5"></span>
                        </span>
                    </template>
                </div>
                <select name="c2_lebar" x-model="formData.c2_lebar" class="{{ $selectClass }}" required>
                    <option value="">-- Pilih Lebar Jalan --</option>
                    @foreach(\App\Models\Road::getC2Options() as $val => $text)
                        <option value="{{ $val }}">
                            Skala {{ $val }} : {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- C3: Kedalaman Lubang -->
            <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/80 border border-gray-200 transition-all hover:border-gray-300">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <label class="text-xs sm:text-sm font-bold text-gray-800 flex items-center gap-1.5">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-black bg-amber-100 text-amber-800">C3</span>
                        <span>Kedalaman Lubang</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <template x-if="formData.c3_kedalaman">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800">
                            Skala <span x-text="formData.c3_kedalaman" class="ml-0.5"></span>
                        </span>
                    </template>
                </div>
                <select name="c3_kedalaman" x-model="formData.c3_kedalaman" class="{{ $selectClass }}" required>
                    <option value="">-- Pilih Kedalaman Lubang --</option>
                    @foreach(\App\Models\Road::getC3Options() as $val => $text)
                        <option value="{{ $val }}">
                            Skala {{ $val }} : {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- C4: Banyaknya Lubang -->
            <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/80 border border-gray-200 transition-all hover:border-gray-300">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <label class="text-xs sm:text-sm font-bold text-gray-800 flex items-center gap-1.5">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-black bg-red-100 text-red-700">C4</span>
                        <span>Banyaknya Lubang</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <template x-if="formData.c4_lubang">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-red-100 text-red-700">
                            Skala <span x-text="formData.c4_lubang" class="ml-0.5"></span>
                        </span>
                    </template>
                </div>
                <select name="c4_lubang" x-model="formData.c4_lubang" class="{{ $selectClass }}" required>
                    <option value="">-- Pilih Banyaknya Lubang --</option>
                    @foreach(\App\Models\Road::getC4Options() as $val => $text)
                        <option value="{{ $val }}">
                            Skala {{ $val }} : {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- C5: Tingkat Kepentingan Jalan -->
            <div class="sm:col-span-2 p-3.5 sm:p-4 rounded-xl bg-gray-50/80 border border-gray-200 transition-all hover:border-gray-300">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <label class="text-xs sm:text-sm font-bold text-gray-800 flex items-center gap-1.5">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-black bg-emerald-100 text-emerald-800">C5</span>
                        <span>Tingkat Kepentingan Jalan</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <template x-if="formData.c5_kepentingan">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800">
                            Skala <span x-text="formData.c5_kepentingan" class="ml-0.5"></span>
                        </span>
                    </template>
                </div>
                <select name="c5_kepentingan" x-model="formData.c5_kepentingan" class="{{ $selectClass }}" required>
                    <option value="">-- Pilih Tingkat Kepentingan --</option>
                    @foreach(\App\Models\Road::getC5Options() as $val => $text)
                        <option value="{{ $val }}">
                            Skala {{ $val }} : {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- STEP 3: DOKUMENTASI MEDIA & CATATAN KHUSUS              -->
    <!-- ======================================================== -->
    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5" style="display: none;">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-8 h-8 rounded-lg bg-brand-purple/10 text-brand-purple flex items-center justify-center font-bold">
                <i class="bi bi-camera-fill"></i>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-bold text-gray-900">Langkah 3: Dokumentasi Media & Catatan</h3>
                <p class="text-xs text-gray-400">Lampirkan foto/video dokumentasi lapangan dan catatan penting.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Foto Dokumentasi -->
            <div>
                <label class="{{ $labelClass }}">Foto Dokumentasi</label>
                <input 
                    type="file" 
                    name="photo" 
                    id="photo_input" 
                    @change="previewPhoto($event)" 
                    accept="image/*" 
                    capture="environment"
                    class="{{ $inputClass }} file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-brand-purple hover:file:bg-purple-100 cursor-pointer"
                >

                <!-- Preview Foto -->
                <template x-if="photoPreviewUrl">
                    <div class="relative mt-2 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 w-32 h-24">
                        <img :src="photoPreviewUrl" alt="Preview Foto" class="w-full h-full object-cover">
                        <button 
                            type="button" 
                            @click="clearPhotoPreview()" 
                            class="absolute top-1 right-1 p-1 bg-red-600 text-white rounded-md text-[10px]"
                            title="Hapus"
                        >
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </template>

                @if (!empty($road?->photo))
                    <div x-show="!photoPreviewUrl" class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                        <i class="bi bi-image text-brand-purple"></i>
                        <span class="truncate">Foto tersimpan: {{ basename($road->photo) }}</span>
                    </div>
                @endif
            </div>

            <!-- Video Dokumentasi -->
            <div>
                <label class="{{ $labelClass }}">Video Dokumentasi (Opsional)</label>
                <input 
                    type="file" 
                    name="video" 
                    id="video_input" 
                    @change="previewVideo($event)" 
                    accept="video/mp4,video/quicktime,video/x-msvideo,video/mkv" 
                    class="{{ $inputClass }} file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                >

                <!-- Preview Video -->
                <template x-if="videoPreviewUrl">
                    <div class="relative mt-2 rounded-xl overflow-hidden border border-gray-200 bg-black w-32 h-24">
                        <video :src="videoPreviewUrl" controls class="w-full h-full object-contain"></video>
                        <button 
                            type="button" 
                            @click="clearVideoPreview()" 
                            class="absolute top-1 right-1 p-1 bg-red-600 text-white rounded-md text-[10px]"
                            title="Hapus"
                        >
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </template>

                @if (!empty($road?->video))
                    <div x-show="!videoPreviewUrl" class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                        <i class="bi bi-film text-blue-600"></i>
                        <span class="truncate">Video tersimpan: {{ basename($road->video) }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Catatan Khusus -->
        <div>
            <label class="{{ $labelClass }}">Catatan Khusus</label>
            <textarea 
                name="notes" 
                class="{{ $inputClass }}" 
                rows="3" 
                placeholder="Tambahkan catatan keterangan penting mengenai kondisi ruas jalan ini..."
            >{{ old('notes', $road->notes ?? '') }}</textarea>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- WIZARD NAVIGATION FOOTER BUTTONS                        -->
    <!-- ======================================================== -->
    <div class="pt-5 border-t border-gray-100 flex items-center justify-between gap-3">
        <!-- Tombol Kiri (Batal / Sebelumnya) -->
        <div>
            <template x-if="currentStep === 1">
                <a 
                    href="{{ route('roads.index') }}" 
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 shadow-xs hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all min-h-[44px]"
                >
                    Batal
                </a>
            </template>
            <template x-if="currentStep > 1">
                <button 
                    type="button" 
                    @click="prevStep()" 
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 shadow-xs hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all min-h-[44px]"
                >
                    <i class="bi bi-arrow-left mr-1.5"></i> Sebelumnya
                </button>
            </template>
        </div>

        <!-- Tombol Kanan (Selanjutnya / Simpan) -->
        <div>
            <template x-if="currentStep < 3">
                <button 
                    type="button" 
                    @click="nextStep()" 
                    class="inline-flex items-center justify-center rounded-xl border border-transparent bg-brand-purple px-5 sm:px-6 py-2.5 text-xs sm:text-sm font-bold text-white shadow-sm hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all min-h-[44px]"
                >
                    <span>Langkah Selanjutnya</span>
                    <i class="bi bi-arrow-right ml-1.5"></i>
                </button>
            </template>
            <template x-if="currentStep === 3">
                <button 
                    type="submit" 
                    class="inline-flex items-center justify-center rounded-xl border border-transparent bg-brand-purple px-6 sm:px-8 py-2.5 text-xs sm:text-sm font-bold text-white shadow-sm hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all min-h-[44px]"
                >
                    <i class="bi bi-save mr-2"></i> Simpan Data Jalan
                </button>
            </template>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('roadMultiStepForm', () => ({
            currentStep: 1,
            searchQuery: '',
            searchResults: [],
            isSearching: false,
            isLocating: false,
            isFullscreenMap: false,
            userLocation: null,
            userLocationMarker: null,
            searchAbortController: null,
            map: null,
            marker: null,
            photoPreviewUrl: null,
            videoPreviewUrl: null,

            formData: {
                location: "{{ old('location', $road->location ?? '') }}",
                survey_year: "{{ old('survey_year', $road->survey_year ?? date('Y')) }}",
                latitude: "{{ old('latitude', $road->latitude ?? '') }}",
                longitude: "{{ old('longitude', $road->longitude ?? '') }}",
                kecamatan: "{{ old('kecamatan', str_replace('Kecamatan ', '', $road->kecamatan ?? '')) }}",
                kelurahan: "{{ old('kelurahan', str_replace('Kelurahan ', '', $road->kelurahan ?? '')) }}",
                c1_panjang: "{{ old('c1_panjang', $road->c1_panjang ?? '') }}",
                c2_lebar: "{{ old('c2_lebar', $road->c2_lebar ?? '') }}",
                c3_kedalaman: "{{ old('c3_kedalaman', $road->c3_kedalaman ?? '') }}",
                c4_lubang: "{{ old('c4_lubang', $road->c4_lubang ?? '') }}",
                c5_kepentingan: "{{ old('c5_kepentingan', $road->c5_kepentingan ?? '') }}",
            },

            // 20 Kecamatan Lengkap Kota Bandar Lampung beserta 126 Kelurahannya
            kecamatanList: [
                "Bumi Waras",
                "Enggal",
                "Kedamaian",
                "Kedaton",
                "Kemiling",
                "Labuhan Ratu",
                "Langkapura",
                "Panjang",
                "Rajabasa",
                "Sukabumi",
                "Sukarame",
                "Tanjung Karang Barat",
                "Tanjung Karang Pusat",
                "Tanjung Karang Timur",
                "Tanjung Senang",
                "Teluk Betung Barat",
                "Teluk Betung Selatan",
                "Teluk Betung Timur",
                "Teluk Betung Utara",
                "Way Halim"
            ],

            kelurahanMap: {
                "Bumi Waras": ["Bumi Waras", "Garuntang", "Kangkung", "Kaliawi", "Pecoh Raya", "Sukaraja"],
                "Enggal": ["Enggal", "Gunung Sari", "Pelita", "Rawa Laut", "Tanjung Karang"],
                "Kedamaian": ["Bumi Kedamaian", "Kedamaian", "Kalibalau Kencana", "Tanjung Agung Raya", "Tanjung Gading", "Tanjung Raya"],
                "Kedaton": ["Campang Raya", "Kedaton", "Penengahan", "Sidodadi", "Sukamenanti", "Surabaya"],
                "Kemiling": ["Beringin Raya", "Beringin Jaya", "Kedaung", "Kemiling Permai", "Pinang Jaya", "Sumber Agung", "Sumber Rejo", "Sumber Rejo Sejahtera"],
                "Labuhan Ratu": ["Kampung Baru", "Kampung Baru Raya", "Labuhan Ratu", "Labuhan Ratu Raya", "Sepang Jaya", "Kota Sepang"],
                "Langkapura": ["Bilabong Jaya", "Gunung Agung", "Langkapura", "Langkapura Baru", "Pinang Jaya"],
                "Panjang": ["Karang Maritim", "Ketapang", "Ketapang Kuala", "Pidada", "Panjang Selatan", "Panjang Utara", "Srengsem"],
                "Rajabasa": ["Gedong Meneng", "Gedong Meneng Baru", "Rajabasa", "Rajabasa Jaya", "Rajabasa Nunyai", "Rajabasa Pemuka"],
                "Sukabumi": ["Campang Jaya", "Campang Raya", "Nusantara Permai", "Sukabumi", "Sukabumi Indah", "Way Gubak"],
                "Sukarame": ["Korpri Jaya", "Korpri Raya", "Sukarame", "Sukarame Baru", "Way Dadi", "Way Dadi Baru"],
                "Tanjung Karang Barat": ["Gedong Air", "Kelapa Tiga", "Segala Mider", "Suka Jawa", "Sukajawa Baru", "Susunan Baru", "Tanjung Karang", "Durian Payung"],
                "Tanjung Karang Pusat": ["Durian Payung", "Gotong Royong", "Gunung Sari", "Kaliawi", "Kaliawi Persada", "Palapa", "Pasir Gintung", "Pelita", "Tanjung Karang"],
                "Tanjung Karang Timur": ["Kebon Jeruk", "Kota Baru", "Sawah Brebes", "Sawah Lama", "Tanjung Agung", "Tanjung Gading"],
                "Tanjung Senang": ["Labuhan Dalam", "Pematang Wangi", "Tanjung Senang", "Way Kandis", "Way Kandis Baru"],
                "Teluk Betung Barat": ["Bakung", "Batu Putuk", "Beringin Raya", "Kuripan", "Negeri Olok Gading", "Sukarame II"],
                "Teluk Betung Selatan": ["Gedong Pakuon", "Gunung Mas", "Pesawahan", "Sumur Putri", "Talang", "Teluk Betung"],
                "Teluk Betung Timur": ["Batang Arau", "Kota Karang", "Kota Karang Raya", "Perwata", "Sukamaju", "Way Tataan"],
                "Teluk Betung Utara": ["Gulak Galik", "Kupang Kota", "Kupang Raya", "Kupang Teba", "Pengajaran", "Sumur Batu"],
                "Way Halim": ["Gunung Sulah", "Jagabaya I", "Jagabaya II", "Jagabaya III", "Perumnas Way Halim", "Way Halim Permai"]
            },

            availableKelurahans: [],
            
            init() {
                this.updateKelurahanList();

                setTimeout(() => {
                    this.initMap();
                    this.detectUserLocation(false);
                }, 150);
            },

            goToStep(step) {
                if (step === this.currentStep) return;
                if (step < this.currentStep) {
                    this.currentStep = step;
                    this.onStepChanged();
                    return;
                }
                if (this.validateStep(this.currentStep)) {
                    this.currentStep = step;
                    this.onStepChanged();
                }
            },

            nextStep() {
                if (this.validateStep(this.currentStep)) {
                    if (this.currentStep < 3) {
                        this.currentStep++;
                        this.onStepChanged();
                    }
                }
            },

            prevStep() {
                if (this.currentStep > 1) {
                    this.currentStep--;
                    this.onStepChanged();
                }
            },

            onStepChanged() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                if (this.currentStep === 1) {
                    setTimeout(() => {
                        if (this.map) this.map.invalidateSize();
                    }, 200);
                }
            },

            validateStep(step) {
                if (step === 1) {
                    if (!this.formData.location || this.formData.location.trim() === '') {
                        alert('Silakan isi Lokasi / Alamat Ruas Jalan terlebih dahulu.');
                        document.getElementById('location_input')?.focus();
                        return false;
                    }
                    if (!this.formData.kecamatan) {
                        alert('Silakan pilih Kecamatan.');
                        return false;
                    }
                    if (!this.formData.kelurahan) {
                        alert('Silakan pilih Kelurahan.');
                        return false;
                    }
                } else if (step === 2) {
                    if (!this.formData.c1_panjang || !this.formData.c2_lebar || !this.formData.c3_kedalaman || !this.formData.c4_lubang || !this.formData.c5_kepentingan) {
                        alert('Silakan lengkapi seluruh 5 parameter kondisi kerusakan jalan.');
                        return false;
                    }
                }
                return true;
            },

            onKecamatanChange() {
                this.updateKelurahanList();
                this.formData.kelurahan = '';
            },

            updateKelurahanList() {
                if (this.formData.kecamatan && this.kelurahanMap[this.formData.kecamatan]) {
                    this.availableKelurahans = this.kelurahanMap[this.formData.kecamatan];
                } else {
                    this.availableKelurahans = [];
                }
            },

            initMap() {
                const latInput = document.getElementById('latitude');
                const lngInput = document.getElementById('longitude');
                
                let initialLat = this.formData.latitude ? parseFloat(this.formData.latitude) : -5.385500;
                let initialLng = this.formData.longitude ? parseFloat(this.formData.longitude) : 105.275000;
                let zoomLevel = this.formData.latitude ? 16 : 13;

                this.map = L.map('map').setView([initialLat, initialLng], zoomLevel);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(this.map);

                if (this.formData.latitude && this.formData.longitude) {
                    this.marker = L.marker([initialLat, initialLng]).addTo(this.map);
                }

                this.map.on('click', (e) => {
                    const lat = e.latlng.lat.toFixed(8);
                    const lng = e.latlng.lng.toFixed(8);

                    this.formData.latitude = lat;
                    this.formData.longitude = lng;

                    if (latInput) latInput.value = lat;
                    if (lngInput) lngInput.value = lng;

                    if (this.marker) {
                        this.marker.setLatLng(e.latlng);
                    } else {
                        this.marker = L.marker(e.latlng).addTo(this.map);
                    }
                });
            },

            toggleFullscreenMap() {
                this.isFullscreenMap = !this.isFullscreenMap;
                setTimeout(() => {
                    if (this.map) {
                        this.map.invalidateSize();
                    }
                }, 200);
            },

            detectUserLocation(manual = false) {
                if (!navigator.geolocation) {
                    if (manual) {
                        alert('Browser perangkat Anda tidak mendukung fitur Geolocation / GPS.');
                    }
                    return;
                }

                this.isLocating = true;

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;

                        this.userLocation = { lat, lng, accuracy };
                        this.isLocating = false;

                        if (manual || !this.formData.latitude || !this.formData.longitude) {
                            this.formData.latitude = lat.toFixed(8);
                            this.formData.longitude = lng.toFixed(8);

                            if (this.map) {
                                this.map.setView([lat, lng], 17);

                                if (this.marker) {
                                    this.marker.setLatLng([lat, lng]);
                                } else {
                                    this.marker = L.marker([lat, lng]).addTo(this.map);
                                }
                            }
                        }

                        this.renderUserLocationMarker(lat, lng);
                    },
                    (error) => {
                        this.isLocating = false;
                        console.warn('Geolocation notice:', error.message);
                        if (manual) {
                            alert('Gagal mendeteksi lokasi perangkat. Pastikan izin akses lokasi (GPS) telah diaktifkan.');
                        }
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 30000
                    }
                );
            },

            renderUserLocationMarker(lat, lng) {
                if (!this.map) return;

                if (this.userLocationMarker) {
                    this.userLocationMarker.setLatLng([lat, lng]);
                } else {
                    const userIcon = L.divIcon({
                        className: 'custom-user-marker',
                        html: '<div class="relative flex items-center justify-center w-5 h-5"><div class="absolute w-5 h-5 rounded-full bg-blue-500 opacity-75 animate-ping"></div><div class="w-3.5 h-3.5 rounded-full bg-blue-600 border-2 border-white shadow-md"></div></div>',
                        iconSize: [20, 20],
                        iconAnchor: [10, 10]
                    });

                    this.userLocationMarker = L.marker([lat, lng], { icon: userIcon, zIndexOffset: 1000 })
                        .addTo(this.map)
                        .bindPopup('<div class="text-xs font-bold text-gray-800">📍 Posisi Anda Saat Ini</div>');
                }
            },

            calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371;
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a = 
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            },

            formatDistance(distKm) {
                if (distKm === null || distKm === undefined || isNaN(distKm)) {
                    return '';
                }
                if (distKm < 1) {
                    return Math.round(distKm * 1000) + ' m';
                }
                return distKm.toFixed(1) + ' km';
            },

            onSearchInput() {
                if (!this.searchQuery || this.searchQuery.trim().length < 2) {
                    this.searchResults = [];
                    this.isSearching = false;
                    if (this.searchAbortController) {
                        this.searchAbortController.abort();
                    }
                    return;
                }
                this.searchLocation();
            },

            async searchLocation() {
                if (!this.searchQuery || this.searchQuery.trim().length < 2) {
                    this.searchResults = [];
                    this.isSearching = false;
                    return;
                }

                if (this.searchAbortController) {
                    this.searchAbortController.abort();
                }
                this.searchAbortController = new AbortController();

                this.isSearching = true;

                try {
                    let query = this.searchQuery.trim();
                    let endpoint = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=10&countrycodes=id&addressdetails=1`;
                    
                    let refLat = this.userLocation ? this.userLocation.lat : (this.formData.latitude ? parseFloat(this.formData.latitude) : -5.385500);
                    let refLng = this.userLocation ? this.userLocation.lng : (this.formData.longitude ? parseFloat(this.formData.longitude) : 105.275000);

                    if (!isNaN(refLat) && !isNaN(refLng)) {
                        const vbMinLng = (refLng - 0.35).toFixed(4);
                        const vbMaxLng = (refLng + 0.35).toFixed(4);
                        const vbMinLat = (refLat - 0.35).toFixed(4);
                        const vbMaxLat = (refLat + 0.35).toFixed(4);
                        endpoint += `&viewbox=${vbMinLng},${vbMaxLat},${vbMaxLng},${vbMinLat}`;
                    }

                    const response = await fetch(endpoint, {
                        signal: this.searchAbortController.signal,
                        headers: {
                            'Accept-Language': 'id'
                        }
                    });
                    
                    if (response.ok) {
                        let data = await response.json();

                        data.forEach(item => {
                            const itemLat = parseFloat(item.lat);
                            const itemLon = parseFloat(item.lon);

                            if (refLat && refLng && !isNaN(itemLat) && !isNaN(itemLon)) {
                                item.distance = this.calculateDistance(refLat, refLng, itemLat, itemLon);
                                item.distanceFormatted = this.formatDistance(item.distance);
                            } else {
                                item.distance = 999999;
                                item.distanceFormatted = '';
                            }
                        });

                        data.sort((a, b) => a.distance - b.distance);

                        this.searchResults = data;
                    }
                } catch (error) {
                    if (error.name !== 'AbortError') {
                        console.error('Error fetching geocoding:', error);
                    }
                } finally {
                    this.isSearching = false;
                }
            },

            selectSearchResult(result) {
                const lat = parseFloat(result.lat);
                const lon = parseFloat(result.lon);

                this.formData.latitude = lat.toFixed(8);
                this.formData.longitude = lon.toFixed(8);

                if (!this.formData.location || this.formData.location.trim() === '') {
                    this.formData.location = result.display_name;
                }

                if (this.map) {
                    this.map.setView([lat, lon], 17);

                    if (this.marker) {
                        this.marker.setLatLng([lat, lon]);
                    } else {
                        this.marker = L.marker([lat, lon]).addTo(this.map);
                    }
                }

                this.searchResults = [];
            },

            previewPhoto(event) {
                const file = event.target.files[0];
                if (file) {
                    this.photoPreviewUrl = URL.createObjectURL(file);
                }
            },

            clearPhotoPreview() {
                this.photoPreviewUrl = null;
                const input = document.getElementById('photo_input');
                if (input) input.value = '';
            },

            previewVideo(event) {
                const file = event.target.files[0];
                if (file) {
                    this.videoPreviewUrl = URL.createObjectURL(file);
                }
            },

            clearVideoPreview() {
                this.videoPreviewUrl = null;
                const input = document.getElementById('video_input');
                if (input) input.value = '';
            }
        }));
    });
</script>
<style>
    [x-cloak] { display: none !important; }
    .leaflet-container { z-index: 10 !important; }
    .custom-user-marker { background: transparent; border: none; }
</style>
