@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Sepet</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ödeme</li>
    </ol>
</nav>

<h1 class="mb-4">Ödeme Bilgileri</h1>

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
            @csrf
            
            <!-- Delivery Address -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Teslimat Adresi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="address" class="form-label">Adres</label>
                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Payment Method -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Ödeme Yöntemi</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method_credit_card" value="credit_card" {{ $user->balance < $cart->total ? 'checked' : '' }} required>
                        <label class="form-check-label" for="payment_method_credit_card">
                            <i class="fas fa-credit-card me-2"></i>Kredi Kartı ile Ödeme
                        </label>
                    </div>
                    
                    @if($user->balance > 0)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method_balance" value="balance" {{ $user->balance >= $cart->total ? 'checked' : '' }} {{ $user->balance < $cart->total ? 'disabled' : '' }}>
                        <label class="form-check-label" for="payment_method_balance">
                            <i class="fas fa-wallet me-2"></i>Bakiye ile Ödeme ({{ number_format($user->balance, 2) }} ₺)
                        </label>
                        @if($user->balance < $cart->total)
                            <div class="text-danger small">Bakiyeniz yetersiz. Lütfen başka bir ödeme yöntemi seçin.</div>
                        @endif
                    </div>
                    @endif
                    
                    <div id="credit-card-form" class="mt-4 {{ $user->balance >= $cart->total ? 'd-none' : '' }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cc_name" class="form-label">Kart Üzerindeki İsim</label>
                                <input type="text" class="form-control" id="cc_name" placeholder="Ad Soyad">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cc_number" class="form-label">Kart Numarası</label>
                                <input type="text" class="form-control" id="cc_number" placeholder="xxxx xxxx xxxx xxxx">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cc_expiry" class="form-label">Son Kullanma Tarihi</label>
                                <input type="text" class="form-control" id="cc_expiry" placeholder="AA/YY">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cc_cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cc_cvv" placeholder="xxx">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cc_installment" class="form-label">Taksit</label>
                                <select class="form-select" id="cc_installment">
                                    <option value="1">Tek Çekim</option>
                                    <option value="3">3 Taksit</option>
                                    <option value="6">6 Taksit</option>
                                    <option value="9">9 Taksit</option>
                                </select>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>Bu demo uygulamada gerçek ödeme işlemi yapılmamaktadır. Kart bilgileriniz kaydedilmez.
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-lg btn-primary">
                    <i class="fas fa-check-circle me-2"></i>Siparişi Tamamla
                </button>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Sepete Geri Dön
                </a>
            </div>
        </form>
    </div>
    
    <div class="col-lg-4">
        <!-- Order Summary -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Sipariş Özeti</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Ürünler ({{ $cart->items->sum('quantity') }})</span>
                    <span>{{ number_format($cart->total, 2) }} ₺</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Kargo Ücreti</span>
                    <span>0.00 ₺</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <strong>Genel Toplam</strong>
                    <strong>{{ number_format($cart->total, 2) }} ₺</strong>
                </div>
                
                @if($user->balance > 0)
                <div class="alert alert-info mb-0">
                    <div class="d-flex justify-content-between">
                        <span>Kullanılabilir Bakiye:</span>
                        <span>{{ number_format($user->balance, 2) }} ₺</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Cart Items Summary -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Sepetinizdeki Ürünler</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($cart->items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ $item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://via.placeholder.com/50x50?text=' . urlencode($item->product->name) }}" alt="{{ $item->product->name }}" class="me-3" width="50">
                            <div>
                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                <small class="text-muted">{{ $item->quantity }} x {{ number_format($item->product->price, 2) }} ₺</small>
                            </div>
                        </div>
                        <span>{{ number_format($item->product->price * $item->quantity, 2) }} ₺</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle credit card form based on payment method
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const creditCardForm = document.getElementById('credit-card-form');
        
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                if (this.value === 'credit_card') {
                    creditCardForm.classList.remove('d-none');
                } else {
                    creditCardForm.classList.add('d-none');
                }
            });
        });
        
        // Format credit card inputs
        const ccNumber = document.getElementById('cc_number');
        if (ccNumber) {
            ccNumber.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 16) value = value.slice(0, 16);
                // Format: xxxx xxxx xxxx xxxx
                let formattedValue = '';
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) formattedValue += ' ';
                    formattedValue += value[i];
                }
                e.target.value = formattedValue;
            });
        }
        
        const ccExpiry = document.getElementById('cc_expiry');
        if (ccExpiry) {
            ccExpiry.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 4) value = value.slice(0, 4);
                // Format: MM/YY
                if (value.length > 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2);
                }
                e.target.value = value;
            });
        }
        
        const ccCvv = document.getElementById('cc_cvv');
        if (ccCvv) {
            ccCvv.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 3) value = value.slice(0, 3);
                e.target.value = value;
            });
        }
    });
</script>
@endsection
