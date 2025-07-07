<?php
Flight::route('GET /home', function() {
    $data = [
        'name' => 'test'
    ];
    Flight::json($data);
});


