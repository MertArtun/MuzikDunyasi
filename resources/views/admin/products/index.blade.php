@extends('layouts.admin.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ürünler</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Yeni Ürün Ekle
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-8">
                <h6 class="m-0 font-weight-bold text-primary">Ürün Listesi</h6>
            </div>
            <div class="col-md-4">
                <form action="{{ route('admin.products.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Ürün Ara..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Resim</th>
                        <th>Ürün Adı</th>
                        <th>Kategori</th>
                        <th>Fiyat</th>
                        <th>Stok</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/50x50?text=' . urlencode($product->name) }}" alt="{{ $product->name }}" width="50" height="50" class="img-thumbnail">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ number_format($product->price, 2) }} ₺</td>
                        <td>
                            @if($product->stock <= 0)
                            <span class="badge bg-danger">Tükendi</span>
                            @elseif($product->stock <= 5)
                            <span class="badge bg-warning text-dark">Kritik: {{ $product->stock }}</span>
                            @else
                            <span class="badge bg-success">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_active)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-danger">Pasif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Henüz ürün bulunmamaktadır.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- Quick Filters -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Hızlı Filtreler</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.products.index', ['stock' => 'low']) }}" class="btn btn-warning btn-block">
                    <i class="fas fa-exclamation-triangle me-2"></i>Düşük Stoklu Ürünler
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.products.index', ['stock' => 'out']) }}" class="btn btn-danger btn-block">
                    <i class="fas fa-times-circle me-2"></i>Tükenen Ürünler
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.products.index', ['status' => 'active']) }}" class="btn btn-success btn-block">
                    <i class="fas fa-check-circle me-2"></i>Aktif Ürünler
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.products.index', ['status' => 'inactive']) }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-ban me-2"></i>Pasif Ürünler
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .btn-block {
        display: block;
        width: 100%;
    }
</style>
@endsection
