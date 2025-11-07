<?php
/**
 * WebP Migration Runner
 * Run this script to add WebP support to the slider table
 */

// Include database connection
require_once '../func/db.php';

try {
    // Check if webp_resim column already exists
    $checkColumn = $ozy->query("SHOW COLUMNS FROM slider LIKE 'webp_resim'")->fetch();
    
    if ($checkColumn) {
        echo "WebP column already exists. Migration not needed.";
        exit;
    }
    
    // Add webp_resim column
    $ozy->exec("ALTER TABLE `slider` ADD COLUMN `webp_resim` VARCHAR(255) NULL DEFAULT NULL AFTER `resim`");
    echo "✓ Added webp_resim column to slider table<br>";
    
    // Create index for better performance
    $ozy->exec("CREATE INDEX `idx_slider_webp_resim` ON `slider` (`webp_resim`)");
    echo "✓ Created index for webp_resim column<br>";
    
    // Update existing records
    $ozy->exec("UPDATE `slider` SET `webp_resim` = '' WHERE `webp_resim` IS NULL");
    echo "✓ Updated existing records<br>";
    
    echo "<br><strong>Migration completed successfully!</strong><br>";
    echo "WebP support is now enabled for sliders.";
    
} catch (Exception $e) {
    echo "Error during migration: " . $e->getMessage();
}
?>
