<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT id, name FROM report_type WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $report = $result->fetch_assoc();
        echo json_encode($report);
    } else {
        echo json_encode(['error' => 'Report Type not found']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
$stmt->close();
$conn->close();