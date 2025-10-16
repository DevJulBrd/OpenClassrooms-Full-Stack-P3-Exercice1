<?php
final class DBConnect
{
    private string $host = DB_HOST; ;
    private int $port = DB_PORT;
    private string $dbname = DB_NAME;
    private string $user = DB_USER;
    private string $password = DB_PASSWORD;
    private string $charset = 'utf8';

    // DSN structure
    public function __construct (
        string $host,
        int $port,
        string $dbname,
        string $user,
        string $password,
        string $charset
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
        $this->charset = $charset;
    }

    // PDO instance
    public function getPDO() : PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $this->host,
            $this->port,
            $this->dbname,
            $this->charset
        );

        try {
            $pdo = new PDO($dsn, $this->user, $this->password);
        }
        catch (PDOException $e) {
            die('Erreur connexion BDD : ' . $e->getMessage());
        }

        return $pdo;
    }
}