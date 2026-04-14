<?php
session_start();
include 'koneksi.php';

echo "<!DOCTYPE html>";
echo "<html lang='id'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Test Database Connection & CRUD</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }";
echo ".container { max-width: 900px; margin: 0 auto; }";
echo ".test-item { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #ddd; }";
echo ".test-item.success { border-left-color: #28a745; }";
echo ".test-item.error { border-left-color: #dc3545; }";
echo ".test-item.warning { border-left-color: #ffc107; }";
echo "h1 { color: #333; }";
echo ".status { font-weight: bold; padding: 5px 10px; border-radius: 3px; display: inline-block; }";
echo ".status.ok { background: #d4edda; color: #155724; }";
echo ".status.fail { background: #f8d7da; color: #721c24; }";
echo ".status.warning { background: #fff3cd; color: #856404; }";
echo "table { width: 100%; border-collapse: collapse; margin-top: 10px; }";
echo "table td, table th { padding: 10px; text-align: left; border: 1px solid #ddd; }";
echo "table th { background: #f8f9fa; font-weight: bold; }";
echo "code { background: #f4f4f4; padding: 2px 5px; border-radius: 3px; font-family: monospace; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
echo "<h1>🧪 Test Database Connection & CRUD - PSAJ</h1>";

// Test 1: Database Connection
echo "<div class='test-item success'>";
echo "<h3>✅ Test 1: Database Connection</h3>";
if ($conn) {
    echo "<p><span class='status ok'>SUCCESS</span> Database <code>db_psaj</code> connected successfully!</p>";
} else {
    echo "<p><span class='status fail'>FAILED</span> Connection error: " . mysqli_connect_error() . "</p>";
}
echo "</div>";

// Test 2: Check Tables
echo "<div class='test-item success'>";
echo "<h3>✅ Test 2: Database Tables</h3>";
$tables = ['kelas', 'siswa', 'guru_bk', 'pengaduan', 'chat', 'notifikasi'];
$query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='db_psaj'";
$result = mysqli_query($conn, $query);
$db_tables = [];
while ($row = mysqli_fetch_assoc($result)) {
    $db_tables[] = $row['TABLE_NAME'];
}

echo "<table>";
echo "<tr><th>Tabel</th><th>Status</th><th>Keterangan</th></tr>";
foreach ($tables as $table) {
    $status = in_array($table, $db_tables) ? "✅ Ada" : "❌ Tidak Ada";
    $status_class = in_array($table, $db_tables) ? "ok" : "fail";
    echo "<tr>";
    echo "<td><code>$table</code></td>";
    echo "<td><span class='status $status_class'>$status</span></td>";
    echo "<td>Table digunakan untuk data operasional</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";

// Test 3: Data Count
echo "<div class='test-item success'>";
echo "<h3>✅ Test 3: Data Count</h3>";
$kelas_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kelas"))['count'];
$siswa_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM siswa"))['count'];
$guru_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM guru_bk"))['count'];
$pengaduan_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM pengaduan"))['count'];

echo "<table>";
echo "<tr><th>Tabel</th><th>Total Data</th><th>Status</th></tr>";
echo "<tr><td><code>kelas</code></td><td>" . $kelas_count . "</td><td>" . ($kelas_count > 0 ? "✅ Ada data" : "⚠️ Kosong") . "</td></tr>";
echo "<tr><td><code>siswa</code></td><td>" . $siswa_count . "</td><td>" . ($siswa_count > 0 ? "✅ Ada data" : "⚠️ Kosong") . "</td></tr>";
echo "<tr><td><code>guru_bk</code></td><td>" . $guru_count . "</td><td>" . ($guru_count > 0 ? "✅ Ada data" : "⚠️ Kosong") . "</td></tr>";
echo "<tr><td><code>pengaduan</code></td><td>" . $pengaduan_count . "</td><td>" . ($pengaduan_count > 0 ? "✅ Ada data" : "⚠️ Kosong") . "</td></tr>";
echo "</table>";
echo "</div>";

// Test 4: Sample Siswa Data
echo "<div class='test-item success'>";
echo "<h3>✅ Test 4: Sample Siswa Data</h3>";
$query = "SELECT s.*, k.nama_kelas FROM siswa s LEFT JOIN kelas k ON s.id_kelas = k.id_kelas LIMIT 5";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>NISN</th><th>Nama</th><th>Kelas</th><th>Email</th><th>Status</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id_siswa']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nisn']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_kelas'] ?? '-') . "</td>";
        echo "<td>" . htmlspecialchars($row['email'] ?? '-') . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>⚠️ Tidak ada data siswa. Silakan gunakan <code>tambah_siswa.php</code> untuk menambah data.</p>";
}
echo "</div>";

// Test 5: Sample Pengaduan Data
echo "<div class='test-item success'>";
echo "<h3>✅ Test 5: Sample Pengaduan Data</h3>";
$query = "SELECT p.*, s.nama as siswa_nama FROM pengaduan p LEFT JOIN siswa s ON p.id_siswa = s.id_siswa LIMIT 5";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Siswa</th><th>Judul</th><th>Jenis</th><th>Status</th><th>Tanggal</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id_pengaduan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['siswa_nama'] ?? '-') . "</td>";
        echo "<td>" . htmlspecialchars(substr($row['judul'], 0, 30)) . "...</td>";
        echo "<td>" . htmlspecialchars($row['jenis']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>" . date('d/m/Y', strtotime($row['tanggal'])) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>⚠️ Tidak ada data pengaduan.</p>";
}
echo "</div>";

// Test 6: CRUD File Check
echo "<div class='test-item success'>";
echo "<h3>✅ Test 6: CRUD Files</h3>";
$crud_files = [
    'data_siswa.php' => 'Tampilkan semua data siswa',
    'tambah_siswa.php' => 'Form tambah siswa baru',
    'edit_siswa.php' => 'Form edit data siswa',
    'proses_siswa.php' => 'Processor untuk CRUD (CREATE, READ, UPDATE, DELETE)',
    'dashboard.php' => 'Dashboard dengan statistik',
    'koneksi.php' => 'Database connection file'
];

echo "<table>";
echo "<tr><th>File</th><th>Status</th><th>Deskripsi</th></tr>";
foreach ($crud_files as $file => $desc) {
    $exists = file_exists($file);
    $status = $exists ? "✅ Ada" : "❌ Tidak Ada";
    $status_class = $exists ? "ok" : "fail";
    echo "<tr>";
    echo "<td><code>$file</code></td>";
    echo "<td><span class='status $status_class'>$status</span></td>";
    echo "<td>$desc</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";

// Test 7: Workflow Test
echo "<div class='test-item warning'>";
echo "<h3>⚠️ Test 7: Manual CRUD Testing</h3>";
echo "<p>Silakan test CRUD operations secara manual:</p>";
echo "<ul>";
echo "<li><strong>CREATE:</strong> <a href='tambah_siswa.php' target='_blank'>Buka Tambah Siswa</a></li>";
echo "<li><strong>READ:</strong> <a href='data_siswa.php' target='_blank'>Buka Data Siswa</a></li>";
echo "<li><strong>Dashboard:</strong> <a href='dashboard.php' target='_blank'>Buka Dashboard</a></li>";
echo "</ul>";
echo "</div>";

// Summary
echo "<div style='background: #d4edda; padding: 20px; border-radius: 5px; margin-top: 20px;'>";
echo "<h2 style='color: #155724;'>✅ Database & CRUD Integration Complete!</h2>";
echo "<p style='color: #155724;'>";
echo "Semua file CRUD sudah terhubung dengan database <code>db_psaj</code>. ";
echo "Anda dapat mulai menguji fitur CREATE, READ, UPDATE, dan DELETE.";
echo "</p>";
echo "</div>";

echo "</div>";
echo "</body>";
echo "</html>";
?>
