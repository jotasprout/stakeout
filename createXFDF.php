<?php

// this is from koivi.com
// createXFDF takes data from an HTML form and saves it to an XFDF file

function createXFDF( $file, $info, $enc='UTF-8' )
{
    $data = '<?xml version="1.0" encoding="'.$enc.'"?>' . "\n" .
        '<xfdf xmlns="http://ns.adobe.com/xfdf/" xml:space="preserve">' . "\n" .
        '<fields>' . "\n";
    foreach( $info as $field => $val )
    {
        $data .= '<field name="' . $field . '">' . "\n";
        if( is_array( $val ) )
        {
            foreach( $val as $opt )
                $data .= '<value>' .
                    htmlentities( $opt, ENT_COMPAT, $enc ) .
                    '</value>' . "\n";
        }
        else
        {
            $data .= '<value>' .
                htmlentities( $val, ENT_COMPAT, $enc ) .
                '</value>' . "\n";
        }
        $data .= '</field>' . "\n";
    }
    $data .= '</fields>' . "\n" .
        '<ids original="' . md5( $file ) . '" modified="' .
            time() . '" />' . "\n" .
        '<f href="' . $file . '" />' . "\n" .
        '</xfdf>' . "\n";
    return $data;
}

// Apparently saving that to disk is different

$result_directory = dirname(__FILE__) . '/results';
$xfdf_file = time() . '.xfdf';
$xfdf_file_path = $result_directory . '/' . $xfdf_file;

if( $fp = fopen( $xfdf_file_path, 'w' ) )
{
    fwrite( $fp, $xfdf, strlen( $xfdf ) );
}
fclose($fp);

// Use the above createXFDF function to grab data from database

$q = 'SELECT first_name, last_name, email, dob, notes
    FROM user_xfdf_data WHERE id = 1';
$res = $mysqli->query($q);
if( $res->num_rows )
{
    $data = $res->fetch_array( MYSQLI_ASSOC );
    $xfdf = createXFDF( $pdf_file_url, $data );
}


?>