<?php
require_once 'consts.php';
require_once 'game_objects/Logger.php';
require_once 'game_objects/Message.php';

class Db
{
    //jméno z kontejneru Dockeru
    protected ?string $servername =  'localhost'; //'db'; //'localhost';
    protected ?int $port =  3306;// 
    protected ?string $username = 'root';
    protected ?string $password = '';// "secret";
    protected ?string $database = 'lode';

    
    protected ?\PDO $db = null;


    protected static ?Db $instance = null;


    protected function __construct(){
        $this->db = new PDO("mysql:host={$this->servername};port={$this->port};dbname={$this->database};",
            $this->username, $this->password);
    }

    protected static function getDb() : \PDO{
        if(self::$instance == null){
            self::$instance = new Db();
        }
        return self::$instance->db;
    }

    protected static function prepare(string $query, array $params) : PDOStatement{
        $conn = self::getDb();
        $prep = $conn->prepare($query, $params);
        foreach ($params as $key => $value) {
            $prep->bindValue(":{$key}", $value);
        }
        return $prep;
    }
/*
    protected static function log(string $message, array $context = []) : void{
        Logger::log($message, $context, 'DB_');
    }
*/
    public static function select(string $sql, array $params = []) : array{
        Logger::log($sql, $params, 'DB_');
        $stat = self::prepare($sql, $params);
        $stat->execute();
        return $stat->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function query(string $query, array $params = []) : bool
    {
        //echo $query."<hr/>";
        Logger::log($query, $params);
        //Logger::log($params);
        $stat = self::prepare($query, $params, 'DB_');
        return $stat->execute();
    }
}