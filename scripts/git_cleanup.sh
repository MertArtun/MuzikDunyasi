#!/bin/bash

echo "Git deposu temizleme işlemi başlatılıyor..."

# Gereksiz dosyaları temizle
echo "Git çöp toplama başlatılıyor..."
git gc --aggressive --prune=now

# İzlenen dosyaları kontrol et
echo "Artık takip edilmemesi gereken dosyaları bulma..."
git ls-files --cached | grep -E "storage/app/public|storage/logs" | xargs -r git rm --cached

echo "Değişiklikleri kaydet..."
git commit -m "Gereksiz dosyaları Git izlemesinden çıkar" 

echo "Git deposu temizleme işlemi tamamlandı!"
echo "Not: Bu işlem sadece local Git deposunu temizler. Değişiklikleri uzak sunucuya göndermek için 'git push' komutunu çalıştırın." 