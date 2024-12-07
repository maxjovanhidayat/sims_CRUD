<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
</head>

<body>
    <div class="login-container">
        <div class=" vertical-center text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <!-- Display validation errors -->
                        <?php if (isset($validation)): ?>
                            <div style="color: red;">
                                <?= \Config\Services::validation()->listErrors() ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('/register') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <h1 class="h3 mb-4 fw-normal">
                                <i class="fa fa-bag-shopping text-danger"></i> SIMS Web App
                            </h1>

                            <h1 class="h3 mb-3 fw-normal">Daftar Akun</h1>

                            <!-- Name -->
                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name"
                                    value="<?= old('name') ?>" required>
                                <label for="name">Nama Lengkap</label>
                            </div>

                            <!-- Email -->
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="name@example.com" value="<?= old('email') ?>" required>
                                <label for="email">Email</label>
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-floating mb-3">
                                <input type="password" name="confirm_password" class="form-control"
                                    id="confirm_password" placeholder="Confirm Password" required>
                                <label for="confirm_password">Konfirmasi Password</label>
                            </div>

                            <!-- Position -->
                            <div class="form-floating mb-3">
                                <input type="text" name="position" class="form-control" id="position"
                                    placeholder="Position" value="<?= old('position') ?>" required>
                                <label for="position">Posisi</label>
                            </div>

                            <!-- Profile Image -->
                            <div class="mb-3">
                                <label for="image_profile" class="form-label">Gambar Profil</label>
                                <input type="file" name="image_profile" class="form-control" id="image_profile">
                            </div>

                            <button class="w-100 btn btn-lg btn-danger" type="submit">Daftar</button>

                            <p class="mt-3 mb-1 text-muted">
                                <a id="forgot-password" href="<?= site_url('/login') ?>">Sudah Punya Akun?</a>
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