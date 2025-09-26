<?php

namespace BookMyHouse\Models;

use BookMyHouse\Database;
use PDO;

class House
{
    public int $id;
    public string $name;
    public string $city;
    public string $created_at;
    public string $updated_at;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->name = $data['name'] ?? '';
            $this->city = $data['city'] ?? '';
            $this->created_at = $data['created_at'] ?? '';
            $this->updated_at = $data['updated_at'] ?? '';
        }
    }

    public static function all(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM houses ORDER BY name, city");
        $houses = [];
        
        while ($row = $stmt->fetch()) {
            $houses[] = new self($row);
        }
        
        return $houses;
    }

    public static function find(int $id): ?self
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM houses WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        return $data ? new self($data) : null;
    }

    public static function ordered(): array
    {
        return self::all();
    }

    public function bookings(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE house_id = ? ORDER BY day");
        $stmt->execute([$this->id]);
        $bookings = [];
        
        while ($row = $stmt->fetch()) {
            $bookings[] = new Booking($row);
        }
        
        return $bookings;
    }

    public function save(): bool
    {
        $pdo = Database::getConnection();
        
        if (empty($this->id)) {
            // Insert new house
            $stmt = $pdo->prepare("
                INSERT INTO houses (name, city, created_at, updated_at) 
                VALUES (?, ?, datetime('now'), datetime('now'))
            ");
            $result = $stmt->execute([$this->name, $this->city]);
            $this->id = $pdo->lastInsertId();
            return $result;
        } else {
            // Update existing house
            $stmt = $pdo->prepare("
                UPDATE houses 
                SET name = ?, city = ?, updated_at = datetime('now') 
                WHERE id = ?
            ");
            return $stmt->execute([$this->name, $this->city, $this->id]);
        }
    }

    public function validate(): array
    {
        $errors = [];
        
        if (empty(trim($this->name))) {
            $errors[] = "Name can't be blank";
        }
        
        // Check uniqueness
        if (!empty($this->name)) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT id FROM houses WHERE name = ? AND id != ?");
            $stmt->execute([$this->name, $this->id ?? 0]);
            if ($stmt->fetch()) {
                $errors[] = "Name has already been taken";
            }
        }
        
        return $errors;
    }
}