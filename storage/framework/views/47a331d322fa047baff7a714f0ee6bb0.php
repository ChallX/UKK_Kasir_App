<?php $__env->startSection('content'); ?>
    <h1 class="font-bold text-xl">Dashboard</h1>

    <div class="mt-5 border rounded-md p-2 h-[930px] border-gray-200">
        <h1 class="font-bold">Selamat Datang, Administrator !</h1>

        <div class="my-4">
            <h2 class="font-semibold text-lg">Jumlah Penjualan Per Hari</h2>
            <canvas id="myBarChart" width="400" height="100"></canvas>
        </div>

        <div class="my-4" style="height: 300px;">
            <h2 class="font-semibold text-lg">Persentase Keseluruhan Produk</h2>
            <canvas id="myPieChart"></canvas>
        </div>



        <script>
            const labels = <?php echo json_encode($penjualanPerHariSelama1Bulan->pluck('tanggal')); ?>;
            const data = <?php echo json_encode($penjualanPerHariSelama1Bulan->pluck('total')); ?>;

            const ctx = document.getElementById('myBarChart').getContext('2d');
            const myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Penjualan per Hari',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <script>
            const pieLabels = <?php echo json_encode($persentasePenjualanProduk->pluck('nama_product')); ?>;
            const pieData = <?php echo json_encode($persentasePenjualanProduk->pluck('total')); ?>;

            const pieCtx = document.getElementById('myPieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: pieLabels,
                    datasets: [{
                        label: 'Persentase Penjualan Produk',
                        data: pieData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(255, 205, 86, 0.6)',
                            'rgba(201, 203, 207, 0.6)',
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\UKK_Kasir_App\resources\views/admin/index.blade.php ENDPATH**/ ?>