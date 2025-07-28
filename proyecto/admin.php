<?php
session_start();
require_once 'conexion.php';


if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}


$juegos_result = mysqli_query($conexion, "SELECT * FROM juegos ORDER BY id DESC");


$usuarios_result = mysqli_query($conexion, "SELECT id, nombre_usuario, correo_electronico, rol FROM usuarios ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Panel de Administrador - IndiePlay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="container mt-5" style="background-color: darkblue; color: yellow;">
    <h1>Panel de Administrador</h1>
    <ul class="nav nav-tabs" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="juegos-tab" data-bs-toggle="tab" data-bs-target="#juegos" type="button" role="tab" aria-controls="juegos" aria-selected="true">Juegos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="usuarios-tab" data-bs-toggle="tab" data-bs-target="#usuarios" type="button" role="tab" aria-controls="usuarios" aria-selected="false">Admin / Usuarios</button>
        </li>
    </ul>

    <div class="tab-content" id="adminTabsContent">
        <div class="tab-pane fade show active" id="juegos" role="tabpanel" aria-labelledby="juegos-tab">
            <h2 class="mt-3">Lista de Juegos</h2>
            <a href="agregar_juegos.php" class="btn btn-success mb-3">Agregar Nuevo Juego</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($juego = mysqli_fetch_assoc($juegos_result)): ?>
                        <tr>
                            <td><?= $juego['id'] ?></td>
                            <td><?= htmlspecialchars($juego['nombre']) ?></td>
                            <td><?= htmlspecialchars($juego['descripcion']) ?></td>
                            <td>$<?= number_format($juego['precio'], 2) ?></td>
                            <td><img src="<?= htmlspecialchars($juego['imagen']) ?>" alt="<?= htmlspecialchars($juego['nombre']) ?>" style="height:50px;"></td>
                            <td>
                                <a href="editar_juego.php?id=<?= $juego['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                                <a href="eliminar_juego.php?id=<?= $juego['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este juego?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
            <h2 class="mt-3">Lista de Usuarios</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de Usuario</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($usuario = mysqli_fetch_assoc($usuarios_result)): ?>
                        <tr>
                            <td><?= $usuario['id'] ?></td>
                            <td><?= htmlspecialchars($usuario['nombre_usuario']) ?></td>
                            <td><?= htmlspecialchars($usuario['correo_electronico']) ?></td>
                            <td><?= htmlspecialchars($usuario['rol']) ?></td>
                            <td>
                                <?php if ($usuario['rol'] !== 'admin'): ?>
                                    <a href="dar_admin.php?id=<?= $usuario['id'] ?>" class="btn btn-warning btn-sm" onclick="return confirm('¿Dar permisos de administrador a este usuario?')">Hacer Admin</a>
                                    <a href="editar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-info btn-sm">Editar</a>
                                    <a href="eliminar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este usuario?')">Eliminar</a>
                                <?php else: ?>
                                    <span class="text-muted">Administrador</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>