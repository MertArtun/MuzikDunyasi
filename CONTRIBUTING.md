# 🤝 Katkıda Bulunma Rehberi

Müzik Dünyası projesine katkıda bulunduğunuz için teşekkür ederiz! Bu rehber, projeye nasıl katkıda bulunabileceğinizi açıklar.

## 📋 İçindekiler

- [Davranış Kuralları](#-davranış-kuralları)
- [Nasıl Katkıda Bulunurum](#-nasıl-katkıda-bulunurum)
- [Geliştirme Ortamı](#-geliştirme-ortamı)
- [Kod Standartları](#-kod-standartları)
- [Commit Mesaj Formatı](#-commit-mesaj-formatı)
- [Pull Request Süreci](#-pull-request-süreci)
- [Issue Raporlama](#-issue-raporlama)

## 📜 Davranış Kuralları

Bu proje [Contributor Covenant](https://www.contributor-covenant.org/) davranış kurallarını benimser. Katılım göstererek bu kuralları desteklemeyi kabul etmiş olursunuz.

## 🚀 Nasıl Katkıda Bulunurum

### 🐛 Bug Raporlama
1. [Issue tracker](../../issues)'da mevcut bir rapor olup olmadığını kontrol edin
2. Yoksa yeni bir bug raporu oluşturun
3. Bug template'ini kullanın ve mümkün olduğunca detay verin

### ✨ Özellik Önerme
1. [Issue tracker](../../issues)'da benzer bir öneriniz olup olmadığını kontrol edin
2. Feature request template'ini kullanarak yeni bir issue oluşturun
3. Özelliğin neden gerekli olduğunu açıklayın

### 💻 Kod Katkısı
1. Repository'yi fork edin
2. Yeni bir feature branch oluşturun
3. Değişikliklerinizi yapın
4. Test edin
5. Pull request oluşturun

## 🛠️ Geliştirme Ortamı

### Gereksinimler
- PHP 8.1+
- Composer
- Node.js 18+ (opsiyonel)
- Git

### Kurulum
```bash
# Repository'yi fork edin ve klonlayın
git clone https://github.com/YOUR-USERNAME/MuzikDunyasi.git
cd MuzikDunyasi

# Upstream remote ekleyin
git remote add upstream https://github.com/MertArtun/MuzikDunyasi.git

# Bağımlılıkları yükleyin
composer install
npm install (opsiyonel)

# Ortam dosyasını kopyalayın
cp .env.example .env
php artisan key:generate

# Veritabanını hazırlayın
touch database/database.sqlite
php artisan migrate:fresh --seed

# Sunucuyu başlatın
php artisan serve
```

## 📏 Kod Standartları

### PHP Standartları
- [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard'ını takip edin
- Laravel coding conventions'ları uygulayın
- PHP 8.1+ type declarations kullanın

### Kod Formatı
```bash
# Kod formatını kontrol edin
./vendor/bin/pint --test

# Kodu otomatik formatlayın
./vendor/bin/pint
```

### Static Analysis
```bash
# Kod kalitesini kontrol edin
./vendor/bin/phpstan analyse
```

### Testler
```bash
# Tüm testleri çalıştırın
php artisan test

# Coverage raporu
php artisan test --coverage
```

## 📝 Commit Mesaj Formatı

[Conventional Commits](https://conventionalcommits.org/) formatını kullanın:

```
<type>[optional scope]: <description>

[optional body]

[optional footer(s)]
```

### Commit Türleri
- `feat`: Yeni özellik
- `fix`: Bug düzeltmesi
- `docs`: Dokümantasyon değişikliği
- `style`: Kod formatı değişikliği
- `refactor`: Code refactoring
- `test`: Test ekleme/düzeltme
- `chore`: Build süreci, dependency güncellemeleri

### Örnekler
```bash
feat(auth): add two-factor authentication
fix(cart): resolve quantity update bug
docs(readme): update installation instructions
style: fix indentation in ProductController
refactor(user): extract validation logic to form request
test(product): add unit tests for price calculation
chore: update Laravel to 10.48
```

## 🔄 Pull Request Süreci

### Hazırlık
1. Upstream repository'den güncel kodları alın:
```bash
git fetch upstream
git checkout main
git merge upstream/main
```

2. Yeni feature branch oluşturun:
```bash
git checkout -b feature/amazing-feature
```

3. Değişikliklerinizi yapın ve commit edin
4. Branch'inizi push edin:
```bash
git push origin feature/amazing-feature
```

### PR Oluşturma
1. GitHub'da Pull Request oluşturun
2. PR template'ini doldurun
3. Değişikliklerinizi açıklayın
4. İlgili issue'ları bağlayın
5. Reviewers atayın (isteğe bağlı)

### PR Gereksinimleri
- [ ] Tüm testler geçiyor
- [ ] Kod formatı doğru (Pint)
- [ ] Dokümantasyon güncellendi (gerekirse)
- [ ] Breaking change'ler işaretlendi
- [ ] Issue bağlantıları eklendi

## 🐛 Issue Raporlama

### Bug Reports
Aşağıdaki bilgileri içeren detaylı bug raporları oluşturun:

- **Açıklama**: Hatanın kısa açıklaması
- **Tekrarlanma Adımları**: Hatayı nasıl tekrarlayabiliriz
- **Beklenen Davranış**: Ne olmasını bekliyordunuz
- **Gerçek Davranış**: Ne oldu
- **Ortam**: OS, Browser, PHP version, vb.
- **Ekran Görüntüleri**: Varsa

### Feature Requests
- **Problemi Açıklayın**: Hangi sorunu çözüyor
- **Çözüm Önerisi**: Nasıl çözülmeli
- **Alternatifler**: Başka çözümler düşündünüz mü
- **Ek Bilgiler**: Diğer yararlı bilgiler

## 🏷️ Label Sistemi

| Label | Açıklama |
|-------|----------|
| `bug` | Bug raporu |
| `enhancement` | Yeni özellik önerisi |
| `documentation` | Dokümantasyon iyileştirmesi |
| `good first issue` | Yeni katkıcılar için uygun |
| `help wanted` | Yardım arıyoruz |
| `priority: high` | Yüksek öncelik |
| `status: in progress` | Üzerinde çalışılıyor |
| `type: breaking change` | Breaking change |

## ❓ Sorularınız mı Var?

- [Discussions](../../discussions) sayfasında soru sorabilirsiniz
- [Discord](https://discord.gg/muzikdunyasi) kanalımıza katılabilirsiniz
- [Email](mailto:info@muzikdunyasi.com) gönderebilirsiniz

## 🎉 Teşekkürler!

Zamanınızı ayırarak Müzik Dünyası projesine katkıda bulunduğunuz için teşekkür ederiz! 🎵
