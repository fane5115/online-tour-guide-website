<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../USER/login.php");
    exit;
}

require_once "../USER/config.php";



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script>
        $('.section-link').click(function() {
            var cur = $('.section-link').index($(this)); // get the index of the clicked link
            $('.section-display').removeClass('active'); // hide all of the sections
            $('.section-display').eq(cur).addClass('active'); // show the section at the same index of the clicked link 
        });
    </script>
    <style>

    </style>
</head>

<body>

    <div class="jumbotron text-center" style="margin-bottom:0">
        <h1>ADMIN</h1>
        <h2></h2>
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="admin.php"><i class="fas fa-home"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../ADMIN/statistici.php">STATISTICI</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../USER/logout.php">LOGOUT</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top:30px">

        <div class="card card-stats m-3">
            <div class="card-header card-header-warning card-header-icon">
                <b class="card-category">Numar utilizatori inregistrati</b>
                <h3 class="card-title">
                    <?php

                    $sql = "SELECT COUNT(*) from users where rol = 'user'";

                    if (!$result = mysqli_query($mysqli, $sql)) {
                        echo "EROARE";
                        exit;
                    }

                    $row = mysqli_fetch_row($result);

                    echo $row[0];
                    ?>
                </h3>
            </div>
        </div>

        <div class="card card-stats m-3">
            <div class="card-header card-header-warning card-header-icon">
                <b class="card-category">Turistii cu cele mai multe rezervari</b>
                <h3 class="card-title">
                    <?php

                    $sql = "SELECT nume, prenume, max(nr_max) as maxim FROM ( SELECT T.nume as nume, T.prenume as prenume, Count(*) as nr_max from programare P join turist T on T.id_turist = P.id_turist group by T.nume ) as tabel";

                    if (!$result = mysqli_query($mysqli, $sql)) {
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                        exit;
                    } 
                    //$row = mysqli_fetch_row($result);
                    if( mysqli_num_rows($result) > 0 ) {
                        while($row = mysqli_fetch_row($result))
                            echo $row[0] . " " . $row[1] . " " . $row[2] ."<br><br>";
                    } else echo "Nu exista inregistrari";
                    ?>
                </h3>
            </div>
        </div>

        <div class="card card-stats m-3">
            <div class="card-header card-header-warning card-header-icon">
                <b class="card-category">Suma totala </b>
                <h3 class="card-title">
                    <?php

                    $sql = "SELECT Sum(pret) FROM programare ";

                    if (!$result = mysqli_query($mysqli, $sql)) {
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                        exit;
                    }

                    $row = mysqli_fetch_row($result);

                    echo $row[0] ." lei";
                    ?>
                </h3>
            </div>
        </div>
        
        <div class="card card-stats m-3">
            <div class="card-header card-header-warning card-header-icon">
                <b class="card-category"> Cate rezervari s-au facut pentru fiecare locatie  </b>
                <h3 class="card-title">
                    <?php
                        $sql = " SELECT LOCATIE.NUME, COUNT(PROGRAMARE.ID_LOCATIE) NUMAR FROM LOCATIE JOIN PROGRAMARE ON LOCATIE.ID_LOCATIE = PROGRAMARE.ID_LOCATIE GROUP BY LOCATIE.NUME  ";

                        if (!$result = mysqli_query($mysqli, $sql)) {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                            exit;
                        } 
                        if( mysqli_num_rows($result) > 0 ) {
                            while($row = mysqli_fetch_row($result))
                                echo $row[0] . " " . $row[1] ."<br><br>";
                        } else echo "Nu exista inregistrari";
                    ?>
                </h3>
            </div>
        </div>

        <div class="card card-stats m-3">
            <div class="card-header card-header-warning card-header-icon">
                <b class="card-category"> Cati utilizatori nu si-au actualizat datele:  </b>
                <h3 class="card-title">
                    <?php
                        $sql = " SELECT COUNT(*) from users U   where U.rol = 'user' and 
                        U.id = ( SELECT T.id_cont FROM turist T where T.id_cont = U.id and ( T.nume is null or T.prenume is null or T.cnp is null or T.id_oras is null ) ) ";

                        if (!$result = mysqli_query($mysqli, $sql)) {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                            exit;
                        } 
                        if( mysqli_num_rows($result) > 0 ) {
                            while($row = mysqli_fetch_row($result))
                                echo $row[0] ."<br><br>";
                        } else echo "Nu exista inregistrari";
                    ?>
                </h3>
            </div>
        </div>

        <div class="card card-stats m-3">
            <div class="card-header card-header-warning card-header-icon">
                <b class="card-category"> Cate locatii are fiecare oras:  </b>
                <h3 class="card-title">
                    <?php
                        $sql = " SELECT O.nume, count(L.id_locatie) from oras O join locatie L on O.id_oras = L.id_oras group by O.nume ";

                        if (!$result = mysqli_query($mysqli, $sql)) {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                            exit;
                        } 
                        if( mysqli_num_rows($result) > 0 ) {
                            while($row = mysqli_fetch_row($result))
                                echo $row[0] . " " . $row[1]  ."<br><br>";
                        } else echo "Nu exista inregistrari";
                    ?>
                </h3>
            </div>
        </div>

        <div class="card card-stats m-3">
            <div class="card-header card-header-warning card-header-icon">
                <b class="card-category"> Afisarea celui mai vechi utilizator:  </b>
                <h3 class="card-title">
                    <?php
                        $sql = " SELECT T.NUME, T.PRENUME, U.created_at FROM TURIST T JOIN USERS U ON T.ID_CONT = U.ID WHERE U.ROL = 'user' GROUP BY T.NUME, T.PRENUME order by U.created_at ";

                        if (!$result = mysqli_query($mysqli, $sql)) {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                            exit;
                        } 
                        $row = mysqli_fetch_row($result);
                        //if( mysqli_num_rows($result) > 0 ) {
                            //while($row = mysqli_fetch_row($result))
                                echo $row[0] . " " . $row[1] ." ". $row[2] ."<br><br>";
                        //} else echo "Nu exista inregistrari";
                    ?>
                </h3>
            </div>
        </div>

    </div>




    <div class="jumbotron text-center" style="margin-bottom:0">
        <p>@ARDELEANU STEFAN</p>
    </div>

</body>

</html>