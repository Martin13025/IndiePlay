<?php
include 'conexion.php';
$conf = mysqli_query($conexion, "SELECT logo FROM configuracion WHERE id = 1");
$logo = mysqli_fetch_assoc($conf)['logo'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nosotros - IndiePlay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #0b121a;
            color: #e0e0e0;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex-grow: 1;
            padding: 6rem 2rem 2rem;
            max-width: 900px;
            margin: 0 auto;
        }

        h1 {
            color: #7b5fff;
            margin-bottom: 1rem;
            margin-top: 2rem;
        }

        p {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .highlight {
            color: #a1aaff;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-dark text-light">
    <?php require 'header.php'; ?>

    <main class="content-wrapper">
        <h1>Nosotros</h1>
        <p>
            Bienvenido a <span class="highlight">IndiePlay</span>, un proyecto dedicado a ofrecer un catálogo curado de juegos independientes para todos los amantes del gaming.
            Nuestra misión es apoyar a los desarrolladores pequeños y emergentes, brindándoles una plataforma para que sus juegos sean descubiertos y disfrutados.
        </p>
        <p>
            IndiePlay nace de la pasión por los videojuegos y el deseo de conectar a jugadores con experiencias únicas y creativas. Creemos que cada juego tiene una historia que merece ser contada y compartida.
        </p>
        <p>
            Este sitio es un proyecto educativo y no representa una tienda real. Sin embargo, trabajamos para que la experiencia sea lo más realista e intuitiva posible.
        </p>
        <p>
            Si tienes alguna pregunta o quieres colaborar con nosotros, no dudes en contactarnos a través de nuestro formulario de contacto.
        </p>
    </main>

    <?php require 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>