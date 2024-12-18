<?php

require "vendor/autoload.php";
require "libraryService.php"; // Memuat file `libraryService.php`

use PHP2WSDL\PHPClass2WSDL;

// Inisialisasi generator dengan nama kelas "LibraryService" dan URL untuk endpoint SOAP
$gen = new PHPClass2WSDL("LibraryService", "http://localhost/myproject/library/server.php");

// Generate WSDL dan simpan ke file
$gen->generateWSDL();
file_put_contents("library.wsdl", $gen->dump());

echo "WSDL file has been generated!";
?>
