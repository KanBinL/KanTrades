<?php
// Asegurarse de que todos los errores se muestren durante la ejecución del script PHP
error_reporting(E_ALL);
ini_set('display_errors', '1');

$available_languages = ['en', 'es'];

if (isset($_GET['lang']) && in_array($_GET['lang'], $available_languages)) {
    $_SESSION['lang'] = $_GET['lang']; // asume que el idioma se pasa como un parámetro GET.
} elseif (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en'; // idioma predeterminado
}

function head()
{
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra y vende de forma fácil</title>
    <?php
}
?>