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


$stmt = $conexion->prepare("SELECT imagen FROM juegos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($imagen);
if (!$stmt->fetch()) {
    $stmt->close();
    die("Juego no encontrado");
}
$stmt->close();

$stmt = $conexion->prepare("DELETE FROM juegos WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    if ($imagen && file_exists($imagen)) {
        unlink($imagen);
    }
    $stmt->close();
    header("Location: admin.php?mensaje=Juego eliminado correctamente");
    exit;
} else {
    $stmt->close();
    die("Error al eliminar el juego");
}
