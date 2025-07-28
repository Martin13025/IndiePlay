<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}


$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    die("ID inválido");
}


$stmt = $conexion->prepare("SELECT nombre, descripcion, precio, imagen FROM juegos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nombre_actual, $descripcion_actual, $precio_actual, $imagen_actual);
if (!$stmt->fetch()) {
    die("Juego no encontrado");
}
$stmt->close();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $imagen = $imagen_actual;


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

                if ($imagen_actual && file_exists($imagen_actual)) {
                    unlink($imagen_actual);
                }
                $imagen = $rutaDestino;
            } else {
                $mensaje = "Error al mover el archivo subido.";
            }
        }
    }

    if (!$mensaje) {
        if ($nombre && $descripcion && $precio > 0) {
            $stmt = $conexion->prepare("UPDATE juegos SET nombre = ?, descripcion = ?, precio = ?, imagen = ? WHERE id = ?");
            $stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $imagen, $id);
            if ($stmt->execute()) {
                $mensaje = "Juego actualizado correctamente.";
                $nombre_actual = $nombre;
                $descripcion_actual = $descripcion;
                $precio_actual = $precio;
                $imagen_actual = $imagen;
            } else {
                $mensaje = "Error al actualizar el juego: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensaje = "Por favor complete todos los campos correctamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Editar Juego</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="container mt-5">

    <h2>Editar Juego</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre_actual) ?>" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($descripcion_actual) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="number" step="0.01" min="0" name="precio" class="form-control" value="<?= htmlspecialchars($precio_actual) ?>" required>
        </div>
        <div class="mb-3">
            <label>Imagen actual</label><br>
            <?php if ($imagen_actual && file_exists($imagen_actual)): ?>
                <img src="<?= htmlspecialchars($imagen_actual) ?>" alt="Imagen" style="max-width: 150px;">
            <?php else: ?>
                <p>No hay imagen</p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Cambiar imagen (opcional)</label>
            <input type="file" name="imagen" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="admin.php" class="btn btn-secondary">Volver</a>
    </form>

</body>

</html>