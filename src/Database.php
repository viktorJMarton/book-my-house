<?php

namespace BookMyHouse;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;
    private static string $dbPath = __DIR__ . '/../database/book_my_house.sqlite';

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO('sqlite:' . self::$dbPath);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
            }
        }
        
        return self::$connection;
    }

    public static function createTables(): void
    {
        $pdo = self::getConnection();
        
        // Create houses table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS houses (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(255) NOT NULL UNIQUE,
                city VARCHAR(255) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Create bookings table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS bookings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                day DATE NOT NULL UNIQUE,
                house_id INTEGER NOT NULL,
                number_of_guests INTEGER,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (house_id) REFERENCES houses(id)
            )
        ");
        
        // Insert sample houses if none exist
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM houses");
        $result = $stmt->fetch();
        
        if ($result['count'] == 0) {
            $pdo->exec("
                INSERT INTO houses (name, city) VALUES 
                ('Beach House', 'Malibu'),
                ('Mountain Cabin', 'Aspen'),
                ('City Apartment', 'New York')
            ");
        }
    }
}