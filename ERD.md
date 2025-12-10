# Entity Relationship Diagram (ERD) - Lab IVSS

Dokumen ini menjelaskan struktur database dan hubungan antar entitas dalam sistem Lab IVSS.

## Conceptual ERD

```mermaid
erDiagram
    %% Master Data
    ROLES {
        int id PK
        string role_name
    }

    %% User Management & Auth
    USERS {
        int id PK
        int role_id FK
        string username
        string email
        string password
        string status
    }
    
    DOSEN {
        int id PK
        int user_id FK
        string nip
        string nama
        string no_hp
    }
    
    MAHASISWA {
        int id PK
        int user_id FK
        int supervisor_id FK
        string nim
        string nama
        string angkatan
    }

    %% Core Business: Research
    RESEARCH {
        int id PK
        int leader_id FK
        string title
        string status
        date start_date
        date end_date
    }
    
    RESEARCH_MEMBERS {
        int research_id FK
        int user_id FK
        string role
        string status
    }

    %% Registration System
    MEMBER_REGISTRATIONS {
        int id PK
        int supervisor_id FK
        int research_id FK
        string name
        string email
        string status
    }

    %% Content & Management
    NEWS {
        int id PK
        int author_id FK
        string title
        string status
    }
    
    NOTIFICATIONS {
        int id PK
        int target_user_id FK
        string target_role
        string message
        boolean is_read
    }

    %% Standalone Entities (No Strong Relationships)
    PUBLICATIONS {
        int id PK
        string title
        string authors
        int year
        string type
    }
    
    EQUIPMENT {
        int id PK
        string name
        string category
        string condition
    }

    %% Relationships
    ROLES ||--o{ USERS : "assigned to"
    USERS ||--|| DOSEN : "is details of"
    USERS ||--|| MAHASISWA : "is details of"
    
    DOSEN ||--o{ MAHASISWA : "supervises"
    
    USERS ||--o{ RESEARCH_MEMBERS : "joins"
    RESEARCH ||--o{ RESEARCH_MEMBERS : "has members"
    RESEARCH }o--|| USERS : "led by"
    
    USERS ||--o{ NEWS : "authors"
    USERS ||--o{ NOTIFICATIONS : "receives"
    
    MEMBER_REGISTRATIONS }o--|| DOSEN : "requests supervisor"
    MEMBER_REGISTRATIONS }o--|| RESEARCH : "interested in"
```

## Deskripsi Entitas Utama

1. **Users & Roles**: Sistem menggunakan RBAC (Role-Based Access Control) sederhana. Tabel `users` menyimpan kredensial login, sedangkan detail profil dipisah ke tabel `dosen` dan `mahasiswa` (One-to-One).
2. **Research**: Entitas pusat aktivitas lab. Mahasiswa dan Dosen dapat bergabung dalam riset melalui tabel junction `research_members` (Many-to-Many).
3. **Registration**: Calon member mendaftar melalui `member_registrations`. Mereka memilih Dosen Pembimbing (`supervisor_id`) dan Topik Riset (`research_id`). Setelah disetujui, data akan dipindahkan ke tabel `users` dan `mahasiswa`.
4. **Content**: User (Admin/Dosen) dapat menulis berita (`news`).
5. **Inventory**: Peralatan (`equipment`) dan Publikasi (`publications`) dikelola sebagai data master terpisah.

## Tabel Pendukung (Utility Tables)
Tabel-tabel berikut bersifat mandiri untuk konfigurasi tampilan website:
- **system_settings**: Konfigurasi global lab.
- **navbar_settings**: Struktur menu navigasi dinamis.
- **footer_settings**: Konten footer & sosmed.
- **visimisi**: Data Visi dan Misi.
- **facilities**: Daftar fasilitas lab.
- **gallery**: Galeri foto kegiatan.
- **team_members**: Struktur organisasi tim lab (tampilan home).
