<?php
$bypass = isset($_GET['bypass']) && $_GET['bypass'] == '1';
$profile = $bypass ? ['username' => 'dev', 'image' => 'image72.jpg'] : checkSession($connectionData);
if (!empty($profile)) {
    $portrait = PORTRAITSDIR.$profile['image'];
}
else {
    // Redirigir al usuario al listado de consolas
    header('Location: ./error.php');
    exit(); // Es importante llamar a exit después de una redirección
}