# 🤖🧪 Lab IVSS – Portal Management System

> **Portal Lab Intelligent Vision and Smart System – Politeknik Negeri Malang**  
> Proyek Basis Data untuk PBL | Computer Vision & Smart Systems Lab

[![PHP](https://img.shields.io/badge/PHP-Native-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-13+-336791?style=flat&logo=postgresql&logoColor=white)](https://www.postgresql.org/)
[![Status](https://img.shields.io/badge/Status-Active-success?style=flat)](https://github.com/hafisc/lab-ivss-pbl)
[![License](https://img.shields.io/badge/License-Campus%20Project-orange?style=flat)](https://github.com/hafisc/lab-ivss-pbl)
[![Made by](https://img.shields.io/badge/Made%20by-@hafisc-blue?style=flat)](https://github.com/hafisc)

---

## 👋 Apa itu Lab IVSS?

**Lab IVSS (Intelligent Vision and Smart System)** adalah laboratorium riset di Politeknik Negeri Malang yang fokus pada **Computer Vision**, **AI**, dan **IoT Smart Systems**. Portal web ini dibuat sebagai bagian dari tugas **PBL (Project Based Learning)** untuk memfasilitasi manajemen lab, member, riset, dan dokumentasi kegiatan.

Web ini jadi pusat informasi buat dosen pembimbing, mahasiswa aktif, alumni, dan siapa aja yang pengen tahu aktivitas riset di Lab IVSS!

> 📸 _(Screenshot coming soon – portal lagi tahap development!)_

---

## 🔥 Fitur Utama

### 👨‍🏫 **Manajemen Admin & Ketua Lab**
- Dashboard monitoring kegiatan lab real-time
- **Approval bertingkat** pendaftar member baru (Dosen → Ketua Lab)
- Kelola berita, riset, dan peralatan lab
- Settings sistem dan profil
- Role-based access control untuk setiap fitur

### 👨‍🔬 **Manajemen Dosen Pengampu**
- Review pendaftar yang memilih dosen sebagai pembimbing
- **Notifikasi email** otomatis saat ada pendaftar baru
- Approve/reject pendaftaran dengan catatan
- Kelola riset yang dibimbing
- Dashboard statistik member yang dibimbing

### 🧑‍🎓 **Manajemen Member Lab**
- **Pendaftaran online dengan approval 2 tingkat:**
  1. Review Dosen Pengampu
  2. Review Ketua Lab
- Form registrasi lengkap (biodata + judul penelitian + motivasi)
- **Notifikasi email** untuk setiap tahap approval
- Status: Pending Dosen → Pending Ketua Lab → Active → Alumni
- Profil member dengan foto dan bio
- Upload riset dan dokumentasi

### 📄 **Portal Riset & Publikasi**
- Listing riset utama & pendukung
- Kategori: Computer Vision, IoT, Face Recognition, dll
- Status riset: Active, Completed, On-Hold
- Tim riset, funding, publikasi

### 📰 **Berita & Dokumentasi**
- Portal berita kegiatan lab
- Workshop, seminar, publikasi paper
- Kategori berita & search functionality
- Draft & published mode

### 🛠️ **Inventaris Peralatan Lab**
- Katalog peralatan: Kamera, GPU, Sensor, dll
- Kondisi: Baik, Maintenance, Rusak
- Lokasi & spesifikasi lengkap
- Purchase tracking

### 🎨 **Modern UI/UX**
- Tailwind CSS - clean & responsive
- Dark mode ready (coming soon)
- Mobile-friendly design
- Smooth animations & transitions

---

## 🏗️ Arsitektur & Modul

Portal ini dibangun dengan **4 level access control**:

### 🌐 **Public Area** (No Login Required)
- 🏠 Landing page Lab IVSS
- 👨‍🏫 Profil dosen pembimbing
- 📄 Listing riset & publikasi
- 📰 Berita & kegiatan lab
- 📝 **Pendaftaran member online** (dengan form lengkap)
- 📞 Kontak & informasi lab

### 🔐 **Member Area** (Login as Member)
- 👤 Profil & edit profile
- 📤 Upload riset & dokumentasi
- 📋 Lihat pengumuman internal
- 💬 Request akses peralatan
- 📊 Tracking status approval pendaftaran

### 👨‍🔬 **Dosen Area** (Login as Dosen)
- 📊 Dashboard statistik member bimbingan
- ✅ **Review & approve pendaftar** yang memilih sebagai pembimbing
- 🔔 Notifikasi email otomatis pendaftar baru
- 📝 CRUD riset yang dibimbing
- ⚙️ Settings profil

### 👨‍🏫 **Admin/Ketua Lab Area** (Login as Admin/Ketua Lab)
- 📊 Dashboard analytics lengkap
- ✅ **Approval final** pendaftar (setelah disetujui dosen)
- 📝 CRUD berita, riset, dan member
- 🛠️ Kelola inventaris peralatan
- ⚙️ Settings sistem & manajemen user
- 📧 Email notification management

---

## ⚙️ Tech Stack

| Technology | Purpose |
|------------|---------|
| **PHP Native** | Backend logic tanpa framework (pure PHP OOP) |
| **PostgreSQL** | Database relasional |
| **Tailwind CSS** | Styling modern & responsive |
| **JavaScript (Vanilla)** | Interactivity & real-time search |
| **Apache/Nginx** | Web server (cPanel friendly) |
| **Git** | Version control |

**Why PHP Native?**  
Karena ini tugas kampus yang fokus ke konsep database & SQL query, bukan framework magic ✨

---

## 📁 Struktur Folder

```
lab-ivss-pbl/
├── 📂 app/                    # Core application
│   ├── config/                # Database & app config
│   ├── controllers/           # Business logic (MVC)
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   └── PublicController.php
│   ├── models/                # Database models
│   └── helpers/               # Helper functions
│
├── 📂 view/                   # Views (HTML + PHP)
│   ├── admin/                 # Admin panel views
│   │   ├── berita/            # News management
│   │   ├── research/          # Research management
│   │   ├── members/           # Member management
│   │   ├── equipment/         # Equipment management
│   │   └── settings/          # System settings
│   ├── public/                # Public pages
│   └── layouts/               # Layout templates
│
├── 📂 public/                 # Public assets & entry point
│   ├── index.php              # Main entry point
│   ├── assets/
│   │   ├── css/               # Stylesheets
│   │   ├── js/                # JavaScript files
│   │   ├── images/            # Images & logos
│   │   └── uploads/           # User uploaded files
│   │       └── profiles/      # Profile photos
│
├── 📂 database/               # Database scripts
│   └── setup_database.sql     # Complete DB setup
│
├── 📄 .env                    # Environment variables
├── 📄 .env.example            # Env template
└── 📄 README.md               # You're here! 👋
```

---

## 🛠️ Setup & Instalasi

### 📋 Prerequisites
- PHP >= 7.4
- PostgreSQL >= 13
- Apache/Nginx
- Git

### 🚀 Quick Start

```bash
# 1. Clone repository
git clone https://github.com/hafisc/lab-ivss-pbl.git
cd lab-ivss-pbl

# 2. Setup database
psql -U postgres
CREATE DATABASE lab_ivss;
\c lab_ivss
\i database/setup_database.sql
\q

# 3. Konfigurasi environment
cp .env.example .env
# Edit .env sesuai konfigurasi database Anda

# 4. Setup permissions (Linux/Mac)
chmod -R 755 public/assets/uploads

# 5. Jalankan di localhost
# Akses: http://localhost/lab-ivss-pbl/public
```

### 🌐 Deployment ke cPanel

1. Upload semua file ke hosting
2. Arahkan **Document Root** ke folder `public/`
3. Import database via phpPgAdmin
4. Edit `.env` dengan credential hosting
5. Set permission folder `uploads/` ke 755
6. Done! 🎉

### 🔑 Default Login

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@ivss.polinema.ac.id | admin123 |
| **Ketua Lab** | ketualab@ivss.polinema.ac.id | admin123 |
| **Dosen 1** | budi.dosen@polinema.ac.id | admin123 |
| **Dosen 2** | andi.dosen@polinema.ac.id | admin123 |
| **Dosen 3** | siti.dosen@polinema.ac.id | admin123 |
| **Member** | ahmad@student.polinema.ac.id | admin123 |

> ⚠️ **PENTING:** Ganti password default setelah login pertama kali!

**💡 Testing Role-Based Filtering:**
- Login sebagai **Dosen 1** (budi.dosen) → akan melihat 2 pendaftar (Budi & Yusuf)
- Login sebagai **Dosen 2** (andi.dosen) → akan melihat 2 pendaftar (Siti & Fitri)
- Login sebagai **Dosen 3** (siti.dosen) → akan melihat 1 pendaftar (Rudi)
- Login sebagai **Ketua Lab** → akan melihat 1 pendaftar yang sudah di-approve dosen (Andi Pratama)

### 📧 Email Configuration (Development)

Untuk testing notifikasi email di localhost:
- Install **MailHog** atau **FakeSMTP** untuk SMTP server lokal
- Atau gunakan layanan SMTP testing (Mailtrap, SendGrid Sandbox)
- Edit `app/helpers/EmailHelper.php` untuk konfigurasi SMTP

**Production:** Gunakan email service (SendGrid, AWS SES, Mailgun)

---

## 🗄️ Database Schema (Simplified)

Portal ini menggunakan **5 tabel utama**:

```sql
-- 1. USERS - Data pengguna (admin, ketua_lab, dosen, member)
users (
    id, name, email, password, 
    role,  -- 'admin', 'ketua_lab', 'dosen', 'member'
    status, -- 'active', 'inactive'
    nim, nip, phone, angkatan, photo, 
    created_at, updated_at
)

-- 2. MEMBER_REGISTRATIONS - Pendaftaran member baru (Approval Bertingkat)
member_registrations (
    id, name, email, nim, phone, angkatan, origin, password,
    
    -- Penelitian
    research_title, research_id, motivation,
    
    -- Dosen Pengampu (Approval Tier 1)
    supervisor_id, supervisor_approved_at, supervisor_notes,
    
    -- Ketua Lab (Approval Tier 2)
    lab_head_approved_at, lab_head_notes,
    
    status, -- 'pending_supervisor', 'pending_lab_head', 'approved', 
            -- 'rejected_supervisor', 'rejected_lab_head'
    created_at, updated_at
)

-- 3. NEWS - Berita & dokumentasi
news (
    id, title, slug, content, excerpt, image,
    category, tags, author_id, 
    status, -- 'draft', 'published'
    published_at, views, created_at, updated_at
)

-- 4. RESEARCH - Data riset & publikasi
research (
    id, title, description, 
    category, -- 'Riset Utama', 'Riset Pendukung', dll
    image, leader_id, team_members,
    status, -- 'active', 'completed', 'on-hold'
    start_date, end_date, funding, publications,
    created_at, updated_at
)

-- 5. EQUIPMENT - Inventaris peralatan lab
equipment (
    id, name, 
    category, -- 'Hardware', 'Software', 'Sensor', dll
    brand, model, quantity,
    condition, -- 'baik', 'maintenance', 'rusak'
    location, specifications, purchase_date,
    created_at, updated_at
)
```

**Relasi Penting:**
- `users.id` → `news.author_id` (1 user → many news)
- `users.id` → `research.leader_id` (1 dosen → many research)
- `users.id` → `member_registrations.supervisor_id` (1 dosen → many pendaftar)
- **Approval Flow:** `pending_supervisor` → `pending_lab_head` → `approved` → create user

📄 **Full schema:** Lihat `database/setup_database.sql`

---

## 🔄 Member Registration & Approval Workflow

Portal ini menggunakan **sistem approval bertingkat** untuk pendaftaran member baru:

### 📝 **Step 1: Mahasiswa Mendaftar**
Mahasiswa mengisi form registrasi lengkap melalui halaman public:
- Biodata (nama, email, NIM, angkatan, kelas/jurusan)
- **Judul Penelitian** yang akan dikerjakan
- **Pilih Dosen Pengampu** yang akan membimbing
- Motivasi bergabung (minimal 50 karakter)
- Password untuk akun

### 📧 **Step 2: Notifikasi Email Otomatis**
Sistem mengirim email secara otomatis:
- **Email ke Dosen Pengampu:** Notifikasi ada pendaftar baru dengan detail lengkap
- **Email ke Mahasiswa:** Konfirmasi pendaftaran diterima + info tahapan approval

### 👨‍🔬 **Step 3: Review Dosen Pengampu**
Dosen login ke admin panel dan:
- Melihat daftar pendaftar yang memilih dirinya sebagai pembimbing
- Review biodata + judul penelitian + motivasi
- **Approve** (lanjut ke Ketua Lab) atau **Reject** (dengan catatan)
- Status: `pending_supervisor` → `pending_lab_head` atau `rejected_supervisor`

### 👨‍🏫 **Step 4: Review Ketua Lab (Final Approval)**
Setelah disetujui dosen, Ketua Lab melakukan review final:
- Melihat pendaftar yang sudah lolos review dosen
- Verifikasi kelengkapan data dan kesesuaian dengan lab
- **Approve** (akun aktif) atau **Reject** (dengan catatan)
- Status: `pending_lab_head` → `approved` atau `rejected_lab_head`

### ✅ **Step 5: Akun Member Aktif**
Jika disetujui oleh **kedua pihak**:
- Data dipindahkan dari `member_registrations` ke tabel `users`
- Status user: `active`
- Member bisa login dan mengakses member area
- Email notifikasi dikirim: "Selamat! Akun Anda sudah aktif"

### 🔴 **Rejection Handling**
Jika ditolak di salah satu tahap:
- Status berubah menjadi `rejected_supervisor` atau `rejected_lab_head`
- Catatan penolakan disimpan
- Email notifikasi rejection dengan alasan
- Mahasiswa bisa daftar ulang dengan data yang diperbaiki

---

## ✅ Development Roadmap

### ✔️ **Sudah Selesai**
- [x] Database design & setup dengan approval bertingkat
- [x] Authentication system (login/logout) - 4 role support
- [x] **Role-based access control** (Admin, Ketua Lab, Dosen, Member)
- [x] Admin dashboard with statistics
- [x] CRUD Berita (create, read, update, delete, draft mode)
- [x] CRUD Riset dengan kategori & table layout
- [x] CRUD Peralatan lab dengan summary cards
- [x] **Member approval system 2 tingkat** (Dosen → Ketua Lab)
- [x] **Email notification system** (pendaftar + dosen)
- [x] Search & filter functionality dengan real-time search
- [x] Profile settings (update profile + upload photo)
- [x] Security settings (change password)
- [x] Responsive UI (mobile friendly)
- [x] **Dynamic page title** untuk halaman auth
- [x] Stats cards & summary cards di admin pages
- [x] Filter tabs dengan inline action buttons

### 🚧 **In Progress**
- [ ] Public landing page refinement
- [ ] Member dashboard & profile management
- [ ] Dosen profile pages (public view)
- [ ] Research detail page with full info
- [ ] News detail page with comments

### 🔮 **Future Plans**
- [ ] Upload riset file (PDF, PPT, dataset)
- [ ] Advanced search & filtering
- [ ] Export data (PDF/Excel)
- [ ] Email templates customization
- [ ] Notification center (in-app)
- [ ] Dark mode toggle
- [ ] Integrasi face recognition (presensi)
- [ ] Activity logs & audit trail
- [ ] REST API untuk mobile app
- [ ] Multi-language support (ID/EN)

---

## 📸 Features Preview

### 🎛️ Admin Dashboard
- **Real-time statistics:** Total member aktif, alumni, riset berjalan, berita published
- **Pending approvals:** Notifikasi pendaftar baru
- **Latest news:** Quick access ke berita terbaru

### 📝 Content Management
- **Rich text editor** untuk berita & riset
- **Drag & drop upload** untuk gambar
- **Live search & filter** di semua halaman list
- **Status management:** Draft → Published workflow

### 👥 Member Management
- **Grid/Table view** untuk list member
- **Filter by status:** Active, Inactive (Alumni), Pending
- **Batch actions:** Set as alumni, activate, delete
- **Profile details:** Foto, bio, kontak, riset yang diikuti

---

## 🤝 Contributing

Proyek ini adalah bagian dari tugas kuliah, tapi pull request tetap welcome! 😊

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 👨‍💻 Credits

**Dibuat oleh:** [Hafis](https://github.com/hafisc)  
**Institusi:** Politeknik Negeri Malang - Jurusan Teknologi Informasi  
**Mata Kuliah:** Basis Data & Project Based Learning  
**Tahun:** 2024

### 📚 Referensi & Resources

- **Lab IVSS Official** - Intelligent Vision and Smart System Laboratory
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [PostgreSQL Tutorial](https://www.postgresql.org/docs/)
- Design inspiration: Modern admin dashboards & SaaS apps

---

## 📄 License

Proyek ini dibuat untuk keperluan **tugas kampus (PBL)** dan bukan untuk komersial.

```
MIT License (Campus Project)

Copyright (c) 2024 Hafis - Lab IVSS Polinema

Permission is granted for educational purposes only.
```

---

## 📞 Contact & Support

Ada pertanyaan atau menemukan bug? 🐛

- **GitHub Issues:** [Create an issue](https://github.com/hafisc/lab-ivss-pbl/issues)
- **Email:** (254107023005@student.polinema.ac.id)
- **Lab IVSS:** Contact your lab supervisor

---

<div align="center">

**⭐ Star this repo if you find it helpful!**

Made with ❤️ by students of Polinema  
🎓 Learning by Building | 🚀 Building by Learning

</div>
