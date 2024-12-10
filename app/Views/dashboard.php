<?= $this->section('content') ?>

<div class="container mt-5">

    <nav class="breadcrumb" style="font-size:18px;">
        <a class="breadcrumb-item text-dark fw-bold" href="#">Daftar Produk</a>
    </nav>

    <div class="row mb-4">
        <!-- Flash Message -->
        <?php if (session()->getFlashdata('message')): ?>
            <div class="mb-3 alert alert-success alert-dismissible fade show" role="alert" id="flash-message">
                <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Search -->
        <div class="col-4">
            <form action="<?= site_url('/dashboard') ?>" method="get">
                <input type="text" class="form-control" name="search" value="<?= esc($searchTerm) ?>"
                    placeholder="Search...">
            </form>
        </div>

        <!-- Dropdown Kategori -->
        <div class="col-2">
            <form action="<?= site_url('/dashboard') ?>" method="get">
                <select class="form-select" name="category_id" onchange="this.form.submit()">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $categoryId ? 'selected' : '' ?>>
                            <?= esc($cat['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <!-- Export and Add Data Icons -->
        <div class="col-6 text-end">
            <a class="btn btn-success" href="<?= site_url('/export') ?>" target="_blank">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="<?= site_url('/create') ?>" class="btn btn-danger ms-3">
                <i class="fas fa-plus-circle"></i> Add Data
            </a>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Beli (Rp)</th>
                <th>Harga Jual (Rp)</th>
                <th>Stok</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 0; ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= ++$counter ?></td>
                    <td class="text-center">
    <img class="img-thumbnail" 
         src="<?= base_url($product['product_image'] ?: 'https://via.placeholder.com/100x100.png?text=No+Image') ?>" 
         alt="<?= esc($product['product_name']) ?>" 
         width="100">
</td>

                    <td><?= esc($product['product_name']) ?></td>
                    <td>Alat <?= esc($product['nama_kategori']) ?></td>
                    <td><?= esc(number_format($product['harga_beli'], 0, ',', ',')) ?></td>
                    <td><?= esc(number_format($product['harga_jual'], 0, ',', ',')) ?></td>
                    <td><?= esc($product['stok']) ?></td>
                    <td>
                        <a href="<?= site_url('/edit/' . $product['id']) ?>" class="text-primary" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="<?= site_url('/delete/' . $product['id']) ?>" class="ms-3 text-danger" title="Delete"
                            onclick="return confirm('Yakin akan menghapus produk <?= esc($product['product_name']) ?>')">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- TODO: I WANT THIS ALSO SHOW HOW MANY ITEMS ARE FETCHED FROM HOW MANY DATA>? -->
    <!-- Pagination Links --><!-- Show items count and total count -->
    <div class="d-flex justify-content-between mb-2">
        <span>Showing <?= $itemsOnCurrentPage ?> of <?= $totalItems ?> items</span>
    </div>
    <?= $pager->links('default', 'custom_pager') ?>

</div>

<?= $this->endSection() ?>