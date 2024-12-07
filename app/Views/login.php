<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<style>
    .login-container {
        display: grid;
        grid-template-columns: 50% 50%;
        height: 100vh;
        width: 100vw;
    }

    .vertical-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo-container {
        background-color: #f13b2f;
    }

    .logo-container img {
        max-width: 400px;
    }

    .btn-primary {
        background-color: #003489;
        border: #003489;
    }

    a {
        color: #003489;
    }

    @media (max-width: 575.98px) {
        .login-container {
            grid-template-columns: 100%;
        }

        .logo-container {
            display: none;
        }
    }
</style>

<body>
    <div class="login-container">
        <div class=" vertical-center text-center">
            <div class="container">
                <div class="row">


                    <div class="col-md-6 offset-md-3">


                        <form action="<?= site_url('/login') ?>" method="post">
                            <?= csrf_field() ?>
                            <h1 class="h3 mb-4 fw-normal">
                                <i class="fa fa-bag-shopping text-danger"></i> SIMS Web App
                            </h1>

                            <h1 class="h3 mb-3 fw-normal">Masuk Atau Buat Akun Untuk Memulai</h1>
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success">
                                    <?= session()->getFlashdata('message') ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($validation)): ?>
                                <div style="color: red;">
                                    <?= \Config\Services::validation()->listErrors() ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control" id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="floatingInput">Masukkan Email Anda</label>
                            </div>
                            <div class="form-floating mt-3 mb-3">
                                <input type="password" name="password" class="form-control" id="floatingPassword"
                                    placeholder="Password">
                                <label for="floatingPassword">Masukkan Password Anda</label>
                            </div>

                            <button class="w-100 btn btn-lg btn-danger" type="submit">Masuk</button>
                            <p class="mt-3 mb-1 text-muted">
                                <a id="forgot-password" href="<?= site_url('/register') ?>">Belum Punya Akun?</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="logo-container vertical-center">
            <img src="<?= base_url('assets/img/Frame 98699.png') ?>" alt="">
        </div>
    </div>


    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>