@php
$labelClass = "block text-sm font-medium text-gray-700 mb-1";
$inputClass = "mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2.5 border bg-white";
@endphp

<!-- Leaflet CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div x-data="roadForm()">
    <!-- Tahun Survei & Lokasi Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Lokasi / Alamat Ruas Jalan</label>
            <input type="text" name="location" id="location_input" class="{{ $inputClass }}" value="{{ old('location', $road->location ?? '') }}" placeholder="Contoh: Jl. Raden Intan No. 12, Enggal" required>
        </div>
        <div>
            <label class="{{ $labelClass }}">Tahun Survei</label>
            <input type="number" name="survey_year" class="{{ $inputClass }}" value="{{ old('survey_year', $road->survey_year ?? date('Y')) }}" required>
        </div>
    </div>

    <!-- Peta Lokasi & Pencarian Geocoding -->
    <div class="mb-6">
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
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

    <!-- 20 Kecamatan & Kelurahan Dinamis Kota Bandar Lampung -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="{{ $labelClass }}">Kecamatan (20 Kecamatan Bandar Lampung)</label>
            <select name="kecamatan" x-model="selectedKecamatan" @change="onKecamatanChange()" class="{{ $inputClass }}" required>
                <option value="">-- Pilih Kecamatan --</option>
                <template x-for="kec in kecamatanList" :key="kec">
                    <option :value="kec" x-text="kec" :selected="selectedKecamatan === kec"></option>
                </template>
            </select>
        </div>
        <div>
            <label class="{{ $labelClass }}">Kelurahan</label>
            <select name="kelurahan" x-model="selectedKelurahan" class="{{ $inputClass }}" required>
                <option value="">-- Pilih Kelurahan --</option>
                <template x-for="kel in availableKelurahans" :key="kel">
                    <option :value="kel" x-text="kel" :selected="selectedKelurahan === kel"></option>
                </template>
            </select>
        </div>
    </div>

    <!-- Parameter Kondisi Kerusakan Jalan (Dropdown) -->
    <div class="bg-purple-50/40 p-6 rounded-xl border border-purple-200/80 mb-6 shadow-xs">
        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-purple-100">
            <i class="bi bi-list-check text-brand-purple text-xl"></i>
            <div>
                <h3 class="font-bold text-gray-900 text-base">Parameter Kondisi Kerusakan Jalan</h3>
                <p class="text-xs text-gray-500">Pilih rentang kondisi sesuai dengan hasil survei lapangan.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- C1: Panjang Kerusakan Jalan -->
            <div>
                <label class="{{ $labelClass }}">
                    <span>Panjang Kerusakan Jalan</span>
                </label>
                <select name="c1_panjang" class="{{ $inputClass }}" required>
                    <option value="">-- Pilih Panjang Kerusakan --</option>
                    @foreach(\App\Models\Road::getC1Options() as $val => $text)
                        <option value="{{ $val }}" {{ old('c1_panjang', $road->c1_panjang ?? '') == $val ? 'selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- C2: Lebar Jalan -->
            <div>
                <label class="{{ $labelClass }}">
                    <span>Lebar Jalan</span>
                </label>
                <select name="c2_lebar" class="{{ $inputClass }}" required>
                    <option value="">-- Pilih Lebar Jalan --</option>
                    @foreach(\App\Models\Road::getC2Options() as $val => $text)
                        <option value="{{ $val }}" {{ old('c2_lebar', $road->c2_lebar ?? '') == $val ? 'selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- C3: Kedalaman Lubang -->
            <div>
                <label class="{{ $labelClass }}">
                    <span>Kedalaman Lubang</span>
                </label>
                <select name="c3_kedalaman" class="{{ $inputClass }}" required>
                    <option value="">-- Pilih Kedalaman Lubang --</option>
                    @foreach(\App\Models\Road::getC3Options() as $val => $text)
                        <option value="{{ $val }}" {{ old('c3_kedalaman', $road->c3_kedalaman ?? '') == $val ? 'selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- C4: Banyaknya Lubang -->
            <div>
                <label class="{{ $labelClass }}">
                    <span>Banyaknya Lubang</span>
                </label>
                <select name="c4_lubang" class="{{ $inputClass }}" required>
                    <option value="">-- Pilih Banyaknya Lubang --</option>
                    @foreach(\App\Models\Road::getC4Options() as $val => $text)
                        <option value="{{ $val }}" {{ old('c4_lubang', $road->c4_lubang ?? '') == $val ? 'selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- C5: Tingkat Kepentingan Jalan -->
            <div class="md:col-span-2">
                <label class="{{ $labelClass }}">
                    <span>Tingkat Kepentingan Jalan</span>
                </label>
                <select name="c5_kepentingan" class="{{ $inputClass }}" required>
                    <option value="">-- Pilih Kepentingan Jalan --</option>
                    @foreach(\App\Models\Road::getC5Options() as $val => $text)
                        <option value="{{ $val }}" {{ old('c5_kepentingan', $road->c5_kepentingan ?? '') == $val ? 'selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>
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
            searchQuery: '',
            searchResults: [],
            isSearching: false,
            map: null,
            marker: null,

            // 20 Kecamatan Lengkap Kota Bandar Lampung beserta Kelurahannya
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

            selectedKecamatan: "{{ old('kecamatan', str_replace('Kecamatan ', '', $road->kecamatan ?? '')) }}",
            selectedKelurahan: "{{ old('kelurahan', str_replace('Kelurahan ', '', $road->kelurahan ?? '')) }}",
            availableKelurahans: [],
            
            init() {
                this.updateKelurahanList();

                setTimeout(() => {
                    this.initMap();
                }, 150);
            },

            onKecamatanChange() {
                this.updateKelurahanList();
                this.selectedKelurahan = '';
            },

            updateKelurahanList() {
                if (this.selectedKecamatan && this.kelurahanMap[this.selectedKecamatan]) {
                    this.availableKelurahans = this.kelurahanMap[this.selectedKecamatan];
                } else {
                    this.availableKelurahans = [];
                }
            },

            initMap() {
                const latInput = document.getElementById('latitude');
                const lngInput = document.getElementById('longitude');
                
                let initialLat = latInput.value ? parseFloat(latInput.value) : -5.385500;
                let initialLng = lngInput.value ? parseFloat(lngInput.value) : 105.275000;
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
