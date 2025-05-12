@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
        <li class="breadcrumb-item active" aria-current="page">Alışveriş Sepeti</li>
    </ol>
</nav>

<h1 class="mb-4">Alışveriş Sepeti</h1>

@if($cart && $cart->items->count() > 0)
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 100px">Ürün</th>
                                    <th>Detaylar</th>
                                    <th class="text-center">Adet</th>
                                    <th class="text-end">Fiyat</th>
                                    <th class="text-end">Toplam</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr>
                                    <td>
                                        <img src="{{ $item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://via.placeholder.com/100x100?text=' . urlencode($item->product->name) }}" alt="{{ $item->product->name }}" class="img-thumbnail" width="80">
                                    </td>
                                    <td>
                                        <h5 class="mb-1">{{ $item->product->name }}</h5>
                                        <small class="text-muted">{{ $item->product->category->name }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <div class="input-group input-group-sm" style="width: 120px;">
                                                <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="decrease">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" name="quantity" class="form-control text-center quantity-input" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}">
                                                <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="increase">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-end align-middle">{{ number_format($item->product->price, 2) }} ₺</td>
                                    <td class="text-end align-middle">{{ number_format($item->product->price * $item->quantity, 2) }} ₺</td>
                                    <td class="text-end align-middle">
                                        <form action="{{ route('cart.remove', $item->product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu ürünü sepetten çıkarmak istediğinize emin misiniz?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Alışverişe Devam Et
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Tüm sepeti temizlemek istediğinize emin misiniz?')">
                                <i class="fas fa-trash me-2"></i>Sepeti Temizle
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Sipariş Özeti</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ürünler Toplamı</span>
                        <span>{{ number_format($cart->total, 2) }} ₺</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Kargo Ücreti</span>
                        <span>0.00 ₺</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Genel Toplam</strong>
                        <strong>{{ number_format($cart->total, 2) }} ₺</strong>
                    </div>
                    
                    @if(auth()->user()->balance > 0)
                    <div class="alert alert-info mt-3">
                        <div class="d-flex justify-content-between">
                            <span>Kullanılabilir Bakiye:</span>
                            <span>{{ number_format(auth()->user()->balance, 2) }} ₺</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('cart.checkout') }}" class="btn btn-primary">
                            <i class="fas fa-lock me-2"></i>Ödeme Adımına Geç
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h3>Sepetiniz Boş</h3>
            <p class="text-muted">Sepetinizde henüz ürün bulunmamaktadır.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag me-2"></i>Alışverişe Başla
            </a>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity buttons functionality
        const quantityBtns = document.querySelectorAll('.quantity-btn');
        
        quantityBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.dataset.action;
                const inputField = this.parentNode.querySelector('.quantity-input');
                let value = parseInt(inputField.value);
                const max = parseInt(inputField.getAttribute('max'));
                
                if (action === 'increase' && value < max) {
                    inputField.value = value + 1;
                } else if (action === 'decrease' && value > 1) {
                    inputField.value = value - 1;
                }
                
                // Auto-submit form on change
                this.closest('form').submit();
            });
        });
        
        // Auto-submit form when quantity input changes
        const quantityInputs = document.querySelectorAll('.quantity-input');
        
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    });
</script>
@endsection
