<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];

$edgedr = [[]];
$edgedg = [[]];
$edgedb = [[]];

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
	[-1, -1, -1],
	[-1, 8, -1],
	[-1, -1, -1]
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

		$edgedr[$x][$y] = dotmat($m1r, $m2);
		$edgedg[$x][$y] = dotmat($m1g, $m2);
		$edgedb[$x][$y] = dotmat($m1b, $m2);

		//cek kelebihan
		if ($edgedr[$x][$y] > 255) { $edgedr[$x][$y] = 255; }
		if ($edgedg[$x][$y] > 255) { $edgedg[$x][$y] = 255; }
		if ($edgedb[$x][$y] > 255) { $edgedb[$x][$y] = 255; }
		//cek kekurangan
		if ($edgedr[$x][$y] < 0) { $edgedr[$x][$y] = 0; }
		if ($edgedg[$x][$y] < 0) { $edgedg[$x][$y] = 0; }
		if ($edgedb[$x][$y] < 0) { $edgedb[$x][$y] = 0; }
	}
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $edgedr[$x][$y], $edgedg[$x][$y], $edgedb[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $edgedr,
	'g' => $edgedg,
	'b' => $edgedb,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);