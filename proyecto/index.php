<?php
include 'conexion.php';


$limit = 5;


$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;


$offset = ($page - 1) * $limit;

$total_result = mysqli_query($conexion, "SELECT COUNT(*) as total FROM juegos");
$total_row = mysqli_fetch_assoc($total_result);
$total_games = $total_row['total'];


$total_pages = ceil($total_games / $limit);


$query = "SELECT * FROM juegos LIMIT $limit OFFSET $offset";
$resultado = mysqli_query($conexion, $query);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>IndiePlay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-dark text-light">
    <?php require 'header.php'; ?>

    <div class="container py-5">
        <h1 class="text-center mb-5 pt-5">Catálogo de Juegos</h1>

        <div class="row g-4">
            <?php while ($juego = mysqli_fetch_assoc($resultado)) { ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 card-game">
                        <img src="<?php echo $juego['imagen']; ?>" class="card-img-top" alt="<?php echo $juego['nombre']; ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $juego['nombre']; ?></h5>
                            <p class="card-text small"><?php echo $juego['descripcion']; ?></p>
                            <div class="mt-auto">
                                <p class="fw-bold">$<?php echo $juego['precio']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


        <nav aria-label="Page navigation example" class="mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link bg-dark text-primary" href="?page=<?php echo $page - 1; ?>" tabindex="-1">Anterior</a>
                </li>

                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link <?php echo ($i == $page) ? 'bg-primary text-white' : 'bg-dark text-primary'; ?>" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>

                <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                    <a class="page-link bg-dark text-primary" href="?page=<?php echo $page + 1; ?>">Siguiente</a>
                </li>
            </ul>
        </nav>

    </div>

    <?php require 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>