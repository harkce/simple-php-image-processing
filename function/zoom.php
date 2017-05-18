<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];
$direction = $_POST['direction'];

$zoomedr = [[]];
$zoomedg = [[]];
$zoomedb = [[]];

if ($direction == 'in') {
	for ($y=0; $y <= $height; $y++) { 
		for ($x=0; $x <= $width; $x++) { 
			//kiri atas
			$zoomedr[$x][$y] = isset($r[$x - 1][$y - 1]) ? $r[$x - 1][$y - 1] : 0;
			$zoomedg[$x][$y] = isset($g[$x - 1][$y - 1]) ? $g[$x - 1][$y - 1] : 0;
			$zoomedb[$x][$y] = isset($b[$x - 1][$y - 1]) ? $b[$x - 1][$y - 1] : 0;
			//kanan atas
			$zoomedr[$x][$y] += isset($r[$x][$y - 1]) ? $r[$x][$y - 1] : 0;
			$zoomedg[$x][$y] += isset($g[$x][$y - 1]) ? $g[$x][$y - 1] : 0;
			$zoomedb[$x][$y] += isset($b[$x][$y - 1]) ? $b[$x][$y - 1] : 0;
			//kiri bawah
			$zoomedr[$x][$y] += isset($r[$x - 1][$y]) ? $r[$x - 1][$y] : 0;
			$zoomedg[$x][$y] += isset($g[$x - 1][$y]) ? $g[$x - 1][$y] : 0;
			$zoomedb[$x][$y] += isset($b[$x - 1][$y]) ? $b[$x - 1][$y] : 0;
			//kanan bawah
			$zoomedr[$x][$y] += isset($r[$x][$y]) ? $r[$x][$y] : 0;
			$zoomedg[$x][$y] += isset($g[$x][$y]) ? $g[$x][$y] : 0;
			$zoomedb[$x][$y] += isset($b[$x][$y]) ? $b[$x][$y] : 0;
			//rata-rata
			$zoomedr[$x][$y] = (int) ceil((float) $zoomedr[$x][$y] / 4);
			$zoomedg[$x][$y] = (int) ceil((float) $zoomedg[$x][$y] / 4);
			$zoomedb[$x][$y] = (int) ceil((float) $zoomedb[$x][$y] / 4);
		}
	}
	$height++;
	$width++;
} else {
	for ($y=0; $y < ($height - 1); $y++) { 
		for ($x=0; $x < ($width - 1); $x++) { 
			$zoomedr[$x][$y] = (int) ceil(($r[$x][$y] + $r[$x + 1][$y] + $r[$x][$y + 1] + $r[$x + 1][$y + 1])/(float) 4);
			$zoomedg[$x][$y] = (int) ceil(($g[$x][$y] + $g[$x + 1][$y] + $g[$x][$y + 1] + $g[$x + 1][$y + 1])/(float) 4);
			$zoomedb[$x][$y] = (int) ceil(($b[$x][$y] + $b[$x + 1][$y] + $b[$x][$y + 1] + $b[$x + 1][$y + 1])/(float) 4);
		}
	}
	$height--;
	$width--;
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $zoomedr[$x][$y], $zoomedg[$x][$y], $zoomedb[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $zoomedr,
	'g' => $zoomedg,
	'b' => $zoomedb,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);