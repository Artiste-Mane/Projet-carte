<?php
session_start();

require_once 'vendor/autoload.php';

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Writer;


function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function redirectIfNotLoggedIn($redirect_to = 'connexion.php')
{
    if (!isLoggedIn()) {
        header('Location: ' . $redirect_to);
        exit();
    }
}

function handleFileUpload($file, $uploadDir)
{
    $targetFile = $uploadDir . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $targetFile);
    return $targetFile;
}
function generateQRCode($data, $outputDir)
{
    // Créer un nom de fichier unique
    $fileName = uniqid('qrcode_', true) . '.png';
    $filePath = $outputDir . $fileName;

    // Créer le renderer pour le QR code
    $renderer = new ImageRenderer(
        new RendererStyle(300, 2),

        new ImagickImageBackEnd()
    );

    // Créer le writer avec le renderer
    $writer = new Writer($renderer);

    // Écrire le QR code dans le fichier
    $writer->writeFile($data, $filePath);

    // Retourner le chemin du fichier QR code généré
    return $filePath;
}
