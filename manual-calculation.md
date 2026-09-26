# Perhitungan Metode MOORA — Prioritas Perbaikan Jalan

**Alternatif (ruas jalan):**
- **A1** → Jl. Letjen Alamsyah Ratu Prawiranegara
- **A2** → Jl. Urip Sumoharjo, Wayhalim Permai
- **A3** → Jl. Endro Suratmin (Jalur 2 sisi timur)
- **A4** → Jl. Endro Suratmin (Jalur 2 sisi barat)
- **A5** → Jl. Endro Suratmin (depan UIN)

**Kriteria:** C1, C2, C3, C4, C5 (bobot masing-masing ditentukan pada tahap 3)

---

## 1. Matriks Keputusan Awal (Skala Likert)

| Alternatif | C1 | C2 | C3 | C4 | C5 |
|---|---|---|---|---|---|
| A1 | 3 | 5 | 5 | 1 | 1 |
| A2 | 1 | 1 | 4 | 1 | 1 |
| A3 | 2 | 5 | 4 | 5 | 4 |
| A4 | 3 | 5 | 5 | 3 | 4 |
| A5 | 5 | 5 | 5 | 3 | 4 |

---

## 2. Normalisasi Matriks (Metode Vektor)

Setiap kolom dinormalisasi dengan membagi tiap nilai dengan akar jumlah kuadrat seluruh nilai pada kolom tersebut.

**Menghitung penyebut (pembagi) tiap kriteria:**

$$C_1 = \sqrt{3^2+1^2+2^2+3^2+5^2} = \sqrt{9+1+4+9+25} = \sqrt{48} = 6{,}928$$

$$C_2 = \sqrt{5^2+1^2+5^2+5^2+5^2} = \sqrt{25+1+25+25+25} = \sqrt{101} = 10{,}0499$$

$$C_3 = \sqrt{5^2+4^2+4^2+5^2+5^2} = \sqrt{25+16+16+25+25} = \sqrt{107} = 10{,}3441$$

$$C_4 = \sqrt{1^2+1^2+5^2+3^2+3^2} = \sqrt{1+1+25+9+9} = \sqrt{45} = 6{,}7082$$

$$C_5 = \sqrt{1^2+1^2+4^2+4^2+4^2} = \sqrt{1+1+16+16+16} = \sqrt{50} = 7{,}0711$$

**Ringkasan nilai pembagi:**

| Kriteria | Nilai Pembagi |
|---|---|
| C1 | 6,928 |
| C2 | 10,0499 |
| C3 | 10,3441 |
| C4 | 6,7082 |
| C5 | 7,0711 |

### Hasil pembagian tiap alternatif

**Kriteria C1** (pembagi 6,928)

| Alternatif | Perhitungan | Hasil |
|---|---|---|
| A1 | 3 / 6,928 | 0,4330 |
| A2 | 1 / 6,928 | 0,1443 |
| A3 | 2 / 6,928 | 0,2886 |
| A4 | 3 / 6,928 | 0,4335 |
| A5 | 5 / 6,928 | 0,7217 |

**Kriteria C2** (pembagi 10,0499)

| Alternatif | Perhitungan | Hasil |
|---|---|---|
| A1 | 5 / 10,0499 | 0,4975 |
| A2 | 1 / 10,0499 | 0,0995 |
| A3 | 5 / 10,0499 | 0,4975 |
| A4 | 5 / 10,0499 | 0,4975 |
| A5 | 5 / 10,0499 | 0,4975 |

**Kriteria C3** (pembagi 10,3441)

| Alternatif | Perhitungan | Hasil |
|---|---|---|
| A1 | 5 / 10,3441 | 0,4833 |
| A2 | 4 / 10,3441 | 0,3866 |
| A3 | 4 / 10,3441 | 0,3866 |
| A4 | 5 / 10,3441 | 0,4833 |
| A5 | 5 / 10,3441 | 0,4833 |

**Kriteria C4** (pembagi 6,7082)

| Alternatif | Perhitungan | Hasil |
|---|---|---|
| A1 | 1 / 6,7082 | 0,1490 |
| A2 | 1 / 6,7082 | 0,1490 |
| A3 | 5 / 6,7082 | 0,7453 |
| A4 | 3 / 6,7082 | 0,4472 |
| A5 | 3 / 6,7082 | 0,4472 |

**Kriteria C5** (pembagi 7,0711)

| Alternatif | Perhitungan | Hasil |
|---|---|---|
| A1 | 1 / 7,0711 | 0,1414 |
| A2 | 1 / 7,0711 | 0,1414 |
| A3 | 4 / 7,0711 | 0,5656 |
| A4 | 4 / 7,0711 | 0,5656 |
| A5 | 4 / 7,0711 | 0,5656 |

### Matriks Ternormalisasi (Rangkuman)

| Alternatif | C1 | C2 | C3 | C4 | C5 |
|---|---|---|---|---|---|
| A1 | 0,4330 | 0,4975 | 0,4833 | 0,1490 | 0,1414 |
| A2 | 0,1443 | 0,0995 | 0,3866 | 0,1490 | 0,1414 |
| A3 | 0,2886 | 0,4975 | 0,3866 | 0,7453 | 0,5656 |
| A4 | 0,4335 | 0,4975 | 0,4833 | 0,4472 | 0,5656 |
| A5 | 0,7217 | 0,4975 | 0,4833 | 0,4472 | 0,5656 |

---

## 3. Matriks Ternormalisasi Terbobot

Bobot kriteria yang digunakan:

| Kriteria | Bobot |
|---|---|
| C1 | 0,20 |
| C2 | 0,20 |
| C3 | 0,20 |
| C4 | 0,25 |
| C5 | 0,15 |
| **Total** | **1,00** |

Setiap nilai pada matriks ternormalisasi dikalikan dengan bobot kriterianya:

| Alternatif | C1 × 0,20 | C2 × 0,20 | C3 × 0,20 | C4 × 0,25 | C5 × 0,15 |
|---|---|---|---|---|---|
| A1 | 0,0866 | 0,0995 | 0,0966 | 0,0372 | 0,0212 |
| A2 | 0,0288 | 0,0199 | 0,0773 | 0,0372 | 0,0212 |
| A3 | 0,0577 | 0,0995 | 0,0773 | 0,1863 | 0,0848 |
| A4 | 0,0867 | 0,0995 | 0,0966 | 0,1118 | 0,0848 |
| A5 | 0,1443 | 0,0995 | 0,0966 | 0,1118 | 0,0848 |

---

## 4. Menghitung Nilai Optimasi (Yi)

Karena seluruh kriteria bersifat **benefit**, maka rumus optimasinya:

$$Y_i = \sum_{j=1}^{5} V_{ij}$$

**A1:**
$$Y_1 = 0{,}0866+0{,}0995+0{,}0966+0{,}0372+0{,}0212 = 0{,}3411$$

**A2:**
$$Y_2 = 0{,}0288+0{,}0199+0{,}0773+0{,}0372+0{,}0212 = 0{,}1844$$

**A3:**
$$Y_3 = 0{,}0577+0{,}0995+0{,}0773+0{,}1863+0{,}0848 = 0{,}5056$$

**A4:**
$$Y_4 = 0{,}0867+0{,}0995+0{,}0966+0{,}1118+0{,}0848 = 0{,}4794$$

**A5:**
$$Y_5 = 0{,}1443+0{,}0995+0{,}0966+0{,}1118+0{,}0848 = 0{,}5372$$

---

## 5. Hasil Peringkat Prioritas

| Rank | Alternatif | Nilai Yi |
|---|---|---|
| 1 | A5 → Jl. Endro Suratmin (depan UIN) | 0,5372 |
| 2 | A3 → Jl. Endro Suratmin (Jalur 2 sisi timur) | 0,5058 |
| 3 | A4 → Jl. Endro Suratmin (Jalur 2 sisi barat) | 0,4794 |
| 4 | A1 → Jl. Letjen Alamsyah Ratu Prawiranegara | 0,3413 |
| 5 | A2 → Jl. Urip Sumoharjo, Wayhalim Permai | 0,1846 |

> **Kesimpulan:** Prioritas perbaikan jalan tertinggi jatuh pada **A5 – Jl. Endro Suratmin (depan UIN)** dengan nilai optimasi 0,5372, disusul A3, A4, A1, dan terakhir A2.

*Catatan: selisih kecil (±0,0002) antara nilai Yi pada tahap 4 dan tabel akhir di atas berasal dari pembulatan bertahap pada catatan asli.*