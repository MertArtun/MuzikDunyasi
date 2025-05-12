-- Resim yolu boş olan ürünleri kategori bazlı varsayılan görseller ile güncelle
UPDATE products p
JOIN categories c ON p.category_id = c.id
SET p.image_path = CONCAT('products/default/', c.slug, '.jpg')
WHERE p.image_path IS NULL OR p.image_path = '';

-- Stok durumu 0 veya NULL olan ürünleri güncelle (burada rastgele değer atanacak)
-- Production ortamında bu değerler gerçek stok durumuna göre ayarlanmalı
UPDATE products
SET stock = FLOOR(10 + RAND() * 90)
WHERE stock = 0 OR stock IS NULL;

-- Fotoğrafı olmayan ürün görselleri tablosundaki kayıtları düzelt
UPDATE product_images pi
JOIN products p ON pi.product_id = p.id
JOIN categories c ON p.category_id = c.id
SET pi.image_path = CONCAT('products/default/', c.slug, '.jpg')
WHERE pi.image_path IS NULL OR pi.image_path = '';

-- Primary olarak işaretli görsel olmayan ürünler için varsayılan görselleri oluştur
INSERT INTO product_images (product_id, image_path, is_primary, created_at, updated_at)
SELECT p.id, CONCAT('products/default/', c.slug, '.jpg'), 1, NOW(), NOW()
FROM products p
LEFT JOIN categories c ON p.category_id = c.id
LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
WHERE pi.id IS NULL; 