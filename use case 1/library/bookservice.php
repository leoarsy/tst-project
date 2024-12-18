<?php

require('libraryService.php');
$server = new SoapServer('library.wsdl');
$server->setClass('LibraryService');
$server->handle();
?>
