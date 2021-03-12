(function ($) {
    "use strict";

	/*[ Smooth Scroll ]
    ===========================================================*/
	$('#smooth-scroll').on('click', function() {
		
		var page = $(this).attr('href');
		
		$('html, body').animate( { scrollTop: $(page).offset().top }, 750 );
		
		return false;
	});
	
    /*[ Back to top ]
    ===========================================================*/
    var windowH = $(window).height()*1.2;

    $(window).on('scroll',function(){
		
        if ($(this).scrollTop() > windowH) {
			
            $("#back-to-top").css('display','flex');
			
        } else {
			
            $("#back-to-top").css('display','none');
			
        }
    });

    $('#back-to-top').on("click", function(){
		
        $('html, body').animate({scrollTop: $('#content').offset().top}, 300);
    });
	
	/*[ onLoad/onChange : Update IHM & params ]
    ===========================================================*/
	var type = 'iframe';
	
	function resetForm(){
		
		type= 'iframe';
		
		url = base_url + 'iframe.php';
		
		$('#type option[value="iframe"]').prop('selected', true);
		$('#pubkey').val('');
		$('#target').val('');
		$('#title').val('');
		$('#theme').val('paidge');
		$('#unit option[value="quantitative"]').prop('selected', true);
		$('#lang option[value="fr"]').prop('selected', true);
		$('#node').val('');
		$('#period option[value="current-monh"]').prop('selected', true);
		$('#start_date').val('');
		$('#end_date').val('');
		$('#p-start_date').addClass("w3-hide");
		$('#p-end_date').addClass("w3-hide");
		$('#hide_title').prop( "checked", false );
		$('#display_pubkey').prop( "checked", false );
		$('#display_qrcode').prop( "checked", false );
		$('#display_button').prop( "checked", false );
		$('#display_graph').prop( "checked", false );
		$('#logo option[value="no-logo"]').prop('selected', true);
		$('#p-logo').addClass("w3-hide");
		$('#p-display_button').removeClass("w3-hide");
		$('#p-display_graph').removeClass("w3-hide");
		$('#background_color').val('#ffffff');
		$('#font_color').val('#212529');
		$('#progress_color').val('#ffc107');
		$('#border_color').val('#343a40');
		$('#preview_label').addClass("w3-hide");
		$('#result').val('');
		
		for (var param in params) {
			
			params[param] = '';
		}
	}
	$(window).on('load',resetForm);
	
	$('#type').on('change', function() {
		type = this.value;
		
		switch (type) {
			case 'iframe':
				$('#p-logo').addClass("w3-hide");
				params['logo'] = '';
				$('#p-display_button').removeClass("w3-hide");
				$('#p-display_graph').removeClass("w3-hide");
				url = base_url + 'iframe.php';
				break;
			case 'png':
				$('#p-logo').removeClass("w3-hide");
				$('#p-display_button').addClass("w3-hide");
				$('#p-display_graph').addClass("w3-hide");
				params['display_button'] = '';
				params['display_graph'] = '';
				url = base_url + 'image.php';
				break;
			case 'svg':
				$('#p-logo').removeClass("w3-hide");
				$('#p-display_button').addClass("w3-hide");
				$('#p-display_graph').addClass("w3-hide");
		        params['display_button'] = '';
				params['display_graph'] = '';
				url = base_url + 'svg.php';
				break;
			default:
				break;
		}
	});
	
	var theme = 'paidge';
	
	$('#theme').on('change', function() {
		
		theme = this.value;
		
		switch (theme) {
				
			case 'kickstarter':
				$('#p-progress_color').addClass("w3-hide");
				$('#p-logo').addClass("w3-hide");
				$('#p-display-graph').addClass("w3-hide");
				
				$('#p-display_button').removeClass("w3-hide");
				$('#p-display_button').removeClass("w3-hide");
				$('#p-display_qrcode').addClass("w3-hide");
				$('#p-display_pubkey').addClass("w3-hide");
				$('#p-display_graph').addClass("w3-hide");
				$('#p-hide_title').addClass("w3-hide");
				$('#p-border_color').addClass("w3-hide");
				$('#p-type').addClass("w3-hide");
				break;
				
			case 'paidge':
				$('#p-progress_color').removeClass("w3-hide");
				$('#p-logo').removeClass("w3-hide");
				$('#p-display_button').addClass("w3-hide");
				$('#p-display_graph').addClass("w3-hide");
				$('#p-display_qrcode').removeClass("w3-hide");
				$('#p-display_pubkey').removeClass("w3-hide");
				$('#p-hide_title').removeClass("w3-hide");
				$('#p-border_color').removeClass("w3-hide");
				$('#p-display_graph').removeClass("w3-hide");
				$('#p-type').removeClass("w3-hide");
				params['display_button'] = '';
				params['display_graph'] = '';
				break;
			default:
				break;
		}
	});
	
	$('#period').on('change', function() {
		var period = this.value;
		
		switch (period) {
			case 'current-monh':
				$('#p-start_date').addClass("w3-hide");
				$('#p-end_date').addClass("w3-hide");
				params['start_date'] = '';
				params['end_date'] = '';
				break;
			case 'one-date':
				$('#p-start_date').removeClass("w3-hide");
				$('#p-end_date').addClass("w3-hide");
				params['end_date'] = '';
				break;
			case 'two-dates':
				$('#p-start_date').removeClass("w3-hide");
				$('#p-end_date').removeClass("w3-hide");
				break;
		}
	});
	
	$('#hide_title').on('change', function() { params['hide_title'] = $('#hide_title').prop('checked') ? true : ''; });
	
	$('#title').on('change', function() {params['title'] = encodeURIComponent(this.value);});
	$('#theme').on('change', function() {params['theme'] = encodeURIComponent(this.value);});
	$('#unit').on('change', function() {params['unit'] = this.value;});
	$('#lang').on('change', function() {params['lang'] = this.value;});
	$('#node').on('change', function() {params['node'] = this.value;});
	$('#start_date').on('change', function() {params['start_date'] = this.value;});
	$('#end_date').on('change', function() {params['end_date'] = this.value;});	
	
	$('#display_pubkey').on('change', function() {params['display_pubkey'] = $('#display_pubkey').prop('checked') ? true : '';});
	$('#display_qrcode').on('change', function() {params['display_qrcode'] = $('#display_qrcode').prop('checked') ? true : '';});
	$('#display_button').on('change', function() {params['display_button'] = $('#display_button').prop('checked') ? true : '';});
	$('#display_graph').on('change', function() {params['display_graph'] = $('#display_graph').prop('checked') ? true : '';});
	$('#logo').on('change', function() {params['logo'] = $('#logo').val();});
	$('#background_color').on('change', function() {params['background_color'] = this.value.substr(1);});
	$('#font_color').on('change', function() {params['font_color'] = this.value.substr(1);});
	$('#progress_color').on('change', function() {params['progress_color'] = this.value.substr(1);});
	$('#border_color').on('change', function() {params['border_color'] = this.value.substr(1);});

	/*[ Generate URL ]
    ===========================================================*/
	var base_url = document.location.href;
	base_url = base_url.substr(0,base_url.lastIndexOf('/')+1);
	var url = base_url+'iframe.php';
	
	var params = {
		
		'title' : '',
		'theme' : '',
		'unit' : '',
		'lang' : '',
		'node' : '',
		'start_date' : '',
		'end_date' : '',
		'hide_title' : '',
		'display_pubkey' : '',
		'display_qrcode' : '',
		'display_button' : '',
		'display_graph' : '',
		'logo' : '',
		'background_color' : '',
		'font_color' : '',
		'progress_color' : '',
		'border_color' : ''
	};
	
	function generateFullUrl (pubkey, target) {
		
		var fullUrl = '';
		
		fullUrl += url;
		
		fullUrl += '?pubkey=' + pubkey;
		
		fullUrl += '&target=' + target;

		for (var param in params) {

			if (params[param] !== '') {

				fullUrl += '&'+param+'='+params[param];
			}
		}
		
		return fullUrl;
	}
	
	function generateHTM (fullUrl, integrationType, title) {
		
		fullUrl = fullUrl.replace('&', '&amp;');
		
		switch (integrationType) {

			case 'iframe':

				return '<iframe src="'+fullUrl+'" width="100%" height="100%" frameborder="0"></iframe>';

			case 'png':

				return '<img src="'+fullUrl+'" alt="' + title + '" />';

			case 'svg':

				return '<object type="image/svg+xml" data="'+fullUrl+'" border="0"></object>';
		}
		
	}
	
	function generateBBCode (fullUrl, integrationType, title) {

		switch (integrationType) {

			case 'iframe':

				return '[url=' + fullUrl + ']'+ title + '[/url]';

			case 'png':

				return '[img]' + fullUrl + '[/url]';

			case 'svg':

				return '[img]' + fullUrl + '[/url]';
		}
		
	}
	
	function generateMarkdown (fullUrl, integrationType, title) {

		switch (integrationType) {

			case 'iframe':

				return '[' + title + '](' + fullUrl + ')';

			case 'png':

				return '\![](' + fullUrl + ')';

			case 'svg':

				return '\![](' + fullUrl + ')';
		}
		
	}
	
	function generateWikitext (fullUrl, integrationType, title) {

		switch (integrationType) {

			case 'iframe':

				return '[[' + fullUrl + '|' + title + ']]';

			case 'png':

				return '[[' + fullUrl + '|{{' + fullUrl + '}}]]';

			case 'svg':

				return '[[' + fullUrl + '|{{' + fullUrl + '}}]]';
		}
		
	}
	
    $('#submit').on("click", function() {
		
		if (document.getElementById("pubkey").checkValidity() 
			&& document.getElementById("target").checkValidity()) {
			
			var pubkeyVal = $('#pubkey').val();
			var targetVal = $('#target').val();
			
			var fullUrl = generateFullUrl(pubkeyVal, targetVal);
			
			var title = decodeURIComponent(params['title']);
			
			var htm = generateHTM(fullUrl, type, title);
			var bbcode = generateBBCode(fullUrl, type, title);
			var markdown = generateMarkdown(fullUrl, type, title);
			var wikitext = generateWikitext(fullUrl, type, title);
			
			$('form').on("submit", function() {
				
				$('#preview_label').removeClass("w3-hide");
				$('#preview').css("visibility","hidden");
				$('#preview').children().remove();
				
				$('#integration-instructions').removeClass("w3-hide");
				
				$('#htm').val(htm);
				$('#bbcode').val(bbcode);
				$('#markdown').val(markdown);
				$('#wikitext').val(wikitext);
				
				$('html, body').animate({scrollTop: $('#display_result').offset().top}, 750);
				
				
				$('#preview').append(htm);
				
				if (type == 'iframe') {
					
					$('iframe').on('load', function() {
						
						var iframe_height = document.getElementsByTagName('iframe')[0].contentWindow.document.body.scrollHeight;
						$('iframe').height(iframe_height);
						
						// Pour relancer l'animation
						$('#preview').html($('#preview').html());
					});
				}
				
				$('#htm').focus();
				$('.buttons').removeClass("w3-hide");
				
				setTimeout(function(){
					
					$('#preview').css("visibility","visible");
					$('#integration-instructions').css("visibility","visible");
					
				}, 1000);
				
				return false;
			});
		}
    });

	/*[ Reset ]
    ===========================================================*/
	
    $('#reset').on("click", function(){
		
		$('#result').val('');
		
		resetForm();
		
		$('html, body').animate({scrollTop: $('#content').offset().top}, 300);
		
		$('#buttons').addClass("w3-hide");
		
		$('#preview').children().remove();
    });
	
})(jQuery);