<?php
require_once("tmsdk.include.php");

/**
  MySQL class of TMSDK, may be used for any MySQL project.
*/
class conndb
{
    private $mysql;
    /**
      Public sql log, usefull for debug or to trace all the SQL queries.
      May be called with my_conndb_class->sqlog.
    */
    public $sqlog;

    /**
      Class constructor.
      Remember to destruct the class in order to close the connection.
      @param $db_host IP or DNS name of the MySQL server
      @param $db_port the MySQL port (usually 3306)
      @param $db_user the MySQL user
      @param $db_pass the MySQL user's password
      @param $db_name the database which the class will be binded to
    */
    public function __construct($db_host, $db_port, $db_user, $db_pass, $db_name)
    {
        $this->mysql = @mysqli_connect($db_host.":".$db_port, $db_user, $db_pass, $db_name) or die('Incorrect MySQL Information!');
            mysqli_select_db($this->mysql,$db_name) or die(mysqli_connect_error());
    }

    /**
      Class destructor.
      Closes the MySQL connection.
    */
    public function __destruct()
    {
        @mysqli_close($this->mysql) or die(mysqli_connect_error($this->mysql));
    }

    /**
      Sends a query (ie INSERT, UPDATE, DELETE)
      @param $query the query to run
    */
    public function send($query)
    {
        @mysqli_query($query,$this->mysql) or die(mysqli_error());
        $this->sqlog .= $query."\n";
    }

    /**
      Retrive SQL data (ie SELECT)
      @param $query the query to run
    */
    public function retrieve($query)
    {
        $sql = @mysqli_query($query,$this->mysql) or die(mysqli_error());
        $this->sqlog .= $query."\n";
        return $sql;
    }
}
?>
