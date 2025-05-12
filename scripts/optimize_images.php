<?php

// Görsel optimizasyon scripti
// Bu script, storage/app/public/products klasöründeki tüm görselleri optimize eder

// Komut satırından çalıştırıldığını doğrula
if (php_sapi_name() !== 'cli') {
    exit("Bu script sadece komut satırından çalıştırılabilir.\n");
}

// Klasör yolu
$productImagesPath = __DIR__ . '/../storage/app/public/products';

// Klasör var mı kontrol et
if (!is_dir($productImagesPath)) {
    exit("Görsel klasörü bulunamadı: {$productImagesPath}\n");
}

// Başlangıç bilgisi
echo "Görsel optimizasyonu başlatılıyor...\n";
echo "Klasör: {$productImagesPath}\n\n";

// İstatistik verileri
$totalFiles = 0;
$totalSizeBefore = 0;
$totalSizeAfter = 0;

// Recursive olarak klasörü tara
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($productImagesPath, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if ($file->isFile() && in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png'])) {
        $filePath = $file->getPathname();
        $totalFiles++;
        
        // Dosya boyutunu al
        $sizeBefore = filesize($filePath);
        $totalSizeBefore += $sizeBefore;
        
        // GD kütüphanesiyle görsel yükle
        $image = null;
        $extension = strtolower($file->getExtension());
        
        if ($extension == 'jpg' || $extension == 'jpeg') {
            $image = imagecreatefromjpeg($filePath);
        } elseif ($extension == 'png') {
            $image = imagecreatefrompng($filePath);
        }
        
        if (!$image) {
            echo "Hata: {$filePath} dosyası yüklenemedi.\n";
            continue;
        }
        
        // Kalite oranını belirleme (0-100 arası, 100 en yüksek kalite)
        $quality = 75; 
        
        // Resmi kaydet
        if ($extension == 'jpg' || $extension == 'jpeg') {
            imagejpeg($image, $filePath, $quality);
        } elseif ($extension == 'png') {
            // PNG için kalite ayarı farklı çalışır (0-9 arası, 0 en hızlı/düşük kalite)
            imagepng($image, $filePath, 6);
        }
        
        // Belleği temizle
        imagedestroy($image);
        
        // Optimize edilmiş dosya boyutunu al
        clearstatcache(true, $filePath);
        $sizeAfter = filesize($filePath);
        $totalSizeAfter += $sizeAfter;
        
        // Dosya işleme sonucunu raporla
        $savingsPercent = round(($sizeBefore - $sizeAfter) / $sizeBefore * 100, 2);
        $sizeBefore = round($sizeBefore / 1024, 2);
        $sizeAfter = round($sizeAfter / 1024, 2);
        
        echo "Optimize edildi: {$filePath}\n";
        echo "  Önceki boyut: {$sizeBefore} KB\n";
        echo "  Yeni boyut: {$sizeAfter} KB\n";
        echo "  Kazanç: %{$savingsPercent}\n\n";
    }
}

// Sonuç raporu
$totalSavingsPercent = round(($totalSizeBefore - $totalSizeAfter) / $totalSizeBefore * 100, 2);
$totalSizeBefore = round($totalSizeBefore / (1024 * 1024), 2);
$totalSizeAfter = round($totalSizeAfter / (1024 * 1024), 2);
$totalSavings = round($totalSizeBefore - $totalSizeAfter, 2);

echo "Optimizasyon tamamlandı!\n";
echo "Toplam optimize edilen dosya sayısı: {$totalFiles}\n";
echo "Toplam boyut (önceki): {$totalSizeBefore} MB\n";
echo "Toplam boyut (sonraki): {$totalSizeAfter} MB\n";
echo "Toplam kazanç: {$totalSavings} MB (%{$totalSavingsPercent})\n"; 