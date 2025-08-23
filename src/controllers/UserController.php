<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private function handlePhotoUpload($uploadDir = null)
    {

        $uploadDir = __DIR__ . '/../../public/uploads/photos/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
            $_SESSION['error'] = "Tipo de arquivo não permitido. Use apenas JPG, PNG, GIF ou WEBP.";
            return false;
        }

        if ($_FILES['photo']['size'] > $maxSize) {
            $_SESSION['error'] = "Arquivo muito grande. Tamanho máximo permitido: 5MB.";
            return false;
        }

        $photoTmpPath = $_FILES['photo']['tmp_name'];
        $photoExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photoName = uniqid('photo_', true) . '.' . $photoExtension;
        $photoPath = 'uploads/photos/' . $photoName;

        if (!move_uploaded_file($photoTmpPath, $uploadDir . $photoName)) {
            $_SESSION['error'] = "Erro ao salvar a foto do usuário.";
            return false;
        }

        return $photoPath;
    }

    private function deleteOldPhoto($photoPath)
    {
        if (!empty($photoPath) && file_exists(__DIR__ . '/../../public/' . $photoPath)) {
            unlink(__DIR__ . '/../../public/' . $photoPath);
        }
    }

    public function store($data)
    {
        if (str_word_count($data['name']) < 2) {
            $_SESSION['error'] = "Por favor, preencha o nome completo (nome e sobrenome).";
            $_SESSION['form_data'] = $data;
            header("Location: home.php");
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

        // Handle photo upload
        $photoResult = $this->handlePhotoUpload();
        if ($photoResult === false) {
            header("Location: home.php");
            exit;
        }

        $data['photo'] = $photoResult ?: '';

        $user = new User($data);
        $conn = connect_database();

        $stmt = $conn->prepare("INSERT INTO users (name, email, birth_date, address, state, gender, interests, username, password, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "ssssssssss",
            $user->name,
            $user->email,
            $user->birth_date,
            $user->address,
            $user->state,
            $user->gender,
            json_encode($user->interests),
            $user->username,
            $user->password,
            $user->photo
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
        // Buscar dados do usuário atual para preservar a foto se necessário
        $currentUser = $this->find($id);
        if (!$currentUser) {
            $_SESSION['error'] = "Usuário não encontrado.";
            header("Location: home.php");
            exit;
        }

        // Verificar se uma nova foto foi enviada
        $photoResult = $this->handlePhotoUpload();

        if ($photoResult === false) {
            // Erro de upload, já tratou sessão dentro da função
            header("Location: home.php");
            exit;
        }

        // Se não foi enviada nova foto, manter a anterior
        $data['photo'] = $photoResult ?? $currentUser['photo'];

        // Se foi enviada nova foto, deletar a antiga
        if ($photoResult && $currentUser['photo']) {
            $this->deleteOldPhoto($currentUser['photo']);
        }

        $user = new User($data);
        $conn = connect_database();

        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, birth_date=?, address=?, state=?, gender=?, interests=?, username=?, password=?, photo=? WHERE id=?");

        $stmt->bind_param(
            "ssssssssssi",
            $user->name,
            $user->email,
            $user->birth_date,
            $user->address,
            $user->state,
            $user->gender,
            json_encode($user->interests),
            $user->username,
            $user->password,
            $user->photo,
            $id
        );

        $stmt->execute();

        $stmt->close();
        $conn->close();

        $_SESSION['success'] = "Usuário atualizado com sucesso!";
        header("Location: home.php");
        exit;
    }

    public function destroy($id)
    {
        // Buscar usuário para deletar a foto antes de excluir do banco
        $user = $this->find($id);
        if ($user && !empty($user['photo'])) {
            $this->deleteOldPhoto($user['photo']);
        }

        $conn = connect_database();
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        $_SESSION['success'] = "Usuário excluído com sucesso!";
        header("Location: home.php");
        exit;
    }
}
