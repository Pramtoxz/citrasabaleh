<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/admin_style.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="<?= csrf_hash() ?>">

    <?= $this->renderSection('styles') ?>
</head>
<body>

<div class="wrapper">
    <!-- Sidebar -->
    <?= $this->include('components/sidebar') ?>

    <!-- Page Content -->
    <div id="content">
        <!-- Navbar -->
        <?= $this->include('components/navbar') ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="container-fluid animate__animated animate__fadeIn">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                        <?php if(isset($breadcrumb)): ?>
                            <?php foreach($breadcrumb as $item): ?>
                                <li class="breadcrumb-item <?= isset($item['active']) ? 'active' : '' ?>" <?= isset($item['active']) ? 'aria-current="page"' : '' ?>>
                                    <?= isset($item['link']) ? '<a href="'.$item['link'].'">'.$item['label'].'</a>' : $item['label'] ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        <?php endif; ?>
                    </ol>
                </nav>

                <!-- Page Title -->
                <div class="page-header mb-4">
                    <h1 class="fw-bold"><?= $pageTitle ?? 'Dashboard' ?></h1>
                    <p class="text-muted"><?= $pageDescription ?? 'Selamat datang di Admin Panel' ?></p>
                </div>

                <!-- Content -->
                <?= $this->renderSection('content') ?>
            </div>
        </div>

        <!-- Footer --> 
        <?= $this->include('components/footer') ?>
    </div>
</div>

<!-- Loader -->
<div class="loader-wrapper">
    <div class="loader"></div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

<!-- Custom JS -->
<script src="/assets/js/admin_script.js"></script>

<!-- AJAX Setup for CSRF Token -->
<script>
    // Setup AJAX CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Update CSRF token after each AJAX request
    $(document).ajaxComplete(function(e, xhr, settings) {
        var csrfName = '<?= csrf_token() ?>';
        var csrfHash = xhr.getResponseHeader('X-CSRF-TOKEN');
        if (csrfHash) {
            $('meta[name="csrf-token"]').attr('content', csrfHash);
        }
    });
</script>

<!-- Logout functionality -->
<script>
$(document).ready(function() {
    // Logout confirmation
    $('#logout').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin keluar?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= site_url('logout') ?>";
            }
        });
    });
});
</script>

<?= $this->renderSection('scripts') ?>

</body>
</html> 