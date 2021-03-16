<?php
require_once "../USER/config.php";
$logat = 0;
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
    if (isset($_SESSION["loggedin"]) === true)
        $logat = 1;
    else {
        header("location: home.php");
        exit;
    }
}

$sql = "SELECT T.nume nume_T, T.prenume prenume, O.nume nume_O, T.CNP cnp FROM turist T join oras O on T.id_oras = O.id_oras where T.id_cont = '" . $_SESSION['id'] . "'";

if (!$result = mysqli_query($mysqli, $sql)) {
    echo 'Could not run query: ' . mysqli_error($mysqli);
    exit;
}
$row = mysqli_fetch_row($result);
$password_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $T_oras = mysqli_real_escape_string($mysqli, $_REQUEST['T_oras']);
    $T_nume = mysqli_real_escape_string($mysqli, $_REQUEST['T_nume']);
    $T_prenume = mysqli_real_escape_string($mysqli, $_REQUEST['T_prenume']);
    $T_CNP = mysqli_real_escape_string($mysqli, $_REQUEST['T_CNP']);
    if (!empty($T_oras) && !empty($T_nume) && !empty($T_prenume) && !empty($T_CNP)) {
        if (isset($_POST['turist'])) {


            $sql = " UPDATE turist SET id_oras = $T_oras, nume = '$T_nume', prenume = '$T_prenume', cnp = $T_CNP where id_cont = '" . $_SESSION['id'] . "'";

            if (mysqli_query($mysqli, $sql)) {
                header("location: cont.php");
            } else {
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 4 Website Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>


    <nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-between">
        <a class="navbar-brand" href="../USER/home.php "><i class="fas fa-home"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if ($logat == 0) { ?>
            <a class="nav-link" href="login.php">LOGIN</a>
        <?php } else { ?>

            <a class="nav-link" href="logout.php">LOGOUT</a>
        <?php } ?>
    </nav>

    <div class="container">
        <div class="card m-5" style="width:400px">
            <div class="card-body">
                <?php
                $sql1 = "SELECT * FROM turist where id_cont = '" . $_SESSION['id'] . "' and ( nume is null or prenume is null or cnp is null or id_oras is null ) ";

                if (!$result1 = mysqli_query($mysqli, $sql1)) {
                    echo 'Could not run query: ' . mysqli_error($mysqli);
                    exit;
                }
                if (mysqli_num_rows($result1) > 0) {
                ?>
                    <div class="alert alert-danger">
                        <strong>Atentie!</strong> Anumite date sunt incomplete sau nu exista. Va rugam sa va actualizati datele.

                    </div><button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo">Actualizeaza Date</button>
                    <div id="demo" class="collapse">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="m-5">
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    <strong>Atentie!</strong> Toate campurile trebuie completate!
                                </div>
                                <label for="sel1">ORAS</label>
                                <select class="form-control" id="sel1" name="T_oras">
                                    <?php
                                    // Attempt select query execution
                                    $sql = "SELECT * FROM oras";
                                    if ($result = mysqli_query($mysqli, $sql)) {
                                        if (mysqli_num_rows($result) > 0) {

                                            while ($row = mysqli_fetch_array($result)) {
                                                echo ("<option value='" . $row[0] . "'>" . $row[1] . "</option>");
                                            }
                                            // Free result set
                                            mysqli_free_result($result);
                                        } else {
                                            echo "No records matching your query were found.";
                                        }
                                    } else {
                                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                                    }

                                    // Close connection
                                    //mysqli_close($mysqli);
                                    ?>
                                    <!-- <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option> -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nume">Nume</label>
                                <input type="text" class="form-control" placeholder="nume" id="nume" name="T_nume">
                                <span class="help-block"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="nume">Prenume</label>
                                <input type="text" class="form-control" placeholder="prenume" id="nume" name="T_prenume">
                            </div>
                            <div class="form-group">
                                <label for="nume">CNP</label>
                                <input type="number" class="form-control" placeholder="CNP" id="nume" name="T_CNP">
                            </div>
                            <button type="submit" class="btn btn-primary m-5" name="turist">Actualizeaza</button>
                        </form> <?php } else { ?>
                        <h4 class="card-title"><?php echo $row[0] . " " . $row[1]; ?></h4>
                        <p class="card-text">Oras: <?php echo $row[2] ?></p>
                        <p class="card-text">CNP: <?php echo $row[3] ?></p>
                        <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo">Actualizeaza Date</button>
                        <div id="demo" class="collapse">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="m-5">
                                <div class="form-group">
                                    <div class="alert alert-danger">
                                        <strong>Atentie!</strong> Toate campurile trebuie completate!
                                    </div>
                                    <label for="sel1">ORAS</label>
                                    <select class="form-control" id="sel1" name="T_oras">
                                        <?php
                                        // Attempt select query execution
                                        $sql = "SELECT * FROM oras";
                                        if ($result = mysqli_query($mysqli, $sql)) {
                                            if (mysqli_num_rows($result) > 0) {

                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo ("<option value='" . $row[0] . "'>" . $row[1] . "</option>");
                                                }
                                                // Free result set
                                                mysqli_free_result($result);
                                            } else {
                                                echo "No records matching your query were found.";
                                            }
                                        } else {
                                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                                        }

                                        // Close connection
                                        //mysqli_close($mysqli);
                                        ?>
                                        <!-- <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option> -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nume">Nume</label>
                                    <input type="text" class="form-control" placeholder="nume" id="nume" name="T_nume">
                                    <span class="help-block"><?php echo $password_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="nume">Prenume</label>
                                    <input type="text" class="form-control" placeholder="prenume" id="nume" name="T_prenume">
                                </div>
                                <div class="form-group">
                                    <label for="nume">CNP</label>
                                    <input type="number" class="form-control" placeholder="CNP" id="nume" name="T_CNP">
                                </div>
                                <button type="submit" class="btn btn-primary m-5" name="turist">Actualizeaza</button>
                            </form>
                        </div>
                        <div class="card m-5" style="width:400px">
                            <div class="card-body">
                                <h3>REZERVARI</h3>
                                <?php

                                $programari = " SELECT L.nume, P.data, P.ora, P.pret FROM programare P  join locatie L on L.id_locatie = P.id_locatie where ( SELECT T.id_cont FROM turist T WHERE T.id_turist = P.id_turist ) = '" . $_SESSION['id'] . "'";

                                if (!$result_prog = mysqli_query($mysqli, $programari)) {
                                    echo "Eroare";
                                    exit;
                                } else {
                                    if (mysqli_num_rows($result_prog) > 0) {
                                        while ($prog = mysqli_fetch_array($result_prog)) {
                                ?>
                                            <p> <?php echo $prog[0] ?> <br /> Ora: <?php echo $prog[2] ?> <br /> Data: <?php echo $prog[1] ?> <br /> Pret: <?php echo $prog[3] ?> lei <br/> 
                                            <b>Zile ramase:  <?php echo abs(round( ( time() - strtotime($prog[1]) ) /(60 * 60 * 24) )); ?> </b>
                                            <br/> </p>
                                <?php
                                        }
                                    }
                                }


                                ?>
                            </div>
                        </div>
                    <?php } ?>

                    </div>

            </div>
        </div>
        <a href="reset-password.php" class="btn btn-warning">Resetare Parola</a>
    </div>

    <div class="jumbotron text-center" style="margin-bottom:0">
        <p>@ARDELEANU STEFAN</p>
    </div>
</body>

</html>