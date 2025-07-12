<?php
// Target page
$url = "https://cordoba.mitelefe.com/vivo/";

// Load HTML
$html = @file_get_contents($url);
if ($html === false) {
    die("Failed to load page");
}

// Find all .m3u8 URLs (very basic regex, may need improvements)
preg_match_all('/(https?:\/\/[^"\']+\.m3u8[^"\']*)/', $html, $matches);

if (!empty($matches[1])) {
    // Output all found .m3u8 links
    foreach ($matches[1] as $index => $streamUrl) {
        echo "Found stream URL [$index]:\n$streamUrl\n\n";
    }

    // Optional: Generate a VLC playlist (M3U format)
    $vlc_playlist = "#EXTM3U\n";
    foreach ($matches[1] as $streamUrl) {
        $vlc_playlist .= "#EXTINF:-1,Stream\n$streamUrl\n";
    }

    // Save to file
    file_put_contents("stream.m3u", $vlc_playlist);
    echo "Playlist saved as stream.m3u\n";
} else {
    echo "No .m3u8 streams found.";
}
?>
