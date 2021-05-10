<?php

/**
 * Manages the database
 * 
 * Purpose: INFO5094 LAMP 2 Group Project - W21
 * Author:  Group 1
 */

declare(strict_types=1);    // Sets as strict types

// Includes the repositories
include_once('repository/employee.php');
include_once('repository/user.php');
include_once('repository/salarygrid.php');
include_once('controller/salarygrid.php');

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
     * Methods to work with the employee table
     *
     * @var Database\Employee
     */
    public $employee;

    /**
     * Methods to work with the user table
     *
     * @var Database\User
     */
    public $user;

    /**
     * Methods to work with the salary grid table
     *
     * @var Database\SalaryGrid
     */
    public $salaryGrid;

    function __construct()
    {
        $this->isConnected = false;

        $host = "localhost";
        $db = "human_resource";
        $user = "hr_user";
        $pass = "usrEmpHr#21";

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
            $this->employee = new Database\Employee($this);
            $this->user = new Database\User($this);
            $this->salaryGrid = new Database\SalaryGrid($this);

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
