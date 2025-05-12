<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ürünler</h1>
    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
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
                <form action="<?php echo e(route('admin.products.index')); ?>" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Ürün Ara..." value="<?php echo e(request('search')); ?>">
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
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($product->id); ?></td>
                        <td>
                            <img src="<?php echo e($product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/50x50?text=' . urlencode($product->name)); ?>" alt="<?php echo e($product->name); ?>" width="50" height="50" class="img-thumbnail">
                        </td>
                        <td><?php echo e($product->name); ?></td>
                        <td><?php echo e($product->category->name); ?></td>
                        <td><?php echo e(number_format($product->price, 2)); ?> ₺</td>
                        <td>
                            <?php if($product->stock <= 0): ?>
                            <span class="badge bg-danger">Tükendi</span>
                            <?php elseif($product->stock <= 5): ?>
                            <span class="badge bg-warning text-dark">Kritik: <?php echo e($product->stock); ?></span>
                            <?php else: ?>
                            <span class="badge bg-success"><?php echo e($product->stock); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($product->is_active): ?>
                            <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                            <span class="badge bg-danger">Pasif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('products.show', $product)); ?>" class="btn btn-sm btn-info" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">Henüz ürün bulunmamaktadır.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($products->links()); ?>

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
                <a href="<?php echo e(route('admin.products.index', ['stock' => 'low'])); ?>" class="btn btn-warning btn-block">
                    <i class="fas fa-exclamation-triangle me-2"></i>Düşük Stoklu Ürünler
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="<?php echo e(route('admin.products.index', ['stock' => 'out'])); ?>" class="btn btn-danger btn-block">
                    <i class="fas fa-times-circle me-2"></i>Tükenen Ürünler
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="<?php echo e(route('admin.products.index', ['status' => 'active'])); ?>" class="btn btn-success btn-block">
                    <i class="fas fa-check-circle me-2"></i>Aktif Ürünler
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="<?php echo e(route('admin.products.index', ['status' => 'inactive'])); ?>" class="btn btn-secondary btn-block">
                    <i class="fas fa-ban me-2"></i>Pasif Ürünler
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .btn-block {
        display: block;
        width: 100%;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/halitartun/Desktop/MuzikDunyasıTest/resources/views/admin/products/index.blade.php ENDPATH**/ ?>