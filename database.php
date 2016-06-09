<?php

include_once dirname(__FILE__) . '\config.php';

class MySQLDatabase {
    
    private $connection;
    private $stmt;
    private $magic_quotes_active;
    private $real_escape_string;
    public $last_query;
    
    public function __construct() {
        $this->open_connection();
        $this->magic_quotes_active = get_magic_quotes_gpc();
        $this->real_escape_string = function_exists('mysql_real_escape_string');
    }
    
    public function open_connection() {
        try {
            $this->connection = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8mb4'
                , DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => true));
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch( PDOException $e) {
            $output = '<p class="bg-danger">';
            $output .= "Conexao com o Banco de dados falhou: ";
            $output .= '<br />' . $e->getMessage();
            $output .= '</p>';
            die($output);
        }        
    }
    
    public function close_connection() {
        if (isset($this->connection)) {  
            unset($this->connection);
            $this->connection = null;
        }
    }
    
    public function query($sql, $bind_values = null) {
        try {
            $this->last_query = $sql;            
            $this->stmt = $this->connection->prepare($sql);
            if(is_array($bind_values)) {
                $this->stmt->execute($bind_values);
            } else {            
                $this->stmt->execute();
            }
        } catch( PDOException $e) {
            $output = '<p class="bg-danger">';
            $output .= "Database query falhou: " . $e->getMessage() . '<br />';            
            $output .= "Ultima query sql: " . $this->last_query;
            $output .= '</p>';
            die($output);
        }
    }
    
    public function fetch() {
        return $this->stmt->fetch();
    }
    
    public function all() {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);        
    }
    
    public function rows() {
        return $this->stmt->rowCount();
    }
    
    public function prepare($sql) {
        echo $this->connection->prepare($sql);
    }
    
    public function execute() {
        $this->stmt->execute();
    }
    
    public function bind_value($order, $value) {
        $this->stmt->bindParam($order, $value);
    }
    
    public function insert_id() {
        return $this->connection->lastInsertId();
    }
    
    public function escape_value($value) {        
        if($this->real_escape_string) {
            if ($this->magic_quotes_active) {
                $value = stripslashes($value);
            }
            //$value = mysql_real_escape_string($value);
        } else {
            if (!$this->magic_quotes_active) {
                $value = addslashes($value);
            }
        }
        return $value;
    }
}

$database = new MySQLDatabase();
$db =& $database;