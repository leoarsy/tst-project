<?php

class LibraryService {
    public function getBookRecommendation($genre) {
        // logika rekomendasi
        return "Recommended book based on genre: $genre";
    }

    public function confirmBorrow($userId, $book) {
        // logika konfirmasi peminjaman
        return "Confirmation for user $userId on borrowing book: $book";
    }
}
?>
