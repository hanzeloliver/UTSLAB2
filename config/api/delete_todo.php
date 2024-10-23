<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['id'])) {
    http_response_code(400);
    exit(json_encode(['success' => false]));
}

$todoId = (int)$_POST['id'];

// Verify ownership and delete
$stmt = $pdo->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
$success = $stmt->execute([$todoId, $_SESSION['user_id']]);

header('Content-Type: application/json');
echo json_encode(['success' => $success]);

