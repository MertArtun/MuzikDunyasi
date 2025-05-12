@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profilim</li>
    </ol>
</nav>

<h1 class="mb-4">Hesap Ayarları</h1>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="avatar-container mb-3">
                    <div class="avatar-circle">
                        <span class="initials">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                </div>
                <h5 class="card-title">{{ auth()->user()->name }}</h5>
                <p class="card-text text-muted">{{ auth()->user()->email }}</p>
                <hr>
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="d-block text-muted">Bakiye</small>
                        <strong>{{ number_format(auth()->user()->balance, 2) }} ₺</strong>
                    </div>
                    <div>
                        <small class="d-block text-muted">Siparişler</small>
                        <strong>{{ auth()->user()->orders->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="list-group mt-4 shadow-sm">
            <a href="#profile-info" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                <i class="fas fa-user me-2"></i>Profil Bilgileri
            </a>
            <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="list">
                <i class="fas fa-lock me-2"></i>Güvenlik
            </a>
            <a href="#addresses" class="list-group-item list-group-item-action" data-bs-toggle="list">
                <i class="fas fa-map-marker-alt me-2"></i>Adreslerim
            </a>
            <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-box me-2"></i>Siparişlerim
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action text-primary">
                <i class="fas fa-tachometer-alt me-2"></i>Admin Paneli
            </a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action text-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>Çıkış Yap
                </button>
            </form>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="tab-content">
            <!-- Profile Information Tab -->
            <div class="tab-pane fade show active" id="profile-info">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Profil Bilgileri</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Ad Soyad</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">E-posta Adresi</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefon Numarası</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                                <small class="form-text text-muted">Örnek: 5551234567</small>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Security Tab -->
            <div class="tab-pane fade" id="security">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Şifre Değiştirme</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mevcut Şifre</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Yeni Şifre</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                <small class="form-text text-muted">En az 8 karakter olmalıdır</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Yeni Şifre (Tekrar)</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-2"></i>Şifremi Değiştir
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Hesap Devre Dışı Bırakma</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Hesabınızı devre dışı bırakmak istiyorsanız, lütfen aşağıdaki butona tıklayın. Bu işlem geri alınamaz.</p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deactivateAccountModal">
                                <i class="fas fa-user-slash me-2"></i>Hesabımı Devre Dışı Bırak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Addresses Tab -->
            <div class="tab-pane fade" id="addresses">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Adreslerim</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Adres</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Adresi Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate Account Modal -->
<div class="modal fade" id="deactivateAccountModal" tabindex="-1" aria-labelledby="deactivateAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deactivateAccountModalLabel">Hesabı Devre Dışı Bırakma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Hesabınızı devre dışı bırakmak istediğinize emin misiniz? Bu işlem geri alınamaz ve tüm verileriniz silinecektir.</p>
                <form action="{{ route('profile.destroy') }}" method="POST" id="deactivateAccountForm">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label for="password_confirmation_deactivate" class="form-label">Şifrenizi Girin</label>
                        <input type="password" class="form-control" id="password_confirmation_deactivate" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('deactivateAccountForm').submit();">
                    Hesabımı Devre Dışı Bırak
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar-container {
        display: flex;
        justify-content: center;
    }
    .avatar-circle {
        width: 80px;
        height: 80px;
        background-color: #4e73df;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: bold;
    }
    .timeline-marker {
        position: absolute;
        left: -30px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        top: 4px;
    }
</style>
@endsection
