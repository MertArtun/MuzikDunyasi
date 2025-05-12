@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
        <li class="breadcrumb-item active" aria-current="page">Siparişlerim</li>
    </ol>
</nav>

<h1 class="mb-4">Siparişlerim</h1>

@if($orders->count() > 0)
    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                Tüm Siparişler
                <span class="badge bg-secondary">{{ $orders->total() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'active' ? 'active' : '' }}" href="{{ route('orders.index', ['status' => 'active']) }}">
                Aktif Siparişler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" href="{{ route('orders.index', ['status' => 'completed']) }}">
                Tamamlanan Siparişler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'canceled' ? 'active' : '' }}" href="{{ route('orders.index', ['status' => 'canceled']) }}">
                İptal Edilen Siparişler
            </a>
        </li>
    </ul>

    <div class="row">
        @foreach($orders as $order)
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sipariş #{{ $order->id }}</h5>
                    <span>
                        @if($order->status == 'pending')
                        <span class="badge bg-warning text-dark">Beklemede</span>
                        @elseif($order->status == 'approved')
                        <span class="badge bg-info">Onaylandı</span>
                        @elseif($order->status == 'processing')
                        <span class="badge bg-primary">Hazırlanıyor</span>
                        @elseif($order->status == 'packaging')
                        <span class="badge bg-primary">Paketleniyor</span>
                        @elseif($order->status == 'shipping')
                        <span class="badge bg-primary">Kargoya Verildi</span>
                        @elseif($order->status == 'in_transit')
                        <span class="badge bg-info">Yolda</span>
                        @elseif($order->status == 'delivered')
                        <span class="badge bg-success">Teslim Edildi</span>
                        @elseif($order->status == 'completed')
                        <span class="badge bg-success">Tamamlandı</span>
                        @elseif($order->status == 'canceled')
                        <span class="badge bg-danger">İptal Edildi</span>
                        @else
                        <span class="badge bg-secondary">{{ $order->status }}</span>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Sipariş Tarihi</small>
                            <strong>{{ $order->created_at->format('d.m.Y H:i') }}</strong>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <small class="text-muted d-block">Toplam Tutar</small>
                            <strong>{{ number_format($order->total_amount, 2) }} ₺</strong>
                        </div>
                    </div>
                    
                    <p class="mb-1"><strong>Teslimat Adresi:</strong></p>
                    <p class="mb-3">{{ $order->address }}</p>
                    
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Ürün</th>
                                    <th>Fiyat</th>
                                    <th class="text-center">Adet</th>
                                    <th class="text-end">Toplam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items->take(3) as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ number_format($item->price, 2) }} ₺</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->price * $item->quantity, 2) }} ₺</td>
                                </tr>
                                @endforeach
                                
                                @if($order->items->count() > 3)
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <a href="{{ route('orders.show', $order) }}">+ {{ $order->items->count() - 3 }} daha fazla ürün</a>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                            <i class="fas fa-eye me-2"></i>Detayları Görüntüle
                        </a>
                        
                        @if($order->status == 'pending')
                        <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Bu siparişi iptal etmek istediğinize emin misiniz?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>İptal Et
                            </button>
                        </form>
                        @elseif($order->status == 'delivered')
                        <form action="{{ route('orders.received', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Teslim Aldım
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
            <h3>Henüz Siparişiniz Yok</h3>
            <p class="text-muted">Sipariş geçmişiniz boş görünüyor.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag me-2"></i>Alışverişe Başla
            </a>
        </div>
    </div>
@endif
@endsection
