<?php

$fsize = filesize("hu-exported.po"); 

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"hu-exported.po\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . $fsize);

$file = @fopen("hu-exported.po","rb");
if ($file) {
  while(!feof($file)) {
    print(fread($file, 1024*8));
    flush();
    if (connection_status()!=0) {
      @fclose($file);
      die();
    }
  }
  @fclose($file);
}
?>

