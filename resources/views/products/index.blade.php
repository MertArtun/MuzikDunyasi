@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Ürünlerimiz</h1>
        </div>
        
        <!-- Filtreler -->
        <div class="col-md-3 mb-4">
            <div class="card filter-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtreler</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ url('/products') }}">
                        <div class="mb-3">
                            <label for="search-input" class="form-label fw-bold">Ara</label>
                            <input type="text" class="form-control form-control-sm" id="search-input" name="search" placeholder="Ürün adı, açıklama..." value="{{ $search ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="category-select" class="form-label fw-bold">Kategori</label>
                            <select class="form-select form-select-sm" id="category-select" name="category">
                                <option value="">Tüm Kategoriler</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ ($categoryId == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Fiyat Aralığı</label>
                            <div class="d-flex align-items-center">
                                <input type="number" name="price_min" class="form-control form-control-sm me-2" placeholder="Min" value="{{ $priceMin ?? '' }}">
                                <span>-</span>
                                <input type="number" name="price_max" class="form-control form-control-sm ms-2" placeholder="Max" value="{{ $priceMax ?? '' }}">
                            </div>
                            @if(isset($priceRange))
                            <div class="mt-1 text-muted small">
                                <span>Min: {{ number_format($priceRange->min_price, 2) }}₺</span>
                                <span class="float-end">Max: {{ number_format($priceRange->max_price, 2) }}₺</span>
                            </div>
                            @endif
                        </div>
                        
                        @if(!empty($allBrands))
                        <div class="mb-3">
                            <label class="form-label fw-bold">Markalar</label>
                            <div class="brands-list" style="max-height: 150px; overflow-y: auto;">
                                @foreach($allBrands as $brand)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="brands[]" value="{{ $brand }}" id="brand-{{ $loop->index }}" 
                                        {{ is_array($brands) && in_array($brand, $brands) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="brand-{{ $loop->index }}">
                                        {{ $brand }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Durum</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="in_stock" value="1" id="in-stock" 
                                    {{ $inStock === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="in-stock">
                                    Stokta Olanlar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is-featured" 
                                    {{ $isFeatured === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="is-featured">
                                    Öne Çıkan Ürünler
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_new" value="1" id="is-new" 
                                    {{ $isNew === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="is-new">
                                    Yeni Ürünler (Son 30 gün)
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Filtrele</button>
                            <a href="{{ url('/products') }}" class="btn btn-outline-secondary"><i class="fas fa-times me-1"></i>Temizle</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Ürünler -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    @if($products->total() > 0)
                        <span>{{ $products->firstItem() }}-{{ $products->lastItem() }} arası gösteriliyor (Toplam {{ $products->total() }} ürün)</span>
                    @else
                        <span>Ürün bulunamadı.</span>
                    @endif
                </div>
                <div class="d-flex align-items-center">
                    <form method="GET" action="{{ url('/products') }}" class="d-inline-block me-2">
                        <!-- Mevcut filtreleri koru -->
                        @if($search)
                            <input type="hidden" name="search" value="{{ $search }}">
                        @endif
                        @if($categoryId)
                            <input type="hidden" name="category" value="{{ $categoryId }}">
                        @endif
                        @if($priceMin)
                            <input type="hidden" name="price_min" value="{{ $priceMin }}">
                        @endif
                        @if($priceMax)
                            <input type="hidden" name="price_max" value="{{ $priceMax }}">
                        @endif
                        @if($inStock === '1')
                            <input type="hidden" name="in_stock" value="1">
                        @endif
                        @if($isFeatured === '1')
                            <input type="hidden" name="is_featured" value="1">
                        @endif
                        @if($isNew === '1')
                            <input type="hidden" name="is_new" value="1">
                        @endif
                        @if(is_array($brands))
                            @foreach($brands as $brand)
                                <input type="hidden" name="brands[]" value="{{ $brand }}">
                            @endforeach
                        @endif
                        
                        <div class="input-group input-group-sm">
                            <label class="input-group-text" for="per-page-select">Göster</label>
                            <select class="form-select form-select-sm" id="per-page-select" name="per_page" onchange="this.form.submit()">
                                <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12</option>
                                <option value="24" {{ $perPage == 24 ? 'selected' : '' }}>24</option>
                                <option value="48" {{ $perPage == 48 ? 'selected' : '' }}>48</option>
                                <option value="96" {{ $perPage == 96 ? 'selected' : '' }}>96</option>
                            </select>
                        </div>
                    </form>
                    
                    <form method="GET" action="{{ url('/products') }}" class="d-inline-block">
                        <!-- Mevcut filtreleri koru -->
                        @if($search)
                            <input type="hidden" name="search" value="{{ $search }}">
                        @endif
                        @if($categoryId)
                            <input type="hidden" name="category" value="{{ $categoryId }}">
                        @endif
                        @if($priceMin)
                            <input type="hidden" name="price_min" value="{{ $priceMin }}">
                        @endif
                        @if($priceMax)
                            <input type="hidden" name="price_max" value="{{ $priceMax }}">
                        @endif
                        @if($inStock === '1')
                            <input type="hidden" name="in_stock" value="1">
                        @endif
                        @if($isFeatured === '1')
                            <input type="hidden" name="is_featured" value="1">
                        @endif
                        @if($isNew === '1')
                            <input type="hidden" name="is_new" value="1">
                        @endif
                        @if(is_array($brands))
                            @foreach($brands as $brand)
                                <input type="hidden" name="brands[]" value="{{ $brand }}">
                            @endforeach
                        @endif
                        @if($perPage != 12)
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                        @endif
                        
                        <div class="input-group input-group-sm">
                            <label class="input-group-text" for="sort-select">Sırala</label>
                            <select class="form-select form-select-sm" id="sort-select" name="sort" onchange="this.form.submit()">
                                <option value="newest" {{ ($sort == 'newest') ? 'selected' : '' }}>En Yeni</option>
                                <option value="price_asc" {{ ($sort == 'price_asc') ? 'selected' : '' }}>Fiyat (Artan)</option>
                                <option value="price_desc" {{ ($sort == 'price_desc') ? 'selected' : '' }}>Fiyat (Azalan)</option>
                                <option value="name" {{ ($sort == 'name') ? 'selected' : '' }}>İsim (A-Z)</option>
                                <option value="popular" {{ ($sort == 'popular') ? 'selected' : '' }}>En Popüler</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row">
                @forelse ($products as $product)
                <div class="col-md-4 col-sm-6 col-12 mb-4">
                    <div class="card h-100 product-card shadow-sm border-0">
                        <div class="position-relative">
                            @if($product->is_featured)
                                <span class="badge bg-warning position-absolute top-0 start-0 m-2 z-1">Öne Çıkan</span>
                            @endif
                            
                            @if($product->created_at >= now()->subDays(30))
                                <span class="badge bg-success position-absolute top-0 end-0 m-2 z-1">Yeni</span>
                            @endif
                            
                            <img 
                                src="{{ $product->getImagePathAttribute() }}" 
                                class="card-img-top product-img" 
                                alt="{{ $product->name }}"
                            >
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                @if($product->category)
                                <a href="{{ url('/products?category='.$product->category->id) }}" class="text-decoration-none">
                                    <span class="badge bg-light text-dark">{{ $product->category->name }}</span>
                                </a>
                                @endif
                                @if($product->brand)
                                <a href="{{ url('/products?brands[]='.$product->brand) }}" class="text-decoration-none">
                                    <span class="badge bg-light text-dark">{{ $product->brand }}</span>
                                </a>
                                @endif
                            </div>
                            
                            <h5 class="card-title mb-1">
                                <a href="{{ url('/products/' . $product->id) }}" class="text-decoration-none product-title">{{ $product->name }}</a>
                            </h5>
                            
                            <p class="card-text small text-muted flex-grow-1">{{ Str::limit($product->description, 70) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="h5 mb-0 text-primary fw-bold">{{ number_format($product->price, 2) }} ₺</span>
                                
                                <div class="d-flex align-items-center">
                                    @if($product->stock > 0)
                                        <span class="badge bg-success me-2">Stokta</span>
                                    @else
                                        <span class="badge bg-danger me-2">Tükendi</span>
                                    @endif
                                    
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-sm btn-primary {{ $product->stock <= 0 ? 'disabled' : '' }}">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Bu kriterlere uygun ürün bulunamadı. Lütfen farklı filtreler deneyin.
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Filtreleme Stilleri */
    .filter-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: none;
        margin-bottom: 20px;
    }
    .filter-card .card-header {
        background-color: var(--primary-color);
        padding: 15px;
    }
    .filter-card .card-body {
        padding: 20px;
    }
    .form-label.fw-bold {
        font-size: 0.9rem;
        margin-bottom: 8px;
    }
    .brands-list {
        padding-right: 10px;
    }
    .brands-list::-webkit-scrollbar {
        width: 4px;
    }
    .brands-list::-webkit-scrollbar-thumb {
        background-color: var(--primary-color);
        border-radius: 10px;
    }
    
    /* Ürün Kartları Stilleri */
    .product-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .product-img {
        height: 220px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .product-card:hover .product-img {
        transform: scale(1.05);
    }
    .product-title {
        color: #333;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s ease;
    }
    .product-title:hover {
        color: var(--primary-color);
    }
    .btn-add-to-cart {
        transition: all 0.3s ease;
    }
    .btn-add-to-cart:hover {
        transform: translateY(-2px);
    }
    
    /* Sayfalama Stilleri */
    .pagination {
        margin-bottom: 0;
    }
    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    .page-link {
        color: var(--primary-color);
    }
    .page-link:hover {
        color: var(--primary-color);
        background-color: rgba(67, 97, 238, 0.1);
    }
    
    /* Mobil Uyumluluk */
    @media (max-width: 767.98px) {
        .product-img {
            height: 180px;
        }
        .col-md-3.mb-4 {
            margin-bottom: 1rem !important;
        }
        .filter-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection
