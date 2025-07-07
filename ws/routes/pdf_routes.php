<?php
require_once __DIR__ . '/../controllers/PdfController.php';

Flight::route('POST /pdf', ['PdfController', 'generatePDF']);
