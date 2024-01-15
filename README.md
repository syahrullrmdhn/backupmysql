Aplikasi Autobackup Database Menggunakan Library Ifsnop

Ubah Konfigurasi

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pemilihan_osis';

// Konfigurasi backu
$backupFolder = './backup/';
$backupFilename = 'backup_' . date('Ymd_His') . '.sql';

Sesuai dengan database dan folder anda
