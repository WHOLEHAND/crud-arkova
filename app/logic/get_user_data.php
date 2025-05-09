<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT id, user_name, names, last_names, identity_card, email, password, level_user FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
$stmt->close();
$conn->close();