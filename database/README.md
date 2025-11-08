# Database Setup - Lab IVSS

## 📋 Quick Start

### 1️⃣ **Fresh Install (Database Baru)**

```sql
-- Di DBeaver / pgAdmin, jalankan:
\i setup_database.sql
```

Atau via command line:
```bash
psql -U USER -d lab_ivss -f setup_database.sql
```

---

### 2️⃣ **Reset Database (Hapus & Create Ulang)**

⚠️ **WARNING: Akan menghapus semua data!**

```sql
-- Step 1: Reset (hapus semua tabel)
\i reset_database.sql

-- Step 2: Create ulang
\i setup_database.sql
```

---

### 3️⃣ **Update Database (Tambah kolom/index baru)**

Jika sudah ada database dan hanya ingin update struktur:

```sql
-- Edit setup_database.sql, uncomment bagian:
-- Line 653-659: Tambah kolom bio
-- Line 662: Update last_login

-- Lalu execute hanya bagian UTILITY QUERIES (line 645-710)
```

---

## 📊 Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@ivss.polinema.ac.id | admin123 |
| **Ketua Lab** | ketualab@ivss.polinema.ac.id | admin123 |
| **Dosen 1** | budi.dosen@polinema.ac.id | admin123 |
| **Dosen 2** | andi.dosen@polinema.ac.id | admin123 |
| **Dosen 3** | siti.dosen@polinema.ac.id | admin123 |
| **Member** | ahmad@student.polinema.ac.id | admin123 |

---

## 🗂️ Database Structure

**12 Tables:**
1. `users` - User accounts (admin, ketua_lab, dosen, member)
2. `member_registrations` - Pending member approval
3. `research` - Research projects
4. `research_members` - Member-research relation
5. `research_documents` - Research documents
6. `member_publications` - Member personal publications
7. `news` - Lab news & articles
8. `equipment` - Lab equipment inventory
9. `publications` - Lab featured publications
10. `notifications` - System notifications
11. `system_settings` - System configuration

---

## 🔧 Common Issues

### Issue 1: "column already exists"
**Cause:** Running setup script on existing database

**Solution:**
```sql
-- Option A: Reset database
\i reset_database.sql
\i setup_database.sql

-- Option B: Skip utility queries (line 645-662)
-- Just run CREATE TABLE sections only
```

### Issue 2: "relation already exists"
**Cause:** Tables already created

**Solution:**
```sql
-- Drop specific table
DROP TABLE IF EXISTS users CASCADE;

-- Or reset all
\i reset_database.sql
```

### Issue 3: Connection error
**Check:**
- Host: 127.0.0.1
- Port: 5433
- Database: lab_ivss
- User: USER
- Password: Nada140125@

---

## 📦 Sample Data

**Users:** 7 sample users
- 1 Admin
- 1 Ketua Lab  
- 3 Dosen
- 2 Member (1 active, 1 inactive/alumni)

**Research:** 5 sample research projects

**Member Registrations:** 6 pending applicants

**News:** 5 articles (4 published, 1 draft)

**Equipment:** 15 lab items

**Publications:** 8 featured publications

**Notifications:** 15 role-based notifications

---

## 🛠️ Maintenance Commands

### Backup Database
```bash
# Compressed format
pg_dump -h 127.0.0.1 -p 5433 -U USER -d lab_ivss -F c -f backup.backup

# SQL format
pg_dump -h 127.0.0.1 -p 5433 -U USER -d lab_ivss > backup.sql
```

### Restore Database
```bash
# From compressed
pg_restore -h 127.0.0.1 -p 5433 -U USER -d lab_ivss backup.backup

# From SQL
psql -U USER -d lab_ivss < backup.sql
```

### Optimize Database
```sql
VACUUM ANALYZE;
```

---

## 📝 Notes

- All passwords default to: **admin123**
- Change passwords after first login in production
- Backup database regularly
- Use `reset_database.sql` only in development

---

## 🆘 Support

Jika ada masalah:
1. Check connection settings
2. Verify PostgreSQL service is running
3. Check port 5433 is available
4. Verify user permissions

---

**Last updated:** November 8, 2025
