<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];

$dilatedr = [[]];
$dilatedg = [[]];
$dilatedb = [[]];

function minarr33($arr) {
	$res = $arr[0][0];
	for ($i=0; $i < 3; $i++) { 
		for ($j=0; $j < 3; $j++) { 
			$res = ($arr[$i][$j] < $res) ? $arr[$i][$j] : $res;
		}
	}
	return $res;
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

		$dilatedr[$x][$y] = minarr33($m1r);
		$dilatedg[$x][$y] = minarr33($m1g);
		$dilatedb[$x][$y] = minarr33($m1b);
	}
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $dilatedr[$x][$y], $dilatedg[$x][$y], $dilatedb[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $dilatedr,
	'g' => $dilatedg,
	'b' => $dilatedb,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);