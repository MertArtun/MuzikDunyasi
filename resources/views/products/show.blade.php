@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="/products">Ürünler</a></li>
            <li class="breadcrumb-item"><a href="/products?category={{ $product->category_id }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row mb-5">
        <!-- Ürün Görseli -->
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm">
                <img src="{{ $product->getImagePathAttribute() }}" class="card-img-top product-main-image" alt="{{ $product->name }}">
            </div>
        </div>
        
        <!-- Ürün Bilgileri -->
        <div class="col-md-7">
            <h1 class="mb-3">{{ $product->name }}</h1>
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-primary me-2">{{ $product->category->name }}</span>
                @if($product->stock > 0)
                    <span class="badge bg-success">Stokta</span>
                @else
                    <span class="badge bg-danger">Tükendi</span>
                @endif
            </div>
            
            <h2 class="text-primary mb-4">{{ number_format($product->price, 2) }} ₺</h2>
            
            <div class="mb-4">
                <h5>Ürün Açıklaması</h5>
                <p>{{ $product->description }}</p>
            </div>
            
            <div class="mb-4">
                <h5>Stok Durumu</h5>
                <p>{{ $product->stock }} adet stokta</p>
            </div>
            
            @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="quantity" class="col-form-label">Adet:</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="{{ $product->stock }}" value="1">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shopping-cart me-2"></i>Sepete Ekle
                        </button>
                    </div>
                </div>
            </form>
            @else
            <button class="btn btn-secondary mb-4" disabled>
                <i class="fas fa-ban me-2"></i>Stokta Yok
            </button>
            @endif
            
            <div class="d-flex mb-4">
                <button class="btn btn-outline-primary me-2">
                    <i class="far fa-heart me-1"></i>Favorilere Ekle
                </button>
                <button class="btn btn-outline-primary">
                    <i class="fas fa-share-alt me-1"></i>Paylaş
                </button>
            </div>
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center border-end">
                            <i class="fas fa-truck fa-2x text-primary mb-2"></i>
                            <h6>Hızlı Teslimat</h6>
                            <p class="small text-muted mb-0">1-3 iş günü içinde</p>
                        </div>
                        <div class="col-md-4 text-center border-end">
                            <i class="fas fa-undo fa-2x text-primary mb-2"></i>
                            <h6>Kolay İade</h6>
                            <p class="small text-muted mb-0">14 gün içinde</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-lock fa-2x text-primary mb-2"></i>
                            <h6>Güvenli Ödeme</h6>
                            <p class="small text-muted mb-0">SSL ile şifreli</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- İlgili Ürünler -->
    @if(count($relatedProducts) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">İlgili Ürünler</h3>
        </div>
        
        @foreach($relatedProducts as $relatedProduct)
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <img src="{{ $relatedProduct->getImagePathAttribute() }}" class="card-img-top" alt="{{ $relatedProduct->name }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><a href="{{ url('/products/' . $relatedProduct->id) }}" class="text-decoration-none text-dark">{{ $relatedProduct->name }}</a></h5>
                    <p class="text-muted small">{{ $relatedProduct->category->name ?? 'Kategorisiz' }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="h5 mb-0 text-primary">{{ number_format($relatedProduct->price, 2) }} ₺</span>
                        <a href="{{ url('/products/' . $relatedProduct->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye me-1"></i>İncele</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .product-main-image {
        max-height: 500px;
        object-fit: cover;
    }
    .product-card {
        transition: transform 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-card img {
        height: 200px;
        object-fit: cover;
    }
</style>
@endsection
