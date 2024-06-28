<?php

//Function to generate slug 
function generateSlug($string) {
    // Lowercase, replace spaces with hyphens, and remove special characters
    return strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '-', str_replace(' ', '-', $string)));
}

function generateRandomString($length = 36) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    error_log('Generated random string: ' . $randomString);
    return $randomString;
}


// Function to resize an image (using GD library)
function resizeImage($filename, $destination, $newWidth, $newHeight, $imageType) {
    list($width, $height) = getimagesize($filename);

    // Calculate new dimensions while maintaining aspect ratio
    $aspectRatio = $width / $height;
    if ($newWidth / $newHeight > $aspectRatio) {
        $newWidth = $newHeight * $aspectRatio;
    } else {
        $newHeight = $newWidth / $aspectRatio;
    }

    // Check if resizing is possible without compromising quality
    if ($width < $newWidth || $height < $newHeight) {
        return false; // Image is too small to resize without losing quality
    }

    $image_p = imagecreatetruecolor($newWidth, $newHeight);
    
    // Create image resource based on file type
    if ($imageType === 'jpeg' || $imageType === 'jpg') {
        $image = imagecreatefromjpeg($filename);
    } elseif ($imageType === 'png') {
        $image = imagecreatefrompng($filename);
    } elseif ($imageType === 'gif') {
        $image = imagecreatefromgif($filename);
    } else {
        return false; // Unsupported file type
    }
    
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    return imagejpeg($image_p, $destination); // Save the resized image
}

