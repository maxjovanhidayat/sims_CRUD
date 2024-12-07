<!-- app/Views/dashboard.php -->

<?= $this->section('content') ?>

<style>
    .image--cover {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin: 20px;

        object-fit: cover;
        object-position: center right;
    }
</style>

<div class="container mt-5">

    <nav class="breadcrumb" style="font-size:24px;">
        <a class="breadcrumb-item text-dark fw-bold" style="text-decoration:none;" href="#">Profil</a>
    </nav>

    <?php if (session()->get('user_id')): ?>
        <div class="row">
            <img src="<?= base_url($user['image_profile']) ?>" class="image--cover">
            <div class="col-md-12">
                <h3><?= esc($user['name']) ?></h3>
            </div>
            <div class="col-md-8">
                <label for="">Nama Kandidat</label>
                <input type="text" class="form-control" name="" id="" value="<?= esc($user['name'])?>"readonly>
            </div>
            <div class="col-md-4">
                <label for="">Posisi Kandidat</label>
                <input type="text" class="form-control" name="" id="" value="<?= esc($user['position'])?>"readonly>
            </div>
        </div>
    <?php else: ?>
        <p>You are not logged in.</p>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>