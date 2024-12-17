<?php
class SearchProxy {
    private $soapClient;
    
    public function __construct() {
        // Inisialisasi SOAP Client
        $this->soapClient = new SoapClient(null, [
            'location' => 'http://example.com/library/search.php',
            'uri' => 'http://example.com/library/search',
            'trace' => 1
        ]);
    }
    
    /**
     * Handle request pencarian
     */
    public function handleSearchRequest() {
        // Validasi input
        $keyword = filter_input(INPUT_POST, 'keyword', FILTER_SANITIZE_STRING);
        $courseId = filter_input(INPUT_POST, 'courseId', FILTER_VALIDATE_INT);
        
        if (!$keyword || !$courseId) {
            $this->sendJsonResponse([
                'status' => 'error',
                'message' => 'Invalid input parameters'
            ], 400);
            return;
        }
        
        try {
            // Panggil SOAP web service
            $result = $this->soapClient->searchBooks($keyword, $courseId);
            
            // Transform hasil ke format yang diinginkan
            $books = array_map(function($book) {
                return [
                    'id' => $book['id'],
                    'title' => $book['title'],
                    'author' => $book['author'],
                    'coverUrl' => $book['cover_url'],
                    'description' => substr($book['description'], 0, 100) . '...',
                    'category' => $book['category']
                ];
            }, $result);
            
            $this->sendJsonResponse([
                'status' => 'success',
                'data' => $books
            ]);
            
        } catch (SoapFault $e) {
            $this->sendJsonResponse([
                'status' => 'error',
                'message' => 'Search service error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Helper untuk mengirim JSON response
     */
    private function sendJsonResponse($data, $code = 200) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

// Handle request
$proxy = new SearchProxy();
$proxy->handleSearchRequest();
?>
