<?php

/**
 * Manages the table employee in the database
 * 
 * Purpose: INFO5094 LAMP 2 Group Project - W21
 * Author:  Group 1
 */

declare(strict_types=1);    // Sets as strict types

namespace Database {
	require_once("interface.php");

	class Employee implements IRepository
	{
		function __construct($dbc)
		{
			$this->dbc = $dbc;
			$this->pdo = $dbc->pdo;
		}

		/**
		 * Gets all employees from the database ordered by name
		 *
		 * @return array [id, sSurname, sGivenName, sMiddleName, dtBirth, sGender, dtHire, iInitialLevel, sPeriodTime, iPTHoursWeek]
		 */
		function get(): array
		{
			$query = "
				SELECT id, sSurname, sGivenName, sMiddleName, dtBirth, sGender, dtHire, iInitialLevel, sPeriodTime, iPTHoursWeek
				FROM tb_Employee 
				ORDER BY sSurname, sGivenName
			";
			$stmt = $this->pdo->query($query);

			$dataSet = [];
			while ($row = $stmt->fetch()) {
				$dataSet[] = $row;
			}

			return $dataSet;
		}

		/**
		 * Gets one employee from the database ordered by name
		 *
		 * @param int $employeeId
		 * @return object [id, sSurname, sGivenName, sMiddleName, dtBirth, sGender, dtHire, iInitialLevel, sPeriodTime, iPTHoursWeek]
		 */
		function getOne(int $employeeId): array
		{
			$query = "
				SELECT id, sSurname, sGivenName, sMiddleName, dtBirth, sGender, dtHire, iInitialLevel, sPeriodTime, iPTHoursWeek
				FROM tb_Employee 
				WHERE id = :id
				ORDER BY sSurname, sGivenName
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
		 * Adds a new employee to the database
		 *
		 * @param string $sSurname
		 * @param string $sGivenName
		 * @param string $sMiddleName
		 * @param string $dtBirth
		 * @param string $sGender
		 * @param string $dtHire
		 * @param string $iInitialLevel
		 * @param string $sPeriodTime
		 * @param string $iPTHoursWeek
		 * @return bool Returns FALSE on failure 
		 */
		function insert(string $sSurname, string $sGivenName, string $sMiddleName, string $dtBirth, string $sGender, string $dtHire, string $iInitialLevel, string $sPeriodTime, string $iPTHoursWeek): bool
		{
			try {
				$data = [
					'sSurname' => $sSurname,
					'sGivenName' => $sGivenName,
					'sMiddleName' => $sMiddleName,
					'dtBirth' => $dtBirth,
					'sGender' => $sGender,
					'dtHire' => $dtHire,
					'iInitialLevel' => $iInitialLevel,
					'sPeriodTime' => $sPeriodTime,
					'iPTHoursWeek' => $iPTHoursWeek
				];

				$query = "
					INSERT INTO tb_Employee(sSurname, sGivenName, sMiddleName, dtBirth, sGender, dtHire, iInitialLevel, sPeriodTime, iPTHoursWeek) 
					VALUES (:sSurname, :sGivenName, :sMiddleName, :dtBirth, :sGender, :dtHire, :iInitialLevel, :sPeriodTime, :iPTHoursWeek);
				";

				$stmt = $this->pdo->prepare($query);
				$executed = $stmt->execute($data);

				return $executed;
			} catch (Exception $e) {
				throw $e;
			}
		}

		/**
		 * Imports employees to the database
		 *
		 * @param string $data
		 * @return bool Returns FALSE on failure 
		 */
		function import(array $data): bool
		{
			try {
				$flatData = [];
				$queryValues = [];
				foreach ($data as $row) {
					$queryValues[] = "(?, ?, ?, ?, ?, ?, ?, ?, ?)";
					foreach ($row as $item) {
						$flatData[] = $item;
					}
				}

				$query = 'INSERT INTO tb_Employee(sSurname, sGivenName, sMiddleName, dtBirth, sGender, dtHire, iInitialLevel, sPeriodTime, iPTHoursWeek) VALUES ' . implode(', ', $queryValues);

				$stmt = $this->pdo->prepare($query);
				$executed = $stmt->execute($flatData);

				return $executed;
			} catch (Exception $e) {
				throw $e;
			}
		}

		/**
		 * Adds a new employee to the database
		 *
		 * @param int $id The id of the employee to be updated
		 * @param string $sSurname
		 * @param string $sGivenName
		 * @param string $sMiddleName
		 * @param string $dtBirth
		 * @param string $sGender
		 * @param string $dtHire
		 * @param string $iInitialLevel
		 * @param string $sPeriodTime
		 * @param string $iPTHoursWeek
		 * @return bool Returns FALSE on failure 
		 */
		function update(int $id, string  $sSurname, string  $sGivenName, string  $sMiddleName, string  $dtBirth, string $sGender, string  $dtHire, string $iInitialLevel, string $sPeriodTime, string $iPTHoursWeek): bool
		{
			try {
				$data = [
					'id' => $id,
					'sSurname' => $sSurname,
					'sGivenName' => $sGivenName,
					'sMiddleName' => $sMiddleName,
					'dtBirth' => $dtBirth,
					'sGender' => $sGender,
					'dtHire' => $dtHire,
					'iInitialLevel' => $iInitialLevel,
					'sPeriodTime' => $sPeriodTime,
					'iPTHoursWeek' => $iPTHoursWeek
				];

				$query = "
					UPDATE tb_Employee
					SET sSurname = :sSurname, sGivenName = :sGivenName, sMiddleName = :sMiddleName, dtBirth = :dtBirth, sGender = :sGender, dtHire = :dtHire, iInitialLevel = :iInitialLevel, sPeriodTime = :sPeriodTime, iPTHoursWeek = :iPTHoursWeek
					WHERE id = :id;
				";

				$stmt = $this->pdo->prepare($query);
				return $stmt->execute($data);
			} catch (Exception $e) {
				throw $e;
			}
		}

		/**
		 * Deletes an employee from the database
		 *
		 * @param int $id The id of the employee to be deleted
		 * @return bool Returns FALSE on failure 
		 */
		function delete(int $id): bool
		{
			try {
				$data = [
					'id' => $id
				];

				$query = "
					DELETE FROM tb_Employee
					WHERE id = :id;
				";

				$stmt = $this->pdo->prepare($query);
				return  $stmt->execute($data);
			} catch (Exception $e) {
				throw $e;
			}
		}

		/**
		 * Deletes all employees from the database
		 * @return bool Returns FALSE on failure 
		 */
		function clear(): bool
		{
			try {
				$query = "
					DELETE FROM tb_Employee
				";

				$stmt = $this->pdo->prepare($query);
				return  $stmt->execute();
			} catch (Exception $e) {
				throw $e;
			}
		}
	}
}
