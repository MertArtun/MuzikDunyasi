# Müzik Dünyası E-Ticaret Projesi

Müzik Dünyası, Laravel framework'ü kullanılarak geliştirilmiş, müzik aletleri satışı yapan bir e-ticaret web uygulamasıdır. Proje, kullanıcı ve yönetici arayüzleri ile tam fonksiyonel bir online alışveriş deneyimi sunmaktadır.

## Proje Özellikleri

### Kullanıcı Arayüzü
- Anasayfa banner ve vitrin ürünleri gösterimi
- Kategori bazlı ürün listeleme ve filtreleme
- Detaylı ürün sayfaları ve ürün resimleri
- Sepete ekleme, güncelleme ve silme işlemleri
- Adres ve ödeme bilgileri girişi ile sipariş oluşturma
- Sipariş takibi ve geçmiş siparişleri görüntüleme
- Kullanıcı profil yönetimi ve şifre değiştirme

### Yönetici Arayüzü
- Ürün ekleme, düzenleme, silme ve listeleme
- Kategori yönetimi
- Sipariş listeleme ve durumlarını güncelleme
- Kullanıcı listesi ve detayları görüntüleme
- Stok yönetimi
- Ürün görselleri yükleme ve yönetme

## Teknik Özellikler
- Laravel 10 framework'ü
- Bootstrap 5 ile responsive tasarım
- MySQL veritabanı
- Blade şablon motoru
- Laravel Auth sistemi
- Repository pattern kullanımı
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
