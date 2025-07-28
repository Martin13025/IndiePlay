<?php
session_start();
include 'conexion.php';

$conf = mysqli_query($conexion, "SELECT logo FROM configuracion WHERE id = 1");
$logo = mysqli_fetch_assoc($conf)['logo'];
?>

<style>
    .indie-navbar {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
        padding-left: 1rem;
        padding-right: 1rem;
        z-index: 1050;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark indie-navbar fixed-top px-4">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php" style="height: 80px;">
            <img src="<?php echo $logo; ?>" alt="Logo" style="height: 50px; border-radius: 8px; margin-right:10px;">
            <span class="fw-bold fs-4">IndiePlay</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" aria-controls="menuNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bienvenida.php">Profile</a>
                </li>

                <?php if (isset($_SESSION['usuario_id'])): ?>

                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Registrarse</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>