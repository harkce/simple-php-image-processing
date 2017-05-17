<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];
$direction = $_POST['direction'];

$shiftedr = [[]];
$shiftedg = [[]];
$shiftedb = [[]];

if ($direction == 'up') {
	for ($y=0; $y < ($height - 1); $y++) { 
		for ($x=0; $x < $width; $x++) { 
			$shiftedr[$x][$y] = $r[$x][$y + 1];
			$shiftedg[$x][$y] = $g[$x][$y + 1];
			$shiftedb[$x][$y] = $b[$x][$y + 1];
		}
	}
	for ($x=0; $x < $width; $x++) { 
		$shiftedr[$x][$height - 1] = 0;
		$shiftedg[$x][$height - 1] = 0;
		$shiftedb[$x][$height - 1] = 0;
	}
} else if ($direction == 'left') {
	for ($y=0; $y < $height; $y++) { 
		for ($x=0; $x < ($width - 1); $x++) { 
			$shiftedr[$x][$y] = $r[$x + 1][$y];
			$shiftedg[$x][$y] = $g[$x + 1][$y];
			$shiftedb[$x][$y] = $b[$x + 1][$y];
		}
	}
	for ($y=0; $y < $height; $y++) { 
		$shiftedr[$width - 1][$y] = 0;
		$shiftedg[$width - 1][$y] = 0;
		$shiftedb[$width - 1][$y] = 0;
	}
} else if ($direction == 'down') {
	for ($y=1; $y < $height; $y++) { 
		for ($x=0; $x < $width; $x++) { 
			$shiftedr[$x][$y] = $r[$x][$y - 1];
			$shiftedg[$x][$y] = $g[$x][$y - 1];
			$shiftedb[$x][$y] = $b[$x][$y - 1];
		}
	}
	for ($x=0; $x < $width; $x++) { 
		$shiftedr[$x][0] = 0;
		$shiftedg[$x][0] = 0;
		$shiftedb[$x][0] = 0;
	}
} else if ($direction == 'right') {
	for ($y=0; $y < $height; $y++) { 
		for ($x=1; $x < $width; $x++) { 
			$shiftedr[$x][$y] = $r[$x - 1][$y];
			$shiftedg[$x][$y] = $g[$x - 1][$y];
			$shiftedb[$x][$y] = $b[$x - 1][$y];
		}
	}
	for ($y=0; $y < $height; $y++) { 
		$shiftedr[0][$y] = 0;
		$shiftedg[0][$y] = 0;
		$shiftedb[0][$y] = 0;
	}
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $shiftedr[$x][$y], $shiftedg[$x][$y], $shiftedb[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $shiftedr,
	'g' => $shiftedg,
	'b' => $shiftedb,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);