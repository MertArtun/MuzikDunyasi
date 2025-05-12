<?php $__env->startSection('content'); ?>
<!-- Leaflet CSS ve JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<!-- Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner rounded shadow">
                <div class="carousel-item active">
                    <img src="<?php echo e(asset('images/banners/main-banner.jpg')); ?>" class="d-block w-100" alt="Müzik Dünyası">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Müzik Dünyasına Hoş Geldiniz</h2>
                        <p>En kaliteli müzik aletleri ve ekipmanları için doğru adres</p>
                        <a href="/products" class="btn btn-primary">Ürünleri İncele</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="<?php echo e(asset('images/banners/new-products.jpg')); ?>" class="d-block w-100" alt="Yeni Ürünler">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Yeni Gelen Ürünler</h2>
                        <p>En son eklenen müzik aletlerini keşfedin</p>
                        <a href="/products?sort=new" class="btn btn-primary">Keşfet</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="<?php echo e(asset('images/banners/special-offers.jpg')); ?>" class="d-block w-100" alt="Özel İndirimler">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Özel İndirimler</h2>
                        <p>Sınırlı süre için geçerli fırsatları kaçırmayın</p>
                        <a href="/products?sale=1" class="btn btn-primary">İndirimleri Gör</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

<!-- Countdown Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm countdown-card">
            <div class="card-body p-5">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h2 class="text-white mb-3">Özel İndirim Fırsatını Kaçırma!</h2>
                        <p class="text-white-50 mb-4">Tüm gitar ve davul ürünlerinde %20'ye varan indirimler için son</p>
                        <a href="/products?sale=1" class="btn btn-light btn-lg">Hemen İncele</a>
                    </div>
                    <div class="col-lg-6">
                        <div class="countdown-timer" id="countdown">
                            <div class="countdown-item">
                                <div class="countdown-value" id="countdown-days">00</div>
                                <div class="countdown-label">Gün</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-value" id="countdown-hours">00</div>
                                <div class="countdown-label">Saat</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-value" id="countdown-minutes">00</div>
                                <div class="countdown-label">Dakika</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-value" id="countdown-seconds">00</div>
                                <div class="countdown-label">Saniye</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="row mb-5">
    <div class="col-12">
        <h2 class="mb-4">Kategoriler</h2>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm category-card">
            <img src="<?php echo e(asset('images/categories/guitars.jpg')); ?>" class="card-img-top category-img" alt="Gitarlar">
            <div class="card-body text-center">
                <h4 class="card-title">Gitarlar</h4>
                <p class="card-text">Akustik, elektro ve bas gitarların geniş seçkisi</p>
                <a href="/products?category=1" class="btn btn-outline-primary">Göz At</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm category-card">
            <img src="<?php echo e(asset('images/categories/drums.jpg')); ?>" class="card-img-top category-img" alt="Davul ve Perküsyon">
            <div class="card-body text-center">
                <h4 class="card-title">Davul ve Perküsyon</h4>
                <p class="card-text">Akustik davullar, elektronik davullar ve perküsyon aletleri</p>
                <a href="/products?category=3" class="btn btn-outline-primary">Göz At</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm category-card">
            <img src="<?php echo e(asset('images/categories/audio.jpg')); ?>" class="card-img-top category-img" alt="Ses Ekipmanları">
            <div class="card-body text-center">
                <h4 class="card-title">Ses Ekipmanları</h4>
                <p class="card-text">Mikrofon, amfi, mixer ve daha fazlası</p>
                <a href="/products?category=6" class="btn btn-outline-primary">Göz At</a>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<div class="row mb-5">
    <div class="col-12">
        <h2 class="mb-4">Öne Çıkan Ürünler</h2>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-md-3 mb-4">
        <div class="card h-100 border-0 shadow-sm product-card">
            <?php
                $imagePath = $product->getImagePathAttribute();
            ?>
            <img src="<?php echo e($imagePath); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><a href="<?php echo e(url('/products/' . $product->id)); ?>" class="text-decoration-none text-dark"><?php echo e($product->name); ?></a></h5>
                <p class="text-muted small"><?php echo e($product->category->name ?? 'Kategorisiz'); ?></p>
                <p class="card-text small flex-grow-1"><?php echo e(Str::limit($product->description, 70)); ?></p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="h5 mb-0 text-primary"><?php echo e(number_format($product->price, 2)); ?> ₺</span>
                    
                    <a href="#" class="btn btn-sm btn-outline-primary"><i class="fas fa-shopping-cart me-1"></i>Ekle</a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
     <div class="col-12">
        <p class="text-center text-muted">Şu anda öne çıkan ürün bulunmamaktadır.</p>
    </div>
    <?php endif; ?>
</div>

<!-- Instrument Guide Section -->
<div class="row mb-5">
    <div class="col-12 mb-4 text-center">
        <h2 class="mb-3">Enstrüman Seçim Rehberi</h2>
        <p class="text-muted">Size en uygun enstrümanı bulmanıza yardımcı olalım</p>
    </div>
    <div class="col-12">
        <div class="card border-0 shadow-sm instrument-guide-card">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-lg-5 instrument-finder-img d-none d-lg-block">
                        <!-- Enstrüman resmi arka plan olarak CSS ile eklenecek -->
                    </div>
                    <div class="col-lg-7">
                        <div class="p-4 p-lg-5">
                            <h3 class="mb-4">Seviyenize Uygun Enstrüman Bulun</h3>
                            <form class="instrument-finder-form">
                                <div class="mb-3">
                                    <label class="form-label">Hangi enstrümanla ilgileniyorsunuz?</label>
                                    <select class="form-select" id="instrument-type">
                                        <option selected>Enstrüman seçiniz</option>
                                        <option value="guitar">Gitar</option>
                                        <option value="piano">Piyano/Klavye</option>
                                        <option value="drums">Davul</option>
                                        <option value="bass">Bas Gitar</option>
                                        <option value="wind">Nefesli Çalgılar</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Müzik deneyiminiz nedir?</label>
                                    <select class="form-select" id="experience-level">
                                        <option selected>Seviye seçiniz</option>
                                        <option value="beginner">Başlangıç - Hiç deneyimim yok</option>
                                        <option value="intermediate">Orta - Biraz çalabiliyorum</option>
                                        <option value="advanced">İleri - Düzenli çalıyorum</option>
                                        <option value="professional">Profesyonel - Deneyimliyim</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bütçeniz nedir?</label>
                                    <select class="form-select" id="budget-range">
                                        <option selected>Bütçe seçiniz</option>
                                        <option value="low">Ekonomik (₺1.000 - ₺10.000)</option>
                                        <option value="medium">Orta Segment (₺10.000 - ₺25.000)</option>
                                        <option value="high">Premium (₺25.000 - ₺50.000)</option>
                                        <option value="luxury">Profesyonel (₺50.000+)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hangi müzik tarzını çalmak istiyorsunuz?</label>
                                    <select class="form-select" id="music-style">
                                        <option selected>Müzik tarzı seçiniz</option>
                                        <option value="rock">Rock/Metal</option>
                                        <option value="pop">Pop</option>
                                        <option value="jazz">Jazz/Blues</option>
                                        <option value="classical">Klasik</option>
                                        <option value="folk">Halk Müziği</option>
                                        <option value="electronic">Elektronik</option>
                                    </select>
                                </div>
                                <button type="button" id="find-instrument-btn" class="btn btn-primary">Bana Uygun Enstrümanları Göster</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sonuç kartı (başlangıçta gizli) -->
        <div class="card mt-4 border-0 shadow-sm d-none" id="instrument-results">
            <div class="card-body p-4">
                <h4 class="mb-4">Size Önerilen Enstrümanlar</h4>
                <div class="row" id="recommendation-results">
                    <!-- Sonuçlar JavaScript ile buraya eklenecek -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Musician Stories Section -->
<div class="row mb-5">
    <div class="col-12 mb-4 text-center">
        <h2 class="mb-3">Müzisyen Hikayeleri</h2>
        <p class="text-muted">İlham veren müzisyenlerin yolculuklarını keşfedin</p>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm musician-story-card">
            <img src="<?php echo e(asset('images/musicians/musician1.jpg')); ?>" class="card-img-top musician-img" alt="Ahmet Yılmaz">
            <div class="card-body">
                <div class="musician-quote">
                    <i class="fas fa-quote-left"></i>
                </div>
                <h5 class="card-title">Ahmet Yılmaz</h5>
                <p class="text-muted mb-3">Rock Gitaristi, 15 yıllık deneyim</p>
                <p class="card-text">İlk gitarımı Müzik Dünyası'ndan aldığımda henüz 16 yaşındaydım. O gün bugündür müzik hayatımın vazgeçilmez bir parçası. Şimdi kendi grubuyla sahne alıyor ve genç müzisyenlere ilham veriyorum.</p>
                <button class="btn btn-link text-primary p-0 read-more-btn" data-story="ahmet">Devamını Oku</button>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm musician-story-card">
            <img src="<?php echo e(asset('images/musicians/musician2.jpg')); ?>" class="card-img-top musician-img" alt="Zeynep Kaya">
            <div class="card-body">
                <div class="musician-quote">
                    <i class="fas fa-quote-left"></i>
                </div>
                <h5 class="card-title">Zeynep Kaya</h5>
                <p class="text-muted mb-3">Piyanist, 12 yıllık deneyim</p>
                <p class="card-text">Klasik müzik eğitiminden sonra kendi yolumu çizmeye karar verdim. Burada bulduğum dijital piyano, müzik tarzımı keşfetmem için bana yeni kapılar açtı. Şimdi kendi bestelerimi yapıyorum.</p>
                <button class="btn btn-link text-primary p-0 read-more-btn" data-story="zeynep">Devamını Oku</button>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm musician-story-card">
            <img src="<?php echo e(asset('images/musicians/musician3.jpg')); ?>" class="card-img-top musician-img" alt="Burak Demir">
            <div class="card-body">
                <div class="musician-quote">
                    <i class="fas fa-quote-left"></i>
                </div>
                <h5 class="card-title">Burak Demir</h5>
                <p class="text-muted mb-3">Davulcu, 8 yıllık deneyim</p>
                <p class="card-text">Müzik hayatıma başlarken doğru ekipmanı bulmak zordu. Müzik Dünyası'ndaki ustalar, bana en uygun davul setini seçmemde yardımcı oldu. Şimdi farklı gruplarla çalışıyorum.</p>
                <button class="btn btn-link text-primary p-0 read-more-btn" data-story="burak">Devamını Oku</button>
            </div>
        </div>
    </div>
</div>

<!-- Musician Story Modal -->
<div class="modal fade" id="musician-story-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="story-modal-title">Müzisyen Hikayesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="story-modal-content">
                <!-- İçerik JavaScript ile doldurulacak -->
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="row mb-5">
    <div class="col-12 mb-4">
        <h2 class="mb-2 text-center">Neden Bizi Tercih Etmelisiniz?</h2>
        <p class="text-muted text-center">Müzik Dünyası olarak en iyi hizmeti sunmak için çalışıyoruz</p>
    </div>
    <div class="col-md-3 mb-4">
        <div class="feature-box text-center">
            <div class="feature-icon">
                <i class="fas fa-truck"></i>
            </div>
            <h5>Hızlı Teslimat</h5>
            <p class="text-muted">Siparişleriniz 1-3 iş günü içerisinde kapınızda</p>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="feature-box text-center">
            <div class="feature-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h5>Güvenli Ödeme</h5>
            <p class="text-muted">128-bit SSL ile korunan ödeme altyapısı</p>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="feature-box text-center">
            <div class="feature-icon">
                <i class="fas fa-undo"></i>
            </div>
            <h5>Kolay İade</h5>
            <p class="text-muted">14 gün içerisinde koşulsuz iade imkanı</p>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="feature-box text-center">
            <div class="feature-icon">
                <i class="fas fa-headset"></i>
            </div>
            <h5>7/24 Destek</h5>
            <p class="text-muted">Müşteri hizmetlerimiz her zaman yanınızda</p>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="row mb-5">
    <div class="col-12">
        <h2 class="mb-4">Müşteri Yorumları</h2>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm testimonial-card">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                </div>
                <p class="card-text">"Aldığım Fender gitardan çok memnunum. Hızlı kargo ve güvenli paketleme için teşekkürler."</p>
                <div class="d-flex align-items-center">
                    <img src="<?php echo e(asset('images/testimonials/person1.jpg')); ?>" class="rounded-circle me-3 testimonial-img" alt="Müşteri">
                    <div>
                        <h6 class="mb-0">Ahmet Y.</h6>
                        <small class="text-muted">İstanbul</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm testimonial-card">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                </div>
                <p class="card-text">"Uzun zamandır aradığım davul setini burada buldum. Fiyat ve kalite olarak çok memnunum."</p>
                <div class="d-flex align-items-center">
                    <img src="<?php echo e(asset('images/testimonials/person2.jpg')); ?>" class="rounded-circle me-3 testimonial-img" alt="Müşteri">
                    <div>
                        <h6 class="mb-0">Zeynep K.</h6>
                        <small class="text-muted">Ankara</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm testimonial-card">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star-half-alt text-warning"></i>
                </div>
                <p class="card-text">"Kaliteli ürünler ve hızlı teslimat. Alışveriş deneyiminden çok memnun kaldım."</p>
                <div class="d-flex align-items-center">
                    <img src="<?php echo e(asset('images/testimonials/person3.jpg')); ?>" class="rounded-circle me-3 testimonial-img" alt="Müşteri">
                    <div>
                        <h6 class="mb-0">Mehmet S.</h6>
                        <small class="text-muted">İzmir</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm newsletter-card">
            <div class="card-body p-5 position-relative overflow-hidden">
                <div class="newsletter-bg"></div>
                <div class="row align-items-center position-relative">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h3 class="text-white">Haberdar Olun</h3>
                        <p class="mb-0 text-white-50">Yeni ürünler, indirimler ve kampanyalardan haberdar olmak için bültenimize kaydolun.</p>
                    </div>
                    <div class="col-md-6">
                        <form action="/newsletter/subscribe" method="POST">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="E-posta adresinizi girin" aria-label="E-posta adresinizi girin">
                                <button class="btn btn-primary" type="submit">Abone Ol</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Music Notes Decoration -->
<div class="music-notes">
    <i class="fas fa-music note-1"></i>
    <i class="fas fa-music note-2"></i>
    <i class="fas fa-music note-3"></i>
</div>

<!-- Event Calendar Section -->
<div class="row mb-5">
    <div class="col-12 mb-4 text-center">
        <h2 class="mb-3">Etkinlik Takvimi</h2>
        <p class="text-muted">Yaklaşan müzik etkinlikleri ve workshoplar</p>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm event-card" 
             data-event-image="<?php echo e(asset('images/events/event1.jpg')); ?>" 
             data-event-title="Canlı Performans Gecesi" 
             data-event-location="İstanbul, Beyoğlu, İstiklal Caddesi No:123" 
             data-event-lat="41.0352" 
             data-event-lng="28.9772">
            <div class="event-date">
                <span class="event-day">15</span>
                <span class="event-month">HAZ</span>
            </div>
            <img src="<?php echo e(asset('images/events/event1.jpg')); ?>" class="card-img-top event-img" alt="Canlı Performans Gecesi">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-primary event-badge">Konser</span>
                    <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> İstanbul</small>
                </div>
                <h5 class="card-title">Canlı Performans Gecesi</h5>
                <p class="card-text">Yerel müzisyenlerden oluşan grupların performanslarını izleyebileceğiniz özel bir gece.</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted"><i class="far fa-clock me-1"></i> 20:00 - 23:00</small>
                    <a href="#" class="btn btn-outline-primary btn-sm event-details-btn" data-event-title="Canlı Performans Gecesi">Detaylar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm event-card"
             data-event-image="<?php echo e(asset('images/events/event2.jpg')); ?>" 
             data-event-title="Gitar Workshop" 
             data-event-location="Ankara, Çankaya, Tunalı Hilmi Caddesi No:45"
             data-event-lat="39.9078" 
             data-event-lng="32.8539">
            <div class="event-date">
                <span class="event-day">22</span>
                <span class="event-month">HAZ</span>
            </div>
            <img src="<?php echo e(asset('images/events/event2.jpg')); ?>" class="card-img-top event-img" alt="Gitar Workshop">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-success event-badge">Workshop</span>
                    <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> Ankara</small>
                </div>
                <h5 class="card-title">Gitar Workshop</h5>
                <p class="card-text">Profesyonel gitaristlerden teknik ve performans ipuçları alabileceğiniz interaktif bir atölye.</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted"><i class="far fa-clock me-1"></i> 14:00 - 17:00</small>
                    <a href="#" class="btn btn-outline-primary btn-sm event-details-btn" data-event-title="Gitar Workshop">Detaylar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm event-card"
             data-event-image="<?php echo e(asset('images/events/event3.jpg')); ?>" 
             data-event-title="Enstrüman Tanıtım Günü" 
             data-event-location="İzmir, Konak, Kıbrıs Şehitleri Caddesi No:78"
             data-event-lat="38.4195" 
             data-event-lng="27.1261">
            <div class="event-date">
                <span class="event-day">30</span>
                <span class="event-month">HAZ</span>
            </div>
            <img src="<?php echo e(asset('images/events/event3.jpg')); ?>" class="card-img-top event-img" alt="Enstrüman Tanıtım Günü">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-info event-badge">Demo</span>
                    <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> İzmir</small>
                </div>
                <h5 class="card-title">Enstrüman Tanıtım Günü</h5>
                <p class="card-text">Yeni gelen ürünleri deneyebileceğiniz ve uzmanlarla tanışabileceğiniz özel etkinlik.</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted"><i class="far fa-clock me-1"></i> 12:00 - 18:00</small>
                    <a href="#" class="btn btn-outline-primary btn-sm event-details-btn" data-event-title="Enstrüman Tanıtım Günü">Detaylar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 text-center mt-3">
        <a href="#" class="btn btn-primary">Tüm Etkinlikleri Göster</a>
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="event-details-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="event-modal-title">Etkinlik Detayları</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="event-modal-content">
                <!-- İçerik JavaScript ile doldurulacak -->
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="row mb-5">
    <div class="col-12 mb-4 text-center">
        <h2 class="mb-3">Sık Sorulan Sorular</h2>
        <p class="text-muted">Müşterilerimizin en çok merak ettiği konular</p>
    </div>
    
    <div class="col-12">
        <div class="accordion faq-accordion" id="faqAccordion">
            <div class="accordion-item border-0 mb-3 shadow-sm">
                <h2 class="accordion-header" id="faqHeading1">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                        <i class="fas fa-question-circle me-2 text-primary"></i> Siparişim ne kadar sürede elime ulaşır?
                    </button>
                </h2>
                <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Siparişleriniz, ödeme onayından sonra 1-3 iş günü içerisinde kargoya verilmektedir. Teslimat süresi, bulunduğunuz konuma göre değişmekle birlikte genellikle 1-4 iş günü arasındadır. Özel durumlar (büyük enstrümanlar, stok durumu, vb.) için lütfen müşteri hizmetlerimiz ile iletişime geçiniz.</p>
                    </div>
                </div>
            </div>
            
            <div class="accordion-item border-0 mb-3 shadow-sm">
                <h2 class="accordion-header" id="faqHeading2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                        <i class="fas fa-question-circle me-2 text-primary"></i> Ürünlerde garanti var mı?
                    </button>
                </h2>
                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Sitemizden satın aldığınız tüm ürünler, Türkiye distribütörlerinin sağladığı resmi garantiye sahiptir. Garanti süresi ürüne göre değişmekle birlikte genellikle 2 yıldır. Ayrıca, tüm ürünlerde 14 gün içerisinde iade hakkınız bulunmaktadır.</p>
                    </div>
                </div>
            </div>
            
            <div class="accordion-item border-0 mb-3 shadow-sm">
                <h2 class="accordion-header" id="faqHeading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                        <i class="fas fa-question-circle me-2 text-primary"></i> Mağazanızda ürünleri deneyebilir miyim?
                    </button>
                </h2>
                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Evet, İstanbul, Ankara ve İzmir'deki mağazalarımızda tüm ürünlerimizi deneyebilirsiniz. Özellikle enstrüman seçimi gibi kişisel tercihlerin önemli olduğu konularda, ürünleri fiziksel olarak denemenizi tavsiye ederiz. Mağaza ziyareti öncesinde ilgilendiğiniz ürünün stok durumunu kontrol etmek için bizi arayabilirsiniz.</p>
                    </div>
                </div>
            </div>
            
            <div class="accordion-item border-0 mb-3 shadow-sm">
                <h2 class="accordion-header" id="faqHeading4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                        <i class="fas fa-question-circle me-2 text-primary"></i> Taksitli ödeme yapabilir miyim?
                    </button>
                </h2>
                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Evet, sitemizden yapacağınız alışverişlerde kredi kartına taksit imkanımız bulunmaktadır. Anlaşmalı bankalara göre 3, 6, 9 ve 12 taksit seçenekleri sunulmaktadır. Ödeme sayfasında kredi kartınıza uygun taksit seçeneklerini görebilirsiniz.</p>
                    </div>
                </div>
            </div>
            
            <div class="accordion-item border-0 mb-3 shadow-sm">
                <h2 class="accordion-header" id="faqHeading5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                        <i class="fas fa-question-circle me-2 text-primary"></i> Yeni başlayanlar için enstrüman öneriniz nedir?
                    </button>
                </h2>
                <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Yeni başlayanlar için en uygun enstrüman kişisel ilgi alanlarına göre değişir. Ancak genel olarak:</p>
                        <ul>
                            <li>Gitar: Akustik gitarlar, özellikle ölçek boyu standart olan modeller başlangıç için idealdir.</li>
                            <li>Piyano: Ağırlıklı tuşlara sahip dijital piyanolar, başlangıç için uygun fiyatlı bir seçenektir.</li>
                            <li>Bateri: Elektronik davullar, apartman dairelerinde çalışabilmek için sessiz bir alternatiftir.</li>
                        </ul>
                        <p>Daha detaylı bilgi için "Enstrüman Seçim Rehberi" bölümümüzü kullanabilir veya müşteri temsilcilerimizle görüşebilirsiniz.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <p>Başka sorularınız mı var?</p>
            <a href="/contact" class="btn btn-primary">Bize Ulaşın</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .product-card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
    .carousel-item img {
        height: 400px;
        object-fit: cover;
    }
    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.6);
        border-radius: 10px;
        padding: 20px;
        bottom: 40px;
        left: 10%;
        right: 10%;
        max-width: 600px;
        margin: 0 auto;
    }
    .carousel-caption h2 {
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    .carousel-caption p {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }
    .carousel-caption .btn {
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    /* Kategori Kartları Stilleri */
    .category-card {
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .category-card:hover {
        transform: translateY(-7px);
    }
    .category-img {
        height: 180px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .category-card:hover .category-img {
        transform: scale(1.05);
    }
    
    /* Müşteri Yorumları Stilleri */
    .testimonial-card {
        transition: all 0.3s ease;
    }
    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .testimonial-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 3px solid var(--primary-color);
    }
    
    /* Bülten Aboneliği Stilleri */
    .newsletter-card {
        border-radius: 15px;
        overflow: hidden;
    }
    .newsletter-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        opacity: 0.9;
        z-index: 0;
    }
    .newsletter-card .input-group {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* Müzik Notaları Dekorasyonu */
    .music-notes {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        z-index: -1;
    }
    .music-notes i {
        position: absolute;
        color: rgba(67, 97, 238, 0.05);
        animation: floating 8s infinite ease-in-out;
    }
    .note-1 {
        top: 20%;
        left: 10%;
        font-size: 2.5rem;
        animation-delay: 0s;
    }
    .note-2 {
        top: 40%;
        right: 10%;
        font-size: 3.5rem;
        animation-delay: 2s;
    }
    .note-3 {
        bottom: 30%;
        left: 15%;
        font-size: 3rem;
        animation-delay: 4s;
    }
    
    @keyframes floating {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        50% {
            transform: translateY(-20px) rotate(10deg);
        }
    }
    
    @media (max-width: 768px) {
        .carousel-caption {
            position: static;
            background-color: rgba(0, 0, 0, 0.8);
            margin-top: -6px;
            border-radius: 0;
            max-width: 100%;
        }
        .carousel-item img {
            height: 250px;
        }
    }

    /* Özellikler Bölümü Stilleri */
    .feature-box {
        padding: 1.5rem;
        border-radius: 10px;
        transition: all 0.3s ease;
        position: relative;
    }
    .feature-box:hover {
        background-color: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transform: translateY(-5px);
    }
    .feature-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1.25rem;
        position: relative;
        z-index: 1;
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    }
    .feature-box:hover .feature-icon {
        transform: rotateY(360deg);
        transition: transform 0.8s ease;
    }
    .feature-box h5 {
        margin-bottom: 0.75rem;
        font-weight: 600;
    }
    .feature-box p {
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    /* Özel İndirim Sayacı Stilleri */
    .countdown-card {
        background: linear-gradient(135deg, #f72585, #3f37c9);
        border-radius: 15px;
        overflow: hidden;
        position: relative;
    }
    .countdown-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.6;
        z-index: 0;
    }
    .countdown-card .card-body {
        position: relative;
        z-index: 1;
    }
    .countdown-timer {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    .countdown-item {
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        padding: 15px;
        width: 100px;
        text-align: center;
        backdrop-filter: blur(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .countdown-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        line-height: 1;
        margin-bottom: 5px;
    }
    .countdown-label {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    @media (max-width: 768px) {
        .countdown-item {
            width: 70px;
            padding: 10px;
        }
        .countdown-value {
            font-size: 1.8rem;
        }
        .countdown-label {
            font-size: 0.7rem;
        }
    }

    /* Enstrüman Seçim Rehberi Stilleri */
    .instrument-guide-card {
        border-radius: 15px;
        overflow: hidden;
    }
    .instrument-finder-img {
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1520523839897-bd0b52f945a0?q=80&w=600&h=800&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        min-height: 450px;
        position: relative;
    }
    .instrument-finder-img::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
    }
    .instrument-finder-form .form-select {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }
    .instrument-finder-form .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
    }
    .instrument-finder-form label {
        font-weight: 500;
        margin-bottom: 8px;
    }
    #find-instrument-btn {
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    #find-instrument-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    }
    .recommendation-card {
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .recommendation-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
        border-color: var(--primary-color);
    }
    .recommendation-card h5 {
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    .recommendation-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .recommendation-header i {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-right: 15px;
    }
    .recommendation-features {
        margin-top: 15px;
    }
    .recommendation-features .badge {
        margin-right: 5px;
        margin-bottom: 5px;
        padding: 6px 10px;
        font-weight: 500;
    }

    /* Müzisyen Hikayeleri Stilleri */
    .musician-story-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    .musician-story-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }
    .musician-img {
        height: 230px;
        object-fit: cover;
        transition: all 0.5s ease;
    }
    .musician-story-card:hover .musician-img {
        transform: scale(1.05);
    }
    .musician-quote {
        position: absolute;
        top: -30px;
        left: 20px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    }
    .musician-story-card .card-body {
        padding-top: 40px;
        position: relative;
    }
    .musician-story-card .card-title {
        margin-bottom: 0.25rem;
        font-weight: 600;
    }
    .read-more-btn {
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    .read-more-btn:after {
        content: '\f054';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        margin-left: 5px;
        font-size: 0.75rem;
        transition: transform 0.3s ease;
    }
    .read-more-btn:hover:after {
        transform: translateX(5px);
    }

    /* Etkinlik Takvimi Stilleri */
    .event-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
    }
    .event-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }
    .event-img {
        height: 180px;
        object-fit: cover;
        transition: all 0.5s ease;
    }
    .event-card:hover .event-img {
        transform: scale(1.05);
    }
    .event-date {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 60px;
        height: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        z-index: 1;
    }
    .event-day {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: var(--primary-color);
    }
    .event-month {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--gray-color);
    }
    .event-badge {
        font-weight: 500;
        padding: 0.4em 0.8em;
        border-radius: 50rem;
    }
    .event-card .card-title {
        margin-bottom: 0.5rem;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .event-card .card-text {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* FAQ Bölümü Stilleri */
    .faq-accordion .accordion-item {
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .faq-accordion .accordion-item:hover {
        transform: translateY(-3px);
    }
    .faq-accordion .accordion-button {
        padding: 1.25rem;
        font-weight: 600;
        font-size: 1.05rem;
        background-color: white;
        box-shadow: none;
    }
    .faq-accordion .accordion-button:not(.collapsed) {
        color: var(--primary-color);
        background-color: rgba(67, 97, 238, 0.05);
        border-bottom: none;
    }
    .faq-accordion .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0, 0, 0, 0.125);
    }
    .faq-accordion .accordion-button::after {
        background-size: 1.25rem;
        transition: all 0.3s ease;
    }
    .faq-accordion .accordion-body {
        padding: 1rem 1.25rem 1.5rem;
        background-color: white;
    }
    .faq-accordion .accordion-button:not(.collapsed)::after {
        transform: rotate(180deg);
    }
    
    /* Harita Kartı Stilleri */
    .map-card {
        overflow: hidden;
        border-radius: 0.5rem;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-top: 1rem;
    }
    .map-card .card-footer {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
    
    /* Event Modal Stilleri */
    #event-details-modal .modal-body {
        padding: 1.5rem;
    }
    #event-details-modal .modal-header {
        border-bottom-color: rgba(0, 0, 0, 0.05);
    }
    #event-details-modal .modal-footer {
        border-top-color: rgba(0, 0, 0, 0.05);
    }
    
    /* Harita Kartı Stilleri */
    .map-container {
        position: relative;
        overflow: hidden;
        border-radius: 0.5rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-top: 1rem;
    }
    
    .map-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to right, rgba(67, 97, 238, 0.9), rgba(67, 97, 238, 0.7));
        padding: 0.6rem 1rem;
    }
    
    .map-address {
        color: white;
        font-size: 0.85rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }
    
    /* Etkinlik Detayları Stilleri */
    .event-info p {
        margin-bottom: 0.6rem;
        font-size: 1rem;
    }
    
    .event-info i {
        color: var(--primary-color);
    }
    
    .event-program {
        list-style: none;
        padding-left: 0;
    }
    
    .event-program li {
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }
    
    .event-program i {
        color: var(--primary-color);
    }
    
    /* Event Modal Stilleri */
    #event-details-modal .modal-body {
        padding: 1.5rem;
    }
    
    #event-details-modal .modal-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        background-color: var(--primary-color);
        color: white;
    }
    
    #event-details-modal .modal-title {
        font-weight: 600;
    }
    
    #event-details-modal .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    #event-details-modal .btn-close {
        color: white;
        filter: invert(1) brightness(200%);
    }
    
    /* Harita ve Adres Stilleri */
    .map-container {
        position: relative;
        border-radius: 0.5rem;
        overflow: hidden;
        margin-top: 1rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        height: 220px;
        width: 100%;
        z-index: 1;
    }
    
    .map-address {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        font-size: 0.85rem;
        z-index: 10;
    }
    
    /* Modal Stilleri */
    .event-details-modal .modal-header {
        background-color: #4361ee;
        color: white;
    }
    
    .event-details-modal .modal-body {
        padding: 1.5rem;
    }
    
    /* Mobil Responsive İyileştirmeler */
    @media (max-width: 767.98px) {
        .map-container {
            height: 180px;
        }
        
        #event-details-modal .modal-dialog {
            margin: 0.5rem;
        }
        
        #event-details-modal .modal-content {
            width: 100%;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Asset URL'lerini JavaScript için tanımlayalım
    const assetBaseUrl = "<?php echo e(asset('')); ?>";
    
    // Geri sayım tarihi - hedef tarih (Şu andan 7 gün sonrası)
    const targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + 7);
    
    function updateCountdown() {
        const currentDate = new Date();
        const difference = targetDate - currentDate;
        
        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);
        
        document.getElementById("countdown-days").innerText = days.toString().padStart(2, "0");
        document.getElementById("countdown-hours").innerText = hours.toString().padStart(2, "0");
        document.getElementById("countdown-minutes").innerText = minutes.toString().padStart(2, "0");
        document.getElementById("countdown-seconds").innerText = seconds.toString().padStart(2, "0");
        
        if (difference < 0) {
            clearInterval(timer);
            document.getElementById("countdown").innerHTML = "<p class='text-white'>İndirim süresi doldu!</p>";
        }
    }
    
    // İlk çağrı
    updateCountdown();
    
    // Her saniye güncelle
    const timer = setInterval(updateCountdown, 1000);
</script>

<!-- Enstrüman Seçim Rehberi JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const findBtn = document.getElementById('find-instrument-btn');
        if (findBtn) {
            findBtn.addEventListener('click', function(e) {
                // Sayfa başına dönmeyi engelle
                e.preventDefault();
                
                const instrumentType = document.getElementById('instrument-type').value;
                const experienceLevel = document.getElementById('experience-level').value;
                const budgetRange = document.getElementById('budget-range').value;
                const musicStyle = document.getElementById('music-style').value;
                
                // Seçimleri konsola yazdıralım
                console.log('MuzikDunyasi Debug: Seçilen Enstrüman Tipi ->', instrumentType);
                console.log('MuzikDunyasi Debug: Seçilen Deneyim Seviyesi ->', experienceLevel);
                console.log('MuzikDunyasi Debug: Seçilen Bütçe Aralığı ->', budgetRange);
                console.log('MuzikDunyasi Debug: Seçilen Müzik Tarzı ->', musicStyle);

                if (instrumentType === 'Enstrüman seçiniz' || 
                    experienceLevel === 'Seviye seçiniz' || 
                    budgetRange === 'Bütçe seçiniz' || 
                    musicStyle === 'Müzik tarzı seçiniz') {
                    alert('Lütfen tüm alanları doldurunuz.');
                    return;
                }
                
                const resultsContainer = document.getElementById('recommendation-results');
                resultsContainer.innerHTML = ''; // Önceki sonuçları temizle
                
                let recommendations = []; // Öneri dizisini her tıklamada sıfırla
                                
                // Enstrüman tipine göre farklı öneriler sunalım (if/else if ile)
                if (instrumentType === 'guitar') {
                    console.log('MuzikDunyasi Debug: Gitar önerileri işleniyor...');
                    if (experienceLevel === 'beginner') {
                        if (budgetRange === 'low') {
                            recommendations.push({
                                name: '[GİTAR] Yamaha F310 Akustik Gitar',
                                description: 'Başlangıç için ideal akustik gitar.',
                                price: '₺2.500 - ₺5.000',
                                image: assetBaseUrl + 'storage/products/yamaha-f310-akustik-gitar.jpg',
                                link: '/products?instrument_type=guitar&experience_level=beginner&budget_range=low'
                            });
                        }
                        // Gitar için diğer bütçe/seviye kombinasyonları eklenebilir
                    } else if (experienceLevel === 'intermediate') {
                        if (budgetRange === 'medium') {
                            recommendations.push({
                                name: '[GİTAR] Fender Player Stratocaster Elektro Gitar',
                                description: 'Orta seviye için çok yönlü bir elektro gitar.',
                                price: '₺15.000 - ₺25.000',
                                image: assetBaseUrl + 'storage/products/fender-player-stratocaster-elektro-gitar.jpg',
                                link: '/products?instrument_type=guitar&experience_level=intermediate&budget_range=medium'
                            });
                        }
                    } else { // advanced or professional
                         if (budgetRange === 'high' || budgetRange === 'luxury') {
                            recommendations.push({
                                name: '[GİTAR] Gibson Les Paul Standard Elektro Gitar',
                                description: 'İleri seviye ve profesyoneller için ikonik model.',
                                price: '₺40.000+',
                                image: assetBaseUrl + 'storage/products/gibson-les-paul-standard-50s-elektro-gitar.jpg',
                                link: '/products?instrument_type=guitar&experience_level=advanced&budget_range=high'
                            });
                        }
                    }
                } else if (instrumentType === 'piano') {
                    console.log('MuzikDunyasi Debug: Piyano önerileri işleniyor...');
                    if (experienceLevel === 'beginner') {
                        if (budgetRange === 'low') {
                            recommendations.push({
                                name: '[PİYANO] Casio CDP-S110 Dijital Piyano (Başlangıç - Ekonomik)',
                                description: 'Başlangıç için kompakt ve uygun fiyatlı dijital piyano.',
                                price: '₺7.000 - ₺10.000',
                                image: assetBaseUrl + 'storage/products/casio-cdp-s110-dijital-piyano.jpg',
                                link: '/products?instrument_type=piano&experience_level=beginner&budget_range=low'
                            });
                        } else if (budgetRange === 'medium') {
                            recommendations.push({
                                name: '[PİYANO] Yamaha P-125 Dijital Piyano (Başlangıç - Orta)',
                                description: 'Orta seviye için popüler, taşınabilir dijital piyano.',
                                price: '₺12.000 - ₺18.000',
                                image: assetBaseUrl + 'storage/products/yamaha-p-125-dijital-piyano.jpg',
                                link: '/products?instrument_type=piano&experience_level=beginner&budget_range=medium'
                            });
                        } else if (budgetRange === 'high') {
                             recommendations.push({
                                name: '[PİYANO] Roland GO:PIANO88 (Başlangıç - Premium)',
                                description: 'Geniş özellikli, başlangıç için üst düzey dijital piyano.',
                                price: '₺25.000 - ₺35.000',
                                image: assetBaseUrl + 'storage/products/default/piyanolar.jpg', // Varsayılan piyano resmi
                                link: '/products?instrument_type=piano&experience_level=beginner&budget_range=high'
                            });
                        }
                    } else if (experienceLevel === 'intermediate' || experienceLevel === 'advanced') {
                         if (budgetRange === 'medium') {
                             recommendations.push({
                                name: '[PİYANO] Kawai ES120 Dijital Piyano (Orta/İleri - Orta)',
                                description: 'İyi tuşe ve ses kalitesi sunan taşınabilir piyano.',
                                price: '₺18.000 - ₺24.000',
                                image: assetBaseUrl + 'storage/products/default/piyanolar.jpg', // Varsayılan piyano resmi
                                link: '/products?instrument_type=piano&experience_level=intermediate&budget_range=medium'
                            });
                         } else if (budgetRange === 'high') {
                            recommendations.push({
                                name: '[PİYANO] Roland FP-90X Dijital Piyano (Orta/İleri - Premium)',
                                description: 'İleri seviye özelliklere sahip, sahne ve ev kullanımı için.',
                                price: '₺30.000 - ₺45.000',
                                image: assetBaseUrl + 'storage/products/roland-fp-90x-dijital-piyano.jpg',
                                link: '/products?instrument_type=piano&experience_level=intermediate&budget_range=high'
                            });
                        } else if (budgetRange === 'luxury') {
                            recommendations.push({
                                name: '[PİYANO] Yamaha AvantGrand NU1X (Orta/İleri - Profesyonel)',
                                description: 'Akustik piyano hissi veren hibrit dijital piyano.',
                                price: '₺80.000+',
                                image: assetBaseUrl + 'storage/products/default/piyanolar.jpg', // Varsayılan piyano resmi
                                link: '/products?instrument_type=piano&experience_level=advanced&budget_range=luxury'
                            });
                        }
                    } else if (experienceLevel === 'professional') {
                        if (budgetRange === 'medium') {
                             recommendations.push({
                                name: '[PİYANO] Yamaha Arius YDP-165 (Profesyonel - Orta)',
                                description: 'Ev için iyi bir tuşe ve ses sunan dijital konsol piyano.',
                                price: '₺20.000 - ₺28.000',
                                image: assetBaseUrl + 'storage/products/default/piyanolar.jpg', // Varsayılan piyano resmi
                                link: '/products?instrument_type=piano&experience_level=professional&budget_range=medium'
                            });
                        } else if (budgetRange === 'high') {
                            recommendations.push({
                                name: '[PİYANO] Kawai CA79 Dijital Piyano (Profesyonel - Premium)',
                                description: 'Ahşap tuşlar ve üstün ses motoru ile profesyonel seçim.',
                                price: '₺50.000 - ₺70.000',
                                image: assetBaseUrl + 'storage/products/default/piyanolar.jpg', // Varsayılan piyano resmi
                                link: '/products?instrument_type=piano&experience_level=professional&budget_range=high'
                            });
                        } else if (budgetRange === 'luxury') {
                            recommendations.push({
                                name: '[PİYANO] Kawai CA99 Dijital Piyano (Profesyonel - Lüks)',
                                description: 'Profesyoneller için üst düzey ses ve tuşe kalitesi.',
                                price: '₺70.000+',
                                image: assetBaseUrl + 'storage/products/kawai-ca99-dijital-piyano.jpg',
                                link: '/products?instrument_type=piano&experience_level=professional&budget_range=luxury'
                            });
                        }
                    }
                } else if (instrumentType === 'drums') {
                    console.log('MuzikDunyasi Debug: Davul önerileri işleniyor...');
                    // Davul önerileri (Linkler instrument_type=drums olarak güncellenecek)
                    if (experienceLevel === 'beginner' && budgetRange === 'low') {
                        recommendations.push({
                            name: '[DAVUL] Alesis Nitro Mesh Kit Elektronik Davul',
                            description: 'Başlangıç için uygun fiyatlı elektronik davul.',
                            price: '₺8.000 - ₺12.000',
                            image: assetBaseUrl + 'storage/products/alesis-nitro-mesh-kit-elektronik-davul-seti.jpg',
                            link: '/products?instrument_type=drums&experience_level=beginner&budget_range=low'
                        });
                    }
                    // ... Diğer davul koşulları ...
                } else if (instrumentType === 'bass') {
                    console.log('MuzikDunyasi Debug: Bas Gitar önerileri işleniyor...');
                    // Bas gitar önerileri
                     if (experienceLevel === 'beginner' && budgetRange === 'low') {
                        recommendations.push({
                            name: '[BAS GİTAR] Ibanez GSR200 Bas Gitar',
                            description: 'Başlangıç için popüler bas gitar modeli.',
                            price: '₺6.000 - ₺9.000',
                            image: assetBaseUrl + 'storage/products/ibanez-gsr200-bas-gitar.jpg',
                            link: '/products?instrument_type=bass&experience_level=beginner&budget_range=low'
                        });
                    }
                    // ... Diğer bas gitar koşulları ...
                } else if (instrumentType === 'wind') {
                    console.log('MuzikDunyasi Debug: Nefesli Çalgı önerileri işleniyor...');
                    // Nefesli çalgılar önerileri
                    if (experienceLevel === 'beginner' && budgetRange === 'low') {
                        recommendations.push({
                            name: '[NEFESLİ] Yamaha YFL-222 Flüt',
                            description: 'Başlangıç seviyesi öğrenciler için ideal flüt.',
                            price: '₺4.000 - ₺7.000',
                            image: assetBaseUrl + 'storage/products/yamaha-yfl-222-flut.jpg',
                            link: '/products?instrument_type=wind&experience_level=beginner&budget_range=low'
                        });
                    }
                    // ... Diğer nefesli çalgı koşulları ...
                }
                
                // Eğer hiçbir spesifik öneri bulunamazsa ve bir enstrüman tipi seçilmişse genel bir mesaj veya hediye kartı önerisi
                if (recommendations.length === 0 && instrumentType !== 'Enstrüman seçiniz') {
                    console.log('MuzikDunyasi Debug: Seçilen kriterlere uygun spesifik öneri bulunamadı. Hediye kartı öneriliyor.');
                    recommendations.push({
                            name: 'Müzik Dünyası Hediye Kartı',
                            description: 'Aradığınız kriterlere uygun spesifik bir öneri bulamadık. Müzik Dünyası Hediye Kartı ile sevdiklerinize veya kendinize enstrüman seçme özgürlüğü tanıyın!',
                            price: 'Değişken',
                            image: assetBaseUrl + 'images/gift-card.jpg', // Genel bir hediye kartı görseli
                            link: '/gift-cards'
                        });
                }

                console.log('MuzikDunyasi Debug: Oluşturulan öneriler ->', recommendations);
                
                // Sonuçları ekrana yaz
                if (recommendations.length > 0) {
                    recommendations.forEach(product => {
                        const productCard = `
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm product-card">
                                    <img src="${product.image}" class="card-img-top p-3" alt="${product.name}">
                                    <div class="card-body">
                                        <h5 class="card-title">${product.name}</h5>
                                        <p class="card-text text-muted">${product.description}</p>
                                        <p class="card-text text-primary fw-bold">${product.price}</p>
                                        <a href="${product.link}" class="btn btn-primary">İncele</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        resultsContainer.innerHTML += productCard;
                    });
                } else {
                    resultsContainer.innerHTML = `<div class="col-12"><p class="text-center">Seçtiğiniz kriterlere uygun enstrüman bulunamadı.</p></div>`;
                }
                
                // Sonuç bölümünü göster
                document.getElementById('instrument-results').classList.remove('d-none');
                
                // Sonuç bölümüne sorunsuz kaydırma
                document.getElementById('instrument-results').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        }
    });
</script>

<!-- Event Modal JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal nesnesini oluştur
        const eventModal = new bootstrap.Modal(document.getElementById('event-details-modal'), {
            backdrop: 'static'
        });
        
        // Tüm event detay butonlarını seç
        document.querySelectorAll('.event-details-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Sayfa başına dönmeyi engelle
                e.preventDefault();
                
                // Etkinlik başlığını al
                const title = this.getAttribute('data-event-title');
                
                // Etkinlik kartını bul
                const eventCard = this.closest('.event-card');
                
                // Kart verilerini al
                const location = eventCard.getAttribute('data-event-location');
                const imageUrl = eventCard.getAttribute('data-event-image');
                const lat = eventCard.getAttribute('data-event-lat');
                const lng = eventCard.getAttribute('data-event-lng');
                
                console.log("Event card:", eventCard);
                console.log("Title:", title);
                console.log("Location:", location);
                console.log("Lat/Lng:", lat, lng);
                
                if (title) {
                    // Modal başlığını ayarla
                    document.getElementById('event-modal-title').textContent = title;
                    
                    // Modal içeriğini oluştur
                    let eventDetails = '';
                    
                    if (title === "Canlı Performans Gecesi") {
                        eventDetails = `
                            <div class="row">
                                <div class="col-lg-5 mb-4">
                                    <img src="${assetBaseUrl}images/events/event1.jpg" class="img-fluid rounded mb-3" alt="Canlı Performans Gecesi">
                                    <div class="map-container" id="event-map-1">
                                        <!-- Harita buraya yüklenecek -->
                                    </div>
                                    <div class="map-address p-2 bg-primary text-white">
                                        <i class="fas fa-map-marker-alt me-2"></i>${location}
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <h4>Etkinlik Bilgileri</h4>
                                    <p><strong>Tarih:</strong> 15 Haziran 2025</p>
                                    <p><strong>Saat:</strong> 20:00 - 23:00</p>
                                    <p><strong>Yer:</strong> Müzik Dünyası Sahnesi, ${location}</p>
                                    <p><strong>Bilet:</strong> ₺150 (Müzik Dünyası müşterilerine %15 indirim)</p>
                                    
                                    <h5 class="mt-4">Etkinlik Programı</h5>
                                    <ul>
                                        <li>Açılış Konuşması - 20:00</li>
                                        <li>Yerel Gruplar Performansı - 20:15</li>
                                        <li>Ara - 21:30</li>
                                        <li>Ana Grup Performansı - 21:45</li>
                                        <li>Kapanış - 23:00</li>
                                    </ul>
                                    
                                    <div class="mt-4">
                                        <a href="#" class="btn btn-primary me-2">Bilet Al</a>
                                        <a href="https://www.openstreetmap.org/directions?from=&to=${lat}%2C${lng}" class="btn btn-outline-secondary" target="_blank">
                                            <i class="fas fa-directions me-1"></i>Yol Tarifi Al
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else if (title === "Gitar Workshop") {
                        eventDetails = `
                            <div class="row">
                                <div class="col-lg-5 mb-4">
                                    <img src="${assetBaseUrl}images/events/event2.jpg" class="img-fluid rounded mb-3" alt="Gitar Workshop">
                                    <div class="map-container" id="event-map-2">
                                        <!-- Harita buraya yüklenecek -->
                                    </div>
                                    <div class="map-address p-2 bg-primary text-white">
                                        <i class="fas fa-map-marker-alt me-2"></i>${location}
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <h4>Workshop Bilgileri</h4>
                                    <p><strong>Tarih:</strong> 22 Haziran 2025</p>
                                    <p><strong>Saat:</strong> 14:00 - 17:00</p>
                                    <p><strong>Yer:</strong> Müzik Dünyası Eğitim Salonu, ${location}</p>
                                    <p><strong>Ücret:</strong> ₺200 (Kendi gitarınızı getirebilirsiniz)</p>
                                    
                                    <h5 class="mt-4">Eğitmen</h5>
                                    <p>Ahmet Yılmaz - 15 yıllık deneyimli rock gitaristi</p>
                                    
                                    <h5 class="mt-4">İçerik</h5>
                                    <ul>
                                        <li>Temel Gitar Teknikleri</li>
                                        <li>Akort ve Bakım İpuçları</li>
                                        <li>Riff Yazma Teknikleri</li>
                                        <li>Sahne Performansı İpuçları</li>
                                    </ul>
                                    
                                    <div class="mt-4">
                                        <a href="#" class="btn btn-primary me-2">Kayıt Ol</a>
                                        <a href="https://www.openstreetmap.org/directions?from=&to=${lat}%2C${lng}" class="btn btn-outline-secondary" target="_blank">
                                            <i class="fas fa-directions me-1"></i>Yol Tarifi Al
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else if (title === "Enstrüman Tanıtım Günü") {
                        eventDetails = `
                            <div class="row">
                                <div class="col-lg-5 mb-4">
                                    <img src="${assetBaseUrl}images/events/event3.jpg" class="img-fluid rounded mb-3" alt="Enstrüman Tanıtım Günü">
                                    <div class="map-container" id="event-map-3">
                                        <!-- Harita buraya yüklenecek -->
                                    </div>
                                    <div class="map-address p-2 bg-primary text-white">
                                        <i class="fas fa-map-marker-alt me-2"></i>${location}
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <h4>Etkinlik Bilgileri</h4>
                                    <p><strong>Tarih:</strong> 30 Haziran 2025</p>
                                    <p><strong>Saat:</strong> 12:00 - 18:00</p>
                                    <p><strong>Yer:</strong> Müzik Dünyası Mağazası, ${location}</p>
                                    <p><strong>Ücret:</strong> Ücretsiz</p>
                                    
                                    <h5 class="mt-4">Denenebilecek Ürünler</h5>
                                    <ul>
                                        <li>Fender ve Gibson Elektro Gitarlar</li>
                                        <li>Yamaha Akustik Gitarlar</li>
                                        <li>Roland Dijital Piyanolar</li>
                                        <li>Tama ve Pearl Davul Setleri</li>
                                        <li>Yeni Ses Ekipmanları</li>
                                    </ul>
                                    <p class="mt-3"><strong>Not:</strong> Etkinlikte özel indirimler olacaktır.</p>
                                    
                                    <div class="mt-4">
                                        <a href="#" class="btn btn-primary me-2">Hemen Kaydol</a>
                                        <a href="https://www.openstreetmap.org/directions?from=&to=${lat}%2C${lng}" class="btn btn-outline-secondary" target="_blank">
                                            <i class="fas fa-directions me-1"></i>Yol Tarifi Al
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                        } else {
                        eventDetails = `<p>${title} için detaylar yakında eklenecektir.</p>`;
                    }
                    
                    // Modal içeriğini ayarla
                    document.getElementById('event-modal-content').innerHTML = eventDetails;
                    
                    // Modalı göster
                    eventModal.show();
                    
                    // Modal açıldıktan sonra haritayı yükle
                    setTimeout(() => {
                        let mapId = "";
                        if (title === "Canlı Performans Gecesi") mapId = "event-map-1";
                        else if (title === "Gitar Workshop") mapId = "event-map-2";
                        else if (title === "Enstrüman Tanıtım Günü") mapId = "event-map-3";
                        
                        if (mapId && document.getElementById(mapId)) {
                            // Haritayı oluştur
                            const map = L.map(mapId).setView([lat, lng], 15);
                            
                            // OpenStreetMap tile layer ekle
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);
                            
                            // Konuma marker ekle
                            L.marker([lat, lng]).addTo(map)
                                .bindPopup(location);
                                
                            // Harita boyutunu güncelle
                            map.invalidateSize();
                        }
                    }, 500);
                }
            });
        });
    });
</script>

<!-- Müzisyen Hikayeleri Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal nesnesini oluştur
        const storyModal = new bootstrap.Modal(document.getElementById('musician-story-modal'), {
            backdrop: 'static'
        });
        
        // Tüm devamını oku butonlarını seç
        document.querySelectorAll('.read-more-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Sayfa başına dönmeyi engelle
                e.preventDefault();
                
                // Hikaye kimliğini al
                const story = this.getAttribute('data-story');
                
                console.log("Story:", story);
                
                // Modal başlığını ve içeriğini ayarla
                if (story === 'ahmet') {
                    document.getElementById('story-modal-title').textContent = 'Ahmet Yılmaz\'ın Hikayesi';
                    document.getElementById('story-modal-content').innerHTML = `
                        <div class="row">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <img src="${assetBaseUrl}images/musicians/musician1.jpg" class="img-fluid rounded mb-3" alt="Ahmet Yılmaz">
                                <div class="musician-details p-3 bg-light rounded">
                                    <h5>Ahmet Yılmaz</h5>
                                    <p class="mb-2"><i class="fas fa-guitar me-2 text-primary"></i>Rock Gitaristi</p>
                                    <p class="mb-2"><i class="fas fa-calendar-alt me-2 text-primary"></i>15 yıllık deneyim</p>
                                    <p class="mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i>İstanbul</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <p>İlk gitarımı Müzik Dünyası'ndan aldığımda henüz 16 yaşındaydım. O gün bugündür müzik hayatımın vazgeçilmez bir parçası. Şimdi kendi grubuyla sahne alıyor ve genç müzisyenlere ilham veriyorum.</p>
                                
                                <p>Lise yıllarımda rock müziğe olan ilgim, beni bu yolda profesyonel olarak ilerlemeye teşvik etti. İlk başlarda tamamen kulaktan çalarak ve YouTube videoları izleyerek kendimi geliştirdim. Daha sonra Müzik Dünyası'nda düzenlenen bir workshop'a katıldım ve orada tanıştığım eğitmenler sayesinde tekniğimi ilerletme fırsatı buldum.</p>
                                
                                <p>20 yaşında ilk grubumu kurdum ve lokal barlarda sahne almaya başladık. Zaman içinde şehir dışı festivallere katılma fırsatı yakaladık. 2017'de çıkardığımız ilk albümümüz "Gece Yarısı" ile ulusal çapta tanınmaya başladık.</p>
                                
                                <p>Şu anda "Karanlık Sokaklar" isimli grubumla ulusal ve uluslararası festivallerde düzenli olarak sahne alıyoruz. Aynı zamanda genç müzisyenlere mentorluk yapıyor ve Müzik Dünyası'nda düzenlenen gitar atölyelerine eğitmen olarak katılıyorum.</p>
                                
                                <p>Müzik Dünyası'ndan aldığım ilk gitarım hala duruyor ve benim için büyük bir anlam taşıyor. Genç müzisyenlere her zaman kaliteli ekipmanla başlamalarını ve tutkularını asla kaybetmemelerini tavsiye ediyorum.</p>
                                
                                <div class="mt-4">
                                    <h5>Favori Ekipmanları</h5>
                                    <ul>
                                        <li>Fender Stratocaster American Professional</li>
                                        <li>Gibson Les Paul Standard</li>
                                        <li>Marshall JCM800 Amplifikatör</li>
                                        <li>TC Electronic Hall of Fame Reverb Pedal</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;
                } else if (story === 'zeynep') {
                    document.getElementById('story-modal-title').textContent = 'Zeynep Kaya\'nın Hikayesi';
                    document.getElementById('story-modal-content').innerHTML = `
                        <div class="row">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <img src="${assetBaseUrl}images/musicians/musician2.jpg" class="img-fluid rounded mb-3" alt="Zeynep Kaya">
                                <div class="musician-details p-3 bg-light rounded">
                                    <h5>Zeynep Kaya</h5>
                                    <p class="mb-2"><i class="fas fa-music me-2 text-primary"></i>Piyanist</p>
                                    <p class="mb-2"><i class="fas fa-calendar-alt me-2 text-primary"></i>12 yıllık deneyim</p>
                                    <p class="mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Ankara</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <p>Klasik müzik eğitiminden sonra kendi yolumu çizmeye karar verdim. Burada bulduğum dijital piyano, müzik tarzımı keşfetmem için bana yeni kapılar açtı. Şimdi kendi bestelerimi yapıyorum.</p>
                                
                                <p>6 yaşında klasik piyano eğitimine başladım ve 18 yaşıma kadar konservatuarda eğitim gördüm. Ancak hep içimde farklı müzik türlerini keşfetme isteği vardı. Üniversite yıllarımda jazz ve elektronik müziğe olan ilgim arttı ve kendi tarzımı yaratma yolunda adımlar atmaya başladım.</p>
                                
                                <p>Müzik Dünyası'ndan aldığım Roland dijital piyano, bana hem klasik çalışmalarımı sürdürme hem de farklı tonlar ve efektlerle deneyler yapma imkanı sağladı. 2019'da yayınladığım "Sessiz Odalar" isimli EP'im, klasik piyano ve elektronik müziği birleştiren tarzımla dikkat çekti.</p>
                                
                                <p>Şu anda hem solo projelerime devam ediyor hem de farklı müzisyenlerle işbirliği yapıyorum. Ayrıca çocuklara piyano dersleri veriyor ve onlara müziğin sadece notalardan ibaret olmadığını, bir ifade aracı olduğunu öğretmeye çalışıyorum.</p>
                                
                                <p>Müzik yolculuğumda Müzik Dünyası'nın önemli bir yeri var. Hem ekipman konusunda sunduğu kaliteli seçenekler hem de düzenlediği workshoplar sayesinde sürekli kendimi geliştirme fırsatı buluyorum.</p>
                                
                                <div class="mt-4">
                                    <h5>Favori Ekipmanları</h5>
                                    <ul>
                                        <li>Roland FP-90X Dijital Piyano</li>
                                        <li>Nord Stage 3 Compact</li>
                                        <li>Ableton Live 11</li>
                                        <li>Focal Alpha 80 Evo Stüdyo Monitörleri</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;
                } else if (story === 'burak') {
                    document.getElementById('story-modal-title').textContent = 'Burak Demir\'in Hikayesi';
                    document.getElementById('story-modal-content').innerHTML = `
                        <div class="row">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <img src="${assetBaseUrl}images/musicians/musician3.jpg" class="img-fluid rounded mb-3" alt="Burak Demir">
                                <div class="musician-details p-3 bg-light rounded">
                                    <h5>Burak Demir</h5>
                                    <p class="mb-2"><i class="fas fa-drum me-2 text-primary"></i>Davulcu</p>
                                    <p class="mb-2"><i class="fas fa-calendar-alt me-2 text-primary"></i>8 yıllık deneyim</p>
                                    <p class="mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i>İzmir</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <p>Müzik hayatıma başlarken doğru ekipmanı bulmak zordu. Müzik Dünyası'ndaki ustalar, bana en uygun davul setini seçmemde yardımcı oldu. Şimdi farklı gruplarla çalışıyorum.</p>
                                
                                <p>Lise yıllarımda arkadaşlarımla kurduğumuz garaj bandında davul çalmaya başladım. Başlangıçta ikinci el ve düşük kalitede bir davul seti kullanıyordum, bu da hem tekniğimi geliştirmemi zorlaştırıyor hem de sesimizin kalitesini düşürüyordu.</p>
                                
                                <p>Müzik Dünyası'na gittiğimde, oradaki deneyimli personel bana bütçeme uygun ama kaliteli bir davul seti önerdi ve doğru baget seçiminden akort tekniklerine kadar birçok konuda yardımcı oldu. Bu sayede performansım kısa sürede gelişti.</p>
                                
                                <p>Şu anda İzmir'de farklı tarzlarda müzik yapan üç ayrı grupla çalışıyorum ve stüdyo müzisyeni olarak kayıtlara katılıyorum. Rock, funk ve jazz stillerinde çalabilme yeteneğim, beni aranan bir davulcu haline getirdi.</p>
                                
                                <p>Gelecekte kendi davul okulumu açmayı ve genç müzisyenlere ilham vermeyi hedefliyorum. Müzik Dünyası'nın düzenlediği workshoplarda eğitmenlik yaparak bu hedefime doğru ilerliyorum.</p>
                                
                                <div class="mt-4">
                                    <h5>Favori Ekipmanları</h5>
                                    <ul>
                                        <li>Tama Starclassic Maple Davul Seti</li>
                                        <li>Zildjian K Custom Zil Seti</li>
                                        <li>Roland SPD-SX Sampling Pad</li>
                                        <li>Vic Firth Modern Jazz Collection Bagetler</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Modalı göster
                storyModal.show();
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/halitartun/Desktop/MuzikDunyasıTest/resources/views/welcome.blade.php ENDPATH**/ ?>