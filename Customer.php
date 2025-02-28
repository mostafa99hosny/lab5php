<?php
class Customer {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertCustomer($name, $email, $password, $profilePicture, $roomId) {
        $sql = "INSERT INTO customer (name, email, password, profile_picture, room_id) VALUES (:name, :email, :password, :profile_picture, :room_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':profile_picture' => $profilePicture,
            ':room_id' => $roomId
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getAllRooms() {
        $sql = "SELECT * FROM room";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCustomers() {
        $sql = "SELECT customer.id, customer.name, customer.email, customer.profile_picture, room.name AS room_name 
                FROM customer 
                LEFT JOIN room ON customer.room_id = room.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomerById($id) {
        $sql = "SELECT * FROM customer WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteCustomer($id) {
        $sql = "DELETE FROM customer WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

    public function updateCustomer($id, $name, $email, $roomId, $profilePicture = null) {
        $sql = "UPDATE customer SET name = :name, email = :email, room_id = :room_id";
        $params = [
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':room_id' => $roomId
        ];

        if ($profilePicture) {
            $sql .= ", profile_picture = :profile_picture";
            $params[':profile_picture'] = $profilePicture;
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}