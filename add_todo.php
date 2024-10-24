<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['task'])) {
    http_response_code(400);
    exit(json_encode(['success' => false]));
}

$task = trim($_POST['task']);
if (empty($task)) {
    http_response_code(400);
    exit(json_encode(['success' => false]));
}

$stmt = $pdo->prepare("INSERT INTO todos (user_id, task) VALUES (?, ?)");
$success = $stmt->execute([$_SESSION['user_id'], $task]);

header('Content-Type: application/json');
echo json_encode(['success' => $success]);
