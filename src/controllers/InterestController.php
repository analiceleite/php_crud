<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Interest.php';

class InterestController
{
    public function store($data)
    {
        // Validar se o nome do interesse foi fornecido
        if (empty(trim($data['name']))) {
            $_SESSION['error'] = "Por favor, informe o nome do interesse.";
            $_SESSION['form_data'] = $data;
            header("Location: interests.php");
            exit;
        }

        $interestName = trim($data['name']);

        $conn = connect_database();

        // Verificar se o interesse já existe
        $stmtCheck = $conn->prepare("SELECT interest_id FROM interest WHERE name = ? LIMIT 1");
        $stmtCheck->bind_param("s", $interestName);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
        $existingInterest = $result->fetch_assoc();
        $stmtCheck->close();

        if ($existingInterest) {
            $_SESSION['error'] = "Este interesse já existe.";
            $_SESSION['form_data'] = $data;
            header("Location: interests.php");
            exit;
        }

        // Inserir novo interesse
        $stmt = $conn->prepare("INSERT INTO interest (name) VALUES (?)");
        $stmt->bind_param("s", $interestName);

        if (!$stmt->execute()) {
            die("Erro ao salvar interesse: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

        $_SESSION['success'] = "Interesse adicionado com sucesso!";
        header("Location: interests.php");
        exit;
    }

    public function index()
    {
        $conn = connect_database();

        // Buscar todos os interesses com contagem de usuários
        $query = "
            SELECT 
                i.interest_id,
                i.name,
                COUNT(ui.user_id) as user_count
            FROM interest i
            LEFT JOIN user_interest ui ON i.interest_id = ui.interest_id
            GROUP BY i.interest_id, i.name
            ORDER BY i.name ASC
        ";

        $result = $conn->query($query);
        $interests = [];

        while ($row = $result->fetch_assoc()) {
            $interests[] = $row;
        }

        $conn->close();
        return $interests;
    }

    public function find($id)
    {
        $conn = connect_database();
        $stmt = $conn->prepare("SELECT * FROM interest WHERE interest_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $interest = $result->fetch_assoc();
        $stmt->close();
        $conn->close();

        return $interest;
    }

    public function update($id, $data)
    {
        // Validar se o nome do interesse foi fornecido
        if (empty(trim($data['name']))) {
            $_SESSION['error'] = "Por favor, informe o nome do interesse.";
            header("Location: interests.php");
            exit;
        }

        $interestName = trim($data['name']);

        $conn = connect_database();

        // Verificar se já existe outro interesse com o mesmo nome
        $stmtCheck = $conn->prepare("SELECT interest_id FROM interest WHERE name = ? AND interest_id != ? LIMIT 1");
        $stmtCheck->bind_param("si", $interestName, $id);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
        $existingInterest = $result->fetch_assoc();
        $stmtCheck->close();

        if ($existingInterest) {
            $_SESSION['error'] = "Já existe outro interesse com este nome.";
            header("Location: interests.php");
            exit;
        }

        // Atualizar interesse
        $stmt = $conn->prepare("UPDATE interest SET name = ? WHERE interest_id = ?");
        $stmt->bind_param("si", $interestName, $id);

        if (!$stmt->execute()) {
            die("Erro ao atualizar interesse: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

        $_SESSION['success'] = "Interesse atualizado com sucesso!";
        header("Location: interests.php");
        exit;
    }

    public function destroy($id)
    {
        $conn = connect_database();

        // Verificar se o interesse está sendo usado por algum usuário
        $stmtCheck = $conn->prepare("SELECT COUNT(*) as count FROM user_interest WHERE interest_id = ?");
        $stmtCheck->bind_param("i", $id);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
        $row = $result->fetch_assoc();
        $stmtCheck->close();

        if ($row['count'] > 0) {
            $_SESSION['error'] = "Não é possível excluir este interesse pois está sendo usado por " . $row['count'] . " usuário(s).";
            header("Location: interests.php");
            exit;
        }

        // Deletar interesse
        $stmt = $conn->prepare("DELETE FROM interest WHERE interest_id = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            die("Erro ao excluir interesse: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

        $_SESSION['success'] = "Interesse excluído com sucesso!";
        header("Location: interests.php");
        exit;
    }

    public function getUsersByInterest($interestId)
    {
        $conn = connect_database();

        $stmt = $conn->prepare("
            SELECT u.user_id, u.name, u.email
            FROM users u
            INNER JOIN user_interest ui ON u.user_id = ui.user_id
            WHERE ui.interest_id = ?
            ORDER BY u.name ASC
        ");

        $stmt->bind_param("i", $interestId);
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $users;
    }
}
