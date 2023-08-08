<?php
namespace Nihol\Ibmdb2;
define( 'SERVER', '192.168.100.127' );
define( 'USER', 'pltdwadm' );
define( 'PASS', '123456' );
define( 'DBNAME', 'INTPLTDW' );
define( 'SCHEME', 'NIHOLDB2' );
define( 'DB2LIB', '/opt/ibm/db2/dsdriver/lib/libdb2o.so' );

class Db2Connect
{
    public $connectionString;
    private $connection;
    private $server, $user, $pass, $dbname, $db, $port, $scheme, $db2lib;

    function __construct($server, $user, $pass, $dbname, $scheme, $db2lib, $port = 50000)
    {
        $this->server = $server;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->scheme = $scheme;
        $this->db2lib = $db2lib;
        $this->port = $port;
        $this->openConnection();
    }

    public function openConnection()
    {
        if (!$this->db) {
            $driver  = "DRIVER=$this->db2lib;";
            $dsn     = "DATABASE=$this->dbname; " .
                "HOSTNAME=$this->server;" .
                "PORT=$this->port; " .
                "PROTOCOL=TCPIP; " .
                "UID=$this->user;" .
                "PWD=$this->pass;";
            $this->connectionString = $driver . $dsn;
            $this->connection = db2_connect($this->connectionString, '', '');
            if ($this->connection) {
                $this->db = true;
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function findAll($sql){

        $stmt = db2_prepare($this->connection, $sql);
        $result = db2_execute($stmt);
        $rs = array();
        while ($row = db2_fetch_assoc($stmt)) {
            $rs[] = $row;
        }
        /*$rc = db2_close($this->connection);
        if ($rc) {
            echo "Connection was successfully closed.";
        }*/
        return $rs;
    }

    public function findOne($sql){

        $stmt = db2_prepare($this->connection, $sql);
        db2_execute($stmt);
        return db2_fetch_assoc($stmt);
    }

}