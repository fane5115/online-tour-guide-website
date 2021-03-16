<?php
    
    define( 'DB_SERVER', 'localhost' );
    define( 'DB_USERNAME', 'root' );
    define( 'DB_PASSWORD', '' );
    define( 'DB_NAME', 'BD_PROIECT' );

    $mysqli = new mysqli( DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME );

    if( $mysqli == FALSE )
        die( "EROARE: Nu s-a putut conecta" . $mysqli->connect_error );
?>