<?php
header("Content-Type: application/json");

// Your Hugging Face API key
$apiKey = "YOUR_HUGGING_FACE_API_KEY";

// Decode the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);
$userMessage = trim($data["message"]);

// Set up the Hugging Face API request URL and headers
$url = "https://api-inference.huggingface.co/models/gpt2"; // Using GPT-2 model
$headers = [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
];

// Create the data for the Hugging Face request
$postData = json_encode([
    "inputs" => $userMessage
]);

// Initialize cURL session
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

// Execute the cURL request and get the response
$result = curl_exec($ch);

// Check for network errors
if (curl_errno($ch)) {
    $error_message = "Network error: " . curl_error($ch);
    echo json_encode(["response" => $error_message]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Decode the API response and check for errors
$response = json_decode($result, true);
if (isset($response['error'])) {
    $error_message = "Hugging Face API error: " . $response['error']['message'];
    echo json_encode(["response" => $error_message]);
    exit;
}

// Extract the AI's response and return it
$botMessage = $response[0]['generated_text'] ?? "I'm sorry, something went wrong.";
echo json_encode(["response" => $botMessage]);
?>
