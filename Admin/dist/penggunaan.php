<?php
// Sertakan file koneksi database
include 'koneksi.php'; // Baris ini menghubungkan ke database

// Tangani permintaan insert
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'insert') {
    $bahan_baku_id = $_POST['ingredient']; // Ambil ID dari dropdown
    $jumlah = $_POST['jumlah'];
    $satuan = $_POST['satuan'];
    $tanggal_penggunaan = $_POST['tanggal_penggunaan'];

    // Ambil nama bahan berdasarkan ID
    $bahanQuery = "SELECT nama_bahan FROM bahan_baku WHERE id = '$bahan_baku_id'";
    $bahanResult = mysqli_query($koneksi, $bahanQuery);
    $bahan = mysqli_fetch_assoc($bahanResult);
    $nama_bahan = $bahan['nama_bahan']; // Set nama_bahan dari query

    // Validasi input
    if (empty($bahan_baku_id) || empty($jumlah) || empty($satuan) || empty($tanggal_penggunaan)) {
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi.']);
        exit;
    }

    // Cek apakah data sudah ada
    $checkQuery = "SELECT * FROM penggunaan WHERE bahan_baku_id = '$bahan_baku_id' AND tanggal_penggunaan = '$tanggal_penggunaan' AND nama_bahan = '$nama_bahan'";
    $checkResult = mysqli_query($koneksi, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['success' => false, 'message' => 'Data sudah ada.']);
        exit;
    }

    // Insert data
    $query = "INSERT INTO penggunaan (bahan_baku_id, nama_bahan, jumlah, satuan, tanggal_penggunaan) VALUES ('$bahan_baku_id', '$nama_bahan', '$jumlah', '$satuan', '$tanggal_penggunaan')";
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['success' => true, 'message' => 'Data berhasil ditambahkan.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan data.']);
    }
    exit; // Menghentikan eksekusi setelah menangani permintaan
}

// Tangani permintaan update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $nama_bahan = $_POST['nama_bahan'];
    $jumlah = $_POST['jumlah'];
    $satuan = $_POST['satuan'];
    $tanggal_penggunaan = $_POST['tanggal_penggunaan'];

    $query = "UPDATE penggunaan SET nama_bahan='$nama_bahan', jumlah='$jumlah', satuan='$satuan', tanggal_penggunaan='$tanggal_penggunaan' WHERE id='$id'";
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit; // Menghentikan eksekusi setelah menangani permintaan
}

// Tangani permintaan delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];

    $query = "DELETE FROM penggunaan WHERE id='$id'";
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit; // Menghentikan eksekusi setelah menangani permintaan
}

// Query untuk mengambil data dari tabel penggunaan
$usageQuery = "SELECT nama_bahan, jumlah, satuan, tanggal_penggunaan, id FROM penggunaan"; // Tambahkan id ke query
$usageResult = mysqli_query($koneksi, $usageQuery);

$usageData = []; // Array untuk menyimpan data penggunaan
while ($row = mysqli_fetch_assoc($usageResult)) {
    $usageData[] = [
        'id' => $row['id'], // Simpan ID untuk digunakan saat update dan delete
        'nama_bahan' => $row['nama_bahan'],
        'jumlah' => (int)$row['jumlah'],
        'satuan' => $row['satuan'],
        'tanggal_penggunaan' => $row['tanggal_penggunaan']
    ];
}

// Query untuk mengambil data dari tabel bahan_baku berdasarkan kategori
$categories = ['Bahan Dasar', 'Bumbu Dasar Seblak', 'Bumbu Penyedap', 'Bahan Topping', 'Bahan Pelengkap', 'Minyak dan Penggorengan', 'Air Kaldu', 'Penyajian dan Kemasan'];
$chartData = [];

foreach ($categories as $category) {
    $query = "SELECT nama_bahan, stok, satuan FROM bahan_baku WHERE kategori_id = (SELECT id FROM kategori WHERE nama_kategori = '$category')";
    $result = mysqli_query($koneksi, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [$row['nama_bahan'], (int)$row['stok'], $row['satuan']];
    }
    $chartData[$category] = $data; // Simpan data untuk setiap kategori
}
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Stexo - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">



    <!-- jquery.vectormap css -->

    <link rel="stylesheet" href="assets/libs/morris.js/morris.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/flot-charts/jquery.flot.js"></script>
    <script src="assets/libs/flot-charts/jquery.flot.pie.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <link rel="stylesheet" href="assets/libs/c3/c3.min.css">
    <script src="assets/libs/d3/d3.min.js"></script>
    <script src="assets/libs/c3/c3.min.js"></script>

    <style>
        .c3-label {
            fill: black !important; /* Mengubah warna teks label menjadi hitam */
        }
        .form-label {
            font-weight: bold; /* Make the label bold */
            color: #000; /* Ensure the label color is visible */
        }
    </style>

</head>

<body data-sidebar="dark">
    
<!-- <body data-layout="horizontal" data-topbar="dark"> -->

<!-- Begin page -->
<div id="layout-wrapper">

    
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="index.html" class="logo">
                        <span class="logo-light  fs-5 fw-semibold ">
                            <i class="mdi mdi-bowl"></i> Seblak Mutiara
                        </span>
                        <span class="logo-sm fs-2">
                            <i class="mdi mdi-camera-control"></i>
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i class="mdi mdi-menu"></i>
                </button>

                <!-- App Search-->
                <form role="search" class="app-search">
                    <div class="form-group mb-0 position-relative">
                        <input type="text" class="form-control" placeholder="Search..">
                        <span><i class="fa fa-search"></i></span>
                    </div>
                </form>
            </div>

            <div class="d-flex">

                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <i class="ri-search-line"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

                        <form class="p-3">
                            <div class="mb-3 m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown d-none d-sm-inline-block">
                    <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="assets/images/flags/us_flag.jpg" class="me-2" height="12" alt="Header Language"> English <span class="mdi mdi-chevron-down"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <span> French </span> <img src="assets/images/flags/french_flag.jpg" alt="" height="16" class="float-end" />
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <span> Spanish </span><img src="assets/images/flags/spain_flag.jpg" alt="" height="16" class="float-end" />
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <span> Russian </span><img src="assets/images/flags/russia_flag.jpg" alt="" height="16" class="float-end" />
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <span> German </span><img src="assets/images/flags/germany_flag.jpg" alt="" height="16" class="float-end" />
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <span> Italian </span><img src="assets/images/flags/italy_flag.jpg" alt="" height="16" class="float-end" />
                        </a>
                    </div>
                </div>

                <!-- light dark -->
                <button type="button" class="btn header-item fs-4 rounded-end-0" id="light-dark-mode">
                    <i class="fas fa-moon align-middle"></i>
                </button>

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-arrow-expand-all noti-icon"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-bell-outline noti-icon"></i>
                        <span class="badge rounded-pill text-bg-danger noti-dot">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0"> Notifications </h6>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            <a href="" class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-success rounded-circle">
                                            <i class="mdi mdi-cart-outline"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="mb-0"><b class="mb-1 ">Your order is placed</b></p>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="" class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-danger rounded-circle">
                                            <i class="mdi mdi-message-text-outline"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="mb-0"><b class="mb-1">New Message received</b></p>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">You have 87 unread messages</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="" class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-info rounded-circle">
                                            <i class="mdi mdi-filter-outline"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="mb-0"><b class="mb-1">Your item is shipped</b></p>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">It is a long established fact that a reader will</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="" class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-success rounded-circle">
                                            <i class="mdi mdi-message-text-outline"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="mb-0"><b class="mb-1">New Message received</b></p>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">You have 87 unread messages</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="" class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-warning rounded-circle">
                                            <i class="mdi mdi-cart-outline"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="mb-0"><b class="mb-1">Your order is placed</b></p>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="p-1">
                            <div class="d-grid">
                                <a href="javascript:void(0);" class="dropdown-item text-center notify-all text-primary">
                                    View all <i class="fi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown notification-list d-inline-block user-dropdown">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="assets/images/users/user-4.jpg" alt="Header Avatar">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                        <!-- item-->
                        <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle "></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-wallet"></i> My Wallet</a>
                        <a class="dropdown-item d-block" href="#"><span class="badge text-bg-success float-end mt-1">11</span><i class="mdi mdi-settings"></i>Settings</a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline"></i> Lock screen</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#"><i class="mdi mdi-power text-danger"></i> Logout</a>
                    </div>
                </div>

                <!-- <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="ri-settings-2-line"></i>
                    </button>
                </div> -->

            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>

                    <li>
                        <a href="index.php" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="bahan-baku.php" class="waves-effect">
                            <i class="mdi mdi-cube"></i><span> Bahan Baku </span>
                        </a>
                    </li>

                    <li>
                        <a href="pengadaan.php" class="waves-effect">
                            <i class="mdi mdi-cart-plus"></i><span> Pengadaan </span>
                        </a>
                    </li>

                    <li>
                        <a href="penggunaan.php" class="waves-effect">
                            <i class="mdi mdi-cart"></i><span> Penggunaan </span>
                        </a>
                    </li>

                    <li>
                        <a href="log-stok.html" class="waves-effect">
                            <i class="mdi mdi-archive"></i><span> Log Stok </span>
                        </a>
                    </li>

                    <li>
                        <a href="supplier.html" class="waves-effect">
                            <i class="mdi mdi-account-multiple"></i><span> Supplier </span>
                        </a>
                    </li>

                    <li>
                        <a href="laporan.html" class="waves-effect">
                            <i class="mdi mdi-file-document"></i><span> Laporan </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="mdi mdi-bell"></i><span> Notifikasi </span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->

    

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                   <!-- start page title -->
                   <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Penggunaan</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Add this section for inputting usage data -->
                <div class="container-fluid">
                    <h4 class="mb-sm-0">Catatan Penggunaan Bahan</h4>
                    <form id="usage-form" onsubmit="submitUsage(event)">
                        <div class="row">
                            <div class="col-md-4">
                                <select id="ingredient" class="form-control" required>
                                    <option value="" disabled selected>Pilih Bahan</option>
                                    <?php
                                    // Ambil data bahan dari database untuk dropdown
                                    $bahanQuery = "SELECT id, nama_bahan FROM bahan_baku"; // Ganti dengan query yang sesuai
                                    $bahanResult = mysqli_query($koneksi, $bahanQuery);
                                    while ($bahan = mysqli_fetch_assoc($bahanResult)) {
                                        echo '<option value="' . htmlspecialchars($bahan['id']) . '">' . htmlspecialchars($bahan['nama_bahan']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="number" id="amount" class="form-control" placeholder="Jumlah" required>
                                    <select id="unit" class="form-control" required>
                                        <option value="" disabled selected>Pilih Satuan</option>
                                        <option value="kg">Kg</option>
                                        <option value="pcs">Pcs</option>
                                        <option value="bungkus">Bungkus</option>
                                        <option value="liter">Liter</option>
                                        <option value="ml">Ml</option>
                                        <option value="sendok">Sendok</option>
                                        <option value="gelas">Gelas</option>
                                        <option value="kantong">Kantong</option>
                                        <option value="batang">Batang</option>
                                        <option value="lembar">Lembar</option>
                                        <option value="pak">Pak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="usage-date" class="form-control" required>
                            </div>
                        </div>
                        <input type="hidden" id="usage-id" />
                        <button type="submit" class="btn btn-primary mt-3" id="submit-button">Tambah Penggunaan</button>
                    </form>

                    <table class="table mt-4" id="usage-table">
                        <thead>
                            <tr>
                                <th>Bahan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usageData as $usage): ?>
                                <tr data-id="<?php echo $usage['id']; ?>">
                                    <td><?php echo htmlspecialchars($usage['nama_bahan']); ?></td>
                                    <td><?php echo htmlspecialchars($usage['jumlah']); ?></td>
                                    <td><?php echo htmlspecialchars($usage['satuan']); ?></td>
                                    <td><?php echo htmlspecialchars($usage['tanggal_penggunaan']); ?></td>
                                    <td>
                                        <button class="btn btn-warning" onclick="editUsage(this)">Edit</button>
                                        <button class="btn btn-danger" onclick="deleteUsage(this)">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>               
            </div>
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Seblak Nguawor.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Pedasnya bikin Mas Puad Nguakak Rek <i class="mdi mdi-heart text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/flot-charts/jquery.flot.js"></script>
<script src="assets/libs/flot-charts/jquery.flot.pie.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>

<script src="assets/libs/morris.js/morris.min.js"></script>

<script src="assets/libs/raphael/raphael.min.js"></script>

<script src="assets/js/pages/dashboard.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/flot-charts/jquery.flot.js"></script>
<script src="assets/libs/flot-charts/jquery.flot.pie.js"></script>
<script src="assets/js/app.js"></script>
<script>

</script>
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>

<script src="assets/libs/d3/d3.min.js"></script>
<script src="assets/libs/c3/c3.min.js"></script>

<script src="assets/js/app.js"></script>
<script>
    function formatRupiah(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        const formattedValue = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);
        input.value = formattedValue;
    }

    function addPengadaan(event) {
        event.preventDefault(); // Mencegah form dari pengiriman default

        // Ambil nilai dari form
        const itemSelect = document.getElementById('item');
        const item = itemSelect.options[itemSelect.selectedIndex].text; // Ambil teks dari dropdown
        const quantity = document.getElementById('quantity').value;
        const orderDate = document.getElementById('order-date').value;
        const totalCost = document.getElementById('total-cost').value;

        // Tambahkan baris baru ke tabel
        const table = document.getElementById('history-table').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();

        newRow.innerHTML = `
            <td>${item}</td>
            <td>${quantity}</td>
            <td>${orderDate}</td>
            <td>${totalCost}</td>
            <td>Diterima</td>
            <td>
                <button class="btn btn-warning" onclick="editRow(this)">Edit</button>
                <button class="btn btn-danger" onclick="deleteRow(this)">Hapus</button>
            </td>
        `;

        // Reset form setelah menambah data
        document.getElementById('pengadaan-form').reset();
    }

    function editRow(button) {
        const row = button.closest('tr');
        const item = row.cells[0].innerText;
        const quantity = row.cells[1].innerText;
        const orderDate = row.cells[2].innerText;
        const totalCost = row.cells[3].innerText.replace('Rp ', '').replace('.', ''); // Menghapus format Rupiah

        // Mengisi form dengan data yang ada di baris
        const itemSelect = document.getElementById('item');
        for (let i = 0; i < itemSelect.options.length; i++) {
            if (itemSelect.options[i].text === item) {
                itemSelect.selectedIndex = i; // Set index dropdown sesuai dengan item
                break;
            }
        }
        document.getElementById('quantity').value = quantity;
        document.getElementById('order-date').value = orderDate;
        document.getElementById('total-cost').value = totalCost;

        // Menghapus baris yang diedit
        row.remove();
    }

    function addUsage(event) {
        event.preventDefault(); // Prevent default form submission

        // Get the selected ingredient text
        const ingredientSelect = document.getElementById('ingredient');
        const ingredient = ingredientSelect.options[ingredientSelect.selectedIndex].text; // Get the text of the selected option
        const amount = document.getElementById('amount').value;
        const unit = document.getElementById('unit').value; // Get the selected unit
        const usageDate = document.getElementById('usage-date').value;

        const table = document.getElementById('usage-table').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();

        newRow.innerHTML = `
            <td>${ingredient}</td>
            <td>${amount} ${unit}</td> <!-- Display amount with unit -->
            <td>${usageDate}</td>
            <td>
                <button class="btn btn-warning" onclick="editUsage(this)">Edit</button>
                <button class="btn btn-danger" onclick="deleteUsage(this)">Hapus</button>
            </td>
        `;

        document.getElementById('usage-form').reset(); // Reset form after adding
    }

    function editUsage(button) {
        const row = button.closest('tr');
        const id = row.getAttribute('data-id'); // Ambil ID dari atribut data
        const ingredient = row.cells[0].innerText; // Ambil nama bahan
        const amount = row.cells[1].innerText;
        const unit = row.cells[2].innerText;
        const usageDate = row.cells[3].innerText;

        // Mengisi form dengan data yang ada di baris
        document.getElementById('amount').value = amount;
        document.getElementById('unit').value = unit;
        document.getElementById('usage-date').value = usageDate;

        // Set dropdown untuk nama bahan
        const ingredientSelect = document.getElementById('ingredient');
        ingredientSelect.value = row.getAttribute('data-id'); // Set value dropdown ke ID bahan

        // Menyimpan ID untuk digunakan saat update
        document.getElementById('usage-id').value = id; // Tambahkan input hidden untuk ID

        // Ubah teks tombol submit
        document.getElementById('submit-button').innerText = 'Update Penggunaan';
    }

    function submitUsage(event) {
        event.preventDefault(); // Mencegah form dari pengiriman default

        const id = document.getElementById('usage-id').value;
        const ingredient = document.getElementById('ingredient').value; // Ambil ID bahan baku
        const amount = document.getElementById('amount').value;
        const unit = document.getElementById('unit').value;
        const usageDate = document.getElementById('usage-date').value;

        // Ambil nama bahan berdasarkan ID
        const ingredientSelect = document.getElementById('ingredient');
        const selectedOption = ingredientSelect.options[ingredientSelect.selectedIndex];
        const nama_bahan = selectedOption ? selectedOption.text : ''; // Ambil nama bahan dari dropdown

        let action = 'insert'; // Default action untuk insert
        if (id) {
            action = 'update'; // Jika ID ada, berarti kita update
        }

        // Kirim permintaan ke server untuk menyimpan atau memperbarui data
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "", true); // Mengirim ke file yang sama
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('Data berhasil ' + (action === 'insert' ? 'ditambahkan.' : 'diperbarui.'));
                    location.reload(); // Reload halaman untuk memperbarui tabel
                } else {
                    alert('Gagal ' + (action === 'insert' ? 'menambahkan data.' : 'memperbarui data.') + ': ' + response.message);
                }
            } else {
                alert('Terjadi kesalahan saat menghubungi server. Silakan coba lagi.');
            }
        };
        xhr.send("action=" + action + "&id=" + id + "&ingredient=" + encodeURIComponent(ingredient) + "&jumlah=" + amount + "&satuan=" + encodeURIComponent(unit) + "&tanggal_penggunaan=" + usageDate + "&nama_bahan=" + encodeURIComponent(nama_bahan));
    }

    function deleteUsage(button) {
        const row = button.closest('tr');
        const id = row.getAttribute('data-id'); // Ambil ID dari atribut data

        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            // Kirim permintaan ke server untuk menghapus data
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); // Mengirim ke file yang sama
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        row.remove(); // Hapus baris dari tabel
                        alert('Data berhasil dihapus.');
                    } else {
                        alert('Gagal menghapus data.');
                    }
                }
            };
            xhr.send("action=delete&id=" + id); // Mengirim ID untuk dihapus
        }
    }
</script>
</body>

</html>