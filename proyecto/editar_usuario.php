<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre_usuario'] ?? '');
    $rol = $_POST['rol'] ?? 'usuario';

    if (!$nombre) $errores[] = "Nombre requerido";

    if (empty($errores)) {
        $query = "UPDATE usuarios SET nombre_usuario = ?, rol = ? WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $rol, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: admin_usuarios.php");
        exit;
    }
} else {
    $query = "SELECT nombre_usuario, rol FROM usuarios WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nombre_usuario, $rol);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h2>Editar Usuario</h2>

    <?php if ($errores): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nombre de usuario</label>
            <input type="text" name="nombre_usuario" class="form-control" value="<?= htmlspecialchars($nombre_usuario ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>Rol</label>
            <select name="rol" class="form-select">
                <option value="usuario" <?= ($rol === 'usuario' ? 'selected' : '') ?>>Usuario</option>
                <option value="admin" <?= ($rol === 'admin' ? 'selected' : '') ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="admin.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>

</html>