<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController
{
    public function store($data)
    {
        if (str_word_count($data['name']) < 2) {
            $_SESSION['error'] = "Por favor, preencha o nome completo (nome e sobrenome).";
            $_SESSION['form_data'] = $data;
            header("Location: index.php");
            exit;
        }

        $birthDate = new DateTime($data['birth_date']);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;

        $isMinor = $age < 18;

        $treatment = '';
        switch ($data['gender']) {
            case 'Masculino':
                $treatment = $isMinor ? 'Olá jovem' : 'Olá Sr.';
                break;
            case 'Feminino':
                $treatment = $isMinor ? 'Olá jovem' : 'Olá Sra.';
                break;
            default:
                $treatment = $isMinor ? 'Olá jovem' : 'Olá';
        }

        $firstName = explode(' ', $data['name'])[0];
        $_SESSION['greeting'] = $treatment . ' ' . $firstName;
        $_SESSION['is_minor'] = $isMinor;
        $_SESSION['age'] = $age;

        $user = new User($data);
        $conn = connect_database();

        $stmt = $conn->prepare("INSERT INTO users (name, email, birth_date, address, state, gender, interests, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssssssss",
            $user->name,
            $user->email,
            $user->birth_date,
            $user->address,
            $user->state,
            $user->gender,
            json_encode($user->interests),
            $user->username,
            $user->password
        );

        if (!$stmt->execute()) {
            die("Erro ao salvar usuário: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

        header("Location: success.php");
        exit;
    }

    public function index()
    {
        $conn = connect_database();
        $result = $conn->query("SELECT * FROM users ORDER BY id DESC");

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $row['interests'] = json_decode($row['interests'], true);
            $users[] = $row;
        }

        $conn->close();
        return $users;
    }

    public function find($id)
    {
        $conn = connect_database();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        $conn->close();

        if ($user) {
            $user['interests'] = json_decode($user['interests'], true);
        }

        return $user;
    }

    public function update($id, $data)
    {
        $user = new User($data);
        $conn = connect_database();

        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, birth_date=?, address=?, state=?, gender=?, interests=?, username=?, password=? WHERE id=?");

        $stmt->bind_param(
            "sssssssssi",
            $user->name,
            $user->email,
            $user->birth_date,
            $user->address,
            $user->state,
            $user->gender,
            json_encode($user->interests),
            $user->username,
            $user->password,
            $id
        );

        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("Location: index.php");
        exit;
    }

    public function destroy($id)
    {
        $conn = connect_database();
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("Location: index.php");
        exit;
    }
}
