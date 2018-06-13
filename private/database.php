<?php
    /**
     functions related to database
     */

    require_once ('db_credentials.php');

    function db_connect(){
        $connection = (new MongoDB\Client);

        try
        {
            $connection->listDatabases();
        }
        catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e)
        {
            echo "PHP cannot find a MongoDB server using the MongoDB connection 
                string specified.";
            exit();
        }

        return $connection;
    }

    function confirm_result_set($result_set){
        if(!$result_set){
            exit("DB query failed. Returned NuLL");
        }
    }




