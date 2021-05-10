<?php

declare(strict_types=1);    // Sets as strict types

// Includes the repositories
include_once('repository/user.php');
include_once('repository/painting.php');
include_once('repository/upcoming.php');

/**
 * Controls the connection to the database
 */
class DbConnection
{
    /**
     * The PDO object
     *
     * @var PDO
     */
    public $pdo;

    /**
     * Whether it is connected to the database
     *
     * @var bool
     */
    public $isConnected;

    /**
     * Methods to work with the paintings table
     *
     * @var Database\Painting
     */
    public $painting;

    /**
     * Methods to work with the users table
     *
     * @var Database\User
     */
    public $user;

    /**
     * Methods to work with the upcoming table
     *
     * @var Database\Upcoming
     */
    public $upcoming;

    function __construct()
    {
        $this->isConnected = false;

        $host = "db-moniquebergevin.c9wt5b34nzxa.us-east-2.rds.amazonaws.com";
        $db = "moniquebergevin";
        $user = "martndana";
        $pass = "Fred3381!";

        $charset = "utf8mb4";
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            // Repositories
            $this->painting = new Painting($this);
            $this->user = new User($this);
            $this->upcoming = new Upcoming($this);

            // Sets as connected
            $this->isConnected = true;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Executes an SQL statement, returning a result set as a PDOStatement object
     *
     * @param string $statement The SQL statement to prepare and execute.
     * @return object returns a PDOStatement object, or FALSE on failure.
     */
    function query(string $statement)
    {
        return $this->pdo->query($statement);
    }

    /**
     * Executes an SELECT SQL statement, returning a result set as an array
     *
     * @param string $statement The SELECT SQL statement to execute
     * @return array returns the selected fields as an array of object
     */
    function select(string $statement)
    {
        $result = $this->pdo->query($statement);

        $dataSet = [];
        while ($row = $result->fetch()) {
            $dataSet[] = $row;
        }

        return $dataSet;
    }
}
