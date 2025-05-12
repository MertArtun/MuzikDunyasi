@extends('layouts.admin.app')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Ürünler</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ürün Düzenle: {{ $product->name }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ürün Düzenle</h1>
    <div>
        <a href="{{ route('products.show', $product) }}" class="btn btn-info me-2" target="_blank">
            <i class="fas fa-eye me-2"></i>Görüntüle
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Ürünlere Dön
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Ürün Adı <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="price" class="form-label">Fiyat (₺) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="stock" class="form-label">Stok Miktarı <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                    <option value="">Kategori Seçin</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            @if($category->parent_id)
                                {{ $category->parent->name }} > {{ $category->name }}
                            @else
                                {{ $category->name }}
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Ürün Açıklaması <span class="text-danger">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Current Images -->
            @if($product->images->count() > 0)
            <div class="mb-3">
                <label class="form-label">Mevcut Görseller</label>
                <div class="row">
                    @foreach($product->images as $image)
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 150px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h6 class="card-title">
                                    @if($image->is_primary)
                                    <span class="badge bg-primary">Ana Görsel</span>
                                    @else
                                    <span class="badge bg-secondary">Görsel {{ $loop->iteration }}</span>
                                    @endif
                                </h6>
                                <div class="btn-group w-100" role="group">
                                    @if(!$image->is_primary)
                                    <form action="{{ route('admin.products.images.primary') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.products.images.delete', $image->id) }}" method="POST" onsubmit="return confirm('Bu görseli silmek istediğinize emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <div class="mb-3">
                <label for="images" class="form-label">Yeni Görseller Ekle</label>
                <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                <small class="form-text text-muted">Birden fazla görsel seçebilirsiniz.</small>
                @error('images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif (Satışta)</label>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-md-2">
                    <i class="fas fa-times me-2"></i>İptal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Danger Zone -->
<div class="card shadow mb-4 border-danger">
    <div class="card-header bg-danger text-white py-3">
        <h6 class="m-0 font-weight-bold">Tehlikeli İşlemler</h6>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">Ürünü Sil</h5>
                <p class="text-muted mb-0">Bu ürünü kalıcı olarak silmek istiyorsanız, bu butonu kullanın. Bu işlem geri alınamaz.</p>
            </div>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('UYARI: Bu ürünü silmek istediğinize emin misiniz? Bu işlem geri alınamaz!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Ürünü Sil
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Image preview functionality
    document.getElementById('images').addEventListener('change', function(event) {
        // Remove existing previews
        const previewContainer = document.getElementById('image-previews');
        if (previewContainer) {
            previewContainer.remove();
        }
        
        // Create new preview container
        const newPreviewContainer = document.createElement('div');
        newPreviewContainer.id = 'image-previews';
        newPreviewContainer.className = 'row mt-3';
        
        const files = event.target.files;
        
        if (files.length > 0) {
            // Create preview header
            const previewHeader = document.createElement('h6');
            previewHeader.className = 'mb-3';
            previewHeader.textContent = 'Seçilen Yeni Görseller:';
            
            this.parentNode.appendChild(previewHeader);
            this.parentNode.appendChild(newPreviewContainer);
            
            // Create image previews
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                if (!file.type.match('image.*')) {
                    continue;
                }
                
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-md-3 mb-3';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.height = '150px';
                    img.style.width = '100%';
                    img.style.objectFit = 'cover';
                    
                    const caption = document.createElement('p');
                    caption.className = 'text-center mt-1 mb-0';
                    caption.textContent = `Yeni Görsel ${i+1}`;
                    
                    colDiv.appendChild(img);
                    colDiv.appendChild(caption);
                    newPreviewContainer.appendChild(colDiv);
                };
                
                reader.readAsDataURL(file);
            }
        }
    });
</script>
@endsection
