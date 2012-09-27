<?php /* DATABASE AUTH - do not sync */
    
    /* -- settings -- blank = default */
    /* host - hostname has priority over host address */
    $dbhost       = "localhost";
    $dbhostaddr   = "127.0.0.1";
    $dbport       = "5432";
    
    /* database name */
    $dbdbname     = "mydbtest";
    
    /* user auth */
    $dbuser       = "pguser";
    $dbpassword   = "qwerty";
    
    /* verbose */
    $dbv          = FALSE;
    
    /* -- connection to database server -- */
    $dbconnection_string = "port='" . $dbport . "' dbname='" . $dbdbname . "' user='" . $dbuser . "' password='" . $dbpassword . "'";
    
    $dblink = FALSE;
    
    if ($dbhost) {
        $dblink = pg_Connect("host='" . $dbhost . "' " . $dbconnection_string);
        
        if ($dbv) {
            if (!$dblink)
                echo "Connection to host failled. ";
            else
                echo "Connection to host established. ";
        }
    }
    
    if (!$dblink && $dbhostaddr) {
        $dblink = pg_Connect("hostaddr='" . $dbhostaddr . "' " . $dbconnection_string);
        
        if ($dbv) {
            if (!$dblink)
                echo "Connection to host address failled. ";
            else
                echo "Connection to host address established. ";
        }
    }
    
    if ($dbv) {
        if ($dblink)
            echo "Connnected.";
        else
            echo "Not connected.";
    }
    
    unset($dbhost, $dbhostaddr, $dbport, $dbdbname, $dbuser, $dbpassword, $dbv, $dbconnection_string);
    
?>
