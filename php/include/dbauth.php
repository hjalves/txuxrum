<?php /* DATABASE AUTH - do not sync */
    $included = strtolower(realpath(__FILE__)) != strtolower(realpath($_SERVER['SCRIPT_FILENAME']));
    if (!$included)
        header('Location: .');

    /* -- settings -- */
    /* hostname and socket port */
    $dbhost = "localhost";
    $dbport = "5432";
    /* database name */
    $dbname = "txux";
    /* user auth */
    $dbuser = "txux";
    $dbpass = "";
    /* verbose */
    $dbverb = FALSE;

    /* -- connection to database server -- */
    $dbconnection_string = "host=$dbhost port=$dbport dbname=$dbname user=$dbuser password=$dbpass";
    $dblink = pg_connect($dbconnection_string) or die("Database connection failed: '$dbconnection_string'");

    if ($dbverb) {
        if (!$dblink)
            echo "Database connection failed: '$dbconnection_string'";
        else
            echo "Database connected: '$dbconnection_string'";
    }

    unset($dbhost, $dbport, $dbname, $dbuser, $dbpass, $dbverb, $dbconnection_string);
?>
