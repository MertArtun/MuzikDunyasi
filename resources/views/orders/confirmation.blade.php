@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Siparişlerim</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sipariş Onayı</li>
    </ol>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center mb-5">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success fa-5x"></i>
            </div>
            <h1 class="display-4 mb-3">Siparişiniz Alındı!</h1>
            <p class="lead">Sipariş numaranız: <strong>{{ $order->id }}</strong></p>
            <p>Siparişiniz ile ilgili bilgilendirmeler e-posta adresinize gönderilecektir.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Sipariş Özeti</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Sipariş Tarihi:</strong></p>
                            <p>{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Sipariş Durumu:</strong></p>
                            <p>
                                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Teslimat Adresi:</strong></p>
                            <p>{{ $order->address }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Toplam Tutar:</strong></p>
                            <p>{{ number_format($order->total_amount, 2) }} ₺</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6 class="mb-3">Sipariş Edilen Ürünler</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ürün</th>
                                    <th>Birim Fiyat</th>
                                    <th>Miktar</th>
                                    <th class="text-end">Toplam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ number_format($item->price, 2) }} ₺</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->price * $item->quantity, 2) }} ₺</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Genel Toplam:</th>
                                    <th class="text-end">{{ number_format($order->total_amount, 2) }} ₺</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2">
                <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                    <i class="fas fa-info-circle me-2"></i>Sipariş Detayları
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list me-2"></i>Tüm Siparişlerim
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-home me-2"></i>Ana Sayfaya Dön
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 