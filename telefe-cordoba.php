<?php
// URL to scan
$url = isset($_GET['url']) ? $_GET['url'] : '';

if (!$url) {
    echo "Please provide a URL using ?url=...";
    exit;
}

// Validate URL
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    echo "Invalid URL.";
    exit;
}

// Fetch content
$contextOptions = [
    "http" => [
        "header" => "User-Agent: Mozilla/5.0"
    ]
];
$context = stream_context_create($contextOptions);
$html = @file_get_contents($url, false, $context);

if ($html === false) {
    echo "Failed to fetch content.";
    exit;
}

// Find .m3u8 links
preg_match_all('/(https?:\/\/[^\'"\s]+\.m3u8)/i', $html, $matches);

if (empty($matches[0])) {
    echo "No HLS (.m3u8) streams found.";
    exit;
}

// Show results as clickable links
echo "<h3>Found .m3u8 Streams:</h3>";
foreach ($matches[0] as $m3u8) {
    echo "<p><a href=\"" . htmlspecialchars($m3u8) . "\">" . htmlspecialchars($m3u8) . "</a> ";
    echo "[ <a href=\"vlc://$m3u8\">Open in VLC</a> ]</p>";
}
?>
