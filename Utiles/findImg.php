<?php
include_once('../configuracion.php');
$data = data_submitted();
$nombre = $data['nombre'];
$img = glob($_SERVER['DOCUMENT_ROOT'] . "/PWD_TPFinal/files/users/" . $nombre . ".*");
if (!empty($img)) {
    header("Location: ../files/users/" . basename($img[0]));
} else {
    // Redirect to a default image if the file can't be found
    header("Location: ../files/users/default.png");
}