<?php
require_once __DIR__ . '/../../config/database.php';

class AuthController
{
    public function login($username, $password)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $conn = connect_database();

            $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ? LIMIT 1");
            if (!$stmt) {
                error_log("Erro na preparação da consulta: " . $conn->error);
                return false;
            }

            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            $stmt->close();
            $conn->close();

            // Verificação com hash
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['logged_user'] = [
                    'username' => $user['username']
                ];
                return true;
            }

            error_log("Tentativa de login inválida para usuário: " . $username);
            return false;
        } catch (Exception $e) {
            error_log("Erro no login: " . $e->getMessage());
            return false;
        }
    }
}
