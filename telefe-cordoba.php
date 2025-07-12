<?php
// URL of the website to scrape
$url = "https://cordoba.mitelefe.com/vivo/";

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Set a user-agent to mimic a real browser
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/115.0.0.0 Safari/537.36');

$html = curl_exec($ch);

if(curl_errno($ch)) {
    echo "cURL error: " . curl_error($ch);
    exit;
}

curl_close($ch);

// Try to extract .m3u8 links
preg_match_all('/(https?:\/\/[^"\']+\.m3u8[^"\']*)/', $html, $matches);

if (!empty($matches[1])) {
    echo "Found the following .m3u8 links:\n";
    foreach ($matches[1] as $m3u8) {
        echo $m3u8 . "\n";
    }
} else {
    echo "No .m3u8 stream found. The stream may be loaded via JavaScript or protected.\n";
}
?>
