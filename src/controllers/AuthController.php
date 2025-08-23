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

            $stmt = $conn->prepare("SELECT id, username, password FROM auth WHERE username = ? LIMIT 1");
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

            if ($user && $password === $user['password']) {
                $_SESSION['logged_user'] = [
                    'id' => $user['id'],
                    'username' => $user['username']
                ];
                return true;
            }

            error_log("Tentativa de login inválida para usuário: " . $username);
            return false;
        } catch (Exception $e) {
            // Log do erro
            error_log("Erro no login: " . $e->getMessage());
            return false;
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Remove todas as variáveis de sessão
        $_SESSION = array();

        // Se você quiser destruir a sessão completamente, remova também o cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finalmente, destrói a sessão
        session_destroy();
    }
}
