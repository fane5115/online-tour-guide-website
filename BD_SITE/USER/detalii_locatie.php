<?php
require_once "../USER/config.php";
$logat = 0;
$id = $_GET['id'];
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
    if (isset($_SESSION["loggedin"]) === true) {
        $logat = 1;

        $prog1 = "SELECT L.id_locatie from locatie L
        join informatii_locatie IL
        on L.id_locatie = IL.id_locatie
        WHERE IL.id_informatii = $id";

        if (!$result3 = mysqli_query($mysqli, $prog1)) {
            echo 'Could not run query: ' . mysqli_error($mysqli);
            exit;
        }
        $programare = mysqli_fetch_row($result3);

        $prog2 = "SELECT T.id_turist FROM turist T where T.id_cont = '" . $_SESSION['id'] . "'";

        if (!$result4 = mysqli_query($mysqli, $prog2)) {
            echo 'Could not run query: ' . mysqli_error($mysqli);
            exit;
        }
        $programare2 = mysqli_fetch_row($result4);
        


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['programare'])) {
                $P_data = mysqli_real_escape_string($mysqli, $_REQUEST['P_data']);
                $P_ora = mysqli_real_escape_string($mysqli, $_REQUEST['P_ora']);

                $prog = "INSERT INTO programare ( id_turist, id_locatie, data, ora, pret ) VALUES ( '$programare2[0]', '$programare[0]', '$P_data', '$P_ora', 15 ) ";

                if (mysqli_query($mysqli, $prog)) {
                    header("location: home.php");
                } else {
                    echo "ERROR: Could not able to execute $prog. " . mysqli_error($mysqli);
                }
            }
        }
    }
}


$sql = "SELECT IL.id_informatii  as ifo_id, O.nume as nume_oras, IL.descriere as il_descriere, L.nume loc_nume, L.programare, IL.lat as lat, IL.lng as lng
        FROM locatie L join oras O 
        on L.id_oras = O.id_oras 
        join informatii_locatie IL 
        on L.id_locatie = IL.id_locatie
        WHERE IL.id_informatii = $id";

if (!$result = mysqli_query($mysqli, $sql)) {
    echo 'Could not run query: ' . mysqli_error($mysqli);
    exit;
}
$row = mysqli_fetch_row($result);

$sql2 = "SELECT G.nume nume_ghid, G.prenume prenume_ghid  FROM ghid G join locatie L on G.id_locatie = L.id_locatie 
WHERE ( SELECT id_informatii from informatii_locatie as IL where IL.id_locatie = L.id_locatie ) = $id";

if (!$result2 = mysqli_query($mysqli, $sql2)) {
    echo 'Could not run query: ' . mysqli_error($mysqli);
    exit;
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
        .btntst {
            width: 300px;
            height: 100px;
            vertical-align: middle;
            font-size: 40px;
        }

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
        <a class="navbar-brand" href="../USER/home.php"><i class="fas fa-home"></i></a>
        <?php if ($logat == 0) { ?>
            <a class="nav-link" href="login.php">LOGIN</a>
        <?php } else { ?>
            <b><a class="nav-link" href="cont.php?id=<?php $_SESSION['id'] ?>">VIZUALIZARE CONT</a> </b>
            <b><a class="nav-link" href="logout.php">LOGOUT</a> </b>
        <?php } ?>
    </nav>

    <div class="container" style="margin-top:30px">
        <div class="row">
            <div class="col-lg">
                <h2><?php echo $row[3] ?></h2>
                <p><?php echo $row[2] ?></p>
                <?php
                echo "<iframe width='900' height='600' src='https://api.maptiler.com/maps/streets/?key=mtZRn8H6pSOTAi5r8Lcb#17.3/" . $row[5] . "/" . $row[6] . "'></iframe><br/>";
                ?>
                <button type="button" class="btn btn-lg btn-primary m-2" data-toggle="collapse" data-target="#demo">Ghizi</button>
                <div id="demo" class="collapse p-3">
                    <?php
                    while ($ghid = mysqli_fetch_array($result2))
                        echo '<span class="badge badge-pill badge-warning" style="font-size:25px;">' . $ghid[0] . " " . $ghid[1] . '</span><br/><br/>';
                    echo "</div>";
                    if ($row[4] == 1)
                        echo '<a href="#" class="btn btntst btn-large btn-info d-flex align-items-center m-5" data-toggle="modal" data-target="#myModal" role="button">Programare</a>';
                    ?>


                    <!-- The Modal -->
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Programare</h4>
                                </div>
                                <?php if ($logat == 0) { ?>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        TREBUIE SA INTRI IN CONT PENTRU A FACE O REZERVARE
                                    </div>
                                <?php } else {
                                $sql1 = "SELECT * FROM turist where id_cont = '" . $_SESSION['id'] . "' and ( nume is null or prenume is null or cnp is null or id_oras is null ) ";

                                if (!$result1 = mysqli_query($mysqli, $sql1)) {
                                    echo 'Could not run query: ' . mysqli_error($mysqli);
                                    exit;
                                }
                                if (mysqli_num_rows($result1) == 0) {
                                     ?>
                                    <form action="" method="POST" class="m-5">

                                        <div class="form-group">
                                            <label for="data" class="inline">Data</label>
                                            <input type="date" class="form-control" id="email" name="P_data">
                                        </div>
                                        <div class="form-group">
                                            <label for="data" class="inline">Ora</label>
                                            <input type="time" class="form-control" id="email" name="P_ora">
                                        </div>
                                        <button type="submit" class="btn btn-primary m-5" name="programare">rezerva</button>
                                    </form>
                                    <h3><b>Pret: 15 lei</b></h3>
                                <?php }else {echo "Datele trebuie actualizate!";} }?>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="jumbotron text-center" style="margin-bottom:0">
            <p>@ARDELEANU STEFAN</p>
        </div>
</body>

</html>