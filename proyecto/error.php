<?php
http_response_code(404);
include 'conexion.php';
$conf = mysqli_query($conexion, "SELECT logo FROM configuracion WHERE id = 1");
$logo = mysqli_fetch_assoc($conf)['logo'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Error 404 - Página no encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: url('./assets/img/404.png') no-repeat center center fixed;
            background-size: cover;
            color: #e0e0e0;
            font-family: 'Segoe UI', sans-serif;
        }

        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: row;
            gap: 3rem;
            padding: 2rem;
        }

        .error-text {
            max-width: 500px;
        }

        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #7b5fff;
        }

        .error-img {
            max-width: 400px;
            border-radius: 1rem;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php require 'header.php'; ?>

    <div class="container error-container">
        <div class="error-text">
            <div class="error-code">404</div>
            <h1 class="mt-3">Página no encontrada</h1>
            <p class="lead">Lo sentimos, la página que estás buscando no existe o ha sido movida.</p>
            <a href="index.php" class="btn btn-primary mt-4">Volver al inicio</a>
        </div>
        <!--<div>
            <img src="./assets/img/404.png" alt="Error 404" class="error-img">
        </div>-->
    </div>

    <?php require 'footer.php'; ?>
</body>

</html>
