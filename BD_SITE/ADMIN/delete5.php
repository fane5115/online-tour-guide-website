<?php

require_once "../USER/config.php";

$id = $_GET['id'];

$sql = "DELETE FROM turist WHERE id_turist = $id"; 

if (mysqli_query($mysqli, $sql)) {
    mysqli_close($mysqli);
    header('Location: admin.php'); //If book.php is your main page where you list your all records
    exit;
} else {
    echo "Error deleting record";
}

?>