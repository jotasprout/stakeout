<?php

// from Koivi or whatever

$data = array (
    'first_name' => 'John',
    'last_name'  => 'Doe',
    'email'      => 'jdoe@example.com',
    'dob'        => '1980-04-14',
    'notes'      => 'It\'s a plain text field that contains stuff.'
);

$pdf_file_url = 'http://example.com/from.pdf';

include 'createXFDF.php';
$xfdf = createXFDF( $pdf_file_url, $data );




?>