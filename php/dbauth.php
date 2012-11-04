<?php /* DATABASE AUTH - do not sync */
    
    /* -- settings -- */
    /* hostname and socket port */
    $dbhost = "localhost";
    $dbport = "5432";
    /* database name */
    $dbname = "txux";
    /* user auth */
    $dbuser = "txux";
    $dbpass = "txux";
    /* verbose */
    $dbverb = TRUE;

    /* -- connection to database server -- */
    $dbconnection_string = "host=$dbhost port=$dbport dbname=$dbname user=$dbuser password=$dbpass";
    $dblink = pg_connect($dbconnection_string);
    
    if ($dbverb) {
        if (!$dblink)
            echo "Database connection failed: '$dbconnection_string'";
        else
            echo "Database connected: '$dbconnection_string'";
    }

    unset($dbhost, $dbport, $dbname, $dbuser, $dbpass, $dbverb, $dbconnection_string);
    
?>
