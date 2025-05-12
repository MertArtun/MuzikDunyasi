@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">İletişim</h1>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h3>Bize Ulaşın</h3>
                    <p>Sorularınız, önerileriniz veya şikayetleriniz için aşağıdaki iletişim kanallarından bize ulaşabilirsiniz.</p>
                    
                    <div class="mt-4">
                        <h5><i class="fas fa-map-marker-alt me-2 text-primary"></i> Adres</h5>
                        <p>Müzik Caddesi No:123, Kadıköy<br>İstanbul, Türkiye</p>
                        
                        <h5><i class="fas fa-phone me-2 text-primary"></i> Telefon</h5>
                        <p>+90 555 123 4567</p>
                        
                        <h5><i class="fas fa-envelope me-2 text-primary"></i> E-posta</h5>
                        <p>info@muzikdunyasi.com</p>
                        
                        <h5><i class="fas fa-clock me-2 text-primary"></i> Çalışma Saatleri</h5>
                        <p>Pazartesi - Cuma: 09:00 - 18:00<br>Cumartesi: 10:00 - 15:00<br>Pazar: Kapalı</p>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Sosyal Medya</h5>
                        <div class="d-flex">
                            <a href="#" class="btn btn-outline-primary me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-outline-primary me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-outline-primary me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-outline-primary"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h3>İletişim Formu</h3>
                    <p>Aşağıdaki formu doldurarak bize mesaj gönderebilirsiniz. En kısa sürede sizinle iletişime geçeceğiz.</p>
                    
                    <form class="mt-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Adınız Soyadınız</label>
                            <input type="text" class="form-control" id="name" placeholder="Adınız Soyadınız">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta Adresiniz</label>
                            <input type="email" class="form-control" id="email" placeholder="E-posta adresiniz">
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Konu</label>
                            <select class="form-select" id="subject">
                                <option selected>Konu seçiniz</option>
                                <option value="1">Ürün Bilgisi</option>
                                <option value="2">Sipariş Durumu</option>
                                <option value="3">İade / Değişim</option>
                                <option value="4">Teknik Destek</option>
                                <option value="5">Diğer</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Mesajınız</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Mesajınızı buraya yazın..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Gönder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 