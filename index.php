<?php
// Get the table name from the URL (assuming it's passed as a query parameter)
$table_name = $_GET['table'];

if (empty($table_name)) {
    echo json_encode(['error' => 'Table name is missing in the URL.']);
    exit;
}

// Airtable API endpoint URL
$url = 'https://api.airtable.com/v0/{base_id}/' . urlencode($table_name);

// Replace placeholders with your actual values
$base_id = 'app4D9jgcLIfcCZtO';
$api_key = 'patWyqt8N9rr2HFN4.3184dfb4003d9d8cbf18e78d82889c5810e2058f27073563b3748d6b3b142e4e';

// Construct the full API URL with base ID and table name
$url = str_replace('{base_id}', $base_id, $url);

// Set headers for the API request
$headers = [
    'Authorization: Bearer ' . $api_key,
    'Content-Type: application/json',
];

// Set the sort field and direction (sort by the "id" field in ascending order)
$params = [
    'sort' => [
        [
            'field' => 'id',
            'direction' => 'asc',
        ],
    ],
];

// Add the sort parameters to the API URL
$url .= '?' . http_build_query($params);

// Make the GET request using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

// Check if the request was successful
if ($response === false) {
    echo json_encode(['error' => 'Error fetching data from Airtable.']);
} else {
    // Decode the JSON response
    $data = json_decode($response, true);

    // Check if data is valid
    if ($data === null || !isset($data['records'])) {
        echo json_encode(['error' => 'Error decoding JSON data or no records found.']);
    } else {
        // Prepare the structured JSON response
        $api_response = ['data' => []];

        // Loop through records and add them to the response
        foreach ($data['records'] as $record) {
            // Extract record ID and fields
            $record_id = $record['id'];
            $fields = $record['fields'];

            // Prepare the record data with field names as properties
            $record_data = ['id' => $record_id];
            foreach ($fields as $field_name => $field_value) {
                $record_data[$field_name] = $field_value;
            }

            // Add the record data to the API response
            $api_response['data'][] = $record_data;
        }

        // Encode the API response as JSON
        $json_response = json_encode($api_response);

        // Set the content type header to JSON
        header('Content-Type: application/json');

        // Output the JSON response
        echo $json_response;
    }
}
?>
