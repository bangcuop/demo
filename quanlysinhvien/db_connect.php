<?php

class Database {

    private $db_connect;
    private $queryResult;

    function __construct() {
        $this->connect();
    }

    function connect() {
        require_once __DIR__ . '/db_config.php';
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());
        $this->db_connect= mysql_select_db(DB_DATABASE) or die(mysql_error()) or die(mysql_error());
        return $con;
        
    }

    function disconnect() {
        mysql_close($this->db_connect);
    }

    function query($sql) {

        $this->queryResult = @mysql_query($sql, $this->db_connect);

        return $this->queryResult;
    }

    function fetch($result = NULL) {

        // Nếu không truyền result query  

        if ($result == NULL) {

            // Nếu tồn tại result query  

            if (is_resource($this->queryResult))
                return mysql_fetch_assoc($this->queryResult);

            return NULL;
        }

        return mysql_fetch_assoc($result);
    }

    function fetch_array($result = NULL) {

        // Nếu không truyền result query  

        if ($result == NULL) {

            if (is_resource($this->queryResult))
                while ($r = $this->fetch()) {

                    $array[] = $r;
                }
        } else {  // Có truyền result  
            while ($r = $this->fetch($result)) {

                $array[] = $r;
            }
        }

        return $array;
    }

    function exec_query($sql) {

        $this->query($sql);

        return mysql_affected_rows();
    }

    function num_rows($result = NULL) {

        if ($result == NULL) {

            if (is_resource($this->queryResult))
                return mysql_num_rows($this->queryResult);
        }

        return mysql_num_rows($result);
    }

    function __destruct() {

        $this->disconnect();
    }

}
?>  
