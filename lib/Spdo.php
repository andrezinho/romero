<?php
class Spdo extends PDO 
{
    private static $instance = null;
<<<<<<< HEAD
    protected  $host = '192.168.1.10';
=======
    protected  $host = 'localhost';
>>>>>>> 1525f194aff1241198d195db3f74a3e4d0d852f7
    protected $port = '5432';
    protected $dbname='bdromero';
    protected $user='postgres';
    protected $password='12345678';

	public function __construct()
	{            
            $dns='pgsql:dbname='.$this->dbname.';host='.$this->host.';port='.$this->port;
            $user = $this->user;
            $pass = $this->password;
            parent::__construct($dns,$user,$pass);
	}
	public static function singleton()
	{
        if( self::$instance == null )
            {
                self::$instance = new self();
            }
         return self::$instance;
	}
}
?>