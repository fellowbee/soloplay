<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
define('AIRTABLE_API_KEY', 'patrMQ2SBACvYF8gh.d0c7ec778ad523eaf9d022c6487b3d4f56e173b6418a652343567a91bfa22293');
define('AIRTABLE_BASE_ID', 'appI1ljn0MWHvUIJw');

// Function to make a request to Airtable
function airtable_request($tableName) {
    $url = "https://api.airtable.com/v0/" . AIRTABLE_BASE_ID . "/" . $tableName;
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . AIRTABLE_API_KEY,
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        return null;
    }

    curl_close($ch);
    return json_decode($response, true);
}
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $errors = [];

    // Validate username (no spaces, unique)
    if (strpos($username, ' ') !== false) {
        $errors[] = "Username must not contain spaces.";
    } elseif (strlen($username) < 4) {
        $errors[] = "Username must be at least 4 characters long.";
    } else {
        $users = airtable_request('users')['records'] ?? [];
        foreach ($users as $user) {
            if ($user['fields']['username'] === $username) {
                $errors[] = "Username already exists.";
                break;
            }
        }
    }

    // Validate email (unique)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    } else {
        $users = airtable_request('users')['records'] ?? [];
        foreach ($users as $user) {
            if ($user['fields']['email'] === $email) {
                $errors[] = "Email is already registered.";
                break;
            }
        }
    }

    // Validate password (length >= 8)
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // If no errors, register the user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Store user in Airtable
        $data = [
            'records' => [
                [
                    'fields' => [
                        'username' => $username,
                        'email' => $email,
                        'password' => $hashedPassword,
                    ]
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.airtable.com/v0/" . AIRTABLE_BASE_ID . "/users");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . AIRTABLE_API_KEY,
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $errors[] = 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);

        if ($response) {
            $response_data = json_decode($response, true);
            if (isset($response_data['error'])) {
                $errors[] = "API Error: " . $response_data['error']['message'];
            } else {
                $successMessage = "Registration successful! You can now <a href='login.php'>login</a>.";
            }
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-container">
        <h1>Register</h1>
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php elseif (isset($successMessage)): ?>
            <div class="success-message">
                <p><?php echo $successMessage; ?></p>
            </div>
        <?php endif; ?>
        <form action="register.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">

            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" name="password" id="password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
            </div>

            <button type="submit">Register</button>
        </form>
        <div class="links">
            <a href="forgot-password.php">Forgot Password?</a> |
            <a href="login.php">Login Page</a>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
