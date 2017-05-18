<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];

$warpedr = [[]];
$warpedg = [[]];
$warpedb = [[]];

for ($y=0; $y < $height; $y++) { 
	if (($y % 2 == 0)) {
		for ($x=0; $x < ($width - 1); $x++) { 
			$warpedr[$x][$y] = $r[$x + 1][$y];
			$warpedg[$x][$y] = $g[$x + 1][$y];
			$warpedb[$x][$y] = $b[$x + 1][$y];
		}
		$warpedr[$width - 1][$y] = 0;
		$warpedg[$width - 1][$y] = 0;
		$warpedb[$width - 1][$y] = 0;
	} else {
		for ($x=1; $x < $width; $x++) { 
			$warpedr[$x][$y] = $r[$x - 1][$y];
			$warpedg[$x][$y] = $g[$x - 1][$y];
			$warpedb[$x][$y] = $b[$x - 1][$y];
		}
		$warpedr[0][$y] = 0;
		$warpedg[0][$y] = 0;
		$warpedb[0][$y] = 0;
	}
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $warpedr[$x][$y], $warpedg[$x][$y], $warpedb[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $warpedr,
	'g' => $warpedg,
	'b' => $warpedb,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);