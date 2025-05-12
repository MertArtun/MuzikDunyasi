<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Ana Sayfa</a></li>
        <li class="breadcrumb-item active" aria-current="page">Alışveriş Sepeti</li>
    </ol>
</nav>

<h1 class="mb-4">Alışveriş Sepeti</h1>

<?php if($cart && $cart->items->count() > 0): ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 100px">Ürün</th>
                                    <th>Detaylar</th>
                                    <th class="text-center">Adet</th>
                                    <th class="text-end">Fiyat</th>
                                    <th class="text-end">Toplam</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo e($item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://via.placeholder.com/100x100?text=' . urlencode($item->product->name)); ?>" alt="<?php echo e($item->product->name); ?>" class="img-thumbnail" width="80">
                                    </td>
                                    <td>
                                        <h5 class="mb-1"><?php echo e($item->product->name); ?></h5>
                                        <small class="text-muted"><?php echo e($item->product->category->name); ?></small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="item_id" value="<?php echo e($item->id); ?>">
                                            <div class="input-group input-group-sm" style="width: 120px;">
                                                <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="decrease">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" name="quantity" class="form-control text-center quantity-input" value="<?php echo e($item->quantity); ?>" min="1" max="<?php echo e($item->product->stock); ?>">
                                                <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="increase">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-end align-middle"><?php echo e(number_format($item->product->price, 2)); ?> ₺</td>
                                    <td class="text-end align-middle"><?php echo e(number_format($item->product->price * $item->quantity, 2)); ?> ₺</td>
                                    <td class="text-end align-middle">
                                        <form action="<?php echo e(route('cart.remove', $item->product->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu ürünü sepetten çıkarmak istediğinize emin misiniz?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Alışverişe Devam Et
                        </a>
                        <form action="<?php echo e(route('cart.clear')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Tüm sepeti temizlemek istediğinize emin misiniz?')">
                                <i class="fas fa-trash me-2"></i>Sepeti Temizle
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Sipariş Özeti</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ürünler Toplamı</span>
                        <span><?php echo e(number_format($cart->total, 2)); ?> ₺</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Kargo Ücreti</span>
                        <span>0.00 ₺</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Genel Toplam</strong>
                        <strong><?php echo e(number_format($cart->total, 2)); ?> ₺</strong>
                    </div>
                    
                    <?php if(auth()->user()->balance > 0): ?>
                    <div class="alert alert-info mt-3">
                        <div class="d-flex justify-content-between">
                            <span>Kullanılabilir Bakiye:</span>
                            <span><?php echo e(number_format(auth()->user()->balance, 2)); ?> ₺</span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="d-grid gap-2 mt-4">
                        <a href="<?php echo e(route('cart.checkout')); ?>" class="btn btn-primary">
                            <i class="fas fa-lock me-2"></i>Ödeme Adımına Geç
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h3>Sepetiniz Boş</h3>
            <p class="text-muted">Sepetinizde henüz ürün bulunmamaktadır.</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag me-2"></i>Alışverişe Başla
            </a>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity buttons functionality
        const quantityBtns = document.querySelectorAll('.quantity-btn');
        
        quantityBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.dataset.action;
                const inputField = this.parentNode.querySelector('.quantity-input');
                let value = parseInt(inputField.value);
                const max = parseInt(inputField.getAttribute('max'));
                
                if (action === 'increase' && value < max) {
                    inputField.value = value + 1;
                } else if (action === 'decrease' && value > 1) {
                    inputField.value = value - 1;
                }
                
                // Auto-submit form on change
                this.closest('form').submit();
            });
        });
        
        // Auto-submit form when quantity input changes
        const quantityInputs = document.querySelectorAll('.quantity-input');
        
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/halitartun/Desktop/MuzikDunyasıTest/resources/views/cart/index.blade.php ENDPATH**/ ?>