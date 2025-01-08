<?php
// Sertakan file koneksi database
include 'koneksi.php'; // Baris ini menghubungkan ke database

// Fetch data from the pengadaan table with join to bahan_baku
$pengadaanData = [];
$query = "
    SELECT p.*, b.satuan 
    FROM pengadaan p
    JOIN bahan_baku b ON p.nama_bahan = b.nama_bahan"; // Pastikan kolom yang digunakan untuk join sesuai
$result = mysqli_query($koneksi, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $pengadaanData[] = $row;
}

// Ambil data dari tabel bahan_baku
$bahanBakuQuery = "SELECT nama_bahan, satuan FROM bahan_baku";
$bahanBakuResult = mysqli_query($koneksi, $bahanBakuQuery);
$bahanBakuData = [];
while ($bahan = mysqli_fetch_assoc($bahanBakuResult)) {
    $bahanBakuData[] = $bahan;
}

// Handle the POST request to insert data into the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];
    $satuan = $_POST['satuan'];
    $status = $_POST['status'];
    $orderDate = $_POST['orderDate'];
    $totalCost = $_POST['totalCost'];

    // Debugging: Tampilkan data yang diterima
    error_log("Item: $item, Quantity: $quantity, Satuan: $satuan, Status: $status, Order Date: $orderDate, Total Cost: $totalCost");

    // Ambil ID bahan baku berdasarkan nama
    $bahanBakuQuery = "SELECT id FROM bahan_baku WHERE nama_bahan = '$item'";
    $bahanBakuResult = mysqli_query($koneksi, $bahanBakuQuery);
    $bahanBaku = mysqli_fetch_assoc($bahanBakuResult);
    $bahanBakuId = $bahanBaku['id'];

    // Debugging: Tampilkan data yang diterima
    error_log("Total Cost: $totalCost"); // Tambahkan log untuk memeriksa nilai totalCost

    // Pastikan totalCost tidak memiliki format yang tidak diinginkan
    $totalCost = preg_replace('/[^0-9]/', '', $totalCost); // Menghapus karakter yang tidak diinginkan

    // Tambahkan dua angka desimal
    $totalCost = $totalCost / 100; // Mengubah format dari rupiah ke angka desimal

    // Insert into database
    $insertQuery = "INSERT INTO pengadaan (bahan_baku_id, jumlah, tanggal_pesanan, total_biaya, status, nama_bahan) VALUES ('$bahanBakuId', '$quantity', '$orderDate', '$totalCost', '$status', '$item')";
    
    if (mysqli_query($koneksi, $insertQuery)) {
        echo "Data inserted successfully";
    } else {
        // Debugging: Tampilkan kesalahan jika query gagal
        error_log("Error: " . mysqli_error($koneksi));
        echo "Error: " . mysqli_error($koneksi);
    }
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
                            <h4 class="mb-sm-0">Pengadaan</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Alerts Section -->
                <div id="alerts">
                    <div class="alert alert-success" role="alert">
                        Pengadaan berhasil ditambahkan!
                    </div>
                    <div class="alert alert-danger" role="alert">
                        Pengadaan gagal ditambahkan!
                    </div>
                    <div class="alert alert-info" role="alert">
                        Pengadaan sedang diproses.
                    </div>
                </div>

                 <!-- CRUD Form Section -->
    <div id="crud-form">
        <h4>Tambah Pengadaan</h4>
        <form id="pengadaan-form" onsubmit="return addPengadaan(event)">
            <div class="mb-3">
                <label for="item" class="form-label">Bahan yang Dipesan</label>
                <select class="form-control" id="item" required onchange="updateSatuan()">
                    <?php
                    // Ambil data dari tabel bahan_baku
                    $bahanBakuQuery = "SELECT nama_bahan FROM bahan_baku";
                    $bahanBakuResult = mysqli_query($koneksi, $bahanBakuQuery);
                    while ($bahan = mysqli_fetch_assoc($bahanBakuResult)) {
                        echo "<option value=\"{$bahan['nama_bahan']}\">{$bahan['nama_bahan']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="quantity" required>
            </div>
            <div class="mb-3">
                <label for="satuan" class="form-label">Satuan</label>
                <input type="text" class="form-control" id="satuan" required>
            </div>
            <div class="mb-3">
                <label for="order-date" class="form-label">Tanggal Pesanan</label>
                <input type="date" class="form-control" id="order-date" required>
            </div>
            <div class="mb-3">
                <label for="total-cost" class="form-label">Total Biaya</label>
                <input type="text" class="form-control" id="total-cost" name="totalCost" placeholder="Masukkan total biaya" oninput="formatRupiah(this)">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status-value" required>
                    <option value="dipesan">Dipesan</option>
                    <option value="diterima">Diterima</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3 mb-4">Tambah Pengadaan</button>
        </form>
    </div>  

                <!-- Procurement History Table -->
                <h4>Riwayat Pengadaan</h4>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Bahan</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Tanggal Pesanan</th>
                <th>Total Biaya</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pengadaanData as $pengadaan): ?>
                <tr>
                    <td><?php echo $pengadaan['id']; ?></td>
                    <td><?php echo $pengadaan['nama_bahan']; ?></td>
                    <td><?php echo $pengadaan['jumlah']; ?></td>
                    <td><?php echo $pengadaan['satuan']; ?></td>
                    <td><?php echo $pengadaan['tanggal_pesanan']; ?></td>
                    <td><?php echo number_format($pengadaan['total_biaya'], 2, ',', '.'); ?></td>
                    <td><?php echo $pengadaan['status']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
        let value = input.value.replace(/[^0-9]/g, ''); // Hanya ambil angka
        const formattedValue = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(value / 100); // Format dengan dua angka desimal
        input.value = formattedValue; // Tampilkan format yang benar
    }

    function updateSatuan() {
        const itemSelect = document.getElementById('item');
        const selectedItem = itemSelect.value;

        // Ambil satuan dari data bahan baku
        const bahanBakuData = <?php echo json_encode($bahanBakuData); ?>; // Mengambil data bahan baku dari PHP ke JavaScript
        let satuanValue = 'kg'; // Default satuan

        // Mencari satuan berdasarkan nama bahan
        for (let i = 0; i < bahanBakuData.length; i++) {
            if (bahanBakuData[i].nama_bahan === selectedItem) {
                satuanValue = bahanBakuData[i].satuan; // Set satuan sesuai dengan data dari database
                break;
            }
        }

        // Set nilai satuan pada input
        const satuanInput = document.getElementById('satuan');
        satuanInput.value = satuanValue;
    }

    function addPengadaan(event) {
        event.preventDefault(); // Prevent default form submission

        // Collect form data
        const itemSelect = document.getElementById('item');
        const item = itemSelect.value; // Get selected item
        const quantity = document.getElementById('quantity').value;
        const satuan = document.getElementById('satuan').value; // Get unit
        const status = document.getElementById('status-value').value; // Get status
        const orderDate = document.getElementById('order-date').value;
        const totalCost = document.getElementById('total-cost').value;

        // Send data to server for insertion into the database
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "", true); // Send to the same file
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Action after successful insertion
                alert("Pengadaan berhasil ditambahkan!");
                // Reset form after adding data
                document.getElementById('pengadaan-form').reset();
                document.getElementById('satuan').value = ''; // Reset unit
                document.getElementById('status-value').value = 'dipesan'; // Reset status to default
                location.reload(); // Reload the page to fetch new data
            } else {
                alert("Pengadaan gagal ditambahkan: " + xhr.responseText);
            }
        };
        xhr.send(`item=${item}&quantity=${quantity}&satuan=${satuan}&status=${status}&orderDate=${orderDate}&totalCost=${totalCost}`);
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
</script>
</body>

</html>
</html>