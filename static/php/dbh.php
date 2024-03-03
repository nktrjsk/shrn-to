<?php
/*
require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";
*/

class db_connect
{
    protected $conn;

    function __construct($serverip, $user, $pass, $dbname, $port=3306)
    {
        set_error_handler(function () {echo "db_error";}, E_WARNING);
        $this->conn = mysqli_connect($serverip, $user, $pass, $dbname, $port);
        mysqli_set_charset($this->conn, "utf8");
        restore_error_handler();
    }

    function execute($sql_query, $params=[])
    {
        $stmt = mysqli_stmt_init($this->conn);
        if (!mysqli_stmt_prepare($stmt, $sql_query))
        {
            echo "Chyba";
        }
        else
        {
            if (count($params)) mysqli_stmt_bind_param($stmt, str_repeat("s", count($params)), ...$params);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);

            return $result;
        }
    }

    function fetch_one($sql_query, $params=[])
    {
        return mysqli_fetch_row($this->execute($sql_query, $params));
    }

    function fetch_all($sql_query, $params=[])
    {
        return mysqli_fetch_all($this->execute($sql_query, $params));
    }

    function fetch_all_a($sql_query, $params=[])
    {
        return mysqli_fetch_all($this->execute($sql_query, $params), MYSQLI_ASSOC);
    }

    function fetch_assoc($sql_query, $params=[])
    {
        return mysqli_fetch_assoc($this->execute($sql_query, $params));
    }
}

$db = new db_connect($_SERVER["mysql_server"], $_SERVER["mysql_user"], $_SERVER["mysql_pass"], $_SERVER["mysql_db"]);