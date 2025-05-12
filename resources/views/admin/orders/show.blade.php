@extends('layouts.admin.app')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Siparişler</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sipariş #{{ $order->id }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Sipariş #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Siparişlere Dön
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Order Details -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Sipariş Detayları</h6>
                <span class="ms-auto">
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
                        <p class="mb-1"><strong>Sipariş Tarihi:</strong></p>
                        <p>{{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Sipariş Numarası:</strong></p>
                        <p>#{{ $order->id }}</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Müşteri:</strong></p>
                        <p>
                            <a href="{{ route('admin.users.show', $order->user) }}">
                                {{ $order->user->name }}
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>E-posta:</strong></p>
                        <p>{{ $order->user->email }}</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <p class="mb-1"><strong>Teslimat Adresi:</strong></p>
                        <p>{{ $order->address }}</p>
                    </div>
                </div>
                
                <hr>
                
                <h5 class="mb-3">Sipariş Ürünleri</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 80px">Ürün</th>
                                <th>Ürün Adı</th>
                                <th class="text-center">Adet</th>
                                <th class="text-end">Birim Fiyat</th>
                                <th class="text-end">Toplam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <img src="{{ $item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://via.placeholder.com/50x50?text=' . urlencode($item->product->name) }}" alt="{{ $item->product->name }}" width="50" height="50" class="img-thumbnail">
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $item->product) }}">
                                        {{ $item->product->name }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($item->price, 2) }} ₺</td>
                                <td class="text-end">{{ number_format($item->price * $item->quantity, 2) }} ₺</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Toplam Tutar:</strong></td>
                                <td class="text-end"><strong>{{ number_format($order->total_amount, 2) }} ₺</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Order Status Timeline -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Sipariş Durumu Geçmişi</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @foreach($statuses as $status)
                    <div class="timeline-item">
                        <div class="timeline-marker 
                            @if($status->status == 'pending') bg-warning
                            @elseif($status->status == 'approved') bg-info
                            @elseif(in_array($status->status, ['processing', 'packaging', 'shipping', 'in_transit'])) bg-primary
                            @elseif(in_array($status->status, ['delivered', 'completed'])) bg-success
                            @elseif($status->status == 'canceled') bg-danger
                            @else bg-secondary
                            @endif
                        "></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0">
                                    @if($status->status == 'pending')
                                    <span class="badge bg-warning text-dark">Beklemede</span>
                                    @elseif($status->status == 'approved')
                                    <span class="badge bg-info">Onaylandı</span>
                                    @elseif($status->status == 'processing')
                                    <span class="badge bg-primary">Hazırlanıyor</span>
                                    @elseif($status->status == 'packaging')
                                    <span class="badge bg-primary">Paketleniyor</span>
                                    @elseif($status->status == 'shipping')
                                    <span class="badge bg-primary">Kargoya Verildi</span>
                                    @elseif($status->status == 'in_transit')
                                    <span class="badge bg-info">Yolda</span>
                                    @elseif($status->status == 'delivered')
                                    <span class="badge bg-success">Teslim Edildi</span>
                                    @elseif($status->status == 'completed')
                                    <span class="badge bg-success">Tamamlandı</span>
                                    @elseif($status->status == 'canceled')
                                    <span class="badge bg-danger">İptal Edildi</span>
                                    @else
                                    <span class="badge bg-secondary">{{ $status->status }}</span>
                                    @endif
                                </h6>
                                <small class="text-muted">{{ $status->created_at->format('d.m.Y H:i') }}</small>
                            </div>
                            <p class="mt-2 mb-0">
                                @if($status->status == 'pending')
                                Sipariş alındı, onay bekleniyor.
                                @elseif($status->status == 'approved')
                                Sipariş onaylandı ve işleme alındı.
                                @elseif($status->status == 'processing')
                                Siparişiniz hazırlanıyor.
                                @elseif($status->status == 'packaging')
                                Siparişiniz paketleniyor.
                                @elseif($status->status == 'shipping')
                                Sipariş kargoya verildi.
                                @elseif($status->status == 'in_transit')
                                Sipariş kargo firması tarafından taşınıyor.
                                @elseif($status->status == 'delivered')
                                Sipariş müşteriye teslim edildi.
                                @elseif($status->status == 'completed')
                                Sipariş müşteri tarafından teslim alındı.
                                @elseif($status->status == 'canceled')
                                Sipariş iptal edildi.
                                @else
                                {{ $status->status }}
                                @endif
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Order Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Sipariş İşlemleri</h6>
            </div>
            <div class="card-body">
                <!-- Pending Order Actions -->
                @if($order->status == 'pending')
                <div class="d-grid gap-2 mb-3">
                    <form action="{{ route('admin.orders.approve', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-check-circle me-2"></i>Siparişi Onayla
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Bu siparişi iptal etmek istediğinize emin misiniz?')">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-times-circle me-2"></i>Siparişi İptal Et
                        </button>
                    </form>
                </div>
                @endif
                
                <!-- Update Order Status -->
                @if(in_array($order->status, ['approved', 'processing', 'packaging', 'shipping', 'in_transit']))
                <form action="{{ route('admin.orders.update_status', $order) }}" method="POST" class="mb-4">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">Durumu Güncelle</label>
                        <select class="form-select" id="status" name="status">
                            @if($order->status == 'approved')
                            <option value="processing">Hazırlanıyor</option>
                            @elseif($order->status == 'processing')
                            <option value="packaging">Paketleniyor</option>
                            @elseif($order->status == 'packaging')
                            <option value="shipping">Kargoya Verildi</option>
                            @elseif($order->status == 'shipping')
                            <option value="in_transit">Yolda</option>
                            @elseif($order->status == 'in_transit')
                            <option value="delivered">Teslim Edildi</option>
                            @endif
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync-alt me-2"></i>Durumu Güncelle
                        </button>
                    </div>
                </form>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Sipariş <strong>
                        @if($order->status == 'approved')
                        Onaylandı
                        @elseif($order->status == 'processing')
                        Hazırlanıyor
                        @elseif($order->status == 'packaging')
                        Paketleniyor
                        @elseif($order->status == 'shipping')
                        Kargoya Verildi
                        @elseif($order->status == 'in_transit')
                        Yolda
                        @endif
                    </strong> durumunda. Bir sonraki aşamaya geçmek için "Durumu Güncelle" butonuna tıklayın.
                </div>
                @endif
                
                <!-- Delivered Order Info -->
                @if($order->status == 'delivered')
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>Bu sipariş müşteriye teslim edildi. Müşterinin siparişi teslim aldığını onaylaması bekleniyor.
                </div>
                @endif
                
                <!-- Completed Order Info -->
                @if($order->status == 'completed')
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>Bu sipariş tamamlanmıştır. Müşteri tarafından teslim alındığı onaylanmıştır.
                </div>
                @endif
                
                <!-- Canceled Order Info -->
                @if($order->status == 'canceled')
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle me-2"></i>Bu sipariş iptal edilmiştir.
                </div>
                @endif
            </div>
        </div>
        
        <!-- Customer Info -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Müşteri Bilgisi</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="https://via.placeholder.com/100x100?text={{ substr($order->user->name, 0, 1) }}" alt="{{ $order->user->name }}" class="rounded-circle img-thumbnail" width="80">
                </div>
                <h5 class="text-center mb-3">{{ $order->user->name }}</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>E-posta:</span>
                        <span>{{ $order->user->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Telefon:</span>
                        <span>{{ $order->user->phone ?? 'Belirtilmemiş' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Bakiye:</span>
                        <span>{{ number_format($order->user->balance, 2) }} ₺</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Toplam Sipariş:</span>
                        <span>{{ $order->user->orders->count() }}</span>
                    </li>
                </ul>
                <div class="d-grid mt-3">
                    <a href="{{ route('admin.users.show', $order->user) }}" class="btn btn-primary">
                        <i class="fas fa-user me-2"></i>Müşteri Profilini Görüntüle
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    .timeline-marker {
        position: absolute;
        left: -30px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        top: 4px;
    }
    .timeline-item:not(:last-child):before {
        content: '';
        position: absolute;
        left: -23px;
        width: 2px;
        background-color: #e0e0e0;
        top: 20px;
        bottom: -20px;
    }
    .btn-block {
        display: block;
        width: 100%;
        margin-bottom: 8px;
    }
</style>
@endsection
