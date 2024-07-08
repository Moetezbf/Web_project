<?php
class PDOCONN {
    private $username;
    private $password;
    private $dbname;
    private $servername;
    private $dsn;
    public function __construct($servername, $dbname, $username, $password) {
        $this->servername = $servername;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->dsn="mysql:host=".$this->$servername.";dbname=".$this->$dbname.";charset=utf8";
    }
    public function connect() {
        try{
            $conn= new PDO($this->dsn, $this->username,$this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            echo "Error : " . $e->getMessage();
        }
        return $conn;
    }
}