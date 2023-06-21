<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>image test</title>
<?php 
// Function from https://www.dyn-web.com/code/random-image-php/

$root = '';
$path = 'images/2001/';

$imgList = getImagesFromDir($root . $path);
$img = getRandomFromArray($imgList);

function getImagesFromDir($path) {
    $images = array();
    if ( $img_dir = @opendir($path) ) {
        while ( false !== ($img_file = readdir($img_dir)) ) {
            // checks for gif, jpg, png
            if ( preg_match("/(\.gif|\.jpg|\.png)$/", $img_file) ) {
                $images[] = $img_file;
            }
        }
        closedir($img_dir);
    }
    return $images;
}

function getRandomFromArray($ar) {
    $num = array_rand($ar);
    return $ar[$num];
}

?>

</head>
<body>

<img src="images/2001/2001ASpaceOdysseyqq02_07_50qq00537.jpg" alt="" height="80" align="left" />
</body>
</html>
