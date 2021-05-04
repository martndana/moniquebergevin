<?php

declare(strict_types=1);    // Sets as strict types

class Upcoming
{
    function __construct($dbc)
    {
        $this->dbc = $dbc;
        $this->pdo = $dbc->pdo;
    }

    /**
     * Gets all active upcoming events from the database ordered by date_added
     *
     * @return array [id, description, description_fr, status]
     */
    function get(): array
    {
        $query = "
            SELECT id, description, description_fr, status
            FROM upcoming 
            WHERE status > 0 
            ORDER BY id
        ";
        $stmt = $this->pdo->query($query);

        $dataSet = [];
        while ($row = $stmt->fetch()) {
            $dataSet[] = $row;
        }

        return $dataSet;
    }

    /**
     * Gets one upcoming event from the database ordered by id
     *
     * @param int $upcomingId
     * @return object [id, description, description_fr, status]
     */
    function getOne(int $upcomingId): array
    {
        $query = "
            SELECT id, description, description_fr, status
            FROM upcoming
            WHERE id = :id
            ORDER BY id
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $upcomingId]);

        $dataSet = [];
        while ($row = $stmt->fetch()) {
            $dataSet[] = $row;
        }

        return $dataSet;
    }

    /**
     * Adds a new paintings to the database
     *
     * @param string $sDescription
     * @param string $sDescription_Fr
     * @param int $iStatus
     * @return bool Returns FALSE on failure 
     */
    function insert(string $sDescription, string $sDescription_Fr, int $iStatus): bool
    {
        try {
            $data = [
                'sDescription' => $sDescription,
                'sDescription_Fr' => $sDescription_Fr,
                'iStatus' => $iStatus
            ];

            $query = "
                INSERT INTO upcoming(description, description_fr, status) 
                VALUES (:sDescription, :sDescription_Fr, :iStatus);
            ";

            $stmt = $this->pdo->prepare($query);
            $executed = $stmt->execute($data);

            return $executed;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Update an existing upcoming event in the database
     *
     * @param int $id The id of the upcoming event to be updated
     * @param string $sDescription
     * @param string $sDescription_Fr
     * @param int $iStatus
     * @return bool Returns FALSE on failure 
     */
    function update(int $id, string $sDescription, string $sDescription_Fr, int $iStatus): bool
    {
        try {
            $data = [
                'id' => $id,
                'sDescription' => $sDescription,
                'sDescription_Fr' => $sDescription_Fr,
                'iStatus' => $iStatus
            ];

            $query = "
                UPDATE upcoming
                SET description = :sDescription, description_fr = :sDescription_Fr, status = :iStatus
                WHERE id = :id;
            ";

            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Deletes an upcoming event from the database
     *
     * @param int $id The id of the upcoming event to be deleted
     * @return bool Returns FALSE on failure 
     */
    function delete(int $id): bool
    {
        try {
            $data = [
                'id' => $id
            ];

            $query = "
                UPDATE upcoming
                SET status = 0
                WHERE id = :id;
            ";

            $stmt = $this->pdo->prepare($query);
            return  $stmt->execute($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Deletes all upcoming events from the database
     * @return bool Returns FALSE on failure 
     */
    function clear(): bool
    {
        try {
            $query = "
                UPDATE upcoming
                SET status = 0;
            ";

            $stmt = $this->pdo->prepare($query);
            return  $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}

