<?php
function searchInDir($dir, $pattern) {
    $results = [];
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            $results = array_merge($results, searchInDir($path, $pattern));
        } else {
            $content = file_get_contents($path);
            if (strpos($content, $pattern) !== false) {
                $results[] = $path;
            }
        }
    }
    return $results;
}

$files = searchInDir(__DIR__ . '/../app', 'with');
foreach ($files as $file) {
    echo str_replace(__DIR__ . '/../', '', $file) . "\n";
}
