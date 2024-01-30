<?php
$clientId = "ae3ca0e83f00a46879ca3e40f016aac8"; // Replace with your JDoodle client ID
$clientSecret = "23c92dfb15a05242ee8dfcea1608f8cb084a0ba9e27e03885c93b534f45aa1e4"; // Replace with your JDoodle client secret
$code = $_POST["code"];
$input = $_POST["input"];
$filename_error = "error.txt";

// Prepare data to send to the JDoodle API
$requestData = [
    'clientId' => $clientId,
    'clientSecret' => $clientSecret,
    'script' => $code,
    'stdin' => $input,
    'language' => 'cpp', // Change 'c' to 'cpp' for C++ code
    'versionIndex' => 3, // Specify C++ version (index 3 corresponds to C++14 on JDoodle)
];

// Initialize cURL session
$ch = curl_init('https://api.jdoodle.com/v1/execute');

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

// Execute cURL session and capture the output
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo "Error: " . curl_error($ch);
} else {
    // Decode the JSON response
    $result = json_decode($response, true);

    // Check for compilation or runtime errors
    if (isset($result['error'])) {
        echo "<pre>Error: " . $result['error']['message'] . "</pre>";
    } else {
        // Strip HTML tags from the output and then display
        $output = strip_tags($result['output']);
        echo "<pre>$output</pre>";
    }
}

// Close cURL session
curl_close($ch);
?>
