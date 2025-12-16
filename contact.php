<?php
header('Content-Type: application/json');

// Use centralized config for DB credentials
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$project = trim($_POST['project'] ?? '');
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$notes = trim($_POST['notes'] ?? '');

if (!$project || !$name || !$email || !$notes || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please complete all fields with a valid email.']);
    exit;
}

$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$stmt = $mysqli->prepare('INSERT INTO contact_messages (project, name, email, notes) VALUES (?, ?, ?, ?)');

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
    $mysqli->close();
    exit;
}

$stmt->bind_param('ssss', $project, $name, $email, $notes);
$ok = $stmt->execute();

if ($ok) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save message.']);
}

$stmt->close();
$mysqli->close();
