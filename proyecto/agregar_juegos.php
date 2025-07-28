<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);


    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $archivoTmp = $_FILES['imagen']['tmp_name'];
        $nombreArchivo = basename($_FILES['imagen']['name']);
        $ext = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));


        $extPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($ext, $extPermitidas)) {
            $mensaje = "Solo se permiten imágenes JPG, PNG, GIF o WEBP.";
        } else {
            $carpetaSubida = 'uploads/';
            if (!is_dir($carpetaSubida)) {
                mkdir($carpetaSubida, 0755, true);
            }
            $rutaDestino = $carpetaSubida . uniqid() . '.' . $ext;

            if (move_uploaded_file($archivoTmp, $rutaDestino)) {
                if ($nombre && $descripcion && $precio > 0) {
                    $stmt = $conexion->prepare("INSERT INTO juegos (nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssds", $nombre, $descripcion, $precio, $rutaDestino);
                    if ($stmt->execute()) {
                        $mensaje = "Juego agregado correctamente.";
                    } else {
                        $mensaje = "Error al agregar el juego: " . $stmt->error;
                        unlink($rutaDestino);
                    }
                    $stmt->close();
                } else {
                    $mensaje = "Por favor complete todos los campos correctamente.";
                    unlink($rutaDestino);
                }
            } else {
                $mensaje = "Error al mover el archivo subido.";
            }
        }
    } else {
        $mensaje = "Debe seleccionar una imagen para el juego.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Agregar Juego con Imagen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="container mt-5">

    <h2>Agregar Juego</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="number" step="0.01" min="0" name="precio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar</button>
    </form>

</body>

</html>