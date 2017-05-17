<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];

$abu = [[]];

for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) {
		$abu[$x][$y] = round(($r[$x][$y] + $g[$x][$y] + $b[$x][$y]) / (float) 3);
	}
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $abu[$x][$y], $abu[$x][$y], $abu[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $abu,
	'g' => $abu,
	'b' => $abu,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);