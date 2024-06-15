<?php
include '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];

$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(['success' => true, 'username' => $user['username']]);
} else {
    echo json_encode(['success' => false]);
}
?>
