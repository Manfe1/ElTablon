<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Tablón</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">
    <link href='https://fonts.googleapis.com/css?family=DynaPuff' rel='stylesheet'>
</head>

<body>
    <header>
        <?php if (isset($_SESSION["id_usuario"])) : ?>
            <nav class="nav-container">
                <ul class="nav-list">
                    <li><img src="../IMG/logotablon.svg" alt="Logo" style="height: 50px;"></li>
                </ul>
                <ul class="nav-list">
                    <li><a href="tablon.php">Tablón de Anuncios</a></li>
                    <li><a href="usuario.php">Mi Perfil</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        <?php endif; ?>
    </header>
    <main>