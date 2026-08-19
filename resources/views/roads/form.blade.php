@php
$labelClass = "block text-sm font-medium text-gray-700 mb-1";
$inputClass = "mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border";
@endphp

<!-- Leaflet CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div x-data="roadForm()">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="{{ $labelClass }}">Nama Ruas Jalan</label>
            <input type="text" name="name" class="{{ $inputClass }}" value="{{ old('name', $road->name ?? '') }}" placeholder="Contoh: Jl. Raden Intan No. 12" required>
        </div>
        <div>
            <label class="{{ $labelClass }}">Tahun Survei</label>
            <input type="number" name="survey_year" class="{{ $inputClass }}" value="{{ old('survey_year', $road->survey_year ?? date('Y')) }}" required>
        </div>
    </div>

    <!-- Peta Lokasi & Pencarian Geocoding -->
    <div class="mb-6">
        <label class="{{ $labelClass }}">Lokasi (Alamat Lengkap Ruas Jalan)</label>
        <input type="text" name="location" id="location_input" class="{{ $inputClass }}" value="{{ old('location', $road->location ?? '') }}" placeholder="Alamat atau patokan lokasi jalan" required>
        
        <div class="mt-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-3">
                <label class="block text-sm font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-geo-alt-fill text-brand-purple"></i> Titik Koordinat & Pencarian Peta
                </label>
                <span class="text-xs text-gray-500">Cari nama jalan atau klik langsung pada peta</span>
            </div>

            <!-- Search Bar Peta -->
            <div class="relative mb-3">
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="bi bi-search"></i>
                        </div>
                        <input 
                            type="text" 
                            x-model="searchQuery" 
                            @keydown.enter.prevent="searchLocation"
                            placeholder="Ketik nama jalan / kelurahan / tempat (misal: Jl. ZA Pagar Alam, Bandar Lampung)..." 
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border bg-white"
                        >
                        <button 
                            type="button" 
                            x-show="searchQuery" 
                            @click="searchQuery = ''; searchResults = []" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                        >
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </div>
                    <button 
                        type="button" 
                        @click="searchLocation" 
                        :disabled="isSearching"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-purple hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-purple disabled:opacity-50 transition-colors"
                    >
                        <span x-show="!isSearching" class="flex items-center gap-1.5"><i class="bi bi-geo"></i> Cari di Peta</span>
                        <span x-show="isSearching" class="flex items-center gap-1.5"><i class="bi bi-arrow-repeat animate-spin"></i> Mencari...</span>
                    </button>
                </div>

                <!-- Dropdown Hasil Pencarian -->
                <div 
                    x-show="searchResults.length > 0" 
                    @click.away="searchResults = []" 
                    class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto z-50 divide-y divide-gray-100"
                    x-cloak
                >
                    <template x-for="(result, index) in searchResults" :key="index">
                        <button 
                            type="button" 
                            @click="selectSearchResult(result)" 
                            class="w-full text-left px-4 py-3 hover:bg-brand-purple/5 transition-colors flex items-start gap-2.5 text-sm text-gray-800"
                        >
                            <i class="bi bi-pin-map text-brand-purple mt-0.5 flex-shrink-0"></i>
                            <span class="truncate" x-text="result.display_name"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Map Element -->
            <div id="map" class="h-72 w-full rounded-lg border border-gray-300 mb-3 shadow-inner relative" style="z-index: 10;"></div>

            <!-- Koordinat Input -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Latitude</label>
                    <input type="text" id="latitude" name="latitude" class="{{ $inputClass }} bg-white font-mono text-xs" readonly placeholder="Contoh: -5.397140" value="{{ old('latitude', $road->latitude ?? '') }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Longitude</label>
                    <input type="text" id="longitude" name="longitude" class="{{ $inputClass }} bg-white font-mono text-xs" readonly placeholder="Contoh: 105.266792" value="{{ old('longitude', $road->longitude ?? '') }}">
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                <i class="bi bi-info-circle text-brand-purple"></i> Anda juga dapat menggeser peta dan mengklik titik kerusakan jalan secara langsung.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div>
            <label class="{{ $labelClass }}">Kecamatan</label>
            <select name="kecamatan" class="{{ $inputClass }}" required>
                <option value="" {{ old('kecamatan', $road->kecamatan ?? '') == '' ? 'selected' : '' }}>Pilih Kecamatan</option>
                <option value="Kecamatan A" {{ old('kecamatan', $road->kecamatan ?? '') == 'Kecamatan A' ? 'selected' : '' }}>Kecamatan A</option>
                <option value="Kecamatan B" {{ old('kecamatan', $road->kecamatan ?? '') == 'Kecamatan B' ? 'selected' : '' }}>Kecamatan B</option>
                <option value="Kecamatan C" {{ old('kecamatan', $road->kecamatan ?? '') == 'Kecamatan C' ? 'selected' : '' }}>Kecamatan C</option>
            </select>
        </div>
        <div>
            <label class="{{ $labelClass }}">Kelurahan</label>
            <select name="kelurahan" class="{{ $inputClass }}" required>
                <option value="" {{ old('kelurahan', $road->kelurahan ?? '') == '' ? 'selected' : '' }}>Pilih Kelurahan</option>
                <option value="Kelurahan X" {{ old('kelurahan', $road->kelurahan ?? '') == 'Kelurahan X' ? 'selected' : '' }}>Kelurahan X</option>
                <option value="Kelurahan Y" {{ old('kelurahan', $road->kelurahan ?? '') == 'Kelurahan Y' ? 'selected' : '' }}>Kelurahan Y</option>
                <option value="Kelurahan Z" {{ old('kelurahan', $road->kelurahan ?? '') == 'Kelurahan Z' ? 'selected' : '' }}>Kelurahan Z</option>
            </select>
        </div>
        <div>
            <label class="{{ $labelClass }}">RT</label>
            <select name="rt" class="{{ $inputClass }}" required>
                <option value="" {{ old('rt', $road->rt ?? '') == '' ? 'selected' : '' }}>Pilih RT</option>
                @for($i=1;$i<=10;$i++)
                    <option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}" {{ old('rt', $road->rt ?? '') == str_pad($i,2,'0',STR_PAD_LEFT) ? 'selected' : '' }}>RT {{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="{{ $labelClass }}">Kepentingan Jalan (C5)</label>
            <select name="importance" class="{{ $inputClass }}" required>
                <option value="" {{ old('importance', $road->importance ?? '') == '' ? 'selected' : '' }}>Pilih kepentingan</option>
                <option value="sekolah" {{ old('importance', $road->importance ?? '') == 'sekolah' ? 'selected' : '' }}>Sekolah (Bobot Utama)</option>
                <option value="pasar" {{ old('importance', $road->importance ?? '') == 'pasar' ? 'selected' : '' }}>Pasar (Pusat Ekonomi)</option>
                <option value="kantor" {{ old('importance', $road->importance ?? '') == 'kantor' ? 'selected' : '' }}>Kantor Dinas Kota (Pelayanan)</option>
                <option value="lainnya" {{ old('importance', $road->importance ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>
        <div>
            <label class="{{ $labelClass }}">Jarak dari Kantor Dinas Pusat (km) (C6)</label>
            <input type="number" step="0.01" name="distance" class="{{ $inputClass }}" value="{{ old('distance', $road->distance ?? '') }}" placeholder="Contoh: 3.5" required>
        </div>
    </div>

    <!-- Data Kerusakan Inti -->
    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 mb-6 shadow-sm">
        <h3 class="font-bold text-lg mb-4 text-gray-800 flex items-center gap-2">
            <i class="bi bi-cone-striped text-brand-yellow"></i> Data Kerusakan Jalan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
            <div>
                <label class="{{ $labelClass }}">Banyaknya Lubang (C4)</label>
                <select name="holes_count" x-model.number="holesCount" @change="generatePotholes" class="{{ $inputClass }}" required>
                    <option value="0">0 Buah (Tidak ada lubang)</option>
                    @for($i=1; $i<=20; $i++)
                        <option value="{{ $i }}">{{ $i }} Buah</option>
                    @endfor
                </select>
                <p class="text-xs text-gray-500 mt-1">Pilih jumlah lubang, form ukuran lubang akan otomatis muncul di bawah.</p>
            </div>
            <div>
                <label class="{{ $labelClass }}">Panjang Kerusakan Total (m) (C1)</label>
                <input type="number" step="0.01" name="length" class="{{ $inputClass }}" value="{{ old('length', $road->length ?? '') }}" placeholder="Contoh: 15.5" required>
            </div>
            <div>
                <label class="{{ $labelClass }}">Lebar Jalan (m) (C2)</label>
                <input type="number" step="0.01" name="width" class="{{ $inputClass }}" value="{{ old('width', $road->width ?? '') }}" placeholder="Contoh: 6.0" required>
            </div>
        </div>

        <!-- Form Dinamis Lubang -->
        <div x-show="holesCount > 0" class="mt-6 border-t border-gray-200 pt-4" x-cloak>
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-bold text-gray-800 text-sm flex items-center gap-1.5">
                    <i class="bi bi-list-nested text-brand-purple"></i> Dimensi Masing-masing Lubang (Kedalaman = C3)
                </h4>
                <span class="text-xs font-semibold px-2 py-0.5 bg-brand-purple/10 text-brand-purple rounded-full">
                    <span x-text="holesCount"></span> Lubang Terdaftar
                </span>
            </div>
            <div class="space-y-4">
                <template x-for="(hole, index) in potholes" :key="index">
                    <div class="bg-white p-4 border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between mb-3 border-b border-gray-100 pb-2">
                            <span class="font-bold text-brand-purple text-sm flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded-full bg-brand-purple text-white inline-flex items-center justify-center text-xs" x-text="index + 1"></span>
                                Lubang ke-<span x-text="index + 1"></span>
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="{{ $labelClass }}">Panjang (cm)</label>
                                <input type="number" step="0.1" :name="`potholes_data[${index}][length]`" x-model="hole.length" class="{{ $inputClass }}" placeholder="Panjang lubang" required>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Lebar/Diameter (cm)</label>
                                <input type="number" step="0.1" :name="`potholes_data[${index}][width]`" x-model="hole.width" class="{{ $inputClass }}" placeholder="Lebar lubang" required>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Kedalaman (cm) <span class="text-brand-purple font-semibold">*C3</span></label>
                                <input type="number" step="0.1" :name="`potholes_data[${index}][depth]`" x-model="hole.depth" class="{{ $inputClass }}" placeholder="Kedalaman lubang" required>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Media -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="{{ $labelClass }}">Foto Dokumentasi</label>
            <input type="file" name="photo" class="{{ $inputClass }} file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-purple/10 file:text-brand-purple hover:file:bg-brand-purple/20" accept="image/*">
            @if (!empty($road?->photo))
                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1"><i class="bi bi-image"></i> Foto saat ini: {{ basename($road->photo) }}</p>
            @endif
        </div>
        <div>
            <label class="{{ $labelClass }}">Video Dokumentasi (Opsional)</label>
            <input type="file" name="video" class="{{ $inputClass }} file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-purple/10 file:text-brand-purple hover:file:bg-brand-purple/20" accept="video/mp4,video/quicktime,video/x-msvideo,video/mkv">
            @if (!empty($road?->video))
                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1"><i class="bi bi-film"></i> Video saat ini: {{ basename($road->video) }}</p>
            @endif
        </div>
    </div>

    <div class="mb-6">
        <label class="{{ $labelClass }}">Catatan Khusus</label>
        <textarea name="notes" class="{{ $inputClass }}" rows="3" placeholder="Tambahkan catatan penting tentang kondisi jalan...">{{ old('notes', $road->notes ?? '') }}</textarea>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('roadForm', () => ({
            holesCount: {{ old('holes_count', $road->holes_count ?? 0) }},
            potholes: {!! json_encode(old('potholes_data', $road->potholes_data ?? [])) !!},
            searchQuery: '',
            searchResults: [],
            isSearching: false,
            map: null,
            marker: null,
            
            init() {
                if (this.potholes.length === 0 && this.holesCount > 0) {
                    this.generatePotholes();
                }
                
                setTimeout(() => {
                    this.initMap();
                }, 150);
            },
            
            generatePotholes() {
                const currentLength = this.potholes.length;
                if (this.holesCount > currentLength) {
                    for (let i = currentLength; i < this.holesCount; i++) {
                        this.potholes.push({ length: '', width: '', depth: '' });
                    }
                } else if (this.holesCount < currentLength) {
                    this.potholes = this.potholes.slice(0, this.holesCount);
                }
            },

            initMap() {
                const latInput = document.getElementById('latitude');
                const lngInput = document.getElementById('longitude');
                
                let initialLat = latInput.value ? parseFloat(latInput.value) : -5.450000;
                let initialLng = lngInput.value ? parseFloat(lngInput.value) : 105.266670;
                let zoomLevel = latInput.value ? 16 : 13;

                this.map = L.map('map').setView([initialLat, initialLng], zoomLevel);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(this.map);

                if (latInput.value && lngInput.value) {
                    this.marker = L.marker([initialLat, initialLng]).addTo(this.map);
                }

                this.map.on('click', (e) => {
                    const lat = e.latlng.lat.toFixed(8);
                    const lng = e.latlng.lng.toFixed(8);

                    latInput.value = lat;
                    lngInput.value = lng;

                    if (this.marker) {
                        this.marker.setLatLng(e.latlng);
                    } else {
                        this.marker = L.marker(e.latlng).addTo(this.map);
                    }
                });
            },

            async searchLocation() {
                if (!this.searchQuery || this.searchQuery.trim().length < 3) {
                    return;
                }

                this.isSearching = true;
                this.searchResults = [];

                try {
                    const endpoint = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery.trim())}&limit=5&countrycodes=id`;
                    const response = await fetch(endpoint, {
                        headers: {
                            'Accept-Language': 'id'
                        }
                    });
                    
                    if (response.ok) {
                        this.searchResults = await response.json();
                    }
                } catch (error) {
                    console.error('Error fetching geocoding:', error);
                } finally {
                    this.isSearching = false;
                }
            },

            selectSearchResult(result) {
                const lat = parseFloat(result.lat);
                const lon = parseFloat(result.lon);

                document.getElementById('latitude').value = lat.toFixed(8);
                document.getElementById('longitude').value = lon.toFixed(8);

                const locationInput = document.getElementById('location_input');
                if (!locationInput.value || locationInput.value.trim() === '') {
                    locationInput.value = result.display_name;
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
            }
        }));
    });
</script>
<style>
    [x-cloak] { display: none !important; }
    .leaflet-container { z-index: 10 !important; }
</style>
