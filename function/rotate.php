<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];
$direction = $_POST['direction'];

$rotatedr = [[]];
$rotatedg = [[]];
$rotatedb = [[]];

$clockwise;
if ($direction == "left") {
	$clockwise = true;
} else {
	$clockwise = false;
}

for ($y = 0; $y < $height; $y++) {
	for ($x = 0; $x < $width; $x++) {
		$newX = $clockwise ? $y : ($height - 1) - $y;
		$newY = $clockwise ? ($width - 1) - $x : $x;
		$rotatedr[$newX][$newY] = $r[$x][$y];
		$rotatedg[$newX][$newY] = $g[$x][$y];
		$rotatedb[$newX][$newY] = $b[$x][$y];
	}
}

$height = $height + $width;
$width = $height - $width;
$height = $height - $width;

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $rotatedr[$x][$y], $rotatedg[$x][$y], $rotatedb[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $rotatedr,
	'g' => $rotatedg,
	'b' => $rotatedb,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);