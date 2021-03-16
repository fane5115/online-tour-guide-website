<?php
session_start();
$logat = 0;
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>USER</h1>
        <h1>Buna, <b><?php echo htmlspecialchars($_SESSION["username"]); ?>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Resetare Parola</a>
        <a href="logout.php" class="btn btn-danger">Log out</a>
    </p>
</body>
</html>