<?php
require_once '../config/variables.php';
header('Content-Type: application/json');

if (empty($_FILES['file'])) {
		echo json_encode(['error' => 'No file uploaded.']);
		exit;
}

$file = $_FILES['file'];
//$targetDir = '../uploads/articles/images/contents/'; // Directory to save uploaded images
$targetDir = UPLOAD_BASE_DIR;
//$targetDir = 'uploads/'; // Directory to save uploaded images
$allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$file_ext = strtolower( pathinfo($file['name'], PATHINFO_EXTENSION) );
if(!in_array($file_ext, $allowed_exts)) {
		echo json_encode(['error' => 'Not allowed file extension.']);
		exit;
}
$fileName = uniqid() . '_' . time() .".".$file_ext;
$targetFilePath = $targetDir . $fileName;
$targetFileURL = UPLOAD_BASE_URL . $fileName;

if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
		echo json_encode(['location' => $targetFileURL]); // Adjust path as needed
} else {
		echo json_encode(['error' => 'Failed to move uploaded file.']);
}

?>
