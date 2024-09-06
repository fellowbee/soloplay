<?php

// Step 1: Retrieve the initial URL from the request
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // Step 2: Fetch the response from the initial URL
    $response = file_get_contents($url);

    if ($response === FALSE) {
        echo "Error fetching data from the URL.";
        exit;
    }

    // Step 3: Decode the JSON response to extract lic_keyId and lic_key
    $data = json_decode($response, true);

    if (isset($data['lic_keyId']) && isset($data['lic_key'])) {
        $keyid = $data['lic_keyId'];
        $key = $data['lic_key'];

        // Step 4: Prepare the final URL with the extracted keyid and key
        $final_url = "https://vercel-php-clearkey-hex-base64-json.vercel.app/api/results.php?keyid=" . urlencode($keyid) . "&key=" . urlencode($key);

        // Step 5: Fetch the response from the final URL
        $final_response = file_get_contents($final_url);

        if ($final_response === FALSE) {
            echo "Error fetching data from the final URL.";
            exit;
        }

        // Step 6: Display the final response
        echo $final_response;
    } else {
        echo "lic_keyId or lic_key not found in the response.";
    }
} else {
    echo "No URL provided.";
}
?>
