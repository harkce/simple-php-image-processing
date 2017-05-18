var base64;
var origin = {
	r: [[]],
	g: [[]],
	b: [[]],
	width: 0,
	height: 0
}
var edited = {
	r: [[]],
	g: [[]],
	b: [[]],
	width: 0,
	height: 0
}
var snd;

function splitstring(str, l) {
	var strs = [];
	var strlen = str.length;
	var tmp = "";
	for (var i = 0; i < strlen; i++) {
		tmp += str[i];
		if (tmp.length == l) {
			strs.push(tmp);
			tmp = "";
		}
	}
	strs.push(tmp);
	var result = {jml: strs.length, splitted: strs};
	return result;
}

function original() {
	$('#progress').show();
	if ($('#image-up').prop('files')[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			base64 = e.target.result;
			$('#ori-image').attr('src', base64);
			snd = splitstring(base64, 1000);
			var rv = {length: snd.jml};
			for (var i = 0; i < snd.jml; i++) {
				var label = "str" + i;
				rv[label] = snd.splitted[i];
			}
			$.ajax({
				type: 'POST',
				url: 'function/image2matrix.php',
				data: rv,
				success: function(data) {
					data = JSON.parse(data);
					$('#edit-image').attr('src', data.base64);
					$('#progress').hide();
					origin.r = data.r;
					origin.g = data.g;
					origin.b = data.b;
					origin.width = data.width;
					origin.height = data.height;
					edited = origin;
				},
				async: false
			});
		};
		reader.readAsDataURL($('#image-up').prop('files')[0]);
	}
}

function grayscale() {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/grayscale.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function rotate(direction) {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/rotate.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height,
			direction: direction
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function zoom(direction) {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/zoom.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height,
			direction: direction
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function brightness(direction) {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/brightness.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height,
			direction: direction
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function kalibright(direction) {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/kalibright.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height,
			direction: direction
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function slide(direction) {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/slide.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height,
			direction: direction
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function smooth(direction) {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/smooth.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height,
			direction: direction
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function warp() {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/warping.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function convulsion(direction) {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/convulsion.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height,
			direction: direction
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function sharpen() {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/sharpen.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function edge() {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/edge.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function erosion() {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/erosion.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}

function dilation() {
	$('#progress').show();
	$.ajax({
		type: 'POST',
		url: 'function/dilation.php',
		data: {
			r: JSON.stringify(edited.r),
			g: JSON.stringify(edited.g),
			b: JSON.stringify(edited.b),
			width: edited.width,
			height: edited.height
		},
		success: function(data) {
			data = JSON.parse(data);
			$('#edit-image').attr('src', data.base64);
			$('#progress').hide();
			edited.r = data.r;
			edited.g = data.g;
			edited.b = data.b;
			edited.width = parseInt(data.width);
			edited.height = parseInt(data.height);
		},
		async: false
	});
}