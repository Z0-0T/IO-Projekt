<?php 

Class DatabaseConnection {
    private $user;
    private $host;
    private $pass;
    private $db;

    public function __construct()
    {
		$this->host = "localhost";
        $this->user = "root";
		$this->pass = "";
        $this->db = "zutexpress";
    }
    public function connect()
    {
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
		
		if ($conn->connect_error) {
		  die("Problem z połaczeniem z bazą danych: " . $conn->connect_error);
		}
		
		$conn->set_charset("utf8");
		
        return $conn;
    }
}

?>
