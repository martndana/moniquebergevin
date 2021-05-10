<?php

declare(strict_types=1);    // Sets as strict types

namespace Database {
	require_once("interface.php");

	class User implements IRepository
	{
		function __construct($dbc)
		{
			$this->dbc = $dbc;
			$this->pdo = $dbc->pdo;
		}

		/**
		 * Gets all users from the database ordered by Username
		 *
		 * @return array [idUsers, uidUsers]
		 */
		function get(): array
		{
			$query = "
				SELECT idUsers, uidUsers
				FROM users 
				ORDER BY uidUsers
			";
			$stmt = $this->pdo->query($query);

			$dataSet = [];
			while ($row = $stmt->fetch()) {
				$dataSet[] = $row;
			}

			return $dataSet;
		}

		/**
		 * Gets all users from the database ordered by Username
		 *
		 * @return object {idUsers, uidUsers}
		 */
		function getLogin(string $sUsername, string $sPassword)
		{
			$data = [
				'sUsername' => $sUsername,
				'sPassword' => $sPassword
			];

			$query = "
				SELECT idUsers, uidUsers
				FROM users 
				WHERE uidUsers = :sUsername AND pwdUsers = SHA1(:sPassword)
			";

			$stmt = $this->pdo->prepare($query);
			$stmt->execute($data);
			return  $stmt->fetch();
		}

		/**
		 * Adds a new user to the database
		 *
		 * @param string $sUsername
		 * @param string $sPassword
		 * @return bool Returns FALSE on failure 
		 */
		function insert(string $sUsername, string $sPassword): bool
		{
			try {
				$data = [
					'sUsername' => $sUsername,
					'sPassword' => $sPassword
				];

				$query = "
					INSERT INTO users(uidUsers, pwdUsers) 
					VALUES (:sUsername, SHA1(:sPassword));
				";

				$stmt = $this->pdo->prepare($query);
				$executed = $stmt->execute($data);

				return $executed;
			} catch (Exception $e) {
				throw $e;
			}
		}

		/**
		 * Adds a new user to the database
		 *
		 * @param int $id The idUsers of the user to be updated
		 * @param string $sUsername
		 * @param string $sPassword
		 * @return bool Returns FALSE on failure 
		 */
		function update(int $id, string  $sUsername, string $sPassword): bool
		{
			try {
				$data = [
					'id' => $id,
					'sUsername' => $sUsername,
					'sPassword' => $sPassword
				];

				$query = "
					UPDATE users
					SET uidUsers = :sSurname, pwdUsers = SHA1(:sPassword)
					WHERE idUsers = :id;
				";

				$stmt = $this->pdo->prepare($query);
				return $stmt->execute($data);
			} catch (Exception $e) {
				throw $e;
			}
		}

		/**
		 * Deletes an user from the database
		 *
		 * @param int $id The idUsers of the user to be deleted
		 * @return bool Returns FALSE on failure 
		 */
		function delete(int $id): bool
		{
			try {
				$data = [
					'id' => $id
				];

				$query = "
					DELETE FROM users
					WHERE idUsers = :id;
				";

				$stmt = $this->pdo->prepare($query);
				return  $stmt->execute($data);
			} catch (Exception $e) {
				throw $e;
			}
		}

		/**
		 * Deletes all users from the database
		 * @return bool Returns FALSE on failure 
		 */
		function clear(): bool
		{
			try {
				$query = "
					DELETE FROM users
				";

				$stmt = $this->pdo->prepare($query);
				return  $stmt->execute();
			} catch (Exception $e) {
				throw $e;
			}
		}
	}
}
