<?php
    require_once __DIR__ . '/../models/pdf.php';

    class PdfController {
       public static function generatePDF(){
            try {
                $data = $_POST;
                $result = pdf::generate_pdf($data);
                Flight::json(pdf::generate_pdf($data));
            } catch (\Throwable $th) {
                Flight::json(['error'=>$th->getMessage()]);     
            }
       }
    }
?>
