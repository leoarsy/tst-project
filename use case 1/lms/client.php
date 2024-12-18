<?php

// Inisialisasi klien SOAP
$client = new SoapClient("http://localhost/myproject/library/library.wsdl");

// Meminta rekomendasi buku dengan genre tertentu
$genre = 'science';
$recommendations = $client->getBookRecommendation($genre);

echo "Recommended books in {$genre} genre:\n";
foreach ($recommendations as $book) {
    echo "- {$book}\n";
}

// Mengirim konfirmasi peminjaman kembali ke LMS (melalui REST)
$userId = "1234";
$book = $recommendations[0];

// Inisialisasi CURL untuk mengirim request ke REST server di LMS
$curl = curl_init("http://localhost/myproject/lms/server.php");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(['userId' => $userId, 'book' => $book]));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

echo "\nLMS confirmation response:\n{$response}\n";
?>
