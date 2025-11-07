<?php

class EmailHelper {
    /**
     * Kirim email menggunakan PHP mail function
     * Untuk production, gunakan library seperti PHPMailer atau SwiftMailer
     */
    public static function sendEmail($to, $subject, $message, $headers = []) {
        // Default headers
        $defaultHeaders = [
            'From' => 'Lab IVSS <noreply@ivss.polinema.ac.id>',
            'Reply-To' => 'admin@ivss.polinema.ac.id',
            'X-Mailer' => 'PHP/' . phpversion(),
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/html; charset=UTF-8'
        ];
        
        // Merge with custom headers
        $allHeaders = array_merge($defaultHeaders, $headers);
        
        // Build headers string
        $headersString = '';
        foreach ($allHeaders as $key => $value) {
            $headersString .= "$key: $value\r\n";
        }
        
        // Send email
        return mail($to, $subject, $message, $headersString);
    }
    
    /**
     * Template email untuk notifikasi pendaftaran member baru ke dosen
     */
    public static function sendSupervisorNotification($supervisorEmail, $supervisorName, $registrationData) {
        $subject = "Pengajuan Member Baru Lab IVSS - {$registrationData['name']}";
        
        $message = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
                .info-box { background: white; padding: 20px; margin: 20px 0; border-left: 4px solid #3b82f6; border-radius: 5px; }
                .info-row { margin: 10px 0; }
                .label { font-weight: bold; color: #1e3a8a; }
                .button { display: inline-block; background: #1e3a8a; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                .footer { text-align: center; color: #666; font-size: 12px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🔔 Pengajuan Member Baru</h1>
                    <p>Lab IVSS - Politeknik Negeri Malang</p>
                </div>
                
                <div class='content'>
                    <p>Yth. <strong>{$supervisorName}</strong>,</p>
                    
                    <p>Ada mahasiswa yang mengajukan pendaftaran sebagai member Lab IVSS dengan Anda sebagai <strong>Dosen Pengampu</strong>.</p>
                    
                    <div class='info-box'>
                        <h3 style='margin-top: 0; color: #1e3a8a;'>📋 Data Pendaftar</h3>
                        
                        <div class='info-row'>
                            <span class='label'>Nama:</span> {$registrationData['name']}
                        </div>
                        <div class='info-row'>
                            <span class='label'>NIM:</span> {$registrationData['nim']}
                        </div>
                        <div class='info-row'>
                            <span class='label'>Email:</span> {$registrationData['email']}
                        </div>
                        <div class='info-row'>
                            <span class='label'>Angkatan:</span> {$registrationData['angkatan']}
                        </div>
                        <div class='info-row'>
                            <span class='label'>Kelas/Jurusan:</span> {$registrationData['origin']}
                        </div>
                        
                        <hr style='margin: 20px 0; border: none; border-top: 1px solid #e5e7eb;'>
                        
                        <div class='info-row'>
                            <span class='label'>Judul Penelitian:</span><br>
                            <strong style='color: #1e3a8a; font-size: 16px;'>{$registrationData['research_title']}</strong>
                        </div>
                        
                        <div class='info-row'>
                            <span class='label'>Motivasi:</span><br>
                            <div style='background: #f3f4f6; padding: 15px; border-radius: 5px; margin-top: 10px;'>
                                {$registrationData['motivation']}
                            </div>
                        </div>
                    </div>
                    
                    <p><strong>⚠️ Tindakan Yang Diperlukan:</strong></p>
                    <p>Sebagai Dosen Pengampu, Anda perlu melakukan review terhadap pengajuan ini. Silakan login ke dashboard admin untuk menyetujui atau menolak pendaftaran.</p>
                    
                    <div style='text-align: center;'>
                        <a href='http://localhost/Lab%20ivss/index.php?page=admin-registrations' class='button'>
                            📝 Review Pendaftaran
                        </a>
                    </div>
                    
                    <div style='background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0; border-radius: 5px;'>
                        <strong>ℹ️ Catatan:</strong><br>
                        Setelah Anda menyetujui, pendaftaran akan diteruskan ke <strong>Ketua Lab</strong> untuk approval final. Member akan aktif setelah mendapat persetujuan dari kedua pihak.
                    </div>
                    
                    <div class='footer'>
                        <p>Email ini dikirim otomatis oleh sistem Lab IVSS</p>
                        <p>Lab Intelligent Vision System and Sight (IVSS)<br>
                        Politeknik Negeri Malang<br>
                        Jl. Soekarno Hatta No.9, Malang</p>
                        <p style='margin-top: 15px; color: #999;'>
                            Jika Anda memiliki pertanyaan, hubungi admin di 
                            <a href='mailto:admin@ivss.polinema.ac.id' style='color: #3b82f6;'>admin@ivss.polinema.ac.id</a>
                        </p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
        
        return self::sendEmail($supervisorEmail, $subject, $message);
    }
    
    /**
     * Template email notifikasi untuk ketua lab tentang pendaftar baru
     */
    public static function sendLabHeadNotification($labHeadEmail, $labHeadName, $registrationData, $supervisorName) {
        $subject = "Info: Pendaftar Baru Lab IVSS - {$registrationData['name']}";
        
        $message = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
                .info-box { background: white; padding: 20px; margin: 20px 0; border-left: 4px solid #10b981; border-radius: 5px; }
                .info-row { margin: 10px 0; }
                .label { font-weight: bold; color: #059669; }
                .button { display: inline-block; background: #059669; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                .footer { text-align: center; color: #666; font-size: 12px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>ℹ️ Notifikasi Pendaftar Baru</h1>
                    <p>Lab IVSS - Politeknik Negeri Malang</p>
                </div>
                
                <div class='content'>
                    <p>Yth. <strong>{$labHeadName}</strong> (Ketua Lab),</p>
                    
                    <p>Terdapat mahasiswa baru yang mengajukan pendaftaran sebagai member Lab IVSS. Berikut adalah informasi pendaftar:</p>
                    
                    <div class='info-box'>
                        <h3 style='margin-top: 0; color: #059669;'>📋 Data Pendaftar</h3>
                        
                        <div class='info-row'>
                            <span class='label'>Nama:</span> {$registrationData['name']}
                        </div>
                        <div class='info-row'>
                            <span class='label'>NIM:</span> {$registrationData['nim']}
                        </div>
                        <div class='info-row'>
                            <span class='label'>Email:</span> {$registrationData['email']}
                        </div>
                        <div class='info-row'>
                            <span class='label'>Angkatan:</span> {$registrationData['angkatan']}
                        </div>
                        <div class='info-row'>
                            <span class='label'>Kelas/Jurusan:</span> {$registrationData['origin']}
                        </div>
                        
                        <hr style='margin: 20px 0; border: none; border-top: 1px solid #e5e7eb;'>
                        
                        <div class='info-row'>
                            <span class='label'>Dosen Pengampu:</span> <strong>{$supervisorName}</strong>
                        </div>
                        
                        <div class='info-row'>
                            <span class='label'>Judul Penelitian:</span><br>
                            <strong style='color: #059669; font-size: 16px;'>{$registrationData['research_title']}</strong>
                        </div>
                        
                        <div class='info-row'>
                            <span class='label'>Motivasi:</span><br>
                            <div style='background: #f3f4f6; padding: 15px; border-radius: 5px; margin-top: 10px;'>
                                {$registrationData['motivation']}
                            </div>
                        </div>
                    </div>
                    
                    <div style='background: #dbeafe; border-left: 4px solid #3b82f6; padding: 15px; margin: 20px 0; border-radius: 5px;'>
                        <strong>📌 Status Saat Ini:</strong><br>
                        Pendaftaran ini sedang dalam tahap <strong>review oleh Dosen Pengampu ({$supervisorName})</strong>. Anda akan menerima notifikasi lebih lanjut setelah dosen memberikan persetujuan.
                    </div>
                    
                    <p><strong>ℹ️ Informasi:</strong></p>
                    <p>Email ini bersifat <strong>notifikasi informasi</strong>. Anda akan diminta untuk melakukan review dan approval setelah Dosen Pengampu menyetujui pendaftaran ini.</p>
                    
                    <div style='text-align: center;'>
                        <a href='http://localhost/Lab%20ivss/index.php?page=admin-registrations' class='button'>
                            👁️ Lihat Dashboard
                        </a>
                    </div>
                    
                    <div class='footer'>
                        <p>Email ini dikirim otomatis oleh sistem Lab IVSS</p>
                        <p>Lab Intelligent Vision System and Sight (IVSS)<br>
                        Politeknik Negeri Malang<br>
                        Jl. Soekarno Hatta No.9, Malang</p>
                        <p style='margin-top: 15px; color: #999;'>
                            Jika Anda memiliki pertanyaan, hubungi admin di 
                            <a href='mailto:admin@ivss.polinema.ac.id' style='color: #10b981;'>admin@ivss.polinema.ac.id</a>
                        </p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
        
        return self::sendEmail($labHeadEmail, $subject, $message);
    }
    
    /**
     * Template email konfirmasi untuk mahasiswa yang mendaftar
     */
    public static function sendStudentConfirmation($studentEmail, $studentName, $supervisorName) {
        $subject = "Pengajuan Pendaftaran Member Lab IVSS - Menunggu Review";
        
        $message = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
                .step-box { background: white; padding: 20px; margin: 15px 0; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
                .step-number { display: inline-block; background: #3b82f6; color: white; width: 30px; height: 30px; line-height: 30px; text-align: center; border-radius: 50%; font-weight: bold; margin-right: 10px; }
                .footer { text-align: center; color: #666; font-size: 12px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>✅ Pengajuan Diterima</h1>
                    <p>Lab IVSS - Politeknik Negeri Malang</p>
                </div>
                
                <div class='content'>
                    <p>Halo <strong>{$studentName}</strong>,</p>
                    
                    <p>Terima kasih telah mengajukan pendaftaran sebagai member Lab IVSS. Pengajuan Anda telah kami terima dan saat ini sedang dalam proses review.</p>
                    
                    <div style='background: #dbeafe; padding: 20px; border-radius: 10px; margin: 20px 0; text-align: center;'>
                        <h3 style='color: #1e40af; margin: 0;'>📊 Status Pendaftaran</h3>
                        <p style='font-size: 20px; font-weight: bold; color: #1e3a8a; margin: 10px 0;'>
                            ⏳ Menunggu Review Dosen
                        </p>
                    </div>
                    
                    <h3 style='color: #1e3a8a;'>📋 Tahapan Persetujuan:</h3>
                    
                    <div class='step-box'>
                        <span class='step-number'>1</span>
                        <strong>Review Dosen Pengampu</strong><br>
                        <small style='color: #666;'>Pengajuan Anda akan direview oleh <strong>{$supervisorName}</strong></small>
                    </div>
                    
                    <div class='step-box' style='opacity: 0.5;'>
                        <span class='step-number' style='background: #9ca3af;'>2</span>
                        <strong>Review Ketua Lab</strong><br>
                        <small style='color: #666;'>Setelah disetujui dosen, akan direview oleh Ketua Lab</small>
                    </div>
                    
                    <div class='step-box' style='opacity: 0.5;'>
                        <span class='step-number' style='background: #9ca3af;'>3</span>
                        <strong>Akun Aktif</strong><br>
                        <small style='color: #666;'>Setelah approval, Anda bisa login dan mengakses sistem</small>
                    </div>
                    
                    <div style='background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0; border-radius: 5px;'>
                        <strong>⏱️ Perkiraan Waktu:</strong><br>
                        Proses review biasanya memakan waktu 1-3 hari kerja. Anda akan mendapat notifikasi email untuk setiap update status.
                    </div>
                    
                    <div class='footer'>
                        <p>Email ini dikirim otomatis oleh sistem Lab IVSS</p>
                        <p>Lab Intelligent Vision System and Sight (IVSS)<br>
                        Politeknik Negeri Malang<br>
                        Jl. Soekarno Hatta No.9, Malang</p>
                        <p style='margin-top: 15px; color: #999;'>
                            Jika Anda memiliki pertanyaan, hubungi admin di 
                            <a href='mailto:admin@ivss.polinema.ac.id' style='color: #3b82f6;'>admin@ivss.polinema.ac.id</a>
                        </p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
        
        return self::sendEmail($studentEmail, $subject, $message);
    }
}
