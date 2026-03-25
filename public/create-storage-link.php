<?php
/**
 * Create storage symlink for shared hosting where symlink() is disabled.
 * Access this file once via browser: https://mawkost.id/create-storage-link.php
 * DELETE this file after use!
 */

$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';

// Check if link already exists
if (file_exists($link)) {
    echo '✅ Storage link already exists!';
    exit;
}

// Try symlink first
if (function_exists('symlink')) {
    symlink($target, $link);
    echo '✅ Symlink created successfully!';
    exit;
}

// Fallback: copy files instead of symlink
echo '⚠️ symlink() is disabled. Creating physical copy...<br>';

function copyDir($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst, 0755, true);
    while (($file = readdir($dir)) !== false) {
        if ($file === '.' || $file === '..')
            continue;
        $srcPath = $src . '/' . $file;
        $dstPath = $dst . '/' . $file;
        if (is_dir($srcPath)) {
            copyDir($srcPath, $dstPath);
        }
        else {
            copy($srcPath, $dstPath);
        }
    }
    closedir($dir);
}

if (is_dir($target)) {
    copyDir($target, $link);
    echo '✅ Storage files copied successfully!<br>';
    echo '⚠️ Note: New uploads won\'t appear until you run this script again.<br>';
}
else {
    mkdir($target, 0755, true);
    mkdir($link, 0755, true);
    echo '✅ Storage directories created!';
}

echo '<br><br>🗑️ <strong>DELETE this file now for security!</strong>';
