<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];
$direction = $_POST['direction'];

$convultedr = [[]];
$convultedg = [[]];
$convultedb = [[]];

function dotmat($m1, $m2, $direction) {
	$res = 0;
	for ($i=0; $i < 3; $i++) { 
		for ($j=0; $j < 3; $j++) { 
			$res += $m1[$i][$j] * $m2[$i][$j];
		}
	}
	if ($direction == 'box') {
		return (int) ceil($res/(float) 9);
	} else {
		return (int) ceil($res/(float) 16);
	}
}

$m2 = [[]];
if ($direction == 'box') {
	$m2 = [
		[1, 1, 1],
		[1, 1, 1],
		[1, 1, 1]
	];
} else {
	$m2 = [
		[1,2,1],
		[2,4,2],
		[1,2,1]
	];
}

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

		$convultedr[$x][$y] = dotmat($m1r, $m2, $direction);
		$convultedg[$x][$y] = dotmat($m1g, $m2, $direction);
		$convultedb[$x][$y] = dotmat($m1b, $m2, $direction);

		//cek kelebihan
		if ($convultedr[$x][$y] > 255) { $convultedr[$x][$y] = 255; }
		if ($convultedg[$x][$y] > 255) { $convultedg[$x][$y] = 255; }
		if ($convultedb[$x][$y] > 255) { $convultedb[$x][$y] = 255; }
		//cek kekurangan
		if ($convultedr[$x][$y] < 0) { $convultedr[$x][$y] = 0; }
		if ($convultedg[$x][$y] < 0) { $convultedg[$x][$y] = 0; }
		if ($convultedb[$x][$y] < 0) { $convultedb[$x][$y] = 0; }
	}
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $convultedr[$x][$y], $convultedg[$x][$y], $convultedb[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $convultedr,
	'g' => $convultedg,
	'b' => $convultedb,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);