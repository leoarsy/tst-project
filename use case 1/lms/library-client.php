<?php

// Fungsi untuk mengirim data peminjaman ke Perpustakaan Digital melalui SOAP
function confirmBorrow($book, $userId) {
    $client = new SoapClient("http://localhost/project-folder/library/library.wsdl");
    return $client->confirmBorrow($userId, $book);
}

// Fungsi utama
$userId = '1234';
$genre = 'science';

try {
    $client = new SoapClient("http://localhost/myproject/library/library.wsdl");
    $recommendations = $client->getBookRecommendation($genre);

    echo "Rekomendasi buku untuk genre {$genre}:\n";
    foreach ($recommendations as $book) {
        echo "- {$book}\n";
    }

    if (count($recommendations) > 0) {
        $selectedBook = $recommendations[0];
        $confirmation = confirmBorrow($selectedBook, $userId);
        echo "\nKonfirmasi peminjaman:\n{$confirmation}";
    }
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}";
}
?>
