<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];

$sharpedr = [[]];
$sharpedg = [[]];
$sharpedb = [[]];

function dotmat($m1, $m2) {
	$res = 0;
	for ($i=0; $i < 3; $i++) { 
		for ($j=0; $j < 3; $j++) { 
			$res += $m1[$i][$j] * $m2[$i][$j];
		}
	}
	return (int) ceil($res);
}

$m2 = [
	[0, -1, 0],
	[-1, 5, -1],
	[0, -1, 0]
];

for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) {
		$m1r = [[]];
		$m1g = [[]];
		$m1b = [[]];

		for ($i=0; $i < 3; $i++) { 
			for ($j=0; $j < 3; $j++) { 
				$m1r[$i][$j] = isset($r[$x - ($j - 1)][$y - ($i - 1)]) ? $r[$x - ($j - 1)][$y - ($i - 1)] : 0;
				$m1g[$i][$j] = isset($g[$x - ($j - 1)][$y - ($i - 1)]) ? $g[$x - ($j - 1)][$y - ($i - 1)] : 0;
				$m1b[$i][$j] = isset($b[$x - ($j - 1)][$y - ($i - 1)]) ? $b[$x - ($j - 1)][$y - ($i - 1)] : 0;
			}
		}

		$sharpedr[$x][$y] = dotmat($m1r, $m2);
		$sharpedg[$x][$y] = dotmat($m1g, $m2);
		$sharpedb[$x][$y] = dotmat($m1b, $m2);

		//cek kelebihan
		if ($sharpedr[$x][$y] > 255) { $sharpedr[$x][$y] = 255; }
		if ($sharpedg[$x][$y] > 255) { $sharpedg[$x][$y] = 255; }
		if ($sharpedb[$x][$y] > 255) { $sharpedb[$x][$y] = 255; }
		//cek kekurangan
		if ($sharpedr[$x][$y] < 0) { $sharpedr[$x][$y] = 0; }
		if ($sharpedg[$x][$y] < 0) { $sharpedg[$x][$y] = 0; }
		if ($sharpedb[$x][$y] < 0) { $sharpedb[$x][$y] = 0; }
	}
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $sharpedr[$x][$y], $sharpedg[$x][$y], $sharpedb[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $sharpedr,
	'g' => $sharpedg,
	'b' => $sharpedb,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);