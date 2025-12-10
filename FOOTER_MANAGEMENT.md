# Panduan Manajemen Footer Dinamis

## Deskripsi

Sistem ini memungkinkan Anda untuk mengedit footer website secara dinamis melalui panel admin, tanpa perlu mengubah kode di file `view/pages/partials/footer.php`.

## Fitur Utama

- **Edit Deskripsi Laboratorium** - Ubah deskripsi yang ditampilkan di footer
- **Kelola Informasi Kontak** - Email, telepon, dan alamat
- **Kelola Link Cepat** - Tambah/hapus link yang muncul di kolom "Link Cepat"
- **Kelola Resources** - Kelola link dokumentasi dan panduan
- **Media Sosial** - Kelola tautan media sosial (Instagram, Facebook, LinkedIn, Twitter, YouTube)

## Instalasi

### 1. Jalankan Migration Database

```sql
-- Jalankan query ini di PostgreSQL
CREATE TABLE IF NOT EXISTS footer_settings (
    id SERIAL PRIMARY KEY,
    description TEXT,
    email VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    instagram VARCHAR(255),
    facebook VARCHAR(255),
    linkedin VARCHAR(255),
    twitter VARCHAR(255),
    youtube VARCHAR(255),
    quick_links JSONB DEFAULT '[]',
    resources JSONB DEFAULT '[]',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_footer_settings_id ON footer_settings(id);
```

### 2. File Yang Diubah/Dibuat

- ✅ `app/controllers/FooterController.php` - Controller untuk mengelola footer
- ✅ `view/admin/footer/index.php` - Halaman utama admin footer
- ✅ `view/admin/footer/view.php` - Tampilan pengaturan footer saat ini
- ✅ `view/admin/footer/edit.php` - Form edit footer
- ✅ `view/pages/partials/footer.php` - Footer yang dinamis (diperbarui)
- ✅ `database/migration_footer_settings.sql` - File migration database

## Penggunaan

### Akses Admin Footer

1. Login sebagai Admin atau Ketua Lab
2. Buka menu Admin
3. Pilih **Footer** atau akses via: `index.php?page=admin-footer`

### Edit Footer

1. Klik tombol **Edit Footer**
2. Isi semua field yang diinginkan:
   - **Deskripsi Laboratorium**
   - **Alamat**
   - **Email & Telepon**
   - **Media Sosial** (Instagram, Facebook, LinkedIn, Twitter, YouTube)
   - **Link Cepat** - Tambah dengan klik "Tambah Link Cepat"
   - **Resources** - Tambah dengan klik "Tambah Resource"
3. Klik **Simpan Perubahan**

### Data Dinamis Footer

Footer sekarang menampilkan data dari database:

```php
// Deskripsi
<?= htmlspecialchars($footer_desc) ?>

// Email & Telepon
<?= htmlspecialchars($footer_email) ?>
<?= htmlspecialchars($footer_phone) ?>

// Link Cepat (dinamis dari array)
<?php foreach ($quick_links as $link): ?>
    <a href="<?= htmlspecialchars($link['url']) ?>">
        <?= htmlspecialchars($link['label']) ?>
    </a>
<?php endforeach; ?>
```

## Struktur Data JSON

### Quick Links

```json
[
  {
    "label": "Profil Laboratorium",
    "url": "#profil"
  },
  {
    "label": "Riset & Penelitian",
    "url": "#riset"
  }
]
```

### Resources

```json
[
  {
    "label": "Panduan Peneliti",
    "url": "https://example.com/panduan"
  },
  {
    "label": "Tutorial Lengkap",
    "url": "https://example.com/tutorial"
  }
]
```

## Integrasi ke Routing

Tambahkan ke file routing (misalnya `index.php` atau router utama Anda):

```php
// Di file routing
case 'admin-footer':
    require_once __DIR__ . '/app/controllers/FooterController.php';
    $controller = new FooterController($db);
    if (isset($_GET['action']) && $_GET['action'] === 'edit') {
        $footerSettings = $controller->getFooterSettings(); // Pastikan public atau buat getter
        $controller->edit();
    } elseif ($_POST) {
        $controller->update();
    } else {
        $controller->index();
    }
    break;
```

## Tips & Trik

### 1. Default Values

Jika data footer belum diatur, akan menggunakan default values yang ada di `footer.php`:

```php
$footer_desc = $footerSettings['description'] ?? 'Default deskripsi...';
```

### 2. Backup Data

Sebelum membuat perubahan besar, backup tabel:

```sql
CREATE TABLE footer_settings_backup AS SELECT * FROM footer_settings;
```

### 3. Format URL

Pastikan URL media sosial lengkap dengan protokol (https://):

```
https://instagram.com/username
https://facebook.com/username
```

### 4. Validasi Email

Email akan divalidasi dengan FILTER_VALIDATE_EMAIL di form

## Struktur Folder

```
admin/
├── footer/
│   ├── index.php        (Main page)
│   ├── view.php         (View settings)
│   └── edit.php         (Edit form)
```

## Masalah Umum

### Q: Footer tidak berubah setelah edit

**A:** Pastikan Anda sudah:

1. Membuat tabel `footer_settings` di database
2. Merefresh halaman (clear cache browser)
3. Login sebagai Admin/Ketua Lab

### Q: Data JSON tidak tersimpan

**A:** Pastikan PostgreSQL Anda support tipe data JSONB. Jika tidak, ubah ke TEXT:

```sql
ALTER TABLE footer_settings MODIFY quick_links TEXT;
```

### Q: Tidak ada menu Footer di Admin

**A:** Tambahkan link menu footer ke sidebar admin Anda

## Support

Untuk pertanyaan lebih lanjut, hubungi tim development.
