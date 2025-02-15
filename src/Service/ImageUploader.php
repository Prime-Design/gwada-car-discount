<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    private string $uploadDirectory;

    public function __construct(string $uploadDirectory)
    {
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true); // Crée le dossier s'il n'existe pas
        }

        $this->uploadDirectory = $uploadDirectory;
    }

    public function uploadAndCompress(UploadedFile $file, int $maxSizeKb = 400): ?string
    {
        if (!in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
            return null;
        }

        $fileName = uniqid() . '.' . $file->guessExtension();
        $filePath = $this->uploadDirectory . '/' . $fileName;

        $image = imagecreatefromstring(file_get_contents($file->getPathname()));

        if ($file->guessExtension() === 'png') {
            imagepng($image, $filePath, 9);
        } else {
            $quality = 90;
            do {
                ob_start();
                imagejpeg($image, null, $quality);
                $compressedData = ob_get_clean();
                $sizeKb = strlen($compressedData) / 1024;
                $quality -= 5;
            } while ($sizeKb > $maxSizeKb && $quality > 10);

            file_put_contents($filePath, $compressedData);
        }

        imagedestroy($image);
        return $fileName;
    }
}
