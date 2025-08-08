<?php
session_start();

require_once __DIR__ . '/../controllers/UserController.php';
define('BASE_PATH', dirname(__DIR__, 2));

$controller = new UserController();

// DELETE
if (isset($_GET['delete'])) {
    $controller->destroy((int)$_GET['delete']);
    header("Location: /formulario/public/index.php");
    exit;
}

// EDIT
if (isset($_GET['edit'])) {
    $editUser = $controller->find((int)$_GET['edit']);
    $_SESSION['edit_user'] = $editUser;
    header("Location: /formulario/public/index.php?action=form");
    exit;
}

// FORM
if (isset($_GET['action']) && $_GET['action'] === 'form') {
    $formData = $_SESSION['form_data'] ?? [];
    $error = $_SESSION['error'] ?? '';
    $editUser = $_SESSION['edit_user'] ?? null;

    unset($_SESSION['form_data'], $_SESSION['error'], $_SESSION['edit_user']);

    include_once BASE_PATH . '/views/form.php';
    exit;
}

// POST (CREATE or UPDATE)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['id'])) {
        $controller->update((int)$_POST['id'], $_POST);
    } else {
        $controller->store($_POST);
    }
    header("Location: /formulario/public/index.php");
    exit;
}

// LIST
$formData = $_SESSION['form_data'] ?? [];
$error = $_SESSION['error'] ?? '';
$editUser = $_SESSION['edit_user'] ?? null;

unset($_SESSION['form_data'], $_SESSION['error'], $_SESSION['edit_user']);

$users = $controller->index();
include_once BASE_PATH . '/views/list.php';
