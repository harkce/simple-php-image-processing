<?php

$raw = "";
for ($i=0; $i < $_POST['length']; $i++) { 
	$raw = $raw . $_POST['str' . $i];
}

$exploded = explode(',', $raw);
$encoded = $exploded[1];
$decoded = base64_decode($encoded);

$image = imagecreatefromstring($decoded);
$width = imagesx($image);
$height = imagesy($image);

$r = [[]];
$g = [[]];
$b = [[]];

for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		$rgb = imagecolorat($image, $x, $y);
		$r[$x][$y] = ($rgb >> 16) & 0xFF;
		$g[$x][$y] = ($rgb >> 8) & 0xFF;
		$b[$x][$y] = $rgb & 0xFF; 
	}
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $r[$x][$y], $g[$x][$y], $b[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $r,
	'g' => $g,
	'b' => $b,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);