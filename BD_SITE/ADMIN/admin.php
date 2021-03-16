<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../USER/login.php");
    exit;
}

require_once "../USER/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['oras'])) {
        $nume = mysqli_real_escape_string($mysqli, $_REQUEST['nume_oras']);
        $loc = mysqli_real_escape_string($mysqli, $_REQUEST['locuitori']);

        $sql = "INSERT INTO oras (nume, nr_locuitori) VALUES (?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("siii", $nume, $loc);


            if ($stmt->execute()) {
                header("location: admin.php");
            } else {
                echo "Incearca mai tarziu.";
            }

            $stmt->close();
        }
    } else if (isset($_POST['locatie'])) {
        $oras = mysqli_real_escape_string($mysqli, $_REQUEST['L_oras']);
        $nume = mysqli_real_escape_string($mysqli, $_REQUEST['L_nume']);
        $rezv = mysqli_real_escape_string($mysqli, $_REQUEST['L_rezv']);

        $sql = "INSERT INTO locatie (id_oras, nume, programare) VALUES ( '$oras', '$nume', '$rezv' ) ";

        if (mysqli_query($mysqli, $sql)) {
            header("location: admin.php");
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
        }
    } else if (isset($_POST['info_locatie'])) {
        $IL_info = mysqli_real_escape_string($mysqli, $_REQUEST['IL_descriere']);
        $IL_lat = mysqli_real_escape_string($mysqli, $_REQUEST['IL_lat']);
        $lat = mysqli_real_escape_string($mysqli, $_REQUEST['lat']);
        $lng = mysqli_real_escape_string($mysqli, $_REQUEST['lng']);

        $sql = "INSERT INTO informatii_locatie ( id_locatie, descriere, lat, lng ) VALUES ( '$IL_loc', '$IL_info', '$lat', '$lng' ) ";
        if (mysqli_query($mysqli, $sql)) {
            header("location: admin.php");
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
        }
    } else if (isset($_POST['ghid'])) {
        $G_locatie = mysqli_real_escape_string($mysqli, $_REQUEST['G_locatie']);
        $G_nume = mysqli_real_escape_string($mysqli, $_REQUEST['G_nume']);
        $G_prenume = mysqli_real_escape_string($mysqli, $_REQUEST['G_prenume']);

        $sql = "INSERT INTO ghid ( id_locatie, nume, prenume ) VALUES ( '$G_locatie', '$G_nume', '$G_prenume' ) ";
        if (mysqli_query($mysqli, $sql)) {
            header("location: admin.php");
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
        }
    } else if (isset($_POST['turist'])) {
        $T_oras = mysqli_real_escape_string($mysqli, $_REQUEST['T_oras']);
        $T_nume = mysqli_real_escape_string($mysqli, $_REQUEST['T_nume']);
        $T_prenume = mysqli_real_escape_string($mysqli, $_REQUEST['T_prenume']);
        $T_CNP = mysqli_real_escape_string($mysqli, $_REQUEST['T_CNP']);

        $sql = "INSERT INTO turist ( id_oras, nume, prenume, cnp ) VALUES ( '$T_oras', '$T_nume', '$T_prenume', '$T_CNP' ) ";

        if (mysqli_query($mysqli, $sql)) {
            header("location: admin.php");
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
        }
    } else if (isset($_POST['programare'])) {
        $P_turist = mysqli_real_escape_string($mysqli, $_REQUEST['P_turist']);
        $P_locatie = mysqli_real_escape_string($mysqli, $_REQUEST['P_locatie']);
        $P_data = mysqli_real_escape_string($mysqli, $_REQUEST['P_data']);
        $P_ora = mysqli_real_escape_string($mysqli, $_REQUEST['P_ora']);
        $P_pret = mysqli_real_escape_string($mysqli, $_REQUEST['P_pret']);

        $sql = "INSERT INTO programare ( id_turist, id_locatie, data, ora, pret ) VALUES ( '$P_turist', '$P_locatie', '$P_data', '$P_ora', '$P_pret' ) ";

        if (mysqli_query($mysqli, $sql)) {
            header("location: admin.php");
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
        }
    }
}
//header("location: " .  $_SERVER['PHP_SELF']);
//mysqli_close($mysqli);

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


        <div class="btn-group-vertical btn-block">
            <!-- ORAS -->
            
            <button type="button" class="btn btn-success m-1" data-toggle="collapse" data-target="#demo">ORAS</button>
            <div id="demo" class="collapse">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="m-5">

                    <div class="form-group">
                        <label for="nume">Nume Oras</label>
                        <input type="text" class="form-control" placeholder="Oras" id="oras" name="nume_oras">
                    </div>
                    <div class="form-group">
                        <label for="loc" class="inline">Nr. Locuitori</label>
                        <input type="number" class="form-control" placeholder="nr locuitori" id="loc" name="locuitori">
                    </div>
                    <button type="submit" class="btn btn-primary m-5" name="oras">ADAUGA</button>
                </form>

                <?php
                // Attempt select query execution
                $sql = "SELECT * FROM oras";
                if ($result = mysqli_query($mysqli, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr>";
                        echo "<th>id</th>";
                        echo "<th>oras</th>";
                        echo "<th>locuitori</th>";
                        echo "<th></th>";
                        echo "</tr>";
                        echo "</thead>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row[0] . "</td>";
                            echo "<td>" . $row['NUME'] . "</td>";
                            echo "<td>" . $row[2] . "</td>";
                            echo "<td><a href='delete.php?id=" . $row[0] . "' class='btn btn-danger'>DELETE</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo "Nu exista inregistrari.";
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                }

                // Close connection
                //mysqli_close($mysqli);
                ?>

            </div>

            <!-- LOCATIE -->
            <button type="button" class="btn btn-success m-1" id="btn1">LOCATIE</button>
            <div id="form1" style="display:none">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="m-5">
                    <div class="form-group">
                        <label for="sel1">ORAS</label>
                        <select class="form-control" id="sel1" name="L_oras">
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
                        <label for="nume">Nume Locatie</label>
                        <input type="text" class="form-control" placeholder="Locatie" id="nume" name="L_nume">
                    </div>
                    <div class="form-group">
                        <label for="email" class="inline">Latitudine</label>
                        <input type="number" step="0.000001" class="form-control" placeholder="latitudine" id="email" name="lat">
                    </div>
                    <div class="form-group">
                        <label for="email" class="inline">Longitudine</label>
                        <input type="text" class="form-control" placeholder="longitutdine" id="email" name="lng">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="L_rezv" value="1" checked>Rezervare
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary m-5" name="locatie">ADAUGA</button>
                </form>

                <?php
                // Attempt select query execution
                $sql = "SELECT L.id_locatie as loc_id, O.nume as nume_oras, L.nume as loc_nume, L.programare FROM locatie L join oras O on L.id_oras = O.id_oras";
                
                
                if ($result = mysqli_query($mysqli, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr>";
                        echo "<th>id</th>";
                        echo "<th>nume</th>";
                        echo "<th>oras</th>";
                        echo "<th>programare</th>";
                        echo "<th></th>";
                        echo "</tr>";
                        echo "</thead>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['loc_id'] . "</td>";
                            echo "<td>" . $row['loc_nume'] . "</td>";
                            echo "<td>" . $row['nume_oras'] . "</td>";
                            if ($row['programare'] == 1)
                                echo "<td>DA</td>";
                            else echo "<td>NU</td>";
                            echo "<td><a href='delete2.php?id=" . $row['loc_id'] . "' class='btn btn-danger' >DELETE</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo "Nu exista inregistrari.";
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                }

                // Close connection
                //mysqli_close($mysqli);
                ?>
            </div>

            <!-- INFO LOCATIE -->
            <button type="button" class="btn btn-success m-1" id="btn2">INFORMATII_LOCATIE</button>
            <div id="form2" style="display:none">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="m-5">
                <div class="form-group">
                        <label for="sel1">LOCATIE</label>
                        <select class="form-control" id="sel1" name="IL_loc">
                            <?php
                            // Attempt select query execution
                            $sql = "SELECT * FROM locatie";
                            if ($result = mysqli_query($mysqli, $sql)) {
                                if (mysqli_num_rows($result) > 0) {

                                    while ($row = mysqli_fetch_array($result)) {
                                        echo ("<option value='" . $row[0] . "'>" . $row['NUME'] . "</option>");
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
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nume">Descriere</label>
                        <textarea class="form-control" rows="5" id="comment" name="IL_descriere"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email" class="inline">Latitudine</label>
                        <input type="number" step=0.0000001 class="form-control" placeholder="latitudine" id="email" name="IL_lat">
                    </div>
                    <div class="form-group">
                        <label for="email" class="inline">Longitudine</label>
                        <input type="number" step=0.0000001 class="form-control" placeholder="longitutdine" id="email" name="IL_lng">
                    </div>
                    <button type="submit" class="btn btn-primary m-5" name="info_locatie">ADAUGA</button>
                </form>

                <?php
                // Attempt select query execution
                $sql = "SELECT IL.id_informatii  as ifo_id, O.nume as nume_oras, IL.descriere as il_descriere, L.nume as loc_nume, L.programare FROM locatie L join oras O on L.id_oras = O.id_oras join informatii_locatie IL on L.id_locatie = IL.id_locatie";
                
                
                if ($result = mysqli_query($mysqli, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr>";
                        echo "<th>id</th>";
                        echo "<th>nume</th>";
                        echo "<th>oras</th>";
                        echo "<th>info</th>";
                        echo "<th>programare</th>";
                        echo "<th></th>";
                        echo "</tr>";
                        echo "</thead>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['ifo_id'] . "</td>";
                            echo "<td>" . $row['loc_nume'] . "</td>";
                            echo "<td>" . $row['nume_oras'] . "</td>";
                            echo "<td>" . $row['il_descriere'] . "</td>";
                            if ($row['programare'] == 1)
                                echo "<td>DA</td>";
                            else echo "<td>NU</td>";
                            echo "<td><a href='delete3.php?id=" . $row['ifo_id'] . "' class='btn btn-danger' >DELETE</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo "Nu exista inregistrari.";
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                }

                // Close connection
                //mysqli_close($mysqli);
                ?>

            </div>


            <!-- GHID -->
            <button type="button" class="btn btn-success m-1" id="btn3">GHID</button>
            <div id="form3" style="display:none">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="m-5">
                    <div class="form-group">
                        <label for="sel1">LOCATIE</label>
                        <select class="form-control" id="sel1" name="G_locatie">
                            <?php
                            // Attempt select query execution
                            $sql = "SELECT * FROM locatie";
                            if ($result = mysqli_query($mysqli, $sql)) {
                                if (mysqli_num_rows($result) > 0) {

                                    while ($row = mysqli_fetch_array($result)) {
                                        echo ("<option value='" . $row[0] . "'>" . $row['NUME'] . "</option>");
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
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nume">Nume</label>
                        <input type="text" class="form-control" placeholder="nume" name="G_nume">
                    </div>
                    <div class="form-group">
                        <label for="nume">Prenume</label>
                        <input type="text" class="form-control" placeholder="prenume" name="G_prenume">
                    </div>
                    <button type="submit" class="btn btn-primary m-5" name="ghid">ADAUGA</button>
                </form>

                <?php
                // Attempt select query execution
                $sql = "SELECT G.id_ghid, L.nume nume_loc, G.nume, G.prenume  FROM ghid G join locatie L on G.id_locatie = L.id_locatie";
                if ($result = mysqli_query($mysqli, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr>";
                        echo "<th>id</th>";
                        echo "<th>locatie</th>";
                        echo "<th>NUME</th>";
                        echo "<th>PRENUME</th>";
                        echo "<th></th>";
                        echo "</tr>";
                        echo "</thead>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_ghid'] . "</td>";
                            echo "<td>" . $row['nume_loc'] . "</td>";
                            echo "<td>" . $row['nume'] . "</td>";
                            echo "<td>" . $row['prenume'] . "</td>";
                            echo "<td><a href='delete4.php?id=" . $row['id_ghid'] . "' class='btn btn-danger' >DELETE</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo "Nu exista inregistrari.";
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                }

                // Close connection
                //mysqli_close($mysqli);
                ?>
            </div>

            <!-- TURIST -->
            <button type="button" class="btn btn-success m-1" id="btn4">TURIST</button>
            <div id="form4" style="display:none">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="m-5">
                    <div class="form-group">
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
                    </div>
                    <div class="form-group">
                        <label for="nume">Prenume</label>
                        <input type="text" class="form-control" placeholder="prenume" id="nume" name="T_prenume">
                    </div>
                    <div class="form-group">
                        <label for="nume">CNP</label>
                        <input type="number" class="form-control" placeholder="CNP" id="nume" name="T_CNP">
                    </div>
                    <button type="submit" class="btn btn-primary m-5" name="turist">ADAUGA</button>
                </form>

                <?php
                // Attempt select query execution
                $sql = "SELECT T.id_turist id_turist, O.nume nume_oras, T.nume turist_nume, T.prenume turist_prenume, T.cnp CNP  FROM turist T join oras O on T.id_oras = O.id_oras";
                if ($result = mysqli_query($mysqli, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr>";
                        echo "<th>id</th>";
                        echo "<th>oras</th>";
                        echo "<th>NUME</th>";
                        echo "<th>PRENUME</th>";
                        echo "<th>CNP</th>";
                        echo "<th></th>";
                        echo "</tr>";
                        echo "</thead>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_turist'] . "</td>";
                            echo "<td>" . $row['nume_oras'] . "</td>";
                            echo "<td>" . $row['turist_nume'] . "</td>";
                            echo "<td>" . $row['turist_prenume'] . "</td>";
                            echo "<td>" . $row['CNP'] . "</td>";
                            echo "<td><a href='delete5.php?id=" . $row['id_turist'] . "' class='btn btn-danger' >DELETE</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo "Nu exista inregistrari.";
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                }

                // Close connection
                //mysqli_close($mysqli);
                ?>

            </div>

            <!-- PROGRAMARE -->
            <button type="button" class="btn btn-success m-1" id="btn5">PROGRAMARE</button>
            <div id="form5" style="display:none">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="m-5">

                    <div class="form-group">
                        <label for="sel1">Turist</label>
                        <select class="form-control" id="sel1" name="P_turist">
                            <?php
                            // Attempt select query execution
                            $sql = "SELECT id_turist, CONCAT( nume,  ' ', prenume ) as np  FROM turist";
                            if ($result = mysqli_query($mysqli, $sql)) {
                                if (mysqli_num_rows($result) > 0) {

                                    while ($row = mysqli_fetch_array($result)) {
                                        echo ("<option value='" . $row[0] . "'>" . $row['np'] . "</option>");
                                    }
                                    // Free result set
                                    mysqli_free_result($result);
                                } else {
                                    echo "No records matching your query were found.";
                                }
                            } else {
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sel1">Locatie</label>
                        <select class="form-control" id="sel1" name="P_locatie">
                            <?php
                            // Attempt select query execution
                            $sql = "SELECT id_locatie, nume as p_nume   FROM locatie";
                            if ($result = mysqli_query($mysqli, $sql)) {
                                if (mysqli_num_rows($result) > 0) {

                                    while ($row = mysqli_fetch_array($result)) {
                                        echo ("<option value='" . $row[0] . "'>" . $row['p_nume'] . "</option>");
                                    }
                                    // Free result set
                                    mysqli_free_result($result);
                                } else {
                                    echo "No records matching your query were found.";
                                }
                            } else {
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="data" class="inline">Data</label>
                        <input type="date" class="form-control" id="email" name="P_data">
                    </div>
                    <div class="form-group">
                        <label for="data" class="inline">Ora</label>
                        <input type="time" class="form-control" id="email" name="P_ora">
                    </div>
                    <div class="form-group">
                        <label for="data" class="inline">Pret</label>
                        <input type="number" class="form-control" id="email" name="P_pret">
                    </div>
                    <button type="submit" class="btn btn-primary m-5" name="programare">ADAUGA</button>
                </form>

                <?php
                // Attempt select query execution
                $sql = " SELECT T.id_turist as id_turist, concat(T.nume, ' ', T.prenume ) as nume_turist, L.nume nume_locatie, P.data data, P.ora ora, P.pret pret FROM turist T join programare P on T.id_turist = P.id_turist join locatie L on P.id_locatie = L.id_locatie ";
                if ($result = mysqli_query($mysqli, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr>";
                        echo "<th>nume</th>";
                        echo "<th>locatia</th>";
                        echo "<th>data</th>";
                        echo "<th>ora</th>";
                        echo "<th>pret</th>";
                        echo "<th></th>";
                        echo "</tr>";
                        echo "</thead>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['nume_turist'] . "</td>";
                            echo "<td>" . $row['nume_locatie'] . "</td>";
                            echo "<td>" . $row['data'] . "</td>";
                            echo "<td>" . $row['ora'] . "</td>";
                            echo "<td>" . $row['pret'] . "</td>";
                            echo "<td><a href='delete6.php?id=" . $row['id_turist'] . "' class='btn btn-danger' >DELETE</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo "Nu exista inregistrari.";
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                }

                // Close connection
                //mysqli_close($mysqli);
                ?>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#btn, #btn1, #btn2, #btn3, #btn4, #btn5').click(function(event) {
                if ($(event.target).attr('id') == 'btn') {
                    $("#form").toggle();
                } else if ($(event.target).attr('id') == 'btn1') {
                    $("#form1").toggle();
                } else if ($(event.target).attr('id') == 'btn2') {
                    $("#form2").toggle();
                } else if ($(event.target).attr('id') == 'btn3') {
                    $("#form3").toggle();
                } else if ($(event.target).attr('id') == 'btn4') {
                    $("#form4").toggle();
                } else if ($(event.target).attr('id') == 'btn5') {
                    $("#form5").toggle();
                }
            });

        });
    </script>




    <div class="jumbotron text-center" style="margin-bottom:0">
        <p>@ARDELEANU STEFAN</p>
    </div>

</body>

</html>