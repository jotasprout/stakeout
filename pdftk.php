<?php

// form data
$albumName = 'The Rise and Fall of Ziggy Stardust and the Spiders from Mars';
$albumPop = '72';
$albumReleased = '06/06/1972';
$artistName = 'David Bowie';
$artistPop = '81';	
$currentDate = '02/27/2017';	
$label = 'unknown';
$trackName01 = 'Five Years';	
$trackName02 = 'Soul Love';
$trackName03 = 'Moonage Daydream';	
$trackName04 = 'Starman';	
$trackName05 = 'It Ain\'t Easy';	
$trackName06 = 'Lady Stardust';	
$trackName07 = 'Star';
$trackName08 = 'Hang On To Yourself';	
$trackName09 = 'Ziggy Stardust';
$trackName10 = 'Suffragette City';
$trackName11 = 'Rock \'n\' Roll Suicide';
$trackPop01 = '49';	
$trackPop02 = '47';	
$trackPop03 = '61';	
$trackPop04 = '65';	
$trackPop05 = '45';	
$trackPop06 = '48';	
$trackPop07 = '44';	
$trackPop08 = '44';	
$trackPop09 = '58';	
$trackPop10 = '53';	
$trackPop11 = '49';

//FDF header
$fdf_header = '%FDF-1.2
1 0 obj<</FDF << /Fields [';

// FDF footer
$fdf_footer = '] >> >>
endobj
trailer
<</Root 1 0 R>>
%%EOF';

// FDF content section
$fdf_content  = "<</T(albumName)/V({$albumName})>>";
$fdf_content .= "<</T(albumPop)/V({$albumPop})>>";
$fdf_content .= "<</T(albumReleased)/V({$albumReleased})>>";
$fdf_content .= "<</T(artistName)/V({$artistName})>>";
$fdf_content .= "<</T(artistPop)/V({$artistPop})>>";
$fdf_content .= "<</T(currentDate)/V({$currentDate})>>";
$fdf_content .= "<</T(label)/V({$label})>>";
$fdf_content .= "<</T(trackName01)/V({$trackName01})>>";
$fdf_content .= "<</T(trackName02)/V({$trackName02})>>";
$fdf_content .= "<</T(trackName03)/V({$trackName03})>>";
$fdf_content .= "<</T(trackName04)/V({$trackName04})>>";
$fdf_content .= "<</T(trackName05)/V({$trackName05})>>";
$fdf_content .= "<</T(trackName06)/V({$trackName06})>>";
$fdf_content .= "<</T(trackName07)/V({$trackName07})>>";
$fdf_content .= "<</T(trackName08)/V({$trackName08})>>";
$fdf_content .= "<</T(trackName09)/V({$trackName09})>>";
$fdf_content .= "<</T(trackName10)/V({$trackName10})>>";
$fdf_content .= "<</T(trackName11)/V({$trackName11})>>";
$fdf_content .= "<</T(trackPop01)/V({$trackPop01})>>";
$fdf_content .= "<</T(trackPop02)/V({$trackPop02})>>";
$fdf_content .= "<</T(trackPop03)/V({$trackPop03})>>";
$fdf_content .= "<</T(trackPop04)/V({$trackPop04})>>";
$fdf_content .= "<</T(trackPop05)/V({$trackPop05})>>";
$fdf_content .= "<</T(trackPop06)/V({$trackPop06})>>";
$fdf_content .= "<</T(trackPop07)/V({$trackPop07})>>";
$fdf_content .= "<</T(trackPop08)/V({$trackPop08})>>";
$fdf_content .= "<</T(trackPop09)/V({$trackPop09})>>";
$fdf_content .= "<</T(trackPop10)/V({$trackPop10})>>";
$fdf_content .= "<</T(trackPop11)/V({$trackPop11})>>";

$content = $fdf_header . $fdf_content . $fdf_footer;

// Creating a temporary file for our FDF file.
$FDFfile = tempnam(sys_get_temp_dir(), gethostname());

file_put_contents($FDFfile, $content);

// Merging the FDF file with the raw PDF form
exec("pdftk templates/AlbumFormEmpty.pdf fill_form $FDFfile output output.pdf"); 

// Removing the FDF file as we don't need it anymore
unlink($FDFfile);

?>