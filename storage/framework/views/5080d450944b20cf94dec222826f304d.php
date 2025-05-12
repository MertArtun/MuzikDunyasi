<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Kullanıcı Yönetimi</h2>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Yeni Kullanıcı Ekle
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <form action="<?php echo e(route('admin.users.index')); ?>" method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="İsim veya e-posta ara..." value="<?php echo e(request('search')); ?>">
                        <button class="btn btn-outline-secondary" type="submit">Ara</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="role" class="form-select" onchange="this.form.submit()">
                        <option value="">Tüm Roller</option>
                        <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                        <option value="user" <?php echo e(request('role') == 'user' ? 'selected' : ''); ?>>Kullanıcı</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <?php if(request('search') || request('role')): ?>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary">Filtreleri Temizle</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <div class="card-body">
            <?php if($users->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>İsim</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Durum</th>
                                <th>Kayıt Tarihi</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($user->id); ?></td>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><?php echo e($user->email); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($user->role == 'admin' ? 'danger' : 'info'); ?>">
                                            <?php echo e($user->role == 'admin' ? 'Admin' : 'Kullanıcı'); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($user->is_active ? 'success' : 'secondary'); ?>">
                                            <?php echo e($user->is_active ? 'Aktif' : 'Pasif'); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($user->created_at->format('d.m.Y H:i')); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <?php echo e($users->withQueryString()->links()); ?>

                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    Herhangi bir kullanıcı bulunamadı.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/halitartun/Desktop/MuzikDunyasıTest/resources/views/admin/users/index.blade.php ENDPATH**/ ?>