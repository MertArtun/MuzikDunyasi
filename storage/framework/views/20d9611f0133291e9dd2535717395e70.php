<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Siparişler</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="m-0 font-weight-bold text-primary">Sipariş Listesi</h6>
            </div>
            <div class="col-md-4">
                <form action="<?php echo e(route('admin.orders.index')); ?>" method="GET" class="d-flex">
                    <input type="text" class="form-control me-2" name="search" placeholder="Ara..." value="<?php echo e(request('search')); ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link <?php echo e(!$status ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index')); ?>">
                    Tümü
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'pending' ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index', ['status' => 'pending'])); ?>">
                    Beklemede
                    <span class="badge bg-warning text-dark"><?php echo e(App\Models\Order::where('status', 'pending')->count()); ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'approved' ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index', ['status' => 'approved'])); ?>">
                    Onaylanmış
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'processing' ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index', ['status' => 'processing'])); ?>">
                    Hazırlanıyor
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'shipping' ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index', ['status' => 'shipping'])); ?>">
                    Kargoda
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'delivered' ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index', ['status' => 'delivered'])); ?>">
                    Teslim Edildi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'completed' ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index', ['status' => 'completed'])); ?>">
                    Tamamlandı
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'canceled' ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index', ['status' => 'canceled'])); ?>">
                    İptal Edildi
                </a>
            </li>
        </ul>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Müşteri</th>
                        <th>Ürün Sayısı</th>
                        <th>Toplam Tutar</th>
                        <th>Durum</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($order->id); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.users.show', $order->user)); ?>">
                                <?php echo e($order->user->name); ?>

                            </a>
                        </td>
                        <td><?php echo e($order->items->sum('quantity')); ?></td>
                        <td><?php echo e(number_format($order->total_amount, 2)); ?> ₺</td>
                        <td>
                            <?php if($order->status == 'pending'): ?>
                            <span class="badge bg-warning text-dark">Beklemede</span>
                            <?php elseif($order->status == 'approved'): ?>
                            <span class="badge bg-info">Onaylandı</span>
                            <?php elseif($order->status == 'processing'): ?>
                            <span class="badge bg-primary">Hazırlanıyor</span>
                            <?php elseif($order->status == 'packaging'): ?>
                            <span class="badge bg-primary">Paketleniyor</span>
                            <?php elseif($order->status == 'shipping'): ?>
                            <span class="badge bg-primary">Kargoya Verildi</span>
                            <?php elseif($order->status == 'in_transit'): ?>
                            <span class="badge bg-info">Yolda</span>
                            <?php elseif($order->status == 'delivered'): ?>
                            <span class="badge bg-success">Teslim Edildi</span>
                            <?php elseif($order->status == 'completed'): ?>
                            <span class="badge bg-success">Tamamlandı</span>
                            <?php elseif($order->status == 'canceled'): ?>
                            <span class="badge bg-danger">İptal Edildi</span>
                            <?php else: ?>
                            <span class="badge bg-secondary"><?php echo e($order->status); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($order->created_at->format('d.m.Y H:i')); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">Gösterilecek sipariş bulunamadı.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($orders->appends(['status' => $status, 'search' => request('search')])->links()); ?>

        </div>
    </div>
</div>

<!-- Order Stats -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Toplam Sipariş</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(App\Models\Order::count()); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Tamamlanan Siparişler</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(App\Models\Order::whereIn('status', ['completed', 'delivered'])->count()); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Bekleyen Siparişler</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(App\Models\Order::where('status', 'pending')->count()); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            İptal Edilen Siparişler</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(App\Models\Order::where('status', 'canceled')->count()); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .border-left-primary {
        border-left: 4px solid #4e73df;
    }
    .border-left-success {
        border-left: 4px solid #1cc88a;
    }
    .border-left-warning {
        border-left: 4px solid #f6c23e;
    }
    .border-left-danger {
        border-left: 4px solid #e74a3b;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/halitartun/Desktop/MuzikDunyasıTest/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>