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

        .vertical-center {
            min-height: 100%;
            /* Fallback for browsers do NOT support vh unit */
            min-height: 100vh;
            /* These two lines are counted as one :-)       */

            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-between">
        <a class="navbar-brand" href="#"><i class="fas fa-home"></i></a>
        <?php if ($logat == 0) { ?>
            <a class="nav-link" href="login.php">LOGIN</a>
        <?php } else { ?>
            <b><a class="nav-link" href="cont.php?id=<?php $_SESSION['id'] ?>">VIZUALIZARE CONT</a> </b>
            <b><a class="nav-link" href="logout.php">LOGOUT</a> </b>
        <?php } ?>
    </nav>

    <!-- Masthead -->
    <header class="masthead text-white text-center vertical-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <form autocomplete="off" action="search.php" method="GET">
                        <div class="form-row">
                            <div class="col-12 col-md-9 mb-2 mb-md-0">
                                <input type="search" id="search" name="term" class="form-control form-control-lg" placeholder="Cauta locatie, oras...">
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="submit" class="btn btn-block btn-lg btn-primary">
                            </div>
                            <div class="col-12 col-md-3 mt-3">
                                <a class="btn btn-success btn-lg" href="descopera_locatii.php" role="button">Descopera Locatii</a>
                            </div>
                            <?php if ($logat == 0) { ?>
                                <div class="col-12 col-md-3 mt-3">
                                    <a class="btn btn-secondary btn-lg" href="login.php" role="button">Login</a>
                                </div>
                                <div class="col-12 col-md-3 mt-3 ml-5">
                                    <a class="btn btn-secondary btn-lg" href="register.php" role="button">Inregistrare</a>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

</body>

</html>