<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Ana Sayfa</a></li>
        <li class="breadcrumb-item active" aria-current="page">Siparişlerim</li>
    </ol>
</nav>

<h1 class="mb-4">Siparişlerim</h1>

<?php if($orders->count() > 0): ?>
    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link <?php echo e(!request('status') ? 'active' : ''); ?>" href="<?php echo e(route('orders.index')); ?>">
                Tüm Siparişler
                <span class="badge bg-secondary"><?php echo e($orders->total()); ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request('status') == 'active' ? 'active' : ''); ?>" href="<?php echo e(route('orders.index', ['status' => 'active'])); ?>">
                Aktif Siparişler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request('status') == 'completed' ? 'active' : ''); ?>" href="<?php echo e(route('orders.index', ['status' => 'completed'])); ?>">
                Tamamlanan Siparişler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request('status') == 'canceled' ? 'active' : ''); ?>" href="<?php echo e(route('orders.index', ['status' => 'canceled'])); ?>">
                İptal Edilen Siparişler
            </a>
        </li>
    </ul>

    <div class="row">
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sipariş #<?php echo e($order->id); ?></h5>
                    <span>
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
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Sipariş Tarihi</small>
                            <strong><?php echo e($order->created_at->format('d.m.Y H:i')); ?></strong>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <small class="text-muted d-block">Toplam Tutar</small>
                            <strong><?php echo e(number_format($order->total_amount, 2)); ?> ₺</strong>
                        </div>
                    </div>
                    
                    <p class="mb-1"><strong>Teslimat Adresi:</strong></p>
                    <p class="mb-3"><?php echo e($order->address); ?></p>
                    
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
                                <?php $__currentLoopData = $order->items->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->product->name); ?></td>
                                    <td><?php echo e(number_format($item->price, 2)); ?> ₺</td>
                                    <td class="text-center"><?php echo e($item->quantity); ?></td>
                                    <td class="text-end"><?php echo e(number_format($item->price * $item->quantity, 2)); ?> ₺</td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                <?php if($order->items->count() > 3): ?>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <a href="<?php echo e(route('orders.show', $order)); ?>">+ <?php echo e($order->items->count() - 3); ?> daha fazla ürün</a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-primary">
                            <i class="fas fa-eye me-2"></i>Detayları Görüntüle
                        </a>
                        
                        <?php if($order->status == 'pending'): ?>
                        <form action="<?php echo e(route('orders.cancel', $order)); ?>" method="POST" onsubmit="return confirm('Bu siparişi iptal etmek istediğinize emin misiniz?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>İptal Et
                            </button>
                        </form>
                        <?php elseif($order->status == 'delivered'): ?>
                        <form action="<?php echo e(route('orders.received', $order)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Teslim Aldım
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($orders->links()); ?>

    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
            <h3>Henüz Siparişiniz Yok</h3>
            <p class="text-muted">Sipariş geçmişiniz boş görünüyor.</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag me-2"></i>Alışverişe Başla
            </a>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/halitartun/Desktop/MuzikDunyasıTest/resources/views/orders/index.blade.php ENDPATH**/ ?>