<?php

// Ürün görsellerini ve stok durumlarını düzelten script

// Laravel uygulamasının yüklenmesi
require __DIR__.'/vendor/autoload.php';

// .env dosyasındaki değişkenleri yükleme
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Veritabanı bağlantı bilgilerini çevre değişkenlerinden alma
$host = $_ENV['DB_HOST'] ?? 'localhost';
$db = $_ENV['DB_DATABASE'] ?? 'muzikdunyasi';
$user = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

// Bağlantı oluştur
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Veritabanına bağlandı.\n";
} catch (PDOException $e) {
    die("Veritabanına bağlanılamadı: " . $e->getMessage() . "\n");
}

// İşlemleri bir transaction içinde gerçekleştir
try {
    $pdo->beginTransaction();

    // 1. Resim yolu boş olan ürünleri kategori bazlı varsayılan görseller ile güncelle
    $sql1 = "UPDATE products p
             JOIN categories c ON p.category_id = c.id
             SET p.image_path = CONCAT('products/default/', c.slug, '.jpg')
             WHERE p.image_path IS NULL OR p.image_path = ''";
    
    $stmt = $pdo->prepare($sql1);
    $stmt->execute();
    $count1 = $stmt->rowCount();
    echo "{$count1} ürünün görseli güncellendi.\n";

    // 2. Stok durumu 0 veya NULL olan ürünleri güncelle
    $sql2 = "UPDATE products
             SET stock = FLOOR(10 + RAND() * 90)
             WHERE stock = 0 OR stock IS NULL";
    
    $stmt = $pdo->prepare($sql2);
    $stmt->execute();
    $count2 = $stmt->rowCount();
    echo "{$count2} ürünün stok durumu güncellendi.\n";

    // 3. Fotoğrafı olmayan ürün görselleri tablosundaki kayıtları düzelt
    $sql3 = "UPDATE product_images pi
             JOIN products p ON pi.product_id = p.id
             JOIN categories c ON p.category_id = c.id
             SET pi.image_path = CONCAT('products/default/', c.slug, '.jpg')
             WHERE pi.image_path IS NULL OR pi.image_path = ''";
    
    $stmt = $pdo->prepare($sql3);
    $stmt->execute();
    $count3 = $stmt->rowCount();
    echo "{$count3} ürün görsel kaydı güncellendi.\n";

    // 4. Primary olarak işaretli görsel olmayan ürünler için varsayılan görselleri oluştur
    $sql4 = "INSERT INTO product_images (product_id, image_path, is_primary, created_at, updated_at)
             SELECT p.id, CONCAT('products/default/', c.slug, '.jpg'), 1, NOW(), NOW()
             FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
             WHERE pi.id IS NULL";
    
    $stmt = $pdo->prepare($sql4);
    $stmt->execute();
    $count4 = $stmt->rowCount();
    echo "{$count4} yeni ürün görsel kaydı oluşturuldu.\n";

    $pdo->commit();
    echo "Tüm işlemler başarıyla tamamlandı.\n";
} catch (PDOException $e) {
    $pdo->rollBack();
    die("İşlem sırasında hata oluştu: " . $e->getMessage() . "\n");
} 