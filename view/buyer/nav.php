<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid">
        <!-- Left side content or brand can be added here if needed -->
        <div class="navbar-brand">
            <a href="?action=dashboard" class="nav-link <?php echo (!isset($_GET['action']) || $_GET['action'] == 'dashboard') ? 'active' : ''; ?>">
                <img src="../../image/logo.png" alt="Nông Sản Xanh Logo" height="30" class="d-inline-block align-text-top">
                <span class="ms-2 d-none d-md-inline">Nông Sản Xanh</span>
            </a>
        </div>
        
        <!-- Spacer to push content to the right -->
        <div class="flex-grow-1"></div>
        
        <!-- Right-aligned Nav Items -->
        <div class="d-flex align-items-center">
            
            <!-- Logout Button -->
            <a href="../login/logout.php" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt me-1"></i>
                <span class="d-none d-md-inline">Đăng xuất</span>
            </a>
        </div>
    </div>
</nav>