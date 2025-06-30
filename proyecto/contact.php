<?php

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $asunto = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');


    if (empty($nombre)) {
        $errors[] = "El nombre es obligatorio.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El email es obligatorio y debe ser válido.";
    }
    if (!empty($telefono) && !preg_match('/^\+?[0-9\s\-]{7,15}$/', $telefono)) {
        $errors[] = "El teléfono debe contener solo números y puede incluir +, espacios o guiones.";
    }
    if (empty($asunto)) {
        $errors[] = "Seleccione un asunto.";
    }
    if (empty($mensaje)) {
        $errors[] = "El mensaje no puede estar vacío.";
    }

    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Contacto - IndiePlay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
</head>

<body class="bg-dark text-light">
    <?php require 'header.php'; ?>

    <div class="container py-5" style="max-width: 600px;">
        <h1 class="mb-4 text-center mt-5">Contacto</h1>

        <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                Gracias por contactarnos, responderemos a la brevedad.
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" novalidate>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre ?? '') ?>" required />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico *</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required />
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($telefono ?? '') ?>" placeholder="+54 9 11 1234 5678" />
            </div>

            <div class="mb-3">
                <label for="asunto" class="form-label">Asunto *</label>
                <select class="form-select" id="asunto" name="asunto" required>
                    <option value="" <?= empty($asunto) ? 'selected' : '' ?>>Selecciona un asunto</option>
                    <option value="consulta" <?= ($asunto ?? '') === 'consulta' ? 'selected' : '' ?>>Consulta</option>
                    <option value="soporte" <?= ($asunto ?? '') === 'soporte' ? 'selected' : '' ?>>Soporte técnico</option>
                    <option value="otro" <?= ($asunto ?? '') === 'otro' ? 'selected' : '' ?>>Otro</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje *</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required><?= htmlspecialchars($mensaje ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Enviar</button>
        </form>
    </div>

    <?php require 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>