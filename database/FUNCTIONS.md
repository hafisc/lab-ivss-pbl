# 📚 Dokumentasi Functions & Stored Procedures - Lab IVSS

## Daftar Isi
- [Triggers](#triggers)
- [Helper Functions](#helper-functions)
- [Business Logic Procedures](#business-logic-procedures)
- [Statistics & Reports](#statistics--reports)
- [Contoh Penggunaan](#contoh-penggunaan)

---

## 🔄 Triggers

### Auto Update Timestamp
Triggers ini otomatis mengupdate kolom `updated_at` setiap kali ada UPDATE pada tabel.

**Tabel yang menggunakan trigger:**
- `users`
- `dosen`
- `mahasiswa`
- `research`
- `news`

**Function Helper:**
```sql
update_updated_at_column() RETURNS TRIGGER
```

---

## 🛠️ Helper Functions

### 1. `get_user_details(p_user_id INTEGER)`
Mendapatkan informasi lengkap user dengan role name.

**Returns:**
- `user_id`, `username`, `email`, `role_name`, `status`, `photo`, `bio`, `created_at`, `last_login`

**Contoh:**
```sql
SELECT * FROM get_user_details(3);
```

---

### 2. `get_dosen_details(p_user_id INTEGER)`
Mendapatkan informasi lengkap dosen.

**Returns:**
- `user_id`, `username`, `email`, `dosen_id`, `nip`, `nama`, `origin`, `no_hp`, `status`

**Contoh:**
```sql
SELECT * FROM get_dosen_details(3);
```

---

### 3. `get_mahasiswa_details(p_user_id INTEGER)`
Mendapatkan informasi lengkap mahasiswa dengan info supervisor.

**Returns:**
- `user_id`, `username`, `email`, `mahasiswa_id`, `nim`, `nama`, `angkatan`, `research_title`, `no_phone`, `supervisor_id`, `supervisor_nama`, `status`

**Contoh:**
```sql
SELECT * FROM get_mahasiswa_details(6);
```

---

### 4. `count_mahasiswa_by_dosen(p_dosen_id INTEGER)` 
Menghitung jumlah mahasiswa bimbingan per dosen.

**Returns:** `INTEGER`

**Contoh:**
```sql
SELECT count_mahasiswa_by_dosen(1);  -- Returns: 1
```

---

### 5. `get_research_members(p_research_id INTEGER)`
Mendapatkan daftar member dari research tertentu.

**Returns:**
- `user_id`, `username`, `nama`, `role_member`, `status`

**Contoh:**
```sql
SELECT * FROM get_research_members(1);
```

---

### 6. `get_pending_registrations_by_supervisor(p_supervisor_user_id INTEGER)`
Mendapatkan daftar pendaftar yang menunggu approval dari dosen tertentu.

**Returns:**
- `registration_id`, `nama`, `email`, `nim`, `research_title`, `motivation`, `created_at`

**Contoh:**
```sql
-- Get pendaftar untuk Dr. Budi (user_id = 3)
SELECT * FROM get_pending_registrations_by_supervisor(3);
```

---

## 📋 Business Logic Procedures

### 1. `update_last_login(p_user_id INTEGER)`
Update timestamp last login user.

**Contoh:**
```sql
CALL update_last_login(3);
```

---

### 2. `approve_registration_supervisor(p_registration_id INTEGER, p_notes TEXT)`
Approve pendaftar oleh dosen. Status berubah dari `pending_supervisor` → `pending_lab_head`.

**Fitur:**
- Update status registration
- Simpan notes dari dosen
- Buat notifikasi untuk ketua lab

**Contoh:**
```sql
CALL approve_registration_supervisor(1, 'Mahasiswa potensial, disetujui untuk lanjut ke ketua lab');
```

---

### 3. `reject_registration_supervisor(p_registration_id INTEGER, p_notes TEXT)`
Reject pendaftar oleh dosen. Status berubah ke `rejected_supervisor`.

**Contoh:**
```sql
CALL reject_registration_supervisor(2, 'Motivasi kurang sesuai dengan riset yang dipilih');
```

---

### 4. `approve_registration_lab_head(p_registration_id INTEGER, p_notes TEXT)`
Approve pendaftar oleh ketua lab dan **otomatis create user + mahasiswa**.

**Proses:**
1. Get data registration
2. Get `dosen_id` dari `supervisor_id`
3. Create user baru (role = mahasiswa)
4. Create record mahasiswa
5. Update status registration → `approved`
6. Buat notifikasi untuk dosen

**Contoh:**
```sql
CALL approve_registration_lab_head(6, 'Disetujui, selamat bergabung di Lab IVSS');
```

---

### 5. `reject_registration_lab_head(p_registration_id INTEGER, p_notes TEXT)`
Reject pendaftar oleh ketua lab.

**Contoh:**
```sql
CALL reject_registration_lab_head(6, 'Kuota lab sudah penuh untuk angkatan ini');
```

---

### 6. `add_member_to_research(p_research_id INTEGER, p_user_id INTEGER, p_role VARCHAR)`
Tambah member ke research project.

**Parameters:**
- `p_role`: 'leader' | 'member' | 'contributor' (default: 'member')

**Contoh:**
```sql
CALL add_member_to_research(1, 7, 'contributor');
```

---

### 7. `remove_member_from_research(p_research_id INTEGER, p_user_id INTEGER)`
Hapus member dari research project.

**Contoh:**
```sql
CALL remove_member_from_research(1, 7);
```

---

### 8. `mark_notification_read(p_notification_id INTEGER)`
Mark 1 notifikasi sebagai sudah dibaca.

**Contoh:**
```sql
CALL mark_notification_read(15);
```

---

### 9. `mark_all_notifications_read(p_user_id INTEGER)`
Mark semua notifikasi user sebagai sudah dibaca.

**Contoh:**
```sql
CALL mark_all_notifications_read(3);
```

---

### 10. `clean_expired_notifications()`
Hapus semua notifikasi yang sudah expired.

**Contoh:**
```sql
-- Bisa dijadwalkan via cron job
CALL clean_expired_notifications();
```

---

### 11. `update_equipment_condition(p_equipment_id INTEGER, p_condition VARCHAR, p_notes TEXT)`
Update kondisi peralatan lab.

**Condition:** 'baik' | 'maintenance' | 'rusak'

**Contoh:**
```sql
CALL update_equipment_condition(2, 'baik', 'Selesai service, normal kembali');
```

---

## 📊 Statistics & Reports

### 1. `get_active_users_by_role()`
Mendapatkan jumlah user aktif per role.

**Returns:**
- `role_name`, `total_users`

**Contoh:**
```sql
SELECT * FROM get_active_users_by_role();
```

**Output:**
| role_name | total_users |
|-----------|-------------|
| admin | 1 |
| ketua_lab | 1 |
| dosen | 3 |
| mahasiswa | 1 |

---

### 2. `get_research_statistics()`
Mendapatkan statistik research.

**Returns:**
- `total_research`, `active_research`, `completed_research`, `total_members`

**Contoh:**
```sql
SELECT * FROM get_research_statistics();
```

**Output:**
| total_research | active_research | completed_research | total_members |
|----------------|-----------------|--------------------|--------------| 
| 5 | 4 | 1 | 4 |

---

### 3. `get_pending_registrations_count()`
Mendapatkan jumlah pendaftar yang pending.

**Returns:**
- `pending_supervisor`, `pending_lab_head`, `total_pending`

**Contoh:**
```sql
SELECT * FROM get_pending_registrations_count();
```

---

### 4. `get_dosen_performance()`
Mendapatkan performance metrics setiap dosen.

**Returns:**
- `dosen_id`, `nama`, `jumlah_mahasiswa`, `jumlah_research`, `jumlah_publikasi`

**Contoh:**
```sql
SELECT * FROM get_dosen_performance();
```

**Output:**
| dosen_id | nama | jumlah_mahasiswa | jumlah_research | jumlah_publikasi |
|----------|------|------------------|-----------------|------------------|
| 1 | Dr. Budi Santoso | 1 | 2 | 3 |
| 2 | Dr. Andi Wijaya | 1 | 2 | 0 |
| 3 | Dr. Siti Nurhaliza | 0 | 1 | 0 |

---

## 💡 Contoh Penggunaan

### Workflow: Approval Pendaftar

```sql
-- 1. Dosen lihat pendaftar yang menunggu approval
SELECT * FROM get_pending_registrations_by_supervisor(3);

-- 2. Dosen approve pendaftar
CALL approve_registration_supervisor(1, 'Motivasi bagus, latar belakang sesuai');

-- 3. Ketua Lab approve dan create user+mahasiswa
CALL approve_registration_lab_head(1, 'Disetujui, selamat bergabung');

-- 4. Cek mahasiswa baru berhasil dibuat
SELECT * FROM get_mahasiswa_details(8);  -- user_id baru
```

---

### Workflow: Login User

```sql
-- 1. Cek kredensial dan get role
SELECT u.*, r.role_name 
FROM users u 
JOIN roles r ON u.role_id = r.id
WHERE u.email = 'ahmad@student.polinema.ac.id' 
AND u.password = '$2y$10$...'
LIMIT 1;

-- 2. Jika login success, update last_login
CALL update_last_login(6);

-- 3. Get detail lengkap based on role
-- Jika mahasiswa:
SELECT * FROM get_mahasiswa_details(6);
-- Jika dosen:
SELECT * FROM get_dosen_details(3);
```

---

### Workflow: Manage Research Members

```sql
-- 1. Lihat member research saat ini
SELECT * FROM get_research_members(1);

-- 2. Tambah member baru
CALL add_member_to_research(1, 7, 'contributor');

-- 3. Verify member berhasil ditambahkan
SELECT * FROM get_research_members(1);

-- 4. Hapus member jika diperlukan
CALL remove_member_from_research(1, 7);
```

---

### Workflow: Dashboard Stats

```sql
-- Get semua statistics untuk dashboard
SELECT * FROM get_active_users_by_role();
SELECT * FROM get_research_statistics();
SELECT * FROM get_pending_registrations_count();
SELECT * FROM get_dosen_performance();
```

---

## 🔐 Security Notes

> [!WARNING]
> **Stored Procedures dengan CREATE USER**
> 
> Procedure `approve_registration_lab_head()` akan **otomatis create user baru** di tabel `users` dan `mahasiswa`. 
> Pastikan hanya role `ketua_lab` yang bisa execute procedure ini!

> [!TIP]
> **Optimasi Performance**
> 
> Semua functions sudah menggunakan indexed columns untuk performa optimal:
> - `get_dosen_details()` → index `idx_dosen_user`
> - `get_mahasiswa_details()` → index `idx_mahasiswa_user`, `idx_mahasiswa_supervisor`
> - `count_mahasiswa_by_dosen()` → index `idx_mahasiswa_supervisor`

---

## 📝 Maintenance

### Cleanup Tasks (Recommended Cron Jobs)

```sql
-- Daily: Clean expired notifications (02:00 AM)
CALL clean_expired_notifications();

-- Weekly: Refresh statistics cache (if implemented)
-- Monthly: Archive old registrations
```

---

## 🚀 Best Practices

1. **Selalu gunakan stored procedures** untuk business logic kompleks (approval, rejection)
2. **Gunakan functions** untuk read-only operations (get details, statistics)
3. **Triggers otomatis** handle update timestamp, tidak perlu manual
4. **Transaction safety** - semua procedures sudah wrapped dalam implicit transaction

---

## 📖 See Also

- [CHANGELOG.md](file:///c:/laragon/www/Lab%20ivss/database/CHANGELOG.md) - Dokumentasi perubahan database
- [setup_database.sql](file:///c:/laragon/www/Lab%20ivss/database/setup_database.sql) - Full SQL script
