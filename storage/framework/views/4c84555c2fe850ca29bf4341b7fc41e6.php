<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.orders.index')); ?>">Siparişler</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sipariş #<?php echo e($order->id); ?></li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Sipariş #<?php echo e($order->id); ?></h1>
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">
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
                        <p class="mb-1"><strong>Müşteri:</strong></p>
                        <p>
                            <a href="<?php echo e(route('admin.users.show', $order->user)); ?>">
                                <?php echo e($order->user->name); ?>

                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>E-posta:</strong></p>
                        <p><?php echo e($order->user->email); ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <p class="mb-1"><strong>Teslimat Adresi:</strong></p>
                        <p><?php echo e($order->address); ?></p>
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
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <img src="<?php echo e($item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://via.placeholder.com/50x50?text=' . urlencode($item->product->name)); ?>" alt="<?php echo e($item->product->name); ?>" width="50" height="50" class="img-thumbnail">
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.products.edit', $item->product)); ?>">
                                        <?php echo e($item->product->name); ?>

                                    </a>
                                </td>
                                <td class="text-center"><?php echo e($item->quantity); ?></td>
                                <td class="text-end"><?php echo e(number_format($item->price, 2)); ?> ₺</td>
                                <td class="text-end"><?php echo e(number_format($item->price * $item->quantity, 2)); ?> ₺</td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Toplam Tutar:</strong></td>
                                <td class="text-end"><strong><?php echo e(number_format($order->total_amount, 2)); ?> ₺</strong></td>
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
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="timeline-item">
                        <div class="timeline-marker 
                            <?php if($status->status == 'pending'): ?> bg-warning
                            <?php elseif($status->status == 'approved'): ?> bg-info
                            <?php elseif(in_array($status->status, ['processing', 'packaging', 'shipping', 'in_transit'])): ?> bg-primary
                            <?php elseif(in_array($status->status, ['delivered', 'completed'])): ?> bg-success
                            <?php elseif($status->status == 'canceled'): ?> bg-danger
                            <?php else: ?> bg-secondary
                            <?php endif; ?>
                        "></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0">
                                    <?php if($status->status == 'pending'): ?>
                                    <span class="badge bg-warning text-dark">Beklemede</span>
                                    <?php elseif($status->status == 'approved'): ?>
                                    <span class="badge bg-info">Onaylandı</span>
                                    <?php elseif($status->status == 'processing'): ?>
                                    <span class="badge bg-primary">Hazırlanıyor</span>
                                    <?php elseif($status->status == 'packaging'): ?>
                                    <span class="badge bg-primary">Paketleniyor</span>
                                    <?php elseif($status->status == 'shipping'): ?>
                                    <span class="badge bg-primary">Kargoya Verildi</span>
                                    <?php elseif($status->status == 'in_transit'): ?>
                                    <span class="badge bg-info">Yolda</span>
                                    <?php elseif($status->status == 'delivered'): ?>
                                    <span class="badge bg-success">Teslim Edildi</span>
                                    <?php elseif($status->status == 'completed'): ?>
                                    <span class="badge bg-success">Tamamlandı</span>
                                    <?php elseif($status->status == 'canceled'): ?>
                                    <span class="badge bg-danger">İptal Edildi</span>
                                    <?php else: ?>
                                    <span class="badge bg-secondary"><?php echo e($status->status); ?></span>
                                    <?php endif; ?>
                                </h6>
                                <small class="text-muted"><?php echo e($status->created_at->format('d.m.Y H:i')); ?></small>
                            </div>
                            <p class="mt-2 mb-0">
                                <?php if($status->status == 'pending'): ?>
                                Sipariş alındı, onay bekleniyor.
                                <?php elseif($status->status == 'approved'): ?>
                                Sipariş onaylandı ve işleme alındı.
                                <?php elseif($status->status == 'processing'): ?>
                                Siparişiniz hazırlanıyor.
                                <?php elseif($status->status == 'packaging'): ?>
                                Siparişiniz paketleniyor.
                                <?php elseif($status->status == 'shipping'): ?>
                                Sipariş kargoya verildi.
                                <?php elseif($status->status == 'in_transit'): ?>
                                Sipariş kargo firması tarafından taşınıyor.
                                <?php elseif($status->status == 'delivered'): ?>
                                Sipariş müşteriye teslim edildi.
                                <?php elseif($status->status == 'completed'): ?>
                                Sipariş müşteri tarafından teslim alındı.
                                <?php elseif($status->status == 'canceled'): ?>
                                Sipariş iptal edildi.
                                <?php else: ?>
                                <?php echo e($status->status); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php if($order->status == 'pending'): ?>
                <div class="d-grid gap-2 mb-3">
                    <form action="<?php echo e(route('admin.orders.approve', $order)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-check-circle me-2"></i>Siparişi Onayla
                        </button>
                    </form>
                    
                    <form action="<?php echo e(route('admin.orders.cancel', $order)); ?>" method="POST" onsubmit="return confirm('Bu siparişi iptal etmek istediğinize emin misiniz?')">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-times-circle me-2"></i>Siparişi İptal Et
                        </button>
                    </form>
                </div>
                <?php endif; ?>
                
                <!-- Update Order Status -->
                <?php if(in_array($order->status, ['approved', 'processing', 'packaging', 'shipping', 'in_transit'])): ?>
                <form action="<?php echo e(route('admin.orders.update_status', $order)); ?>" method="POST" class="mb-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3">
                        <label for="status" class="form-label">Durumu Güncelle</label>
                        <select class="form-select" id="status" name="status">
                            <?php if($order->status == 'approved'): ?>
                            <option value="processing">Hazırlanıyor</option>
                            <?php elseif($order->status == 'processing'): ?>
                            <option value="packaging">Paketleniyor</option>
                            <?php elseif($order->status == 'packaging'): ?>
                            <option value="shipping">Kargoya Verildi</option>
                            <?php elseif($order->status == 'shipping'): ?>
                            <option value="in_transit">Yolda</option>
                            <?php elseif($order->status == 'in_transit'): ?>
                            <option value="delivered">Teslim Edildi</option>
                            <?php endif; ?>
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
                        <?php if($order->status == 'approved'): ?>
                        Onaylandı
                        <?php elseif($order->status == 'processing'): ?>
                        Hazırlanıyor
                        <?php elseif($order->status == 'packaging'): ?>
                        Paketleniyor
                        <?php elseif($order->status == 'shipping'): ?>
                        Kargoya Verildi
                        <?php elseif($order->status == 'in_transit'): ?>
                        Yolda
                        <?php endif; ?>
                    </strong> durumunda. Bir sonraki aşamaya geçmek için "Durumu Güncelle" butonuna tıklayın.
                </div>
                <?php endif; ?>
                
                <!-- Delivered Order Info -->
                <?php if($order->status == 'delivered'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>Bu sipariş müşteriye teslim edildi. Müşterinin siparişi teslim aldığını onaylaması bekleniyor.
                </div>
                <?php endif; ?>
                
                <!-- Completed Order Info -->
                <?php if($order->status == 'completed'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>Bu sipariş tamamlanmıştır. Müşteri tarafından teslim alındığı onaylanmıştır.
                </div>
                <?php endif; ?>
                
                <!-- Canceled Order Info -->
                <?php if($order->status == 'canceled'): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle me-2"></i>Bu sipariş iptal edilmiştir.
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Customer Info -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Müşteri Bilgisi</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="https://via.placeholder.com/100x100?text=<?php echo e(substr($order->user->name, 0, 1)); ?>" alt="<?php echo e($order->user->name); ?>" class="rounded-circle img-thumbnail" width="80">
                </div>
                <h5 class="text-center mb-3"><?php echo e($order->user->name); ?></h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>E-posta:</span>
                        <span><?php echo e($order->user->email); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Telefon:</span>
                        <span><?php echo e($order->user->phone ?? 'Belirtilmemiş'); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Bakiye:</span>
                        <span><?php echo e(number_format($order->user->balance, 2)); ?> ₺</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Toplam Sipariş:</span>
                        <span><?php echo e($order->user->orders->count()); ?></span>
                    </li>
                </ul>
                <div class="d-grid mt-3">
                    <a href="<?php echo e(route('admin.users.show', $order->user)); ?>" class="btn btn-primary">
                        <i class="fas fa-user me-2"></i>Müşteri Profilini Görüntüle
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/halitartun/Desktop/MuzikDunyasıTest/resources/views/admin/orders/show.blade.php ENDPATH**/ ?>