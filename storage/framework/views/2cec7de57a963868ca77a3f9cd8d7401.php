<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Ana Sayfa</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('orders.index')); ?>">Siparişlerim</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sipariş #<?php echo e($order->id); ?></li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Sipariş #<?php echo e($order->id); ?></h1>
    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Siparişlerime Dön
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Order Items -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Sipariş Edilen Ürünler</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
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
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <img src="<?php echo e($item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://via.placeholder.com/60x60?text=' . urlencode($item->product->name)); ?>" alt="<?php echo e($item->product->name); ?>" class="img-thumbnail" width="60">
                                </td>
                                <td>
                                    <h6 class="mb-0"><?php echo e($item->product->name); ?></h6>
                                    <small class="text-muted"><?php echo e($item->product->category->name); ?></small>
                                </td>
                                <td class="text-center"><?php echo e($item->quantity); ?></td>
                                <td class="text-end"><?php echo e(number_format($item->price, 2)); ?> ₺</td>
                                <td class="text-end"><?php echo e(number_format($item->price * $item->quantity, 2)); ?> ₺</td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end border-top"><strong>Ara Toplam:</strong></td>
                                <td class="text-end border-top"><?php echo e(number_format($order->total_amount, 2)); ?> ₺</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Kargo Ücreti:</strong></td>
                                <td class="text-end">0.00 ₺</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Genel Toplam:</strong></td>
                                <td class="text-end"><strong><?php echo e(number_format($order->total_amount, 2)); ?> ₺</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Order Details -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Sipariş Detayları</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Sipariş Tarihi:</strong></p>
                        <p><?php echo e($order->created_at->format('d.m.Y H:i')); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Sipariş Numarası:</strong></p>
                        <p>#<?php echo e($order->id); ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Teslimat Adresi:</strong></p>
                        <p><?php echo e($order->address); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Ödeme Yöntemi:</strong></p>
                        <p>
                            <?php if($order->payment_method == 'credit_card'): ?>
                            <i class="fas fa-credit-card me-2"></i>Kredi Kartı
                            <?php elseif($order->payment_method == 'balance'): ?>
                            <i class="fas fa-wallet me-2"></i>Bakiye
                            <?php else: ?>
                            <?php echo e($order->payment_method); ?>

                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Order Status -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Sipariş Durumu</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <?php if($order->status == 'pending'): ?>
                    <div class="status-icon bg-warning text-dark">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5 class="mt-3">Beklemede</h5>
                    <p class="text-muted">Siparişiniz onay bekliyor</p>
                    <?php elseif($order->status == 'approved'): ?>
                    <div class="status-icon bg-info text-white">
                        <i class="fas fa-check"></i>
                    </div>
                    <h5 class="mt-3">Onaylandı</h5>
                    <p class="text-muted">Siparişiniz onaylandı ve hazırlanıyor</p>
                    <?php elseif($order->status == 'processing'): ?>
                    <div class="status-icon bg-primary text-white">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h5 class="mt-3">Hazırlanıyor</h5>
                    <p class="text-muted">Siparişiniz hazırlanıyor</p>
                    <?php elseif($order->status == 'packaging'): ?>
                    <div class="status-icon bg-primary text-white">
                        <i class="fas fa-box"></i>
                    </div>
                    <h5 class="mt-3">Paketleniyor</h5>
                    <p class="text-muted">Siparişiniz paketleniyor</p>
                    <?php elseif($order->status == 'shipping'): ?>
                    <div class="status-icon bg-primary text-white">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h5 class="mt-3">Kargoya Verildi</h5>
                    <p class="text-muted">Siparişiniz kargoya verildi</p>
                    <?php elseif($order->status == 'in_transit'): ?>
                    <div class="status-icon bg-info text-white">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h5 class="mt-3">Yolda</h5>
                    <p class="text-muted">Siparişiniz size doğru yolda</p>
                    <?php elseif($order->status == 'delivered'): ?>
                    <div class="status-icon bg-success text-white">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h5 class="mt-3">Teslim Edildi</h5>
                    <p class="text-muted">Siparişiniz teslim edildi</p>
                    <?php elseif($order->status == 'completed'): ?>
                    <div class="status-icon bg-success text-white">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h5 class="mt-3">Tamamlandı</h5>
                    <p class="text-muted">Siparişiniz tamamlandı</p>
                    <?php elseif($order->status == 'canceled'): ?>
                    <div class="status-icon bg-danger text-white">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h5 class="mt-3">İptal Edildi</h5>
                    <p class="text-muted">Siparişiniz iptal edildi</p>
                    <?php endif; ?>
                </div>
                
                <!-- Order Actions -->
                <div class="d-grid gap-2">
                    <?php if($order->status == 'pending'): ?>
                    <form action="<?php echo e(route('orders.cancel', $order)); ?>" method="POST" onsubmit="return confirm('Bu siparişi iptal etmek istediğinize emin misiniz?')">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times-circle me-2"></i>Siparişi İptal Et
                        </button>
                    </form>
                    <?php elseif($order->status == 'delivered'): ?>
                    <form action="<?php echo e(route('orders.received', $order)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check-circle me-2"></i>Siparişi Teslim Aldım
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Order Timeline -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Sipariş Takibi</h5>
            </div>
            <div class="card-body p-0">
                <div class="order-timeline">
                    <div class="timeline-item <?php echo e(in_array($order->status, ['pending', 'approved', 'processing', 'packaging', 'shipping', 'in_transit', 'delivered', 'completed']) ? 'completed' : ($order->status == 'canceled' ? 'canceled' : '')); ?>">
                        <div class="timeline-badge">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Sipariş Alındı</h6>
                            <small><?php echo e($order->created_at->format('d.m.Y H:i')); ?></small>
                        </div>
                    </div>
                    
                    <div class="timeline-item <?php echo e(in_array($order->status, ['approved', 'processing', 'packaging', 'shipping', 'in_transit', 'delivered', 'completed']) ? 'completed' : ($order->status == 'canceled' ? 'canceled' : '')); ?>">
                        <div class="timeline-badge">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Sipariş Onaylandı</h6>
                            <small>
                                <?php if($status = $statuses->firstWhere('status', 'approved')): ?>
                                <?php echo e($status->created_at->format('d.m.Y H:i')); ?>

                                <?php else: ?>
                                Bekleniyor
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="timeline-item <?php echo e(in_array($order->status, ['processing', 'packaging', 'shipping', 'in_transit', 'delivered', 'completed']) ? 'completed' : ($order->status == 'canceled' ? 'canceled' : '')); ?>">
                        <div class="timeline-badge">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Hazırlanıyor</h6>
                            <small>
                                <?php if($status = $statuses->firstWhere('status', 'processing')): ?>
                                <?php echo e($status->created_at->format('d.m.Y H:i')); ?>

                                <?php else: ?>
                                Bekleniyor
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="timeline-item <?php echo e(in_array($order->status, ['packaging', 'shipping', 'in_transit', 'delivered', 'completed']) ? 'completed' : ($order->status == 'canceled' ? 'canceled' : '')); ?>">
                        <div class="timeline-badge">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Paketleniyor</h6>
                            <small>
                                <?php if($status = $statuses->firstWhere('status', 'packaging')): ?>
                                <?php echo e($status->created_at->format('d.m.Y H:i')); ?>

                                <?php else: ?>
                                Bekleniyor
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="timeline-item <?php echo e(in_array($order->status, ['shipping', 'in_transit', 'delivered', 'completed']) ? 'completed' : ($order->status == 'canceled' ? 'canceled' : '')); ?>">
                        <div class="timeline-badge">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Kargoya Verildi</h6>
                            <small>
                                <?php if($status = $statuses->firstWhere('status', 'shipping')): ?>
                                <?php echo e($status->created_at->format('d.m.Y H:i')); ?>

                                <?php else: ?>
                                Bekleniyor
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="timeline-item <?php echo e(in_array($order->status, ['in_transit', 'delivered', 'completed']) ? 'completed' : ($order->status == 'canceled' ? 'canceled' : '')); ?>">
                        <div class="timeline-badge">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Yolda</h6>
                            <small>
                                <?php if($status = $statuses->firstWhere('status', 'in_transit')): ?>
                                <?php echo e($status->created_at->format('d.m.Y H:i')); ?>

                                <?php else: ?>
                                Bekleniyor
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="timeline-item <?php echo e(in_array($order->status, ['delivered', 'completed']) ? 'completed' : ($order->status == 'canceled' ? 'canceled' : '')); ?>">
                        <div class="timeline-badge">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Teslim Edildi</h6>
                            <small>
                                <?php if($status = $statuses->firstWhere('status', 'delivered')): ?>
                                <?php echo e($status->created_at->format('d.m.Y H:i')); ?>

                                <?php else: ?>
                                Bekleniyor
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="timeline-item <?php echo e($order->status == 'completed' ? 'completed' : ($order->status == 'canceled' ? 'canceled' : '')); ?>">
                        <div class="timeline-badge">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Tamamlandı</h6>
                            <small>
                                <?php if($status = $statuses->firstWhere('status', 'completed')): ?>
                                <?php echo e($status->created_at->format('d.m.Y H:i')); ?>

                                <?php else: ?>
                                Bekleniyor
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .status-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .status-icon i {
        font-size: 2rem;
    }
    
    .order-timeline {
        position: relative;
        padding: 20px;
    }
    
    .timeline-item {
        position: relative;
        padding-left: 40px;
        margin-bottom: 25px;
    }
    
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    
    .timeline-badge {
        position: absolute;
        left: 0;
        top: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        z-index: 1;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 30px;
        bottom: -25px;
        width: 2px;
        background-color: #e9ecef;
    }
    
    .timeline-item:last-child::before {
        display: none;
    }
    
    .timeline-item.completed .timeline-badge {
        background-color: #28a745;
        color: #fff;
    }
    
    .timeline-item.completed::before {
        background-color: #28a745;
    }
    
    .timeline-item.canceled .timeline-badge {
        background-color: #dc3545;
        color: #fff;
    }
    
    .timeline-item.canceled::before {
        background-color: #dc3545;
    }
    
    .timeline-content {
        padding-left: 15px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/halitartun/Desktop/MuzikDunyasıTest/resources/views/orders/show.blade.php ENDPATH**/ ?>