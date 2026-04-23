<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Application
{
    public function create(array $data): int
    {
        $sql = 'INSERT INTO applications
            (full_name, email, phone, city_state, desired_business_type, available_capital, financing_needed, relevant_experience, timeline_to_launch, business_reason, agreement_acknowledged, status, ip_address, user_agent, created_at)
            VALUES
            (:full_name, :email, :phone, :city_state, :desired_business_type, :available_capital, :financing_needed, :relevant_experience, :timeline_to_launch, :business_reason, :agreement_acknowledged, :status, :ip_address, :user_agent, NOW())';

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($data);

        return (int) Database::connection()->lastInsertId();
    }

    public function paginate(string $status = '', string $business = '', string $query = ''): array
    {
        $sql = 'SELECT * FROM applications WHERE 1=1';
        $params = [];

        if ($status !== '') {
            $sql .= ' AND status = :status';
            $params['status'] = $status;
        }

        if ($business !== '') {
            $sql .= ' AND desired_business_type = :business';
            $params['business'] = $business;
        }

        if ($query !== '') {
            $sql .= ' AND (full_name LIKE :query OR email LIKE :query OR phone LIKE :query)';
            $params['query'] = '%' . $query . '%';
        }

        $sql .= ' ORDER BY created_at DESC LIMIT 200';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM applications WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function updateStatus(int $id, string $status): void
    {
        $stmt = Database::connection()->prepare('UPDATE applications SET status = :status, updated_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $id, 'status' => $status]);
    }
}
