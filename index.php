<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Automated Database Backup</title>
</head>
<body class="bg-gray-100 p-8">

<?php

require 'vendor/autoload.php';

use Ifsnop\Mysqldump\Mysqldump;

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pemilihan_osis';

// Konfigurasi backup
$backupFolder = './backup/';
$backupFilename = 'backup_' . date('Ymd_His') . '.sql';

// Fungsi untuk menjalankan backup
function runBackup($host, $username, $password, $database, $backupFolder, $backupFilename) {
    try {
        $dump = new Mysqldump(
            "mysql:host=$host;dbname=$database",
            $username,
            $password,
            ['add-drop-table' => true]
        );

        $dump->start($backupFolder . $backupFilename);

        return true;  // Backup berhasil
    } catch (\Exception $e) {
        return false;  // Backup gagal
    }
}

// Jika tombol "BACKUP NOW!" ditekan
if (isset($_POST['backup_now'])) {
    $backupResult = runBackup($host, $username, $password, $database, $backupFolder, $backupFilename);

    if ($backupResult) {
        echo '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4" role="alert">';
        echo 'Backup database berhasil disimpan di: <strong>' . $backupFolder . $backupFilename . '</strong>';
        echo '</div>';
    } else {
        echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4" role="alert">';
        echo 'Backup database gagal. Kesalahan: <strong>Terjadi kesalahan selama proses backup.</strong>';
        echo '</div>';
    }
}

?>

<!-- Tombol BACKUP NOW! -->
<div class="flex justify-center mt-4">
    <form method="post" class="flex items-center">
        <button type="submit" name="backup_now" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            BACKUP NOW!
        </button>
    </form>
</div>

<!-- Progress Bar -->
<?php if (isset($_POST['backup_now'])): ?>
    <div class="mt-4">
        <strong>Progress:</strong>
        <div class="bg-gray-200 h-8 mt-2">
            <div class="bg-green-500 h-full" style="width: 100%;"></div>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
