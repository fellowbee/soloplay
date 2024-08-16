<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include Airtable request function
define('AIRTABLE_API_KEY', 'patrMQ2SBACvYF8gh.d0c7ec778ad523eaf9d022c6487b3d4f56e173b6418a652343567a91bfa22293');
define('AIRTABLE_BASE_ID', 'appI1ljn0MWHvUIJw');

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier']);
    $password = $_POST['password'];

    $errors = [];

    // Fetch users from Airtable
    $users = airtable_request('users')['records'] ?? [];
    $userFound = false;
    $user = null;

    foreach ($users as $u) {
        if ($u['fields']['username'] === $identifier || $u['fields']['email'] === $identifier) {
            $userFound = true;
            $user = $u['fields'];
            break;
        }
    }

    // Validate user existence
    if (!$userFound) {
        $errors[] = "Username or email does not exist.";
    } elseif (!password_verify($password, $user['password'])) {
        $errors[] = "Incorrect password.";
    }

    // If no errors, login the user
    if (empty($errors)) {
        $_SESSION['user'] = $user;
        header("Location: index.php"); // Redirect to dashboard or content page
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-container">
        <h1>Login</h1>
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="identifier">Username or Email</label>
            <input type="text" name="identifier" id="identifier" required value="<?php echo isset($identifier) ? htmlspecialchars($identifier) : ''; ?>">

            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" name="password" id="password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
            </div>

            <button type="submit">Login</button>
        </form>
        <div class="links">
            <a href="forgot-password.php">Forgot Password?</a> |
            <a href="register.php">Register Page</a>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
