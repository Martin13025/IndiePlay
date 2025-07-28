<?php
session_start();
require_once 'conexion.php';

$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
    $correo_electronico = trim($_POST['correo_electronico'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

    if (!$nombre_usuario) $errores[] = "Ingrese nombre de usuario";
    if (!$correo_electronico || !filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)) $errores[] = "Ingrese un correo electrónico válido";
    if (!$contrasena) $errores[] = "Ingrese una contraseña";
    if ($contrasena !== $confirmar_contrasena) $errores[] = "Las contraseñas no coinciden";

    if (empty($errores)) {
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ? OR correo_electronico = ?");
        $stmt->bind_param("ss", $nombre_usuario, $correo_electronico);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errores[] = "El nombre de usuario o correo electrónico ya están registrados";
        } else {
            $hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre_usuario, $correo_electronico, $hash_contrasena);
            if ($stmt->execute()) {
                $_SESSION['usuario_id'] = $stmt->insert_id;
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                $_SESSION['rol'] = 'usuario';
                header("Location: bienvenida.php");
                exit;
            } else {
                $errores[] = "Error al registrar el usuario: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="container mt-5">
    <h2>Registro</h2>

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
            <label>Correo electrónico</label>
            <input type="email" name="correo_electronico" class="form-control" value="<?= htmlspecialchars($_POST['correo_electronico'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="contrasena" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirmar contraseña</label>
            <input type="password" name="confirmar_contrasena" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
        <a href="login.php" class="btn btn-link">Ingresar</a>
    </form>
</body>

</html>