<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {
    // Check if request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate and sanitize input
    $fullName = isset($_POST['fullName']) ? htmlspecialchars(trim($_POST['fullName'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
    $dob = isset($_POST['dob']) ? htmlspecialchars(trim($_POST['dob'])) : '';
    $gender = isset($_POST['gender']) ? htmlspecialchars(trim($_POST['gender'])) : '';
    $address = isset($_POST['address']) ? htmlspecialchars(trim($_POST['address'])) : '';
    $course = isset($_POST['course']) ? htmlspecialchars(trim($_POST['course'])) : '';

    // Validate required fields
    if (empty($fullName) || empty($email) || empty($phone) || empty($dob) || 
        empty($gender) || empty($address) || empty($course)) {
        throw new Exception('All fields are required');
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email address');
    }

    // Get current timestamp
    $timestamp = date('Y-m-d H:i:s');

    // Prepare response data
    $responseData = array(
        'fullName' => $fullName,
        'email' => $email,
        'phone' => $phone,
        'dob' => $dob,
        'gender' => $gender,
        'address' => $address,
        'course' => $course,
        'timestamp' => $timestamp
    );

    // Optional: Save to file or database
    // saveToFile($responseData);

    // Send success response
    echo json_encode(array(
        'success' => true,
        'message' => 'Registration successful',
        'data' => $responseData
    ));

} catch (Exception $e) {
    // Send error response
    echo json_encode(array(
        'success' => false,
        'message' => $e->getMessage()
    ));
}

// Optional function to save data to a file
function saveToFile($data) {
    $filename = 'registrations.txt';
    $content = "\n--- Registration Entry ---\n";
    $content .= "Timestamp: " . $data['timestamp'] . "\n";
    $content .= "Name: " . $data['fullName'] . "\n";
    $content .= "Email: " . $data['email'] . "\n";
    $content .= "Phone: " . $data['phone'] . "\n";
    $content .= "DOB: " . $data['dob'] . "\n";
    $content .= "Gender: " . $data['gender'] . "\n";
    $content .= "Address: " . $data['address'] . "\n";
    $content .= "Course: " . $data['course'] . "\n";
    $content .= "-------------------------\n";
    
    file_put_contents($filename, $content, FILE_APPEND);
}
?>
