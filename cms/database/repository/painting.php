<?php

declare(strict_types=1);    // Sets as strict types

class Painting
{
    function __construct($dbc)
    {
        $this->dbc = $dbc;
        $this->pdo = $dbc->pdo;
    }

    /**
     * Gets all paintings from the database ordered by date_added
     *
     * @return array [id, name, dimensions, medium, medium_fr, location, status, date_added]
     */
    function get(): array
    {
        $query = "
            SELECT id, name, dimensions, medium, medium_fr, location, status, date_added
            FROM paintings 
            ORDER BY date_added DESC
        ";
        $stmt = $this->pdo->query($query);

        $dataSet = [];
        while ($row = $stmt->fetch()) {
            $dataSet[] = $row;
        }

        return $dataSet;
    }

    /**
     * Gets one painting from the database ordered by date_added
     *
     * @param int $paintingId
     * @return object [id, name, dimensions, medium, medium_fr, location, status, date_added]
     */
    function getOne(int $paintingId): array
    {
        $query = "
            SELECT id, name, dimensions, medium, medium_fr, location, status, date_added
            FROM paintings
            WHERE id = :id
            ORDER BY date_added
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $paintingId]);

        $dataSet = [];
        while ($row = $stmt->fetch()) {
            $dataSet[] = $row;
        }

        return $dataSet;
    }

    /**
     * Adds a new paintings to the database
     *
     * @param string $sName
     * @param string $sDimensions
     * @param string $sMedium
     * @param string $sMedium_Fr
     * @param string $sLocation
     * @param int $iStatus
     * @return bool Returns FALSE on failure 
     */
    function insert(string $sName, string $sDimensions, string $sMedium, string $sMedium_Fr, string $sLocation, int $iStatus): bool
    {
        try {
            $data = [
                'sName' => $sName,
                'sDimensions' => $sDimensions,
                'sMedium' => $sMedium,
                'sMedium_Fr' => $sMedium_Fr,
                'sLocation' => $sLocation,
                'iStatus' => $iStatus
            ];

            $query = "
                INSERT INTO paintings(name, dimensions, medium, medium_fr, location, status) 
                VALUES (:sName, :sDimensions, :sMedium, :sMedium_Fr, :sLocation, :iStatus);
            ";

            $stmt = $this->pdo->prepare($query);
            $executed = $stmt->execute($data);

            return $executed;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Update an existing painting in the database
     *
     * @param int $id The id of the painting to be updated
     * @param string $sName
     * @param string $sdimensions
     * @param string $sMedium
     * @param string $sMedium_Fr
     * @param string $sLocation
     * @param int $iStatus
     * @return bool Returns FALSE on failure 
     */
    function update(int $id, string $sName, string $sdimensions, string $sMedium, string $sMedium_Fr, string $sLocation, int $iStatus): bool
    {
        try {
            $data = [
                'id' => $id,
                'sName' => $sName,
                'sDimensions' => $sdimensions,
                'sMedium' => $sMedium,
                'sMedium_Fr' => $sMedium_Fr,
                'sLocation' => $sLocation,
                'iStatus' => $iStatus
            ];

            $query = "
                UPDATE paintings
                SET name = :sName, dimensions = :sDimensions, medium = :sMedium, medium_fr = :sMedium_Fr, location = :sLocation, status = :iStatus
                WHERE id = :id;
            ";

            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Deletes a painting from the database
     *
     * @param int $id The id of the paintings to be deleted
     * @return bool Returns FALSE on failure 
     */
    function delete(int $id): bool
    {
        try {
            $data = [
                'id' => $id
            ];

            $query = "
                DELETE FROM paintings
                WHERE id = :id;
            ";

            $stmt = $this->pdo->prepare($query);
            return  $stmt->execute($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Deletes all paintings from the database
     * @return bool Returns FALSE on failure 
     */
    function clear(): bool
    {
        try {
            $query = "
                DELETE FROM paintings
            ";

            $stmt = $this->pdo->prepare($query);
            return  $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}

