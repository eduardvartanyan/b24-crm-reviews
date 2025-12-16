<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Support\Database;
use PDO;
use RuntimeException;
use Throwable;

class ClientRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    /**
     * @return int — id добавленного клиента
     */
    public function create(array $values): int
    {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO clients (domain, title, app_sid) VALUES (:domain, :title, :app_sid);"
            );
            $stmt->execute([
                ':domain'  => $values['domain'],
                ':title'   => $values['title'],
                ':app_sid' => $values['app_sid'],
            ]);

            return (int) $this->pdo->lastInsertId();
        } catch (Throwable $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}