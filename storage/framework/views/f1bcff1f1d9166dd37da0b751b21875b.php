<?php $__env->startSection('content'); ?>
<h1 class="mb-4">Dashboard</h1>

<div class="row">
    <!-- Stats Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Toplam Kullanıcı</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalUsers); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            Toplam Ürün</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalProducts); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-guitar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Toplam Sipariş</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalOrders); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($pendingOrders); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Orders -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Son Siparişler</h6>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-primary">
                    Tümünü Gör
                </a>
            </div>
            <div class="card-body">
                <?php if($recentOrders->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Müşteri</th>
                                <th>Tutar</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($order->id); ?></td>
                                <td><?php echo e($order->user->name); ?></td>
                                <td><?php echo e(number_format($order->total_amount, 2)); ?> ₺</td>
                                <td>
                                    <?php if($order->status == 'pending'): ?>
                                    <span class="badge bg-warning text-dark">Beklemede</span>
                                    <?php elseif($order->status == 'approved'): ?>
                                    <span class="badge bg-info">Onaylandı</span>
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-center">Henüz sipariş bulunmamaktadır.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Stok Durumu Düşük Ürünler</h6>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-sm btn-primary">
                    Tümünü Gör
                </a>
            </div>
            <div class="card-body">
                <?php if($lowStockProducts->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ürün</th>
                                <th>Kategori</th>
                                <th>Fiyat</th>
                                <th>Stok</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($product->id); ?></td>
                                <td><?php echo e($product->name); ?></td>
                                <td><?php echo e($product->category->name); ?></td>
                                <td><?php echo e(number_format($product->price, 2)); ?> ₺</td>
                                <td>
                                    <?php if($product->stock_quantity <= 0): ?>
                                    <span class="badge bg-danger">Tükendi</span>
                                    <?php elseif($product->stock_quantity <= 3): ?>
                                    <span class="badge bg-warning text-dark">Kritik: <?php echo e($product->stock_quantity); ?></span>
                                    <?php else: ?>
                                    <span class="badge bg-info"><?php echo e($product->stock_quantity); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-center">Stok durumu düşük ürün bulunmamaktadır.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Hızlı Erişim</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-success btn-block py-3">
                            <i class="fas fa-plus-circle me-2"></i>Yeni Ürün Ekle
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary btn-block py-3">
                            <i class="fas fa-user-plus me-2"></i>Yeni Kullanıcı Ekle
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('admin.orders.index', ['status' => 'pending'])); ?>" class="btn btn-warning btn-block py-3">
                            <i class="fas fa-clock me-2"></i>Bekleyen Siparişler
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-info btn-block py-3" target="_blank">
                            <i class="fas fa-store me-2"></i>Siteyi Görüntüle
                        </a>
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
    .border-left-info {
        border-left: 4px solid #36b9cc;
    }
    .border-left-warning {
        border-left: 4px solid #f6c23e;
    }
    .btn-block {
        display: block;
        width: 100%;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/halitartun/Desktop/MuzikDunyasıTest/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>