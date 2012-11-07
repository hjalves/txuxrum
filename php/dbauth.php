<?php /* DATABASE AUTH - do not sync */
    require('sqlqry.php');
    session_start();
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
    
    /* TODO: para outro ficheiro init */

    if ($_REQUEST['login']) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $result = sql_login($username, $password);
        $row = pg_fetch_row($result, null);
        $_SESSION['userid'] = $row[0];
    }
    if ($_REQUEST['logout']) {
        unset($_SESSION['userid']);
    }

?>
