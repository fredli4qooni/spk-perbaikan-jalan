# Database schema summary

This file summarizes the main tables used by the application to make it easier to locate fields.

## users
- id, name, email, password, role (admin|petugas), ...

## criteria
- id, code (C1..), name, weight, type (benefit|cost), unit, description

## roads
- id
- name
- location
- survey_year
- photo
- notes
- length (decimal) - panjang jalan (m)
- width (decimal) - lebar jalan (m)
- holes_count (int) - banyaknya lubang
- hole_depth (decimal) - kedalaman lubang (cm)
- importance (string) - kategori kepentingan (sekolah/pasar/kantor/lainnya)
- kelurahan, kecamatan, rt
- is_verified, verified_by, verified_at
- timestamps

## road_scores
- id, road_id (fk), criterion_id (fk), value (float), notes

## account_requests
- fields for pending account requests (see migration files)

---

To update this summary with more details or export a full ERD, tell me and I can generate a more detailed `database/SCHEMA.md` or an image.