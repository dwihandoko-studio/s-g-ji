<!DOCTYPE html>
<html>

<head>
    <!-- <meta http-equiv="refresh" content="2" /> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="" name="description" />
    <meta name="author" content="BJ-Hands (handokowae.my.id)">

    <meta property="og:title" content="SI-UTPG DISDIKBUD KAB. LAMPUNG TENGAH" />
    <meta property="og:url" content="https://si-utpg.lampungtengahkab.go.id" />
    <meta property="og:image" content="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/android-icon-192x192.png" />
    <meta property="og:description" content="Aplikasi untuk pengusulan Tunjangan Profesi Guru." />

    <meta itemprop="name" content="SI-UTPG DISDIKBUD KAB. LAMPUNG TENGAH" />
    <meta itemprop="description" content="Aplikasi untuk pengusulan Tunjangan Profesi Guru." />
    <meta itemprop="image" content="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/android-icon-192x192.png" />

    <link rel="apple-touch-icon" sizes="57x57" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/favicon-16x16.png">
    <link rel="manifest" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="https://si-utpg.disdikbud.lampungtengahkab.go.id/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title>Import Data PTK || DISDIKBUD Kab. Lampung Tengah</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
    <!-- Page plugins -->
    <link rel="stylesheet" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/sweetalert2/dist/sweetalert2.min.css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/css/dashboard.css" type="text/css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/DataTables/datatables.css" type="text/css">
    <script>
        const BASE_URL = 'https://si-utpg.disdikbud.lampungtengahkab.go.id';
    </script>
    <link rel="stylesheet" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/sweetalert2/dist/sweetalert2.min.css">
    <style>
        .preview-image-upload {
            position: relative;
        }

        .preview-image-upload .imagePreviewUpload {
            max-width: 300px;
            max-height: 300px;
            cursor: pointer;
        }

        .preview-image-upload .btn-remove-preview-image {
            display: none;
            position: absolute;
            top: 5px;
            left: 5px;
            /*top: 50%;*/
            /*left: 50%;*/
            /*transform: translate(-50%, -50%);*/
            /*-ms-transform: translate(-50%, -50%);*/
            background-color: #555;
            color: white;
            font-size: 16px;
            padding: 5px 10px;
            border: none;
            /*cursor: pointer;*/
            border-radius: 5px;
        }

        .imagePreviewUpload:hover+.btn-remove-preview-image,
        .btn-remove-preview-image:hover {
            display: block;
        }

        /*.imagePreviewUpload .btn-remove-preview-image:hover {*/

        /*    background-color: black;*/
        /*}*/
    </style>
    <!-- Anti-flicker snippet (recommended) 
<style>.async-hide { opacity: 0 !important} </style>
<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
})(window,document.documentElement,'async-hide','dataLayer',4000,
{'GTM-K9BGS8K':true});</script>
<!-- Analytics-Optimize Snippet
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-46172202-22', 'auto', {allowLinker: true});
ga('set', 'anonymizeIp', true);
ga('require', 'GTM-K9BGS8K');
ga('require', 'displayfeatures');
ga('require', 'linker');
ga('linker:autoLink', ["2checkout.com","avangate.com"]);
</script>
<!-- end Analytics-Optimize Snippet -->

    <!-- Google Tag Manager
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NKDMSK6');</script>
<!-- End Google Tag Manager -->
</head>


<body class="bg-white loading-logout">
    <!-- Google Tag Manager (noscript)
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- Sidenav -->
    <!-- Main content -->
    <!--<div class="main-content">-->
    <!-- Start Main Menu -->
    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header  d-flex  align-items-center">
                <a class="navbar-brand" href="#">
                    <h2>SI-UTPG</h2>
                    <!--<img src="https://si-utpg.disdikbud.lampungtengahkab.go.id/assets/img/brand/dark.svg" height="40" class="navbar-brand-img" alt="...">-->
                </a>
                <div class=" ml-auto ">
                    <!-- Sidenav toggler -->
                    <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/home" role="button" aria-expanded="true">
                                <i class="fa fa-home text-primary"></i>
                                <span class="nav-link-text">Beranda</span>
                            </a>
                        </li>
                        <hr class="my-2">
                        <h6 class="navbar-heading pl-4 text-muted">
                            <span class="docs-normal">Master Data</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/sekolah">
                                <i class="ni ni-building"></i>
                                <span class="nav-link-text">Sekolah</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" style="color: #00BCD4 !important" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/ptk">
                                <i class="ni ni-badge"></i>
                                <span class="nav-link-text">PTK</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/tahuntw">
                                <i class="ni ni-support-16"></i>
                                <span class="nav-link-text">Tahun Triwulan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/gaji">
                                <i class="ni ni-money-coins"></i>
                                <span class="nav-link-text">Referensi Gaji</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/role">
                                <i class="ni ni-atom"></i>
                                <span class="nav-link-text">Role</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#navbar-masterdata-setting" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-usulan-tpg">
                                <i class="ni ni-settings"></i>
                                <span class="nav-link-text">Setting</span>
                            </a>
                            <div class="collapse" id="navbar-masterdata-setting">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/setting/roleaccess">
                                            <span class="sidenav-mini-icon"> R </span>
                                            <span class="sidenav-normal"> Role Akses </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/setting/sptjm">
                                            <span class="sidenav-mini-icon"> S </span>
                                            <span class="sidenav-normal"> SPTJM </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/setting/maintenance">
                                            <span class="sidenav-mini-icon"> MT </span>
                                            <span class="sidenav-normal"> Maintenance </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/pengguna">
                                <i class="ni ni-single-02"></i>
                                <span class="nav-link-text">Pengguna</span>
                            </a>
                        </li>

                        <hr class="my-2">
                        <h6 class="navbar-heading pl-4 text-muted">
                            <span class="docs-normal">USULAN</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#navbar-usulan-tpg" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-usulan-tpg">
                                <i class="ni ni-tag"></i>
                                <span class="nav-link-text">TPG</span>
                            </a>
                            <div class="collapse" id="navbar-usulan-tpg">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/usulan/tpg/antrian">
                                            <span class="sidenav-mini-icon"> A </span>
                                            <span class="sidenav-normal"> Antrian </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/usulan/tpg/ditolak">
                                            <span class="sidenav-mini-icon"> T </span>
                                            <span class="sidenav-normal"> Ditolak </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/usulan/tpg/disetujui">
                                            <span class="sidenav-mini-icon"> LV </span>
                                            <span class="sidenav-normal"> Lolos Verifikasi </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/usulan/tpg/siapsk">
                                            <span class="sidenav-mini-icon"> SK </span>
                                            <span class="sidenav-normal"> Siap SK </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/usulan/tpg/terbitsk">
                                            <span class="sidenav-mini-icon"> ST </span>
                                            <span class="sidenav-normal"> SK Terbit </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/usulan/tpg/prosestransfer">
                                            <span class="sidenav-mini-icon"> PT </span>
                                            <span class="sidenav-normal"> Proses Transfer </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#navbar-usulan-tamsil" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-usulan-tamsil">
                                <i class="ni ni-bag-17"></i>
                                <span class="nav-link-text">TAMSIL</span>
                            </a>
                            <div class="collapse" id="navbar-usulan-tamsil">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/usulan/tamsil/antrian">
                                            <span class="sidenav-mini-icon"> A </span>
                                            <span class="sidenav-normal"> Antrian </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/usulan/tamsil/ditolak">
                                            <span class="sidenav-mini-icon"> T </span>
                                            <span class="sidenav-normal"> Ditolak </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/usulan/tamsil/disetujui">
                                            <span class="sidenav-mini-icon"> S </span>
                                            <span class="sidenav-normal"> Disetujui </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/usulan/tamsil/prosestransfer">
                                            <span class="sidenav-mini-icon"> PT </span>
                                            <span class="sidenav-normal"> Proses Transfer </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <hr class="my-2">
                        <h6 class="navbar-heading pl-4 text-muted">
                            <span class="docs-normal">SPJ</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#navbar-spj-tpg" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-spj-tpg">
                                <i class="ni ni-tag"></i>
                                <span class="nav-link-text">TPG</span>
                            </a>
                            <div class="collapse" id="navbar-spj-tpg">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/spj/tpg/antrian">
                                            <span class="sidenav-mini-icon"> A </span>
                                            <span class="sidenav-normal"> Antrian </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/spj/tpg/belum">
                                            <span class="sidenav-mini-icon"> B </span>
                                            <span class="sidenav-normal"> Belum Upload </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/spj/tpg/ditolak">
                                            <span class="sidenav-mini-icon"> T </span>
                                            <span class="sidenav-normal"> Ditolak Upload </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/spj/tpg/disetujui">
                                            <span class="sidenav-mini-icon"> LV </span>
                                            <span class="sidenav-normal"> Lolos Verifikasi </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#navbar-spj-tamsil" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-spj-tamsil">
                                <i class="ni ni-bag-17"></i>
                                <span class="nav-link-text">TAMSIL</span>
                            </a>
                            <div class="collapse" id="navbar-spj-tamsil">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/spj/tamsil/antrian">
                                            <span class="sidenav-mini-icon"> A </span>
                                            <span class="sidenav-normal"> Antrian </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/spj/tamsil/belum">
                                            <span class="sidenav-mini-icon"> B </span>
                                            <span class="sidenav-normal"> Belum Upload </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/spj/tamsil/ditolak">
                                            <span class="sidenav-mini-icon"> T </span>
                                            <span class="sidenav-normal"> Ditolak Upload </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/spj/tamsil/disetujui">
                                            <span class="sidenav-mini-icon"> S </span>
                                            <span class="sidenav-normal"> Disetujui </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <hr class="my-2">
                        <h6 class="navbar-heading pl-4 text-muted">
                            <span class="docs-normal">UPLOAD</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#navbar-upload-tpg" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-upload-tpg">
                                <i class="ni ni-ungroup"></i>
                                <span class="nav-link-text">TPG</span>
                            </a>
                            <div class="collapse" id="navbar-upload-tpg">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/upload/tpg/matching">
                                            <span class="sidenav-mini-icon"> M </span>
                                            <span class="sidenav-normal"> Matching Simtun </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/upload/tpg/terbitsk">
                                            <span class="sidenav-mini-icon"> T </span>
                                            <span class="sidenav-normal"> Terbit SK </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/upload/tpg/prosestransfer">
                                            <span class="sidenav-mini-icon"> T </span>
                                            <span class="sidenav-normal"> Proses Transfer </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/upload/tpg/transfer2">
                                            <span class="sidenav-mini-icon"> W </span>
                                            <span class="sidenav-normal"> Transfer Tw 2/4 </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#navbar-upload-tamsil" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-upload-tamsil">
                                <i class="ni ni-bag-17"></i>
                                <span class="nav-link-text">TAMSIL</span>
                            </a>
                            <div class="collapse" id="navbar-upload-tamsil">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/upload/tamsil/prosestransfer">
                                            <span class="sidenav-mini-icon"> T </span>
                                            <span class="sidenav-normal"> Proses Transfer </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/upload/tamsil/transfer2">
                                            <span class="sidenav-mini-icon"> T </span>
                                            <span class="sidenav-normal"> Transfer TW 2/4 </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <hr class="my-2">
                        <h6 class="navbar-heading pl-4 text-muted">
                            <span class="docs-normal">INFORMASI</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/informasi/popup">
                                <i class="ni ni-single-02"></i>
                                <span class="nav-link-text">Informasi Popup</span>
                            </a>
                        </li>
                    </ul>






                </div>
            </div>
        </div>
    </nav> <!-- End Main Menu -->

    <!--<div class="main-content" id="panel">-->
    <!-- Start Top Navbar -->
    <!-- End Top Navbar -->
    <!-- Page content -->

    <!--<body>-->
    <!-- Main content -->
    <div class="main-content content-loading" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center  ml-md-auto ">
                        <li class="nav-item d-xl-none">
                            <!-- Sidenav toggler -->
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image placeholder" src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/placeholder.png" width="36px" height="36px">
                                    </span>
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">BEJO DWI HANDOKO</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right ">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Selamat Datang!</h6>
                                </div>
                                <a href="#!" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>Profil Saya</span>
                                </a>
                                <!-- <a href="#!" class="dropdown-item">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <span>Settings</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ni ni-calendar-grid-58"></i>
                                    <span>Activity</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ni ni-support-16"></i>
                                    <span>Support</span>
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a href="javascript:;" class="dropdown-item tombol-logout">
                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <!--<ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">-->

                    <!--</ul>-->
                </div>
            </div>
        </nav> <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/home"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Import Data PTK</li>
                                </ol>
                            </nav>
                        </div>
                        <!--<div class="col-lg-6 col-5 text-right">-->
                        <!--    <a href="javascript:;" class="btn btn-sm btn-neutral button-add-data">Tambah Instansi</a>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                <!-- Light table -->
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header border-0 mb--5">
                            <h3 class="mb-0">Import Data PTK</h3>
                            <br>
                        </div>
                        <hr>
                        <div class="card-body mt--4">
                            <section>
                                <form id="formAdd" method="post" enctype="multipart/form-data">
                                    <div class="content-loaded">
                                        <h6 class="text-uppercase text-muted ls-1 mb-1">IMPORT DATA</h6>
                                        <div class="row clearfix">

                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label for="nama" class="form-control-label">File</label>
                                                    <input type="file" class="form-control" name="file" id="file" accept=".xls, .xlsx" onchange="loadFileXl(this, 'lampiran-import');" required />
                                                    <div class="invalid-feedback lampiran-import">File tidak boleh kosong.</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4" style="float: right; margin-top: 30px;">
                                                <div class="form-group" style="float: right;">
                                                    <button type="button" class="btn btn-success pull-right simpan-add" id="simpan-add" name="simpan-add" style="min-width: 200px;">IMPORT</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">

                                        <div class="col-lg-12" style="float: left;">
                                            <div><progress id="progressBar" value="0" max="100" style="width:100%; display: none;"></progress></div>
                                            <div>
                                                <h3 id="status" style="font-size: 15px; margin: 8px auto;"></h3>
                                            </div>
                                            <div>
                                                <p id="loaded_n_total" style="margin-bottom: 0px;"></p>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="contentModal" tabindex="-1" role="dialog" aria-labelledby="contentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content modal-content-loading">
                        <div class="modal-header">
                            <h5 class="modal-title" id="contentModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="contentBodyModal">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--</div>-->

    <!-- Start Footer -->
    <!-- End Footer -->

    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/js-cookie/js.cookie.js"></script>
    <script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <!-- Argon JS -->
    <script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/js/dashboard.js?v=1.2.0"></script>
    <!-- Demo JS - remove this in your project -->
    <script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/js/demo.min.js"></script>
    <!-- DataTables -->
    <!--<script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/DataTables/datatables.js"></script>-->
    <script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/js/jquery-block-ui.js"></script>
    <!--<script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/assets/js/ckeditor5/build/build/ckeditor.js"></script>-->
    <script src="https://si-utpg.disdikbud.lampungtengahkab.go.id/new-assets/assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>

    <script>
        function changeValidation(event) {
            $('.' + event).css('display', 'none');
        };

        function inputFocus(id) {
            $(id).removeAttr('style');
        }

        function inputChange(event) {
            console.log(event.value);
            if (event.value === null || (event.value.length > 0 && event.value !== "")) {
                $(event).removeAttr('style');
            } else {
                $(event).css("color", "#dc3545");
                $(event).css("border-color", "#dc3545");
                // $('.nama_instansi').html('<ul role="alert" style="color: #dc3545;"><li style="color: #dc3545;">Isian tidak boleh kosong.</li></ul>');
            }
        }

        function ambilId(id) {
            return document.getElementById(id);
        }

        let editor;

        function loadFileXl(fil, event) {
            const input = document.getElementsByName('file')[0];
            if (input.files && input.files[0]) {
                var file = input.files[0];

                // allowed MIME types
                var mime_types = ['application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

                if (mime_types.indexOf(file.type) == -1) {
                    input.value = "";
                    Swal.fire(
                        'Warning!!!',
                        "Hanya file berekstensi .xls atau .xlsx yang diizinkan.",
                        'warning'
                    );
                    return;
                }

                // console.log(file.size);

                // validate file size
                if (file.size > 1 * 2048 * 1000) {
                    input.value = "";
                    Swal.fire(
                        'Warning!!!',
                        "Ukuran file tidak boleh lebih dari 2 Mb.",
                        'warning'
                    );
                    return;
                }

                $('.' + event).css('display', 'none');
            } else {
                console.log("failed Load");
            }
        }

        $('#contentModal').on('click', '.btn-remove-preview-image', function(event) {
            $('.imagePreviewUpload').removeAttr('src');
            document.getElementsByName("_file")[0].value = "";
        });

        $(document).ready(function() {

            $('#simpan-add').on('click', function(e) {
                e.preventDefault();
                const fileName = document.getElementsByName('file')[0].value;
                // const tanggal = document.getElementsByName('tanggal_kasus')[0].value;

                // if(tanggal === "") {
                //     $( "input#tanggal_kasus" ).css("color", "#dc3545");
                //     $( "input#tanggal_kasus" ).css("border-color", "#dc3545");
                //     $('.tanggal_kasus').html('<ul role="alert" style="color: #dc3545;"><li style="color: #dc3545;">Isian tidak boleh kosong.</li></ul>');
                //     return;
                // }

                if (fileName === "") {
                    $("input#file").css("color", "#dc3545");
                    $("input#file").css("border-color", "#dc3545");
                    $('.file').html('<ul role="alert" style="color: #dc3545;"><li style="color: #dc3545;">Isian tidak boleh kosong.</li></ul>');
                }

                if (fileName === "") {
                    swal.fire(
                        'Gagal!',
                        "Isian tidak boleh kosong.",
                        'warning'
                    );
                } else {
                    const formUpload = new FormData();
                    const file = document.getElementsByName('file')[0].files[0];
                    formUpload.append('file', file);
                    // formUpload.append('tanggal', tanggal);

                    $.ajax({
                        xhr: function() {
                            let xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    ambilId("loaded_n_total").innerHTML = "Uploaded " + evt.loaded + " bytes of " + evt.total;
                                    let percent = (evt.loaded / evt.total) * 100;
                                    ambilId("progressBar").value = Math.round(percent);
                                    ambilId("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
                                }
                            }, false);
                            return xhr;
                        },
                        url: "./uploadData",
                        type: 'POST',
                        data: formUpload,
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'JSON',
                        beforeSend: function() {

                            ambilId("progressBar").style.display = "block";
                            $('.simpan-add').attr('disabled', 'disabled');
                            ambilId("status").innerHTML = "Mulai mengupload . . .";
                            ambilId("status").style.color = "blue"; //#858585
                            ambilId("progressBar").value = 0;
                            ambilId("loaded_n_total").innerHTML = "";
                            $('div.content-loading').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });
                        },
                        success: function(data) {
                            $('div.content-loading').unblock();

                            $('div.content-loaded').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });

                            if (data.success) {
                                ambilId("status").innerHTML = "Menyimpan Data . . .";
                                console.log(data.data);
                                console.log(data.data.length);

                                let sendToServer = function(lines, index) {
                                    if (index > lines.length - 1) {
                                        $('div.content-loaded').unblock();
                                        ambilId("progressBar").style.display = "none";
                                        ambilId("status").innerHTML = "Data berhasil diimport semua.";
                                        ambilId("status").style.color = "green";
                                        ambilId("progressBar").value = 0;

                                        Swal.fire(
                                            'SELAMAT!',
                                            "Data berhasil diimport semua.",
                                            'success'
                                        ).then((valRes) => {
                                            // document.location.href = "http://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/ptk/import";
                                            document.location.href = window.location.href;
                                        })
                                        return; // guard condition
                                    }

                                    item = lines[index];
                                    let total = ((index + 1) / lines.length) * 100;
                                    total = total.toFixed(2);

                                    $.ajax({
                                        url: "./importData",
                                        type: 'POST',
                                        data: {
                                            fullname: item.fullname,
                                            email: item.email,
                                            kecamatan: item.kecamatan,
                                            sekolah: item.sekolah,
                                            npsn: item.npsn,
                                            kode_kecamatan: item.kode_kecamatan,
                                            koreg: item.koreg
                                        },
                                        success: function(resMsg) {
                                            const msg = JSON.parse(resMsg);
                                            if (msg.code != 200) {

                                                ambilId("status").style.color = "blue";
                                                ambilId("progressBar").value = total;
                                                ambilId("loaded_n_total").innerHTML = total + '%';
                                                // $('#hidden_field_failed').val(totalFailed+1);
                                                console.log(msg.message);
                                                if (index + 1 === lines.length) {

                                                    $('div.content-loaded').unblock();
                                                    ambilId("progressBar").style.display = "none";
                                                    ambilId("status").innerHTML = msg.message;
                                                    ambilId("status").style.color = "green";
                                                    ambilId("progressBar").value = 0;

                                                    Swal.fire(
                                                        'SELAMAT!',
                                                        msg.message,
                                                        'success'
                                                    ).then((valRes) => {
                                                        // document.location.href = "http://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/ptk/import";
                                                        document.location.href = window.location.href;
                                                    })
                                                }
                                            } else {
                                                // ambilId("status").innerHTML = data.error;

                                                ambilId("status").style.color = "blue";
                                                ambilId("progressBar").value = total;
                                                ambilId("loaded_n_total").innerHTML = total + '%';
                                                // $('.simpan-add').attr('disabled', false);

                                                // Swal.fire(
                                                //     'Failed!',
                                                //     data.error,
                                                //     'warning'
                                                // );



                                                // $('.progress-bar').css('width', total + '%');
                                                // $('.progress-bar').html(total + '%');
                                                if (index + 1 === lines.length) {
                                                    $('div.content-loaded').unblock();
                                                    ambilId("progressBar").style.display = "none";
                                                    ambilId("status").innerHTML = msg.message;
                                                    ambilId("status").style.color = "green";
                                                    ambilId("progressBar").value = 0;

                                                    Swal.fire(
                                                        'SELAMAT!',
                                                        msg.message,
                                                        'success'
                                                    ).then((valRes) => {
                                                        // document.location.href = "http://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/ptk/import";
                                                        document.location.href = window.location.href;
                                                    })





                                                    // $('#process').css('display', 'none');
                                                    // $('.progress-bar').css('width', '0%');
                                                    // $('.progress-bar').html("0%");
                                                    // $('#simpan-data').attr('disabled', false);
                                                    // $('div.content-import-data').unblock();
                                                    // Swal.fire({
                                                    //     icon: 'success',
                                                    //     title: msg.message,
                                                    //     showConfirmButton: false,
                                                    //     timer: 2000,
                                                    // }).then((valRes) => {
                                                    //     document.location.href = msg.url;
                                                    // })
                                                }
                                            }

                                            setTimeout(
                                                function() {
                                                    sendToServer(lines, index + 1);
                                                },
                                                350 // delay in ms
                                            );
                                        },
                                        error: function(error) {
                                            $('div.content-loaded').unblock();
                                            ambilId("progressBar").style.display = "none";
                                            ambilId("status").innerHTML = msg.message;
                                            ambilId("status").style.color = "green";
                                            ambilId("progressBar").value = 0;
                                            $('.simpan-add').attr('disabled', false);
                                            Swal.fire(
                                                'Failed!',
                                                "Gagal.",
                                                'warning'
                                            );
                                        }
                                    });
                                };

                                sendToServer(data.data, 0);

                            }

                            if (data.error) {
                                ambilId("progressBar").style.display = "none";
                                ambilId("status").innerHTML = data.error;
                                ambilId("status").style.color = "red";
                                ambilId("progressBar").value = 0;
                                ambilId("loaded_n_total").innerHTML = "";
                                $('.simpan-add').attr('disabled', false);
                                $('div.content-loading').unblock();

                                Swal.fire(
                                    'Failed!',
                                    data.error,
                                    'warning'
                                );

                                // Swal.fire({
                                //     icon: 'warning',
                                //     title: data.error,
                                //     showConfirmButton: false,
                                //     timer: 2000
                                // })

                                // $('#process').css('display', 'none');
                                // $('.progress-bar').css('width', '0%');
                                // $('.progress-bar').html("0%");
                                // $('#simpan-data').attr('disabled', false);
                                // $('div.content-import-data').unblock();
                            }







                            // const resul = JSON.parse(resMsg);

                            // if(resul.code !== 200) {
                            //     ambilId("status").innerHTML = resul.message;
                            //     ambilId("status").style.color = "red";
                            //     ambilId("progressBar").value = 0;
                            //     ambilId("loaded_n_total").innerHTML = "";
                            //     $('.simpan-add').attr('disabled', false);

                            //     Swal.fire(
                            //         'Failed!',
                            //         resul.message,
                            //         'warning'
                            //     );
                            // } else {
                            //     ambilId("status").innerHTML = resul.message;
                            //     ambilId("status").style.color = "green";
                            //     ambilId("progressBar").value = 100;

                            //     Swal.fire(
                            //         'SELAMAT!',
                            //         resul.message,
                            //         'success'
                            //     ).then((valRes) => {
                            //         // document.location.href = "http://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/ptk/import";
                            //         document.location.href = "https://si-utpg.disdikbud.lampungtengahkab.go.id/v1/superadmin/masterdata/ptk";
                            //     })
                            // }
                        },
                        error: function() {
                            ambilId("progressBar").style.display = "none";
                            ambilId("status").innerHTML = "Upload Failed";
                            ambilId("status").style.color = "red"; //#858585
                            $('.simpan-add').attr('disabled', false);
                            $('div.content-loading').unblock();
                            Swal.fire(
                                'Failed!',
                                "Trafik sedang penuh, silahkan ulangi beberapa saat lagi.",
                                'warning'
                            );
                        }
                    });
                }
            });
        });
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script> -->
    <!-- Reload otomatis -->
    <script>
        $('.tombol-logout').on('click', function(e) {
            e.preventDefault();
            const href = BASE_URL + "/auth/logout";
            Swal.fire({
                title: 'Apakah anda yakin ingin keluar?',
                text: "Dari Aplikasi ini",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Sign Out!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: href,
                        type: 'GET',
                        // data: aform,
                        contentType: false,
                        cache: false,
                        // processData: false,
                        beforeSend: function() {
                            $('body.loading-logout').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });
                        },
                        success: function(resMsg) {
                            Swal.fire(
                                'Berhasil!',
                                "Anda berhasil logout.",
                                'success'
                            ).then((valRes) => {
                                // window.open(msg.data, '_blank').focus();
                                document.location.href = BASE_URL + "/auth";
                            })
                        },
                        error: function() {
                            $('body.loading-logout').unblock();
                            Swal.fire(
                                'Gagal!',
                                "Trafik sedang penuh, silahkan ulangi beberapa saat lagi.",
                                'warning'
                            );
                        }
                    })
                    // 			document.location.href = href;
                }
            })
        });
    </script>

</body>

</html>
<!--<script type="text/javascript">
    // $(document).ready(function() {
    //     $('#table_id').DataTable();
    // });
</script>-->