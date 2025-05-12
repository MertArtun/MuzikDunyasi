#!/bin/bash

echo "Laravel bakım işlemleri başlatılıyor..."

# Cache temizleme
echo "Cache temizleniyor..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Log dosyalarını temizleme
echo "Log dosyaları temizleniyor..."
> storage/logs/laravel.log
find storage/logs -name "*.log" -type f -delete

# Storage dosyalarını optimize etme
echo "Storage klasörü optimize ediliyor..."
php artisan storage:link

# Composer optimizasyonu
echo "Composer cache temizleniyor..."
composer clear-cache
echo "Composer optimizasyonu yapılıyor..."
composer dump-autoload --optimize

echo "Laravel bakım işlemleri tamamlandı!" 