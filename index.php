<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('AIRTABLE_API_KEY', 'patrMQ2SBACvYF8gh.d0c7ec778ad523eaf9d022c6487b3d4f56e173b6418a652343567a91bfa22293');
define('AIRTABLE_BASE_ID', 'appI1ljn0MWHvUIJw');

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

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

// Fetch data for banner
$bannerData = airtable_request('banner')['records'] ?? [];

// Fetch title for horizontal scroll
$titleData = airtable_request('zero')['records'] ?? [];
$horizontalTitle = isset($titleData[0]['fields']['title']) ? $titleData[0]['fields']['title'] : '';
$horizontalTitle1 = isset($titleData[1]['fields']['title']) ? $titleData[1]['fields']['title'] : '';
$horizontalTitle2 = isset($titleData[2]['fields']['title']) ? $titleData[2]['fields']['title'] : '';
$horizontalTitle3 = isset($titleData[3]['fields']['title']) ? $titleData[3]['fields']['title'] : '';
$horizontalTitle4 = isset($titleData[4]['fields']['title']) ? $titleData[4]['fields']['title'] : '';
$horizontalTitle5 = isset($titleData[5]['fields']['title']) ? $titleData[5]['fields']['title'] : '';
$horizontalTitle6 = isset($titleData[6]['fields']['title']) ? $titleData[6]['fields']['title'] : '';
$horizontalTitle7 = isset($titleData[7]['fields']['title']) ? $titleData[7]['fields']['title'] : '';
$horizontalTitle8 = isset($titleData[8]['fields']['title']) ? $titleData[8]['fields']['title'] : '';
$horizontalTitle9 = isset($titleData[9]['fields']['title']) ? $titleData[9]['fields']['title'] : '';

// -----------------------------------------------------------------------------------------------------------------------------------
// Fetch data for horizontal scroll images
$scrollData = airtable_request('one')['records'] ?? [];

// Fetch data for video license
$licenseData = airtable_request('licenses')['records'] ?? []; // Assuming 'licenses' is the table name
$licenseMap = [];
foreach ($licenseData as $license) {
    $licenseMap[$license['fields']['video_id']] = $license['fields']['license'];
}
// -----------------------------------------------------------------------------------------------------------------------------------

// Fetch data for horizontal scroll images
$scrollData1 = airtable_request('two')['records'] ?? [];

// Fetch data for video license
$licenseData1 = airtable_request('licenses')['records'] ?? []; // Assuming 'licenses' is the table name
$licenseMap1 = [];
foreach ($licenseData1 as $license1) {
    $licenseMap1[$license1['fields']['video_id']] = $license1['fields']['license'];
}
// -----------------------------------------------------------------------------------------------------------------------------------

// Fetch data for horizontal scroll images
$scrollData2 = airtable_request('three')['records'] ?? [];

// Fetch data for video license
$licenseData2 = airtable_request('licenses')['records'] ?? []; // Assuming 'licenses' is the table name
$licenseMap2 = [];
foreach ($licenseData2 as $license2) {
    $licenseMap2[$license2['fields']['video_id']] = $license2['fields']['license'];
}

// -----------------------------------------------------------------------------------------------------------------------------------
// Fetch data for horizontal scroll images
$scrollData3 = airtable_request('four')['records'] ?? [];

// Fetch data for video license
$licenseData3 = airtable_request('licenses')['records'] ?? []; // Assuming 'licenses' is the table name
$licenseMap3 = [];
foreach ($licenseData3 as $license3) {
    $licenseMap3[$license3['fields']['video_id']] = $license3['fields']['license'];
}

// // -----------------------------------------------------------------------------------------------------------------------------------

// // Fetch data for horizontal scroll images
// $scrollData1 = airtable_request('five')['records'] ?? [];

// // Fetch data for video license
// $licenseData1 = airtable_request('licenses')['records'] ?? []; // Assuming 'licenses' is the table name
// $licenseMap1 = [];
// foreach ($licenseData1 as $license1) {
//     $licenseMap1[$license1['fields']['video_id']] = $license1['fields']['license'];
// }

// // -----------------------------------------------------------------------------------------------------------------------------------
// // Fetch data for horizontal scroll images
// $scrollData1 = airtable_request('six')['records'] ?? [];

// // Fetch data for video license
// $licenseData1 = airtable_request('licenses')['records'] ?? []; // Assuming 'licenses' is the table name
// $licenseMap1 = [];
// foreach ($licenseData1 as $license1) {
//     $licenseMap1[$license1['fields']['video_id']] = $license1['fields']['license'];
// }

// // -----------------------------------------------------------------------------------------------------------------------------------
// // Fetch data for horizontal scroll images
// $scrollData1 = airtable_request('seven')['records'] ?? [];

// // Fetch data for video license
// $licenseData1 = airtable_request('licenses')['records'] ?? []; // Assuming 'licenses' is the table name
// $licenseMap1 = [];
// foreach ($licenseData1 as $license1) {
//     $licenseMap1[$license1['fields']['video_id']] = $license1['fields']['license'];
// }

// // -----------------------------------------------------------------------------------------------------------------------------------
// // Fetch data for horizontal scroll images
// $scrollData1 = airtable_request('eight')['records'] ?? [];

// // Fetch data for video license
// $licenseData1 = airtable_request('licenses')['records'] ?? []; // Assuming 'licenses' is the table name
// $licenseMap1 = [];
// foreach ($licenseData1 as $license1) {
//     $licenseMap1[$license1['fields']['video_id']] = $license1['fields']['license'];
// }

// // -----------------------------------------------------------------------------------------------------------------------------------
// // Fetch data for horizontal scroll images
// $scrollData1 = airtable_request('nine')['records'] ?? [];

// // Fetch data for video license
// $licenseData1 = airtable_request('licenses')['records'] ?? []; // Assuming 'licenses' is the table name
// $licenseMap1 = [];
// foreach ($licenseData1 as $license1) {
//     $licenseMap1[$license1['fields']['video_id']] = $license1['fields']['license'];
// }

// // -----------------------------------------------------------------------------------------------------------------------------------
// // Fetch data for horizontal scroll images
// $scrollData1 = airtable_request('ten')['records'] ?? [];

// // Fetch data for video license
// $licenseData1 = airtable_request('licenses')['records'] ?? []; // Assuming 'licenses' is the table name
// $licenseMap1 = [];
// foreach ($licenseData1 as $license1) {
//     $licenseMap1[$license1['fields']['video_id']] = $license1['fields']['license'];
// }
// ?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solo Play | Home</title>
    <link rel="stylesheet" href="css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script disable-devtool-auto src='//cdn.jsdelivr.net/npm/disable-devtool@latest'></script>
</head>
<body>
    <!-- Gradient Navbar -->
    <div class="navbar">
        <img src="images/nav-logo.png" alt="Logo" class="logo">
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">Movies</a>
            <a href="#">Shows</a>
            <a href="#">Live TV</a>
            <a href="#">Sports</a>
        </div>
        <div class="account-icon">
            <img src="https://cdn1.iconfinder.com/data/icons/ui-5/502/profile-512.png" alt="Account Icon">
            <div class="logout-menu">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>

    <!-- Banner Section -->
    <div class="banner-container">
        <button class="banner-nav left" onclick="previousSlide()">&#10094;</button>
        <div class="banner-wrapper">
            <?php foreach ($bannerData as $index => $banner): ?>
                <?php
                $videoId = $banner['fields']['license']; // Assuming 'video_id' is a field in 'banner'
                $title = $banner['fields']['title'];
                $licenseKey = isset($licenseMap[$videoId]) ? $licenseMap[$videoId] : 'NA';
                $encodedToken = urlencode(base64_encode($banner['fields']['link']));
                $encodedLicenseKey = urlencode($licenseKey);
                ?>
                <div class="banner-slide">
                    <a href="video_player.php?token=<?php echo $encodedToken; ?>&licenseKey=<?php echo $encodedLicenseKey; ?>&title=<?php echo $title?> ">
                        <img src="<?php echo htmlspecialchars($banner['fields']['image']); ?>" alt="Banner Image <?php echo $index + 1; ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="banner-nav right" onclick="nextSlide()">&#10095;</button>
        <div class="banner-indicators">
            <?php for ($i = 0; $i < count($bannerData); $i++): ?>
                <span class="indicator" onclick="currentSlide(<?php echo $i + 1; ?>)"></span>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Horizontal Scroll Section -->
    <div class="section-header">
        <h2 class="section-title"><?php echo htmlspecialchars($horizontalTitle); ?></h2>
        <a href="#" class="see-all-link">See All</a>
    </div>
    <div class="horizontal-scroll-container">
        <button class="scroll-nav left" onclick="scrollBack()">&#10094;</button>
        <div class="horizontal-scroll-wrapper">
            <?php foreach ($scrollData as $item): ?>
                <div class="scroll-item">
                    <a href="video_player.php?token=<?php echo urlencode(base64_encode($item['fields']['link'])); ?>&licenseKey=<?php echo urlencode($licenseMap[$item['fields']['license']] ?? 'NA'); ?>&title=<?php echo urlencode($item['fields']['title']); ?>">
                        <img src="<?php echo htmlspecialchars($item['fields']['image']); ?>" alt="<?php echo htmlspecialchars($item['fields']['title']); ?>">
                    </a>
                    <p><?php echo htmlspecialchars($item['fields']['title']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="scroll-nav right" onclick="scrollRight()">&#10095;</button>
    </div>
    
    <!------------------------------------------------------------------------------------------------------------------------------------------->
    
    <div class="section-header">
        <h2 class="section-title"><?php echo htmlspecialchars($horizontalTitle1); ?></h2>
        <a href="#" class="see-all-link">See All</a>
    </div>
    <div class="horizontal-scroll-container">
        <button class="scroll-nav left" onclick="scrollBack()">&#10094;</button>
        <div class="horizontal-scroll-wrapper">
            <?php foreach ($scrollData1 as $item): ?>
                <div class="scroll-item">
                    <a href="video_player.php?token=<?php echo urlencode(base64_encode($item['fields']['link'])); ?>&licenseKey=<?php echo urlencode($licenseMap[$item['fields']['license']] ?? 'NA'); ?>&title=<?php echo urlencode($item['fields']['title']); ?>">
                        <img src="<?php echo htmlspecialchars($item['fields']['image']); ?>" alt="<?php echo htmlspecialchars($item['fields']['title']); ?>">
                    </a>
                    <p><?php echo htmlspecialchars($item['fields']['title']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="scroll-nav right" onclick="scrollRight()">&#10095;</button>
    </div>
    
    <!------------------------------------------------------------------------------------------------------------------------------------------------------>
     <div class="section-header">
        <h2 class="section-title"><?php echo htmlspecialchars($horizontalTitle2); ?></h2>
        <a href="#" class="see-all-link">See All</a>
    </div>
    <div class="horizontal-scroll-container">
        <button class="scroll-nav left" onclick="scrollBack()">&#10094;</button>
        <div class="horizontal-scroll-wrapper">
            <?php foreach ($scrollData2 as $item): ?>
                <div class="scroll-item">
                    <a href="video_player.php?token=<?php echo urlencode(base64_encode($item['fields']['link'])); ?>&licenseKey=<?php echo urlencode($licenseMap[$item['fields']['license']] ?? 'NA'); ?>&title=<?php echo urlencode($item['fields']['title']); ?>">
                        <img src="<?php echo htmlspecialchars($item['fields']['image']); ?>" alt="<?php echo htmlspecialchars($item['fields']['title']); ?>">
                    </a>
                    <p><?php echo htmlspecialchars($item['fields']['title']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="scroll-nav right" onclick="scrollRight()">&#10095;</button>
    </div>
    
    <!------------------------------------------------------------------------------------------------------------------------------------------------------>
     <div class="section-header">
        <h2 class="section-title"><?php echo htmlspecialchars($horizontalTitle3); ?></h2>
        <a href="#" class="see-all-link">See All</a>
    </div>
    <div class="horizontal-scroll-container">
        <button class="scroll-nav left" onclick="scrollBack()">&#10094;</button>
        <div class="horizontal-scroll-wrapper">
            <?php foreach ($scrollData3 as $item): ?>
                <div class="scroll-item">
                    <a href="video_player.php?token=<?php echo urlencode(base64_encode($item['fields']['link'])); ?>&licenseKey=<?php echo urlencode($licenseMap[$item['fields']['license']] ?? 'NA'); ?>&title=<?php echo urlencode($item['fields']['title']); ?>">
                        <img src="<?php echo htmlspecialchars($item['fields']['image']); ?>" alt="<?php echo htmlspecialchars($item['fields']['title']); ?>">
                    </a>
                    <p><?php echo htmlspecialchars($item['fields']['title']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="scroll-nav right" onclick="scrollRight()">&#10095;</button>
    </div>
    
    
    
    
    

    <script src="js/app.js"></script>
</body>
</html>
