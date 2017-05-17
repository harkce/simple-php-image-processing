<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];
$direction = $_POST['direction'];

$brightedr = [[]];
$brightedg = [[]];
$brightedb = [[]];

$bright = ($direction == 'inc') ?: false;
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) {
		//inc or dec 
		$brightedr[$x][$y] = $bright ? ($r[$x][$y] + 10) : ($r[$x][$y] - 10);
		$brightedg[$x][$y] = $bright ? ($g[$x][$y] + 10) : ($g[$x][$y] - 10);
		$brightedb[$x][$y] = $bright ? ($b[$x][$y] + 10) : ($b[$x][$y] - 10);
		//cek kelebihan
		if ($brightedr[$x][$y] > 255) { $brightedr[$x][$y] = 255; }
		if ($brightedg[$x][$y] > 255) { $brightedg[$x][$y] = 255; }
		if ($brightedb[$x][$y] > 255) { $brightedb[$x][$y] = 255; }
		//cek kekurangan
		if ($brightedr[$x][$y] < 0) { $brightedr[$x][$y] = 0; }
		if ($brightedg[$x][$y] < 0) { $brightedg[$x][$y] = 0; }
		if ($brightedb[$x][$y] < 0) { $brightedb[$x][$y] = 0; }
	}
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $brightedr[$x][$y], $brightedg[$x][$y], $brightedb[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $brightedr,
	'g' => $brightedg,
	'b' => $brightedb,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);