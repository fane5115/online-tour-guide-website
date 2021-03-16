<?php

require_once "../USER/config.php";

$id = $_GET['id'];

$sql = "DELETE FROM informatii_locatie WHERE id_informatii = $id"; 

if (mysqli_query($mysqli, $sql)) {
    mysqli_close($mysqli);
    header('Location: admin.php'); 
    exit;
} else {
    echo "Error deleting record";
}

?>