<?php
session_start();
require_once 'conexion.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if (!$nombre_usuario) $errores[] = "Ingrese nombre de usuario";
    if (!$contrasena) $errores[] = "Ingrese contraseña";

    if (empty($errores)) {
        $stmt = $conexion->prepare("SELECT id, contrasena, rol FROM usuarios WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hash_contrasena, $rol);
            $stmt->fetch();
            if (password_verify($contrasena, $hash_contrasena)) {
                $_SESSION['usuario_id'] = $id;
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                $_SESSION['rol'] = $rol;
                header("Location: bienvenida.php");
                exit;
            } else {
                $errores[] = "Contraseña incorrecta";
            }
        } else {
            $errores[] = "Usuario no encontrado";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Ingreso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="container mt-5">
    <h2>Ingreso</h2>

    <?php if ($errores): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label>Nombre de usuario</label>
            <input type="text" name="nombre_usuario" class="form-control" value="<?= htmlspecialchars($_POST['nombre_usuario'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="contrasena" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Ingresar</button>
        <a href="register.php" class="btn btn-link">Registrarse</a>
    </form>
</body>

</html>