<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
    <meta name="description" content="Toko Buku KNTechline.">
    <meta name="author" content="BJ Hands - handokowae.my.id">
    <title><?= isset($title) ? $title : 'Toko Buku KNTechline' ?></title>
    <meta name="keywords" content="Toko Buku, Toko, Buku, KNT, KNTechline, kntechline, KNTECHLINE">
    <meta name="description" content="Toko Buku KNTechline.">
    <meta itemprop="name" content="Toko Buku KNTechline.">
    <meta itemprop="description" content="Toko Buku KNTechline.">

    <link type="text/css" href="<?= base_url('new-assets'); ?>/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('new-assets'); ?>/assets/vendor/nucleo/css/nucleo.css" type="text/css">
    <link type="text/css" href="<?= base_url('new-assets'); ?>/assets/vendor/prismjs/themes/prism.css" rel="stylesheet">
    <link type="text/css" href="<?= base_url('new-assets'); ?>/assets/front/css/front.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('new-assets'); ?>/assets/vendor/sweetalert2/dist/sweetalert2.min.css">

</head>

<body>
    <?= $this->include('templates/header-front'); ?>
    <main>
        <section class="section-header bg-primary text-white pb-9 pb-lg-13 mb-4 mb-lg-6">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 text-center">
                        <h1 class="display-2 mb-3">HUBUNGI KAMI<br /><?= $toko->nama_toko ?></h1>
                    </div>
                </div>
            </div>
            <div class="pattern bottom"></div>
        </section>
        <div class="section section-lg pt-0">
            <div class="container mt-n8 mt-lg-n13 z-2">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card border-light shadow-soft p-2 p-md-4 p-lg-5">
                            <div class="card-body">
                                <form action="<?= base_url('toko/about/post') ?>" method="post">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group"><label class="form-label text-dark" for="firstNameLabel">Nama Lengkap <span class="text-danger">*</span></label>
                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-alt"></i></span></div><input class="form-control" id="_fullname" name="_fullname" placeholder="Nama lengkap...." type="text" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group"><label class="form-label text-dark" for="EmailLabel">Email <span class="text-danger">*</span></label>
                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div><input class="form-control" id="_email" name="_email" placeholder="example@company.com" type="email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group"><label class="form-label text-dark" for="phonenumberLabel">No Telp.<span class="text-danger">*</span></label>
                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span></div><input class="form-control" id="_no_hp" name="_no_hp" placeholder="(555) 555-1234" type="number" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <div class="form-group"><label class="form-label text-dark" for="phonenumberLabel">How can we help you?<span class="text-danger">*</span></label> <textarea class="form-control" placeholder="Hi KNT, apa yang bisa kami bantu ..." id="_message" name="_message" rows="8" required></textarea></div>
                                            <div class="text-center"><button type="submit" class="btn btn-secondary mt-4 animate-up-2"><span class="mr-2"><i class="fas fa-paper-plane"></i></span>Send Message</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section section-lg pt-0 line-bottom-light">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 text-center px-4 mb-5 mb-lg-0">
                        <div class="icon icon-sm icon-shape icon-shape-primary rounded mb-4"><i class="fas fa-envelope-open-text"></i></div>
                        <h5 class="mb-3">Via Email</h5>
                        <a class="font-weight-bold text-primary" href="#"><?= $toko->email ?></a>
                    </div>
                    <div class="col-12 col-md-4 text-center px-4 mb-5 mb-lg-0">
                        <div class="icon icon-sm icon-shape icon-shape-primary rounded mb-4"><i class="fas fa-phone-volume"></i></div>
                        <h5 class="mb-3">Via Telp</h5>
                        <a class="font-weight-bold text-primary" href="#"><?= $toko->no_telp_toko ?></a>
                    </div>
                    <div class="col-12 col-md-4 text-center px-4">
                        <div class="icon icon-sm icon-shape icon-shape-primary rounded mb-4"><i class="fas fa-headset"></i></div>
                        <h5 class="mb-3">Alamat</h5>
                        <p><?= $toko->alamat_toko ?></p><a class="btn btn-sm btn-outline-primary" href="#">Kode Pos : <?= $toko->kode_pos ?></a>
                    </div>
                </div>
            </div>
        </div>
        <section class="section section-lg pb-5 bg-soft">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <?= $toko->lokasi_toko ?>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer section pt-6 pt-md-8 pt-lg-10 pb-3 bg-primary text-white overflow-hidden">
            <div class="pattern pattern-soft top"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0"><a class="footer-brand mr-lg-5 d-flex" href="<?= base_url() ?>"><img src="<?= base_url() ?>/assets/knt.png" height="35" class="mr-3" alt="Footer logo"></a>
                        <p class="my-4">Menyediakan berbagai koleksi jenis buku pendidikan, pantun dan cerita. Edisi rata-rata terbaru<br />Silahkan lihat-lihat di koleksi kami.</p>
                    </div>
                </div>
                <hr class="my-4 my-lg-5">
                <div class="row">
                    <div class="col pb-4 mb-md-0">
                        <div class="d-flex text-center justify-content-center align-items-center">
                            <p class="font-weight-normal mb-0">Copyright © <a href="https://handokowae.my.id" target="_blank">Handokowae</a> & <a href="https://kntechline.id">KNTECHLINE</a> <span class="current-year"></span>. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/headroom.js/dist/headroom.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/onscreen/dist/on-screen.umd.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/nouislider/distribute/nouislider.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/jarallax/dist/jarallax.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/countup.js/dist/countUp.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/jquery-countdown/dist/jquery.countdown.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/prismjs/prism.js"></script>
    <script async defer="defer" src="https://buttons.github.io/buttons.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/front/assets/js/front.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery-block-ui.js"></script>
    <script src="<?= base_url('new-assets'); ?>/assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script>
        function addToCard(event, id) {
            console.log(id);
        }
    </script>
</body>

</html>