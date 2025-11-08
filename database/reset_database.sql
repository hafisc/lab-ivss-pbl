-- ========================================
-- RESET DATABASE - Lab IVSS
-- PERINGATAN: Script ini akan MENGHAPUS semua data!
-- Gunakan hanya untuk development/testing
-- ========================================

-- Drop all tables in correct order (reverse of dependencies)
DROP TABLE IF EXISTS member_publications CASCADE;
DROP TABLE IF EXISTS research_documents CASCADE;
DROP TABLE IF EXISTS research_members CASCADE;
DROP TABLE IF EXISTS notifications CASCADE;
DROP TABLE IF EXISTS system_settings CASCADE;
DROP TABLE IF EXISTS equipment CASCADE;
DROP TABLE IF EXISTS publications CASCADE;
DROP TABLE IF EXISTS news CASCADE;
DROP TABLE IF EXISTS member_registrations CASCADE;
DROP TABLE IF EXISTS research CASCADE;
DROP TABLE IF EXISTS users CASCADE;

-- Setelah menjalankan script ini, jalankan setup_database.sql untuk create ulang
-- \i setup_database.sql

SELECT 'Database reset complete. Run setup_database.sql to recreate tables.' as status;
