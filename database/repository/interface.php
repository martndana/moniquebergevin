<?php

/**
 * Interface for the repositories
 * 
 * Purpose: moniquebergevin site
 * Author:  Martin Bergevin
 */

namespace Database {
    interface IRepository
    {
        function get(): array;
        function delete(int $id): bool;
    }
}
