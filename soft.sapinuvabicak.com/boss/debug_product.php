<?php
// Debug file to test product insertion
require_once '../func/db.php';
require_once '../func/fonksiyon.php';

echo "<h2>Product Database Debug Test</h2>";

// Test database connection
try {
    $test_query = $ozy->query("SELECT COUNT(*) as count FROM urunler");
    $result = $test_query->fetch(PDO::FETCH_ASSOC);
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    echo "<p>Current products in database: " . $result['count'] . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
    exit;
}

// Check table structure
try {
    $columns = $ozy->query("DESCRIBE urunler")->fetchAll(PDO::FETCH_ASSOC);
    echo "<h3>Table Structure:</h3>";
    echo "<pre>";
    foreach ($columns as $column) {
        echo $column['Field'] . " - " . $column['Type'] . " - " . $column['Null'] . " - " . $column['Default'] . "\n";
    }
    echo "</pre>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Failed to get table structure: " . $e->getMessage() . "</p>";
}

// Test basic insertion with minimal data
try {
    $test_data = array(
        'adi' => 'Test Product ' . date('Y-m-d H:i:s'),
        'aciklama' => 'Test description',
        'seo' => 'test-product-' . time(),
        'hit' => 0,
        'durum' => 1,
        'sira' => 0,
        'seodurum' => 1,
        'stitle' => 'Test Title',
        'skey' => 'test',
        'sdesc' => 'Test desc',
        'tarih' => date('d.m.Y H:i:s'),
        'resim' => 'resimyok.jpg',
        'urunkodu' => 'TEST-' . time(),
        'urunbarkodu' => 'BARCODE-' . time(),
        'fiyat' => 100.00,
        'idurum' => 0,
        'ifiyat' => 0,
        'parabirimi' => 0,
        'dolar' => 0,
        'idolar' => 0,
        'euro' => 0,
        'ieuro' => 0,
        'kisa' => 'Test short description',
        'instagram' => ' ',
        'stok' => 10,
        'kategori' => '1',
        'marka' => '1',
        'kdv' => 18,
        'agoster' => 0,
        'yeni' => 0,
        'populer' => 0,
        'coksatan' => 0,
        'firsat' => 0,
        'firsatsaat' => 0,
        'filtre' => '',
        'havaledurum' => 0,
        'hfiyat' => 0,
        'ucretsizkargo' => 0,
        'alode' => 0,
        'al' => 0,
        'ode' => 0
    );
    
    $stmt = $ozy->prepare("INSERT INTO urunler (adi, aciklama, seo, hit, durum, sira, seodurum, stitle, skey, sdesc, tarih, resim, urunkodu, urunbarkodu, fiyat, idurum, ifiyat, parabirimi, dolar, idolar, euro, ieuro, kisa, instagram, stok, kategori, marka, kdv, agoster, yeni, populer, coksatan, firsat, firsatsaat, filtre, havaledurum, hfiyat, ucretsizkargo, alode, al, ode) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    
    $result = $stmt->execute(array_values($test_data));
    
    if ($result) {
        $newId = $ozy->lastInsertId();
        echo "<p style='color: green;'>✓ Test product inserted successfully with ID: " . $newId . "</p>";
        
        // Delete test product
        $delete = $ozy->prepare("DELETE FROM urunler WHERE id = ?");
        $delete->execute(array($newId));
        echo "<p>Test product deleted</p>";
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<p style='color: red;'>✗ Failed to insert test product</p>";
        echo "<pre>Error: " . print_r($errorInfo, true) . "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Exception during test insertion: " . $e->getMessage() . "</p>";
}

// Check required tables exist
$required_tables = ['kategoriler', 'markalar'];
foreach ($required_tables as $table) {
    try {
        $check = $ozy->query("SELECT COUNT(*) as count FROM $table")->fetch(PDO::FETCH_ASSOC);
        echo "<p style='color: green;'>✓ Table '$table' exists with " . $check['count'] . " records</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Table '$table' not found or error: " . $e->getMessage() . "</p>";
    }
}

echo "<h3>Check Error Log:</h3>";
echo "<p>Check your server error logs at: boss/error_log and root error_log for detailed error messages when testing product addition.</p>";
?>
