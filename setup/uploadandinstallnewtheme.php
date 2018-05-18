<?php

//delete the ../themes directory
function rrrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
}
echo rrrmdir("../themes");
mkdir("../themes", 0700);
mkdir("../themes/temp", 0700);

$target_path = "../themes/temp/newtheme.zip";
// Upload the zip file to the server and save it as ../themes/temp/newtheme.zip
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    " has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
} 

//unzip the zip archive in ../themes/temp/
     $zip = new ZipArchive;
     $res = $zip->open("../themes/temp/newtheme.zip");
     if ($res === TRUE) {
         $zip->extractTo('../themes/temp/');
         $zip->close();
         echo 'ok';
     } else {
         echo 'failed';
     }
	 
//delete the zip archive
unlink($target_path);


//process index.html in the zip file to move all needed css info into ./includes/jquerymobile.php
$filename = "../themes/temp/index.html";
$file = fopen($filename, "r");
$inheader = 0;
$targetfile = "../includes/jquerymobile.php";
$fh = fopen($targetfile, "w+");
while (($lineoftext = fgets($file)) !== false) {
	if ($inheader === 0){
		if (strpos($lineoftext, '<head>') !== FALSE){
			$inheader = 1;
			continue;}
		else{
			continue;}
		}
	else{
		if (strpos($lineoftext, '</head>') !== FALSE){
			$inheader = 0;
			continue;}
		else{
			if (strpos($lineoftext, '<link rel="stylesheet"') !== FALSE || strpos($lineoftext, '<script src="http://code.jquery.com/') !== FALSE){
				fwrite($fh, $lineoftext);
				continue;}
			else{
			continue;}
			
		}
	}
}
fclose($fh);	
fclose($file);
//delete the ../themes/temp/index.html file
unlink($filename);


//clear the ./themes folder

//function clearthemesdir($dir) {
//   if (is_dir($dir)) {
//     $objects = scandir($dir);
//     foreach ($objects as $object) {
//       if ($object != "." && $object != "..") {
//         if (filetype($dir."/".$object) !== "dir") unlink($dir."/".$object);
//       }
//     }
//     reset($objects);
//   }
//}
//echo clearthemesdir("../themes");


//move all files in the ./themes/temp/ folder into the ./themes folder
function recurse_copy($src,$dst) { 

    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
}
echo recurse_copy("../themes/temp/themes","../themes");


//delete the ../themes/temp/themes directory

echo rrrmdir("../themes/temp/themes");

?>