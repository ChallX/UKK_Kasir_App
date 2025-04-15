<?php $__env->startSection('content'); ?>
    <h1 class="font-bold mb-5 text-xl">Product</h1>

    <div class="border border-gray-200 p-4 rounded-md w-[1000px]">
        <div>
            <table id="search-table">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                Gambar Produk
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Nama Produk
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Harga
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Stok
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><img src="<?php echo e(asset('storage/produk/' . $product->image)); ?>" alt="" width="100"></td>
                            <td><?php echo e($product->nama_product); ?></td>
                            <td>Rp<?php echo e($product->harga); ?></td>
                            <td><?php echo e($product->stock); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>



    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\UKK_Kasir_App\resources\views/staff/product/index.blade.php ENDPATH**/ ?>