<?php

namespace BookMyHouse\Models;

use BookMyHouse\Database;
use PDO;
use DateTime;

class Booking
{
    public int $id;
    public string $day;
    public int $house_id;
    public ?int $number_of_guests;
    public string $created_at;
    public string $updated_at;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->day = $data['day'] ?? '';
            $this->house_id = $data['house_id'] ?? 0;
            $this->number_of_guests = $data['number_of_guests'] ?? null;
            $this->created_at = $data['created_at'] ?? '';
            $this->updated_at = $data['updated_at'] ?? '';
        }
    }

    public static function all(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM bookings ORDER BY day");
        $bookings = [];
        
        while ($row = $stmt->fetch()) {
            $bookings[] = new self($row);
        }
        
        return $bookings;
    }

    public static function ordered(): array
    {
        return self::all();
    }

    public static function find(int $id): ?self
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        return $data ? new self($data) : null;
    }

    public static function bookedFor(string $date): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM bookings WHERE day = ?");
        $stmt->execute([$date]);
        $result = $stmt->fetch();
        
        return $result['count'] > 0;
    }

    public function house(): ?House
    {
        return House::find($this->house_id);
    }

    public function save(): bool
    {
        $pdo = Database::getConnection();
        
        if (empty($this->id)) {
            // Insert new booking
            $stmt = $pdo->prepare("
                INSERT INTO bookings (day, house_id, number_of_guests, created_at, updated_at) 
                VALUES (?, ?, ?, datetime('now'), datetime('now'))
            ");
            $result = $stmt->execute([$this->day, $this->house_id, $this->number_of_guests]);
            $this->id = $pdo->lastInsertId();
            return $result;
        } else {
            // Update existing booking
            $stmt = $pdo->prepare("
                UPDATE bookings 
                SET day = ?, house_id = ?, number_of_guests = ?, updated_at = datetime('now') 
                WHERE id = ?
            ");
            return $stmt->execute([$this->day, $this->house_id, $this->number_of_guests, $this->id]);
        }
    }

    public function validate(): array
    {
        $errors = [];
        
        if (empty($this->day)) {
            $errors[] = "Day can't be blank";
        }
        
        if (empty($this->house_id)) {
            $errors[] = "House must be selected";
        }
        
        // Check day uniqueness
        if (!empty($this->day)) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT id FROM bookings WHERE day = ? AND id != ?");
            $stmt->execute([$this->day, $this->id ?? 0]);
            if ($stmt->fetch()) {
                $errors[] = "Day has already been taken";
            }
        }
        
        // Validate date format
        if (!empty($this->day)) {
            $date = DateTime::createFromFormat('Y-m-d', $this->day);
            if (!$date || $date->format('Y-m-d') !== $this->day) {
                $errors[] = "Day is not a valid date";
            }
        }
        
        return $errors;
    }
}