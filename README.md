# 🎵 Müzik Dünyası E-Ticaret Projesi

Modern ve kullanıcı dostu bir müzik aletleri e-ticaret platformu. Laravel 10 framework'ü ile geliştirilmiştir.

![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 📸 Önizleme

> Modern, responsive tasarım ile müzik aletleri satışına odaklanan profesyonel e-ticaret platformu

## ✨ Özellikler

### 🛍️ **Müşteri Arayüzü**
- 🏠 **Dinamik Anasayfa** - Banner'lar ve öne çıkan ürünler
- 📂 **Kategorili Ürün Listesi** - Kolay navigasyon ve filtreleme
- 🔍 **Detaylı Ürün Sayfaları** - Çoklu resim desteği
- 🛒 **Gelişmiş Sepet Sistemi** - Anlık güncelleme ve hesaplama
- 💳 **Güvenli Ödeme Süreci** - Adres ve ödeme bilgileri yönetimi
- 📋 **Sipariş Takibi** - Gerçek zamanlı durum güncellemeleri
- 👤 **Kullanıcı Profili** - Kişisel bilgiler ve şifre yönetimi

### ⚙️ **Yönetim Paneli**
- 📊 **Dashboard** - Satış ve sipariş istatistikleri
- 🎸 **Ürün Yönetimi** - CRUD işlemleri ve resim yükleme
- 📁 **Kategori Sistemi** - Hiyerarşik kategori yapısı
- 📦 **Sipariş Yönetimi** - Durum güncellemeleri ve takip
- 👥 **Kullanıcı Yönetimi** - Müşteri bilgileri görüntüleme
- 📈 **Stok Takibi** - Envanter yönetimi

### 🎯 **Teknik Özellikler**
- 🏗️ **Laravel 10** - Modern PHP framework
- 🎨 **Bootstrap 5** - Responsive ve mobil uyumlu tasarım
- 🗄️ **SQLite/MySQL** - Esnek veritabanı desteği
- 🔐 **Laravel Auth** - Güvenli kimlik doğrulama
- 📝 **Blade Templates** - Temiz ve organize kod yapısı
- 🔄 **Repository Pattern** - Sürdürülebilir kod mimarisi

## 🚀 Kurulum

### Gereksinimler
- PHP 8.1 veya üzeri
- Composer
- Node.js & NPM (opsiyonel)

### Adım Adım Kurulum

1. **Projeyi Klonlayın**
```bash
git clone https://github.com/kullaniciadi/muzik-dunyasi.git
cd muzik-dunyasi
```

2. **Bağımlılıkları Yükleyin**
```bash
composer install
```

3. **Ortam Dosyasını Oluşturun**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Veritabanını Yapılandırın**

**SQLite için (Önerilen):**
```bash
touch database/database.sqlite
```

**MySQL için:**
```bash
# .env dosyasında veritabanı ayarlarını güncelleyin
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=muzik_dunyasi
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. **Veritabanını Oluşturun**
```bash
php artisan migrate
php artisan db:seed
```

6. **Storage Bağlantısını Oluşturun**
```bash
php artisan storage:link
```

7. **Sunucuyu Başlatın**
```bash
php artisan serve
```

🎉 **Tebrikler!** Proje http://127.0.0.1:8000 adresinde çalışıyor.

## 📁 Proje Yapısı

```
muzik-dunyasi/
├── app/
│   ├── Http/Controllers/     # Controller sınıfları
│   ├── Models/              # Eloquent modelleri
│   └── ...
├── database/
│   ├── migrations/          # Veritabanı migration'ları
│   └── seeders/            # Demo veri seeders
├── public/
│   ├── css/                # Stil dosyaları
│   └── images/             # Site görselleri
├── resources/
│   └── views/              # Blade template'leri
└── routes/
    └── web.php             # Web rotaları
```

## 🎸 Müzik Kategorileri

- **🎸 Gitarlar** - Akustik, Elektro, Bas
- **🎹 Piyanolar** - Akustik, Dijital, Klavyeler  
- **🥁 Davul & Perküsyon** - Akustik ve elektronik setler
- **🎻 Yaylı Çalgılar** - Keman, Viyola, Çello
- **🎺 Nefesli Çalgılar** - Trompet, Saksofon, Flüt
- **🎚️ Stüdyo Ekipmanları** - Mikrofon, Amplifikatör, Ses kartları

## 🛠️ Geliştirme

### Kod Standartları
```bash
# Code formatting
./vendor/bin/pint

# Tests
php artisan test
```

### Yeni Özellik Ekleme
1. Migration oluşturun: `php artisan make:migration`
2. Model oluşturun: `php artisan make:model`
3. Controller oluşturun: `php artisan make:controller`
4. Route ekleyin
5. View oluşturun

## 🤝 Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/AmazingFeature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add some AmazingFeature'`)
4. Branch'inizi push edin (`git push origin feature/AmazingFeature`)
5. Pull Request oluşturun

## 📝 Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için [LICENSE](LICENSE) dosyasını inceleyin.

## 🙏 Teşekkürler

- Laravel Framework geliştiricilerine
- Bootstrap ekibine
- Açık kaynak topluluğuna

---

⭐ **Bu proje işinize yaradıysa yıldız vermeyi unutmayın!**

📧 **İletişim:** [your-email@example.com]
- Form validasyonları ve hata yönetimi
- Resim yükleme ve işleme sistemi

## Kurulum

1. Projeyi klonlayın:
```
git clone https://github.com/MertArtun/MuzikDunyasi.git
```

2. Bağımlılıkları yükleyin:
```
composer install
npm install
```

3. `.env` dosyasını oluşturun:
```
cp .env.example .env
```

4. `.env` dosyasını düzenleyerek veritabanı bağlantı bilgilerinizi ekleyin.

5. Uygulama anahtarını oluşturun:
```
php artisan key:generate
```

6. Veritabanı tablolarını oluşturun:
```
php artisan migrate
```

7. Temel verileri yükleyin (seeder):
```
php artisan db:seed
```

8. Depolama alanı için simbolik link oluşturun:
```
php artisan storage:link
```

9. Uygulamayı başlatın:
```
php artisan serve
```

## Kullanım

### Kullanıcı Girişi
- Normal kullanıcı erişimi: `/login` sayfasından giriş yapılabilir
- Demo kullanıcı: `user@example.com` / `password`

### Yönetici Girişi
- Yönetici paneli: `/admin/login` adresinden erişilebilir
- Demo yönetici: `admin@example.com` / `password`

## Proje Yapısı

Proje, MVC (Model-View-Controller) mimarisi üzerine kurulmuştur:

- `app/Models`: Veritabanı modelleri
- `app/Http/Controllers`: Kontrol sınıfları
- `app/Http/Requests`: Form istekleri ve validasyon kuralları
- `app/Repositories`: Repository sınıfları
- `resources/views`: Blade şablon dosyaları
- `public/css`, `public/js`: Frontend varlıkları
- `public/storage/products`: Ürün görselleri
- `routes`: Web ve API rotaları

## Lisans

Bu proje [MIT lisansı](LICENSE) altında lisanslanmıştır.

## İletişim

Mert Artun - [GitHub](https://github.com/MertArtun)

## Sistem Bakımı ve Optimizasyon

Projenin boyutunu yönetmek ve performansını artırmak için aşağıdaki bakım scriptleri eklenmiştir:

### Görsel Optimizasyonu

Ürün görsellerini optimize etmek için:

```bash
php scripts/optimize_images.php
```

Bu script, tüm ürün görsellerini kaliteyi koruyarak optimize eder ve projenin boyutunu önemli ölçüde azaltır.

### Git Deposu Temizleme

Git deposunu temizlemek ve küçültmek için:

```bash
./scripts/git_cleanup.sh
```

### Laravel Bakım İşlemleri

Cache ve log temizliği için:

```bash
./scripts/maintenance.sh
```

### Manuel Optimizasyon Adımları

1. **Log Dosyalarını Düzenli Temizleme**
   - Log dosyaları düzenli olarak temizlenmelidir
   - Log rotasyonu ayarlamak için Laravel yapılandırmasını güncelleyebilirsiniz

2. **Büyük Dosyaları .gitignore'a Ekleme**
   - Büyük medya dosyaları ve ürün görselleri Git deposuna eklenmemeli
   - storage/app/public klasörü .gitignore dosyasına eklenmiştir

3. **Composer Bağımlılıklarını Optimize Etme**
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

Bu adımları düzenli olarak uygulamak, projenin düzgün çalışmasını sağlarken boyutunu kontrol altında tutar.
