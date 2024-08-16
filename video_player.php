<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Redirect to index.php if the user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: index.php?message=Please%20log%20in%20to%20access%20this%20page');
    exit();
}

// Fetch the title and sanitize it
$title = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '';

// Fetch other parameters
$encodedToken = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : '';
$licenseKey = isset($_GET['licenseKey']) ? htmlspecialchars($_GET['licenseKey']) : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Watching | <?php echo $title; ?></title>
    <meta content="noindex, nofollow, noarchive" name="robots"/>
    <meta name="referrer" content="no-referrer" />
    <script src="//ssl.p.jwpcdn.com/player/v/8.21.0/jwplayer.js"></script>
    <script>
        jwplayer.key = 'XSuP4qMl+9tK17QNb+4+th2Pm9AWgMO/cYH8CI0HGGr7bdjo';
    </script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #player-container {
            position: relative;
            width: 80vw; /* Width as a percentage of viewport width */
            height: 45vw; /* Height to maintain a 16:9 aspect ratio */
            max-width: 100vw;
            max-height: 100vh;
            background: #000;
        }
        #player {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="player-container">
        <div id="player"></div>
    </div>

    <script>
        function getParameterByName(name) {
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(window.location.href);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        var encodedToken = getParameterByName('token');
        var licenseKey = getParameterByName('licenseKey'); // DRM license URL

        if (encodedToken) {
            var playUrl = atob(encodedToken); // Decode Base64

            var sources = [];
            var drmConfig = {};

            // Determine the type of stream based on the licenseKey value
            if (licenseKey === 'NA') {
                // Play HLS (M3U8)
                sources.push({
                    file: playUrl,
                    type: 'application/x-mpegURL', // HLS
                    label: 'HLS Stream',
                    default: true
                });
            } else if (licenseKey === 'HLS') {
                // Play MP4
                sources.push({
                    file: playUrl,
                    type: 'video/mp4', // MP4
                    label: 'MP4 Stream'
                });
            } else {
                // Play MPD with DRM using the provided licenseKey as the DRM license URL
                drmConfig = {
                    "widevine": {
                        "license": licenseKey
                    }
                };
                sources.push({
                    file: playUrl,
                    type: 'application/dash+xml', // MPD
                    drm: drmConfig
                });
            }

            jwplayer("player").setup({
                playlist: [{
                    sources: sources
                }],
                width: "100%",
                height: "100%",
                stretching: "exactfit",
                aspectratio: "16:9",
                controls: true,
                autostart: true,
                playbackRateControls: true
            });
        } else {
            document.getElementById('player').innerHTML = 'No video URL provided.';
        }
    </script>
</body>
</html>
