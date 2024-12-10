<?= $this->section('content') ?>
<div class="container mt-5">

    <nav class="breadcrumb mb-3" style="font-size:18px;">
        <a class="breadcrumb-item text-secondary" style="text-decoration:none;" href="<?= site_url('/dashboard') ?>">Daftar Produk</a>
        <a class="breadcrumb-item text-dark fw-bold" style="text-decoration:none;" href="#">
            <?= isset($product) ? 'Edit Produk' : 'Tambah Produk' ?>
        </a>
    </nav>

    <form action="<?= isset($product) ? site_url('/update/' . $product['id']) : site_url('/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="container mt-5">

            <!-- First Row: Kategori and Nama Barang -->
            <div class="row mb-3">
                <div class="col-4">
                    <label for="category_id" class="mb-1">Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= isset($product) && $product['category_id'] == $category['id'] ? 'selected' : (old('category_id') == $category['id'] ? 'selected' : '') ?>>
                                <?= $category['nama_kategori'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?= isset($validation) && $validation->getError('category_id') ? '<div class="error text-danger">' . $validation->getError('category_id') . '</div>' : '' ?>
                </div>

                <div class="col-8">
                    <label for="product_name" class="mb-1">Nama Produk</label>
                    <input type="text" name="product_name" value="<?= isset($product) ? $product['product_name'] : old('product_name') ?>" class="form-control" required>
                    <?= isset($validation) && $validation->getError('product_name') ? '<div class="error text-danger">' . $validation->getError('product_name') . '</div>' : '' ?>
                </div>
            </div>

            <!-- Second Row: Harga Beli, Harga Jual, and Stok -->
            <div class="row mb-3">
                <div class="col-4">
                    <label for="harga_beli" class="mb-1">Harga Beli</label>
                    <input type="number" name="harga_beli" id="harga_beli" value="<?= isset($product) ? $product['harga_beli'] : old('harga_beli') ?>" class="form-control" oninput="updateHargaBeli()" required >
                </div>

                <div class="col-4">
                    <label for="harga_jual" class="mb-1">Harga Jual</label>
                    <input type="number" name="harga_jual" id="harga_jual" value="<?= isset($product) ? $product['harga_jual'] : old('harga_jual') ?>" class="form-control" readonly>
                </div>

                <div class="col-4">
                    <label for="stok" class="mb-1">Stok</label>
                    <input type="number" name="stok" value="<?= isset($product) ? $product['stok'] : old('stok') ?>" class="form-control" required>
                </div>
            </div>

            <!-- Third Row: Image Upload -->
            <div class="row mb-3">
                <div class="col-12">
                    <label for="product_image" class="mb-1">Gambar Produk</label>
                    <input type="file" name="product_image" class="form-control">
                    <?php if (isset($product) && $product['product_image']): ?>
                        <img src="<?= base_url($product['product_image']) ?>" alt="Product Image" class="img-thumbnail mt-2" width="100">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col-12 text-end">
                    <a href="<?= site_url('/dashboard') ?>" class="btn btn-outline-primary">Batalkan</a>
                    <button type="submit" class="btn btn-primary"><?= isset($product) ? 'Update Produk' : 'Buat Produk' ?></button>
                </div>
            </div>
        </div>
    </form>

</div>
<script>
    function updateHargaBeli() {
        var hargaJual = document.getElementById('harga_beli').value;
        var hargaBeli = document.getElementById('harga_jual');
        var hargaJualInt = parseInt(hargaJual, 10);
        if (hargaJual && !isNaN(hargaJual)) {
            // hargaBeli.value = (hargaJual * 0.30).toFixed(0) + hargaJualInt; 
            var calculatedHargaBeli = (hargaJualInt * 0.30) + hargaJualInt;
        
        // Update the Harga Beli value with the calculated value
        hargaBeli.value = Math.round(calculatedHargaBeli); 
        } else {
            hargaBeli.value = 0;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        updateHargaBeli(); 
    });
</script>
<?= $this->endSection() ?>


