<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['id'])) {
    http_response_code(400);
    exit(json_encode(['success' => false]));
}

$todoId = (int)$_POST['id'];

// First verify the todo belongs to the user
$stmt = $pdo->prepare("SELECT status FROM todos WHERE id = ? AND user_id = ?");
$stmt->execute([$todoId, $_SESSION['user_id']]);
$todo = $stmt->fetch();

if (!$todo) {
    http_response_code(404);
    exit(json_encode(['success' => false]));
}

// Toggle the status
$newStatus = !$todo['status'];
$stmt = $pdo->prepare("UPDATE todos SET status = ? WHERE id = ? AND user_id = ?");
$success = $stmt->execute([$newStatus, $todoId, $_SESSION['user_id']]);

header('Content-Type: application/json');
echo json_encode(['success' => $success]);