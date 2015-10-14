$(function() {

	if ($('input[name=url]').val() == '') {
		$('input[name=url]').val('http://');
	}

	function preload(arrayOfImages) {
	    $(arrayOfImages).each(function(){
	        $('<img/>')[0].src = this;
	        // Alternatively you could use:
	        // (new Image()).src = this;
	    });
	}
	var backgroundImage;

	$.getJSON('https://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC', function(data) {
		backgroundImage = data.data.fixed_height_small_url;
		preload([backgroundImage]);
	});

	var backgrounder;
	$('#pushButton a').hover(function() {
		var i = 0;
		var increasing = true;

		backgrounder = setInterval(function() {

			// backgroundColors = ['ff00ba', 'ff00f6', '005aff', '00ff78', '42ff00', 'e4ff00', 'ffb400', 'ff7200', 'ff0c00'];
			rainbow = ['ff0000', 'ff2a00', 'ff5500', 'ff8000', 'ffaa00', 'ffd400', 'ffff00', 'd5ff00', 'aaff00', '80ff00', '55ff00', '2bff00', '00ff00', '00ff2b', '00ff55', '00ff80', '00ffaa', '00ffd5', '00ffff', '00d5ff', '00aaff', '0080ff', '0055ff', '002bff', '0000ff', '2b00ff', '5500ff', '8000ff', 'aa00ff', 'd500ff', 'ff00ff', 'ff00d4', 'ff00aa', 'ff0080', 'ff0055', 'ff002a', 'ff0000'];

			if (i == rainbow.length) {
				i = 0;
			} else {
				i++;
			}

			$('body').addClass('on_pushbutton');
			$('#pushButton a').css('background-color', '#' + rainbow[Math.floor(Math.random()*rainbow.length)], 200);
			$('body').css('background-image', 'url(' + backgroundImage + ')');

		}, 50);



	}, function() {
		clearInterval(backgrounder);
		$('body, #pushButton a').removeAttr('style');
		$('body').removeClass('on_pushbutton');
		$.getJSON('https://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC', function(data) {
			backgroundImage = data.data.fixed_height_small_url;
			preload([backgroundImage]);
		});

	});

	var rotater;
	$('#pushButton').hover(function() {
		var i = 0;

		rotater = setInterval(function() {
			i+=2;
			$('#pushButton a').css('transform', 'rotate(' + i + 'deg)');	
		}, 1);
		
	}, function() {
		clearInterval(rotater);
		$('#pushButton a').removeAttr('style');
	});
})