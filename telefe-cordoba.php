<?php
// Filmon Court‑TV UK URL endpoint (input page)
$pageUrl = 'https://www.filmon.com/tv/court-tv-uk';

// Use cURL to extract playlist
function fetch_m3u8($pageUrl) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $pageUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    curl_setopt($ch, CURLOPT_REFERER, 'https://www.filmon.com/');
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

$html = fetch_m3u8($pageUrl);

// Parse the HTML to find .m3u8 URLs
if (preg_match_all('/https?:\/\/[^\s"\']+\.m3u8[^\s"\']*/i', $html, $matches)) {
    $urls = array_unique($matches[0]);
    // Pick first .m3u8 as likely candidate (custom logic may be needed)
    $playlist = reset($urls);
    if ($playlist) {
        echo "#EXTM3U\n";
        echo "#EXTINF:-1,Court TV UK (via Filmon)\n";
        echo $playlist . "\n";
    } else {
        echo "No .m3u8 URL found in page source.";
    }
} else {
    echo "No .m3u8 URL matched.";
}
?>
