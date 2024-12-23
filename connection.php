<?php
class Connection {
    private $host = '127.0.0.1'; // Default host
    private $user = 'root'; // Default MySQL user for XAMPP
    private $password = ''; // Default blank password for XAMPP
    private $dbname = 'pemweb'; // Replace with your database name
    private $conn;

    // Constructor to initialize connection
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        // Check if connection failed
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to return the connection object
    public function getConnection() {
        return $this->conn;
    }

    // Method to close the connection
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    // Method to execute a query
    public function executeQuery($sql, $params = [], $types = '') {
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $this->conn->error);
        }

        // Bind parameters if provided
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }

        return $stmt;
    }

    // Method to fetch all results
    public function fetchAll($sql, $params = [], $types = '') {
        $stmt = $this->executeQuery($sql, $params, $types);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method to fetch a single result
    public function fetchOne($sql, $params = [], $types = '') {
        $stmt = $this->executeQuery($sql, $params, $types);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Method to perform an insert or update and get affected rows
    public function affectedRows($sql, $params = [], $types = '') {
        $stmt = $this->executeQuery($sql, $params, $types);
        return $stmt->affected_rows;
    }
}
?>
