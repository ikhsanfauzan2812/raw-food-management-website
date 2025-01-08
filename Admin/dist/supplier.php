<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "stokpintar";

$koneksi = mysqli_connect($host, $user, $password, $dbname);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Cek jika ada data yang dikirim untuk menambah supplier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_supplier') {
    $nama_supplier = $_POST['supplier_name'];
    $keterangan = $_POST['supplier_ket'];
    $kontak = $_POST['supplier_contact'];
    $alamat = $_POST['supplier_address'];

    // Query untuk menambah supplier
    $sql = "INSERT INTO supplier (nama_supplier, keterangan, kontak, alamat) VALUES ('$nama_supplier', '$keterangan', '$kontak', '$alamat')";

    if (mysqli_query($koneksi, $sql)) {
        echo "Supplier berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Ambil data supplier
$sql = "SELECT id, nama_supplier, keterangan, kontak, alamat FROM supplier";
$result = mysqli_query($koneksi, $sql);
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
                        <a href="log-stok.php" class="waves-effect">
                            <i class="mdi mdi-archive"></i><span> Log Stok </span>
                        </a>
                    </li>

                    <li>
                        <a href="supplier.php" class="waves-effect">
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
                            <h4 class="mb-sm-0">Supplier</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Tambahkan di dalam <div class="container-fluid"> -->
<div class="row">
    <div class="col-12">
        <h4 class="mb-sm-0">Daftar Supplier</h4>
        <button class="btn btn-primary" onclick="showAddSupplierForm()">Tambah Supplier</button>
        <table class="table table-bordered table-striped" id="supplier-table">
            <thead>
                <tr>
                    <th>Nama Supplier</th>
                    <th>Keterangan</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nama_supplier']}</td>
                                <td>{$row['keterangan']}</td>
                                <td>{$row['kontak']}</td>
                                <td>{$row['alamat']}</td>
                                <td>
                                    <button class='btn btn-warning' onclick='editSupplier({$row['id']})'>Edit</button>
                                    <button class='btn btn-danger' onclick='deleteSupplier({$row['id']})'>Hapus</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data supplier</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Form untuk menambah dan mengedit supplier -->
<div id="supplier-form" style="display:none; margin-bottom: 20px;">
    <h4 id="form-title">Tambah Supplier</h4>
    <form method="POST" action="">
        <input type="hidden" name="action" value="add_supplier">
        <input type="text" name="supplier_name" class="form-control mb-2" placeholder="Nama Supplier" required>
        <input type="text" name="supplier_ket" class="form-control mb-2" placeholder="Keterangan" required>
        <input type="text" name="supplier_contact" class="form-control mb-2" placeholder="Kontak (+62)" required>
        <input type="text" name="supplier_address" class="form-control mb-2" placeholder="Alamat" required>
        <button type="submit" class="btn btn-success">Simpan</button>
        <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Batal</button>
    </form>
</div>

               
</div>

            <script>
                let suppliers = []; // Array untuk menyimpan data supplier
                let editIndex = -1; // Untuk menyimpan index supplier yang sedang diedit

                function showAddSupplierForm() {
                    document.getElementById('supplier-form').style.display = 'block';
                    document.getElementById('form-title').innerText = 'Tambah Supplier';
                    document.getElementById('supplier-name').value = '';
                    document.getElementById('supplier-contact').value = '';
                    document.getElementById('supplier-address').value = '';
                    editIndex = -1; // Reset edit index
                }

                function addSupplier() {
                    const name = document.getElementById('supplier-name').value;
                    const contact = document.getElementById('supplier-contact').value;
                    const address = document.getElementById('supplier-address').value;

                    if (editIndex === -1) {
                        // Tambah supplier baru
                        suppliers.push({ name, contact, address });
                    } else {
                        // Update supplier yang ada
                        suppliers[editIndex] = { name, contact, address };
                    }

                    renderSupplierTable();
                    cancelEdit();
                }

                function editSupplier(index) {
                    editIndex = index;
                    const supplier = suppliers[index];
                    document.getElementById('supplier-name').value = supplier.name;
                    document.getElementById('supplier-contact').value = supplier.contact;
                    document.getElementById('supplier-address').value = supplier.address;
                    document.getElementById('supplier-form').style.display = 'block';
                    document.getElementById('form-title').innerText = 'Edit Supplier';
                }

                function deleteSupplier(index) {
                    suppliers.splice(index, 1);
                    renderSupplierTable();
                }

                function renderSupplierTable() {
                    const tableBody = document.getElementById('supplier-table').getElementsByTagName('tbody')[0];
                    tableBody.innerHTML = ''; // Kosongkan tabel sebelum diisi ulang

                    suppliers.forEach((supplier, index) => {
                        const row = tableBody.insertRow();
                        row.innerHTML = `
                            <td>${supplier.name}</td>
                            <td>${supplier.contact}</td>
                            <td>${supplier.address}</td>
                            <td>
                                <button class="btn btn-warning" onclick="editSupplier(${index})">Edit</button>
                                <button class="btn btn-danger" onclick="deleteSupplier(${index})">Hapus</button>
                            </td>
                        `;
                    });
                }

                function cancelEdit() {
                    document.getElementById('supplier-form').style.display = 'none';
                }

                // Fungsi untuk memformat input kontak
                function formatContact(input) {
                    // Hapus semua karakter yang bukan angka
                    let value = input.value.replace(/[^0-9]/g, '');
                    
                    // Tambahkan awalan +62 jika belum ada
                    if (value && !value.startsWith('62')) {
                        input.value = '+62' + value;
                    } else {
                        input.value = value;
                    }
                }
            </script>   
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
        const ingredient = row.cells[0].innerText;
        const amount = row.cells[1].innerText;
        const usageDate = row.cells[2].innerText;

        document.getElementById('ingredient').value = ingredient;
        document.getElementById('amount').value = amount;
        document.getElementById('usage-date').value = usageDate;

        row.remove(); // Remove the row after editing
    }

    function deleteUsage(button) {
        const row = button.closest('tr');
        row.remove(); // Remove the row
    }
</script>
</body>

</html></html>
