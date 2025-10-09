<?php
final class DBConnect
{
    private string $host = '127.0.0.1';
    private int $port = 3306;
    private string $dbname = 'P3-exercice1-CLI';
    private string $user = 'root';
    private string $password = '';
    private string $charset = 'utf8';

    // DSN structure
    public function _construct (
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