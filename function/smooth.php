<?php

$r = json_decode($_POST['r'], TRUE);
$g = json_decode($_POST['g'], TRUE);
$b = json_decode($_POST['b'], TRUE);
$width = $_POST['width'];
$height = $_POST['height'];
$direction = $_POST['direction'];

$smoothedr = [[]];
$smoothedg = [[]];
$smoothedb = [[]];

function median($arr) {
    $count = count($arr);
    $middleval = floor(($count-1)/2);
    if($count % 2) {
        $median = $arr[$middleval];
    } else {
        $low = $arr[$middleval];
        $high = $arr[$middleval+1];
        $median = (($low+$high)/2);
    }
    return $median;
}

for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) {
		//mean
		$count = 0;
		$sumr = 0;
		$sumg = 0;
		$sumb = 0;
		//median
		$arrr = [];
		$arrg = [];
		$arrb = [];

		//kiri atas
		if (isset($r[$x-1][$y-1])) {
			$count++;
			$sumr += $r[$x-1][$y-1];
			$sumg += $g[$x-1][$y-1];
			$sumb += $b[$x-1][$y-1];
			array_push($arrr, $r[$x-1][$y-1]);
			array_push($arrg, $g[$x-1][$y-1]);
			array_push($arrb, $b[$x-1][$y-1]);
		}
		//atas
		if (isset($r[$x][$y-1])) {
			$count++;
			$sumr += $r[$x][$y-1];
			$sumg += $g[$x][$y-1];
			$sumb += $b[$x][$y-1];
			array_push($arrr, $r[$x][$y-1]);
			array_push($arrg, $g[$x][$y-1]);
			array_push($arrb, $b[$x][$y-1]);
		}
		//kanan atas
		if (isset($r[$x+1][$y-1])) {
			$count++;
			$sumr += $r[$x+1][$y-1];
			$sumg += $g[$x+1][$y-1];
			$sumb += $b[$x+1][$y-1];
			array_push($arrr, $r[$x+1][$y-1]);
			array_push($arrg, $g[$x+1][$y-1]);
			array_push($arrb, $b[$x+1][$y-1]);
		}
		//kiri
		if (isset($r[$x-1][$y])) {
			$count++;
			$sumr += $r[$x-1][$y];
			$sumg += $g[$x-1][$y];
			$sumb += $b[$x-1][$y];
			array_push($arrr, $r[$x-1][$y]);
			array_push($arrg, $g[$x-1][$y]);
			array_push($arrb, $b[$x-1][$y]);
		}
		//kanan
		if (isset($r[$x+1][$y])) {
			$count++;
			$sumr += $r[$x+1][$y];
			$sumg += $g[$x+1][$y];
			$sumb += $b[$x+1][$y];
			array_push($arrr, $r[$x+1][$y]);
			array_push($arrg, $g[$x+1][$y]);
			array_push($arrb, $b[$x+1][$y]);
		}
		//kiri bawah
		if (isset($r[$x-1][$y+1])) {
			$count++;
			$sumr += $r[$x-1][$y+1];
			$sumg += $g[$x-1][$y+1];
			$sumb += $b[$x-1][$y+1];
			array_push($arrr, $r[$x-1][$y+1]);
			array_push($arrg, $g[$x-1][$y+1]);
			array_push($arrb, $b[$x-1][$y+1]);
		}
		//bawah
		if (isset($r[$x][$y+1])) {
			$count++;
			$sumr += $r[$x][$y+1];
			$sumg += $g[$x][$y+1];
			$sumb += $b[$x][$y+1];
			array_push($arrr, $r[$x][$y+1]);
			array_push($arrg, $g[$x][$y+1]);
			array_push($arrb, $b[$x][$y+1]);
		}
		//kanan bawah
		if (isset($r[$x+1][$y+1])) {
			$count++;
			$sumr += $r[$x+1][$y+1];
			$sumg += $g[$x+1][$y+1];
			$sumb += $b[$x+1][$y+1];
			array_push($arrr, $r[$x+1][$y+1]);
			array_push($arrg, $g[$x+1][$y+1]);
			array_push($arrb, $b[$x+1][$y+1]);
		}

		if ($direction == 'mean') {
			if ($count == 0) {
				$smoothedr[$x][$y] = 0;
				$smoothedg[$x][$y] = 0;
				$smoothedb[$x][$y] = 0;
			} else {
				$smoothedr[$x][$y] = (int) ceil($sumr/(float) $count);
				$smoothedg[$x][$y] = (int) ceil($sumg/(float) $count);
				$smoothedb[$x][$y] = (int) ceil($sumb/(float) $count);
			}
		} else {
			sort($arrr);
			sort($arrg);
			sort($arrb);
			$smoothedr[$x][$y] = median($arrr);
			$smoothedg[$x][$y] = median($arrg);
			$smoothedb[$x][$y] = median($arrb);
		}
	}
}

$img = imagecreatetruecolor($width, $height);
for ($y=0; $y < $height; $y++) { 
	for ($x=0; $x < $width; $x++) { 
		imagesetpixel($img, $x, $y, imagecolorallocate($img, $smoothedr[$x][$y], $smoothedg[$x][$y], $smoothedb[$x][$y]));
	}
}

ob_start();
	imagejpeg($img);
	$contents = ob_get_contents();
ob_end_clean();

$base64 = "data:image/jpeg;base64," . base64_encode($contents);

$result = [
	'r' => $smoothedr,
	'g' => $smoothedg,
	'b' => $smoothedb,
	'width' => $width,
	'height' => $height,
	'base64' => $base64
];
echo json_encode($result);