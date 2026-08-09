@php
$labelClass = "block text-sm font-medium text-gray-700 mb-1";
$inputClass = "mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border";
@endphp

<!-- Tambahkan script Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div x-data="roadForm()">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="{{ $labelClass }}">Nama Ruas Jalan</label>
            <input type="text" name="name" class="{{ $inputClass }}" value="{{ old('name', $road->name ?? '') }}" required>
        </div>
        <div>
            <label class="{{ $labelClass }}">Tahun Survei</label>
            <input type="number" name="survey_year" class="{{ $inputClass }}" value="{{ old('survey_year', $road->survey_year ?? date('Y')) }}" required>
        </div>
    </div>

    <!-- Peta Lokasi -->
    <div class="mb-6">
        <label class="{{ $labelClass }}">Lokasi (Alamat Lengkap)</label>
        <input type="text" name="location" class="{{ $inputClass }}" value="{{ old('location', $road->location ?? '') }}" required>
        
        <div class="mt-4">
            <label class="{{ $labelClass }}">Titik Koordinat (Klik pada peta)</label>
            <div id="map" class="h-64 w-full rounded-md border border-gray-300 mb-2 z-0 relative" style="z-index: 10;"></div>
            <div class="flex gap-4">
                <div class="flex-1">
                    <input type="text" id="latitude" name="latitude" class="{{ $inputClass }} bg-gray-50" readonly placeholder="Latitude" value="{{ old('latitude', $road->latitude ?? '') }}">
                </div>
                <div class="flex-1">
                    <input type="text" id="longitude" name="longitude" class="{{ $inputClass }} bg-gray-50" readonly placeholder="Longitude" value="{{ old('longitude', $road->longitude ?? '') }}">
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1">Gunakan scroll untuk zoom. Klik titik lokasi ruas jalan pada peta.</p>
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
            <label class="{{ $labelClass }}">Kepentingan Jalan</label>
            <select name="importance" class="{{ $inputClass }}" required>
                <option value="" {{ old('importance', $road->importance ?? '') == '' ? 'selected' : '' }}>Pilih kepentingan</option>
                <option value="sekolah" {{ old('importance', $road->importance ?? '') == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                <option value="pasar" {{ old('importance', $road->importance ?? '') == 'pasar' ? 'selected' : '' }}>Pasar</option>
                <option value="kantor" {{ old('importance', $road->importance ?? '') == 'kantor' ? 'selected' : '' }}>Kantor Dinas Kota</option>
                <option value="lainnya" {{ old('importance', $road->importance ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>
        <div>
            <label class="{{ $labelClass }}">Jarak dari Kantor Dinas Pusat (km)</label>
            <input type="number" step="0.01" name="distance" class="{{ $inputClass }}" value="{{ old('distance', $road->distance ?? '') }}" required>
        </div>
    </div>

    <!-- Data Kerusakan Inti -->
    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6">
        <h3 class="font-bold text-lg mb-4 text-gray-800"><i class="bi bi-exclamation-triangle"></i> Data Kerusakan Jalan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
            <div>
                <label class="{{ $labelClass }}">Banyaknya Lubang (C4)</label>
                <select name="holes_count" x-model.number="holesCount" @change="generatePotholes" class="{{ $inputClass }}" required>
                    <option value="0">Tidak ada lubang</option>
                    @for($i=1; $i<=20; $i++)
                        <option value="{{ $i }}">{{ $i }} Buah</option>
                    @endfor
                </select>
                <p class="text-xs text-gray-500 mt-1">Pilih jumlah lubang, form ukuran lubang akan otomatis muncul di bawah.</p>
            </div>
            <div>
                <label class="{{ $labelClass }}">Panjang Kerusakan Total (m) (C1)</label>
                <input type="number" step="0.01" name="length" class="{{ $inputClass }}" value="{{ old('length', $road->length ?? '') }}" required>
            </div>
            <div>
                <label class="{{ $labelClass }}">Lebar Jalan (m) (C2)</label>
                <input type="number" step="0.01" name="width" class="{{ $inputClass }}" value="{{ old('width', $road->width ?? '') }}" required>
            </div>
        </div>

        <!-- Form Dinamis Lubang -->
        <div x-show="holesCount > 0" class="mt-6 border-t border-gray-200 pt-4" x-cloak>
            <h4 class="font-semibold text-gray-700 mb-3">Dimensi Masing-masing Lubang (Kedalaman = C3)</h4>
            <div class="space-y-4">
                <template x-for="(hole, index) in potholes" :key="index">
                    <div class="bg-white p-4 border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-semibold text-brand-purple text-sm">Lubang ke-<span x-text="index + 1"></span></span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="{{ $labelClass }}">Panjang (cm)</label>
                                <input type="number" step="0.1" :name="`potholes_data[${index}][length]`" x-model="hole.length" class="{{ $inputClass }}" required>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Lebar/Diameter (cm)</label>
                                <input type="number" step="0.1" :name="`potholes_data[${index}][width]`" x-model="hole.width" class="{{ $inputClass }}" required>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Kedalaman (cm)</label>
                                <input type="number" step="0.1" :name="`potholes_data[${index}][depth]`" x-model="hole.depth" class="{{ $inputClass }}" required>
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
            <input type="file" name="video" class="{{ $inputClass }} file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-purple/10 file:text-brand-purple hover:file:bg-brand-purple/20" accept="video/mp4,video/quicktime,video/x-msvideo">
            @if (!empty($road?->video))
                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1"><i class="bi bi-film"></i> Video saat ini: {{ basename($road->video) }}</p>
            @endif
        </div>
    </div>

    <div class="mb-6">
        <label class="{{ $labelClass }}">Catatan Khusus</label>
        <textarea name="notes" class="{{ $inputClass }}" rows="3">{{ old('notes', $road->notes ?? '') }}</textarea>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('roadForm', () => ({
            holesCount: {{ old('holes_count', $road->holes_count ?? 0) }},
            potholes: {!! json_encode(old('potholes_data', $road->potholes_data ?? [])) !!},
            
            init() {
                // Ensure initial generation if arrays are empty but holesCount > 0
                if (this.potholes.length === 0 && this.holesCount > 0) {
                    this.generatePotholes();
                }
                
                // Initialize Leaflet Map
                setTimeout(() => {
                    this.initMap();
                }, 100);
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
                let zoomLevel = latInput.value ? 16 : 12;

                const map = L.map('map').setView([initialLat, initialLng], zoomLevel);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                let marker;
                if (latInput.value && lngInput.value) {
                    marker = L.marker([initialLat, initialLng]).addTo(map);
                }

                map.on('click', function(e) {
                    const lat = e.latlng.lat.toFixed(8);
                    const lng = e.latlng.lng.toFixed(8);

                    latInput.value = lat;
                    lngInput.value = lng;

                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng).addTo(map);
                    }
                });
            }
        }));
    });
</script>
<style>
    [x-cloak] { display: none !important; }
    /* Leaflet z-index fix */
    .leaflet-container { z-index: 10 !important; }
</style>
