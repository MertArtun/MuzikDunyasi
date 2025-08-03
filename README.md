# 🎵 Müzik Dünyası

Laravel tabanlı müzik aletleri e-ticaret sitesi

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat)](LICENSE)

## 📖 Hakkında

Bu proje, müzik aletleri satışı yapan bir e-ticaret web sitesidir. Laravel 10 framework'ü kullanılarak geliştirilmiştir.

## ✨ Özellikler

**Müşteri Paneli:**
- 🎸 Ürün kategorilerine göz atma
- 🔍 Ürün detayları ve resimler
- 🛒 Sepete ekleme ve sipariş verme
- 👤 Kullanıcı kayıt/giriş sistemi
- 📋 Sipariş takibi

**Admin Paneli:**
- ⚙️ Ürün ve kategori yönetimi
- 📦 Sipariş yönetimi
- 👥 Kullanıcı listesi

## 🛠️ Kurulum

### Gereksinimler
- PHP 8.1+
- Composer
- SQLite veya MySQL

### Adımlar

```bash
# Projeyi klonlayın
git clone https://github.com/MertArtun/MuzikDunyasi.git
cd MuzikDunyasi

# Bağımlılıkları yükleyin
composer install

# Ortam dosyasını oluşturun
cp .env.example .env
php artisan key:generate

# Veritabanını hazırlayın
touch database/database.sqlite
php artisan migrate:fresh --seed

# Sunucuyu başlatın
php artisan serve
```

Site **http://127.0.0.1:8000** adresinde çalışacaktır.

## 🎸 Müzik Kategorileri

- **Gitarlar** - Akustik, Elektro, Bas
- **Piyanolar** - Akustik, Dijital
- **Davullar** - Akustik ve elektronik setler
- **Yaylı Çalgılar** - Keman, Viyola, Çello
- **Nefesli Çalgılar** - Trompet, Saksofon, Flüt
- **Stüdyo Ekipmanları** - Mikrofon, Amplifikatör, Ses kartları

## 🧪 Test

```bash
php artisan test
```

## 📁 Proje Yapısı

```
app/
├── Http/Controllers/    # Kontrolcüler
├── Models/             # Eloquent modelleri
└── ...
database/
├── migrations/         # Veritabanı migration'ları
└── seeders/           # Demo veriler
resources/views/        # Blade template'leri
routes/web.php         # Web rotaları
```

## 🤝 Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/yeni-ozellik`)
3. Commit edin (`git commit -m 'Yeni özellik eklendi'`)
4. Push edin (`git push origin feature/yeni-ozellik`)
5. Pull Request oluşturun

## 📝 Lisans

Bu proje MIT lisansı ile lisanslanmıştır.

## 👨‍💻 Geliştirici

[Mert Artun](https://github.com/MertArtun)
