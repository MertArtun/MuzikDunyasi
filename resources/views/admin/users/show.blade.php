@extends('layouts.admin.app')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Kullanıcılar</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $user->name }}</h1>
    <div>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>Düzenle
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Geri
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- User Info Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Kullanıcı Bilgileri</h6>
            </div>
            <div class="card-body">
                <div class="mb-3 text-center">
                    <div class="avatar-circle mb-3">
                        <span class="avatar-text">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </div>
                    <h5>{{ $user->name }}</h5>
                    <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                        {{ $user->role === 'admin' ? 'Admin' : 'Kullanıcı' }}
                    </span>
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $user->is_active ? 'Aktif' : 'Pasif' }}
                    </span>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>E-posta:</span>
                        <span>{{ $user->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Telefon:</span>
                        <span>{{ $user->phone ?: 'Belirtilmemiş' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Adres:</span>
                        <span>{{ $user->address ?: 'Belirtilmemiş' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Bakiye:</span>
                        <span>{{ number_format($user->balance, 2) }} ₺</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Kayıt Tarihi:</span>
                        <span>{{ $user->created_at->format('d.m.Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- User Orders -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Siparişler</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sipariş No</th>
                                <th>Tarih</th>
                                <th>Tutar</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ number_format($order->total_amount, 2) }} ₺</td>
                                <td>
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
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Bu kullanıcıya ait sipariş bulunmamaktadır.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar-circle {
        width: 100px;
        height: 100px;
        background-color: #4e73df;
        border-radius: 50%;
        color: white;
        font-size: 32px;
        font-weight: bold;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-text {
        text-transform: uppercase;
    }
</style>
@endsection 