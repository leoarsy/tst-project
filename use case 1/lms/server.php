<?php
// Allow requests from any origin (adjust origin as necessary for security)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Define all functions
function getBookRecommendation($genre) {
    // Dummy recommendation based on genre
    switch (strtolower($genre)) {
        case 'science':
            return "Recommended book based on genre: science - 'A Brief History of Time'";
        case 'fiction':
            return "Recommended book based on genre: fiction - '1984' by George Orwell";
        case 'history':
            return "Recommended book based on genre: history - 'Sapiens: A Brief History of Humankind'";
        case 'technology':
            return "Recommended book based on genre: technology - 'The Innovators' by Walter Isaacson";
        case 'fantasy':
            return "Recommended book based on genre: fantasy - 'Harry Potter and the Sorcerer's Stone'";
        default:
            return "No recommendation available for this genre.";
    }
}

function confirmBorrow($userId, $book) {
    return "Confirmation for user $userId on borrowing book: $book";
}

function confirmBorrowRest($userId, $book) {
    return "Borrowing of '$book' by user $userId has been confirmed with a 10 point added.";
}

// Handle POST request for REST JSON API
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
    header("Content-Type: application/json");
    $input = json_decode(file_get_contents("php://input"), true);
    $genre = $input['genre'] ?? 'unknown';
    $book = getBookRecommendation($genre);
    echo json_encode(['return' => $book]);
    exit();
}

// Handle SOAP request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER["CONTENT_TYPE"], "text/xml") !== false) {
    header("Content-Type: text/xml");
    $request = file_get_contents("php://input");
    $xml = new SimpleXMLElement($request);
    $body = $xml->children('soapenv', true)->Body->children();

    if (isset($body->getBookRecommendation)) {
        $genre = (string) $body->getBookRecommendation->genre;
        $recommendedBook = getBookRecommendation($genre);
        echo <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
   <soapenv:Body>
      <getBookRecommendationResponse>
         <return>$recommendedBook</return>
      </getBookRecommendationResponse>
   </soapenv:Body>
</soapenv:Envelope>
XML;
    } elseif (isset($body->confirmBorrow)) {
        $userId = (string) $body->confirmBorrow->userId;
        $book = (string) $body->confirmBorrow->book;
        $confirmation = confirmBorrow($userId, $book);
        echo <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
   <soapenv:Body>
      <confirmBorrowResponse>
         <return>$confirmation</return>
      </confirmBorrowResponse>
   </soapenv:Body>
</soapenv:Envelope>
XML;
    }
    exit();
}

// Handle REST form-encoded POST request
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER["CONTENT_TYPE"], "application/x-www-form-urlencoded") !== false) {
    header("Content-Type: application/json");
    $userId = $_POST['userId'] ?? '';
    $book = $_POST['book'] ?? '';
    $message = confirmBorrowRest($userId, $book);
    echo json_encode([
        "status" => "success",
        "message" => $message
    ]);
    exit();
}
?>