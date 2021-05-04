<?php

declare(strict_types=1);    // Sets as strict types

namespace Database {
	require_once("interface.php");

	class Painting implements IRepository
	{
		function __construct($dbc)
		{
			$this->dbc = $dbc;
			$this->pdo = $dbc->pdo;
		}

		/**
		 * Gets all paintings from the database ordered by id
		 *
		 * @return array [id, name, dimensions, medium, medium_fr, location, status, date_added]
		 */
		function get(): array
		{
			$query = "
				SELECT id, name, dimensions, medium, medium_fr, location, status, date_added
				FROM paintings 
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
		 * Gets one painting from the database ordered by id
		 *
		 * @param int $paintingId
		 * @return array [id, name, dimensions, medium, medium_fr, location, status, date_added]
		 */
		function getOne(int $paintingId): array
		{
			$query = "
				SELECT id, name, dimensions, medium, medium_fr, location, status, date_added
				FROM paintings 
				WHERE id = :id
				ORDER BY id
			";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute(['id' => $employeeId]);

			$dataSet = [];
			while ($row = $stmt->fetch()) {
				$dataSet[] = $row;
			}

			return $dataSet;
		}

		/**
		 * Adds a new painting to the database
		 *
		 * @param string $name
		 * @param string $dimensions
		 * @param string $medium
		 * @param string $medium_fr
		 * @param string $location
		 * @param string $status
		 * @return bool Returns FALSE on failure 
		 */
		function insert(string $name, string $dimensions, string $medium, string $medium_fr, string $location, string $status): bool
		{
			try {
				$data = [
					'name' => $name,
					'dimensions' => $dimensions,
					'medium' => $medium,
					'medium_fr' => $medium_fr,
					'location' => $location,
					'status' => $status
				];

				$query = "
					INSERT INTO paintings(name, dimensions, medium, medium_fr, location, status) 
					VALUES (:name, :dimensions, :medium, :medium_fr, :location, :status);
				";

				$stmt = $this->pdo->prepare($query);
				$executed = $stmt->execute($data);

				return $executed;
			} catch (Exception $e) {
				throw $e;
			}
		}

		/**
		 * Edit painting in the database
		 *
		 * @param int $id The id of the painting to be updated
		 * @param string $name
		 * @param string $dimensions
		 * @param string $medium
		 * @param string $medium_fr
		 * @param string $location
		 * @param string $status
		 * @return bool Returns FALSE on failure 
		 */
		function update(int $id, string  $name, string  $dimensions, string  $medium, string  $medium_fr, string $location, string  $status): bool
		{
			try {
				$data = [
					'id' => $id,
					'name' => $name,
					'dimensions' => $dimensions,
					'medium' => $medium,
					'medium_fr' => $medium_fr,
					'location' => $location,
					'status' => $status
				];

				$query = "
					UPDATE paintings
					SET name = :name, dimensions = :dimensions, medium = :medium, medium_fr = :medium_fr, location = :location, status = :status
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
		 * @param int $id The id of the painting to be deleted
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
	}
}
