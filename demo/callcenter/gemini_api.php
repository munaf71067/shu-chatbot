<?php
function getGeminiResponse($prompt) {
    $api_key = "AIzaSyCGx2oAu_i5JAWJWqhzxqzYsyu-iulSS48";
    $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$api_key";

    $data = [
        "contents" => [
            [
                "parts" => [
                    // ["text" => "Create a one_point_five-line response for the query $prompt"]
                    ["text" => "You are a chatbot of Salim Habib University. Create a one_point_five-line response only related to SHU for the query: $prompt"]
                ]
            ]
        ]
    ];

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        return $result['candidates'][0]['content']['parts'][0]['text'];
    } else {
        return "Gemini API error or no response.";
    }
}
