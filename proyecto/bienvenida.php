<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="container mt-5" style="background-color: #000; color: #fff;">
    <?php require 'header.php'; ?>

    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['nombre_usuario']) ?>!</h2>
    <p>Tu rol es: <?= htmlspecialchars($_SESSION['rol']) ?></p>

    <?php if ($_SESSION['rol'] === 'admin'): ?>
        <a href="admin.php" class="btn btn-primary mb-3">Ir a Panel Admin</a>
    <?php endif; ?>

    <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>

</body>

</html>