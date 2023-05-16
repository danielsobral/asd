<?php

$files = array(
    [
        'name' => 'mae.jpeg',
        'type' => 'image/jpeg',
        'tmp_name' => 'C:\\Users\\Wilde\\AppData\\Local\\Temp\\phpE788.tmp',
        'error' => 0,
        'size' => 162491,
    ],
    [
        'name' => 'selfie.jpeg',
        'type' => 'image/jpeg',
        'tmp_name' => 'C:\\Users\\Wilde\\AppData\\Local\\Temp\\phpE789.tmp',
        'error' => 0,
        'size' => 122858,
    ],
    [
        'name' => 'zsasz.jpg',
        'type' => 'image/jpeg',
        'tmp_name' => 'C:\\Users\\Wilde\\AppData\\Local\\Temp\\phpE79B.tmp',
        'error' => 0,
        'size' => 25841,
    ],
    [
        'name' => 'new-img.jpg',
        'type' => 'image/jpeg',
        'tmp_name' => 'C:\\Users\\Wilde\\AppData\\Local\\Temp\\phpE79A.tmp',
        'error' => 0,
        'size' => 25841,
    ],
    [
        'name' => 'new-img2.jpg',
        'type' => 'image/jpeg',
        'tmp_name' => 'C:\\Users\\Wilde\\AppData\\Local\\Temp\\phpE795.tmp',
        'error' => 0,
        'size' => 25841,
    ],
);

$storedInDb = [
    [
        'url' => 'https://cndurl/storage/123_mae.jpeg',
        'main' => false,
    ],
    [
        'url' => 'https://cndurl/storage/456_selfie.jpeg',
        'main' => true,
    ],
    [
        'url' => 'https://cndurl/storage/789_uebi.png',
        'main' => false,
    ],
    [
        'url' => 'https://cndurl/storage/123_zsasz.jpg',
        'main' => false,
    ],
];

$removedImages = [];

// Encontra as imagens removidas
foreach ($storedInDb as $image) {
    $url = $image['url'];
    $found = false;

    foreach ($files as $file) {
        $imageName = $file['name'];
        // Verifica se o nome da imagem está presente na URL da imagem armazenada
        if (strpos($url, $imageName) !== false) {
            $found = true;
            break;
        }
    }

    // Se a imagem não foi encontrada nos arquivos enviados, adiciona a URL ao array de imagens removidas
    if (!$found) {
        $removedImages[] = $url;
    }
}

// Exibe as imagens removidas
foreach ($removedImages as $removedImage) {
    echo "Excluindo imagem: " . $removedImage . "\n";
}


echo '<hr>';


$newStoredInDb = array_filter($storedInDb, function ($image) use ($removedImages) {
    $url = $image['url'];
    // Filtra as imagens que não estão presentes no array de imagens removidas
    return !in_array($url, $removedImages);
});

// Exibe o novo array de imagens armazenadas no banco, sem as imagens removidas
foreach ($newStoredInDb as $image) {
    echo "URL da imagem: " . $image['url'] . "\n";
    echo "Flag principal: " . ($image['main'] ? 'true' : 'false') . "\n";
}


echo '<hr>';


$newImages = array_filter($files, function ($file) use ($storedInDb) {
    $imageName = $file['name'];
    $found = false;

    foreach ($storedInDb as $image) {
        $url = $image['url'];
        // Verifica se o nome da imagem está presente na URL da imagem armazenada
        if (strpos($url, $imageName) !== false) {
            $found = true;
            break;
        }
    }

    // Retorna true para as imagens que não estão presentes no banco de dados
    return !$found;
});

// Exibe as novas imagens que não estão armazenadas no banco de dados
foreach ($newImages as $newImage) {
    echo "Nova imagem: " . $newImage['name'];
}
