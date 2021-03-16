<?php
require_once "../USER/config.php";
$logat = 0;
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
    if (isset($_SESSION["loggedin"]) === true) {
        $logat = 1;

        $sql2 = "SELECT * FROM TURIST WHERE id_cont = '" . $_SESSION['id'] . "'";
        if ($result = mysqli_query($mysqli, $sql2)) {
            if (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO turist (id_cont) Values ( '" . $_SESSION['id'] . "')";

                if (mysqli_query($mysqli, $sql)) {
                } else {
                    echo "Error updating record: " . mysqli_error($mysqli);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <style>
        html,
        body {
            background: url(images/5.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            height: 100%;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-between">
        <a class="navbar-brand" href="../USER/home.php "><i class="fas fa-home"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if($logat == 0) { ?>
        <a class="nav-link" href="login.php">LOGIN</a> 
        <?php } else { ?>
            
            <a class="nav-link" href="logout.php">LOGOUT</a> 
        <?php } ?>
    </nav>

    <!-- Masthead -->
    <?php
    if (!empty($_REQUEST['term'])) {
      $term = mysqli_real_escape_string($mysqli,$_REQUEST['term']);  
      $sql = "SELECT IL.id_informatii  as ifo_id, O.nume as nume_oras, LEFT(IL.descriere,200) as il_descriere, L.nume as loc_nume, L.programare FROM locatie L join oras O on L.id_oras = O.id_oras join informatii_locatie IL on L.id_locatie = IL.id_locatie 
      where O.nume LIKE '%".$term."%' or L.nume LIKE '%".$term."%'" ;
      if ($result = mysqli_query($mysqli, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                echo "<a href='detalii_locatie.php?id=".$row[0]."' style='text-decoration:none; color:inherit;'>";//. $row[0] ."'>";
                echo "<div class='container mt-5'>";
                echo "<div class='card'>";
                echo "<div class='card-header'>";
                echo $row['nume_oras'];
                echo "</div>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row['loc_nume'] . "</h5>";
                echo "<p class='card-text'>". $row['il_descriere'] ."<a href='detalii_locatie.php?id=".$row[0]."'>  mai mult...</a></p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</a>";
            }
            mysqli_free_result($result);
        } else {
            echo "Nu exista inregistrari.";
        }
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
    }
  }
    ?>


</body>

</html>