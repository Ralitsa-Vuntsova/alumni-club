<?php
class AlumniClubDB {

    private $connection;

    public function __construct()
    {
        $dbtype = "mysql";
        $host = "localhost";
        $username = "root";
        $pass = "";
        $dbname = "alumniClub";

        $this->connection = new PDO("$dbtype:host=$host;dbname=$dbname",
        $username, $pass,
        [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
?>