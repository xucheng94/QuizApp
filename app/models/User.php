<?php

require_once __DIR__ . '/../config/database.php';

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = getDBConnection();
    }


    /* ===============================
       FIND USER BY EMAIL and ID
       =============================== */
    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }




    /* ===============================
       FIND USER BY USERNAME
       =============================== */
    public function findByUsername(string $username)
    {
        $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }


    /* ===============================
       CREATE NEW USER (STUDENT)
       =============================== */
    public function createUser(array $data)
    {
        $sql = "INSERT INTO users (email, first_name, last_name, username, password_hash, is_admin)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssssi",
            $data['email'],
            $data['first_name'],
            $data['last_name'],
            $data['username'],
            $data['password_hash'],
            $data['is_admin']   // always 0 for student
        );

        return $stmt->execute();
    }


    /* ===============================
       OPTIONAL: GET ALL USERS
       (Useful for admin panel later)
       =============================== */
    public function getAllUsers()
    {
        $sql = "SELECT id, email, first_name, last_name, username, is_admin FROM users ORDER BY id DESC";
        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getInstructors()
    {
        $sql = "SELECT id, first_name, last_name FROM users WHERE is_admin = 1";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}

