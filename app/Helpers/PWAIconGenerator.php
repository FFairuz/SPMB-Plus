<?php

namespace App\Helpers;

class PWAIconGenerator
{
    /**
     * Generate PWA icons from source image
     * 
     * @param string $sourcePath Path to source image
     * @param string $outputDir Directory to save generated icons
     * @return bool
     */
    public static function generateIcons($sourcePath, $outputDir = 'pwa-icons')
    {
        // Check if GD library is available
        if (!extension_loaded('gd')) {
            log_message('error', 'GD library not available for PWA icon generation');
            return false;
        }

        // Create output directory if it doesn't exist
        $fullOutputDir = FCPATH . $outputDir;
        if (!is_dir($fullOutputDir)) {
            mkdir($fullOutputDir, 0755, true);
        }

        // PWA icon sizes
        $sizes = [72, 96, 128, 144, 152, 192, 384, 512];

        // Get image info
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            log_message('error', 'Invalid image file: ' . $sourcePath);
            return false;
        }

        // Create image resource from source
        $sourceImage = self::createImageFromFile($sourcePath, $imageInfo[2]);
        if (!$sourceImage) {
            return false;
        }

        // Generate icons for each size
        foreach ($sizes as $size) {
            $output = imagecreatetruecolor($size, $size);
            
            // Preserve transparency
            imagealphablending($output, false);
            imagesavealpha($output, true);
            
            // Resize image
            imagecopyresampled(
                $output, 
                $sourceImage, 
                0, 0, 0, 0, 
                $size, $size, 
                imagesx($sourceImage), 
                imagesy($sourceImage)
            );

            // Save icon
            $outputPath = $fullOutputDir . '/icon-' . $size . 'x' . $size . '.png';
            imagepng($output, $outputPath);
            imagedestroy($output);
        }

        imagedestroy($sourceImage);
        
        log_message('info', 'PWA icons generated successfully from: ' . $sourcePath);
        return true;
    }

    /**
     * Create image resource from file
     * 
     * @param string $filePath
     * @param int $imageType
     * @return resource|false
     */
    private static function createImageFromFile($filePath, $imageType)
    {
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($filePath);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($filePath);
            case IMAGETYPE_GIF:
                return imagecreatefromgif($filePath);
            case IMAGETYPE_WEBP:
                return imagecreatefromwebp($filePath);
            default:
                log_message('error', 'Unsupported image type: ' . $imageType);
                return false;
        }
    }

    /**
     * Generate a single icon with specific size
     * 
     * @param string $sourcePath
     * @param int $size
     * @param string $outputPath
     * @return bool
     */
    public static function generateIcon($sourcePath, $size, $outputPath)
    {
        if (!extension_loaded('gd')) {
            return false;
        }

        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            return false;
        }

        $sourceImage = self::createImageFromFile($sourcePath, $imageInfo[2]);
        if (!$sourceImage) {
            return false;
        }

        $output = imagecreatetruecolor($size, $size);
        
        imagealphablending($output, false);
        imagesavealpha($output, true);
        
        imagecopyresampled(
            $output, 
            $sourceImage, 
            0, 0, 0, 0, 
            $size, $size, 
            imagesx($sourceImage), 
            imagesy($sourceImage)
        );

        $result = imagepng($output, $outputPath);
        
        imagedestroy($output);
        imagedestroy($sourceImage);
        
        return $result;
    }
}
