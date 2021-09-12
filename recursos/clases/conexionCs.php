<?php
class Connection{
    //Atributos
    private $server = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db = 'repartos';
    protected $connection;
    protected $secured;

    //Constructores
    function __construct()
    {
        $this->connection = new mysqli($this->server ,$this->user ,$this->pass ,$this->db);
        $this->connection->set_charset("utf8");
        if ($this->connection->connect_errno){
            die('Error de conexión a Mysql: ('.$this->connection->connect_errno.') - '.$this->connection->connect_error);
        }
    }

    //Métodos
    public function protected_text($text){
        $this->secured = strip_tags($text);    
        $this->secured = htmlspecialchars(trim(stripslashes($text)),ENT_QUOTES,'UTF-8');
        return $this->secured;
    }

    protected function prepare($query){
        if (!($query = $this->connection->prepare($query))) {
            die('Ha ocurrido un error en la preparación de la consulta: ('.$this->connection->connect_errno.') - '.$this->connection->connect_error);
        }
        return $query;
    }

    public function execute($statement){
        if (!($statement->execute())) {
            die('Ha ocurrido un error en la ejecución de la sentencia: ('.$this->connection->connect_errno.') - '.$this->connection->connect_error);
        }
        return $statement;
    }
}
$connection = new Connection;
?>
