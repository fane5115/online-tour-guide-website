<?php

$prog = "SELECT T.id_turist, L.id_locatie from locatie L
        join informatii_locatie IL
        on L.id_locatie = IL.id_locatie
        join turist T
        on T.id_oras = L.id_oras
        WHERE IL.id_informatii = $id " ;

if (!$result3 = mysqli_query($mysqli, $prog)) {
    echo 'Could not run query: ' . mysqli_error($mysqli);
    exit;
}
$programare = mysqli_fetch_row($result3);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['programare'])) {
        $P_data = mysqli_real_escape_string($mysqli, $_REQUEST['P_data']);
        $P_ora = mysqli_real_escape_string($mysqli, $_REQUEST['P_ora']);

        $prog = "INSERT INTO programare ( id_turist, id_locatie, data, ora, pret ) VALUES ( '$programare[0]', '$programare[1]', '$P_data', '$P_ora', 15 ) ";

        if (mysqli_query($mysqli, $prog)) {
            header("location: home.php");
        } else {
            echo "ERROR: Could not able to execute $prog. " . mysqli_error($mysqli);
        }
    }
}

?>