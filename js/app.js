var bindlist = {};
var _callback = '';
var _response;


$(document).ready(function(){
	
	init();
	events();
	
})

function init(){
	$('#featured-slider').responsiveSlides();

	
	$(document).on('change','.change-submit',function(e){
		var that = this;
		setTimeout(function(){
			$(that).parents('form').submit();
		}, 10);
	})
	
	$(document).on('submit','form',function(e){
		
		var ok = true;
		$(this).find(':input').each(function(){
			if ($(this).hasClass('mandatory')){
				if (!$(this).val()) ok = false;
			}
		});
		
		if (!ok){
			alert('Please make sure you have filled in the mandatory fields.');
			return false;
		}
		
		_callback = $(this).attr('callback');
		
				
		if ($(this).attr('target') == 'postframe'){
			$('body').append('<div class="overlay" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3);"></div>')
		}
		

	})

	
	try {
		initializeCitiesAutocomplete();	
	} catch(e){
	
	}
	
	setInterval(function(){
		getNotifications();
	}, 2000);
	
	getNotifications();

}

function events(){
	
	
	
	
		$('body').append('<iframe style="display:none" id="postframe" name="postframe"></iframe>');
	
	if ($(this).attr('target') == 'postframe'){
		$('body').append('<div class="overlay" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3);"></div>')
	}


	$('.input-select input.text').focus(function(e){
		e.preventDefault();
		$('.input-select ul, .input-select .select-box').hide();
		$(this).parents('.input-select').find('ul,.select-box').show();

	})
	
	$('#sign-up-form form').submit(function(e){
		e.preventDefault();
		
		$('input.error').removeClass('error');
		$('.error-msg').remove();
		
		$(this).find('.btn-primary').val('Signing Up...');
		
		var data = $(this).serialize();
		var url = (_ut == 'tutor') ? 'signup/tutor' : 'signup/user';
		$.ajax({
			url: url,
			type: 'post',
			data: data,
			dataType: 'json',
			success: function(res){
				
				$(this).find('.btn-primary').val('Sign Up');
		
				if (res.status == 'ok'){
					
					$('input[name=h]').val(res.h);
					$('input[name=i]').val(res.i);
					
					$('div.sign-up').hide();
					$('div.mobile-confirm').show();
					
				} else if (res.status == 'error'){
					
					for (var field in res.error){
						var msg = res.error[field];
						$('#sign-up-form [name='+field+']').addClass('error').after('<small class="error-msg">'+msg+'</small>');

					}
				}
			}
		})
	})
	
	$('#mobile-auth-change-number').click(function(e){
		e.preventDefault();
		
		$('div.mobile-confirm').show();
		$('div.mobile-auth').hide();
	})
	
	$('#mobile-auth-resend').click(function(){
		e.preventDefault();

		$('div.mobile-confirm-form form').submit();
	})
	
	
	
	$('#mobile-auth-form input.code').keyup(function(){
		var code = $(this).val();
		
		if (code.length == 4){
			$(this).parents('form').submit();
		}
	})
		
	$('#mobile-auth-form form').submit(function(e){
		
		e.preventDefault();
		
		$('input.error').removeClass('error');
		$('.error-msg').remove();

		var data = $(this).serialize();
		
		$('input.code').attr('disabled',true);
		
		$.ajax({
			url: 'signup/mobauth',
			type: 'post',
			data: data,
			dataType: 'json',
			success: function(res){
			
				if (res.status == 'ok'){
					
					$('div.mobile-auth').hide();
					location.href = location.href;
					
				} else if (res.status == 'error'){
					
					$('input.code').removeAttr('disabled').val('');
					
					for (var field in res.error){
						var msg = res.error[field];
						$('#mobile-auth-form input[name='+field+']').addClass('error').after('<small class="error-msg">'+msg+'</small>');

					}
				}
			}
		})
		
	})
	
	$('#mobile-confirm-form form').submit(function(e){
		
		e.preventDefault();
		
		$('input.error').removeClass('error');
		$('.error-msg').remove();

		var data = $(this).serialize();
		var mobile = $('input.tel').val();
		
		$.ajax({
			url: 'signup/mobreg',
			type: 'post',
			data: data,
			dataType: 'json',
			success: function(res){
				if (res.status == 'ok'){
					
					$('input[name=h]').val(res.h);
					$('input[name=i]').val(res.i);
					
					$('div.mobile-confirm').hide();
					$('div.mobile-auth').show();
					
					$('span.mobile-no-auth').text(mobile);
					
				} else if (res.status == 'error'){
					
					for (var field in res.error){
						var msg = res.error[field];
						$('#mobile-confirm-form input[name='+field+']').addClass('error').after('<small class="error-msg">'+msg+'</small>');

					}
				}
			}
		})
	})
	
	$(".tel").intlTelInput({
		initialCountry: 'my'
	});
	
	$('a.signup-btn').click(function(e){
		e.preventDefault();
		$('div.sign-up').show();
	})
	
	$('a.login-btn').click(function(e){
		e.preventDefault();
		$('div.login').show();
	})
	
	$('a.close-login').click(function(e){
		e.preventDefault();
		$('div.login').hide();
	})
	
	$('.close-form').click(function(e){
		e.preventDefault();
		$(this).parents('div.overlay-form').hide();
	})
	
	$('a.close-sign-up').click(function(e){
		e.preventDefault();
		$('div.sign-up').hide();
	})
	
	$('.description').click(function(){
		$('.description').removeClass('description-selected');
		$(this).addClass('description-selected');
		var n = parseInt($(this).find('.desc-n').html());
		$('.hiw-img img').hide();
		$($('.hiw-img img')[n-1]).show();
	})
	
	$('.description').first().click();
	
	$('.how-it-works .next').click(function(){
		var current = $('div.description-selected').index();
		var total = $('.description').length
		
		if (current == total - 1){
			current = -1;
		}
		
		$('.description-selected').removeClass('description-selected');
		$('.description').eq(current+1).addClass('description-selected');
		$('.hiw-img img').hide();

		$($('.hiw-img img')[current+1]).show();
	
	})

	$('.how-it-works .prev').click(function(){
		var current = $('div.description-selected').index();
		var total = $('.description').length
		
		if (current == 0){
			current = total;
		}
		
		$('.description-selected').removeClass('description-selected');
		$('.description').eq(current-1).addClass('description-selected');
		$('.hiw-img img').hide();
		$($('.hiw-img img')[current-1]).show();
	})
	
	
	$('.input-select input.text').click(function(e){
		e.preventDefault();
		$('.input-select ul, .input-select .select-box').hide();
		$(this).parents('.input-select').find('ul,.select-box').show();

	})
	
	$('.input-select input.text').blur(function(){
		var that = this;
		if ($(this).hasClass('hold')) return;
		
		setTimeout(function(){
			$(that).parents('.input-select').find('ul,.select-box').hide();
		}, 200);
	})
	
	$('.input-select li').click(function(){
		var val = $(this).text();
		$(this).parents('.input-select').find('input.text').val(val).change();
		
	})
	
	$('.preferred-time span').click(function(){
		$(this).toggleClass('selected');
		var values = [];
		$('.preferred-time span.selected').each(function(){
			var val = $(this).text();
			values.push(val);
		})
		
		
		$('.preferred-time').find('input.text').val(values.join(', '));
	})
	
	$('.input-select .done').click(function(e){
		e.preventDefault();
		$('.input-select ul, .input-select .select-box').hide();
	})
	
	$('input.grade').change(function(){
		var rel = $(this).val();
		rel = rel.replace(')','');
		rel = rel.replace('(','');		
		rel = rel.replace('/','');
		rel = rel.replace(/\s+/g,'-');

		$('input.subject').val('');
		$('ul.subject li').hide();
		$('ul.subject li[rel='+rel+']').show();
	})
	
	$('ul.subject li').hide();
	$('ul.subject li[rel=]').show();	

}




function strtotime(text, now) {
  //  discuss at: http://phpjs.org/functions/strtotime/
  //     version: 1109.2016
  // original by: Caio Ariede (http://caioariede.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Caio Ariede (http://caioariede.com)
  // improved by: A. Matías Quezada (http://amatiasq.com)
  // improved by: preuter
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Mirko Faber
  //    input by: David
  // bugfixed by: Wagner B. Soares
  // bugfixed by: Artur Tchernychev
  //        note: Examples all have a fixed timestamp to prevent tests to fail because of variable time(zones)
  //   example 1: strtotime('+1 day', 1129633200);
  //   returns 1: 1129719600
  //   example 2: strtotime('+1 week 2 days 4 hours 2 seconds', 1129633200);
  //   returns 2: 1130425202
  //   example 3: strtotime('last month', 1129633200);
  //   returns 3: 1127041200
  //   example 4: strtotime('2009-05-04 08:30:00 GMT');
  //   returns 4: 1241425800

  var parsed, match, today, year, date, days, ranges, len, times, regex, i, fail = false;

  if (!text) {
    return fail;
  }

  // Unecessary spaces
  text = text.replace(/^\s+|\s+$/g, '')
    .replace(/\s{2,}/g, ' ')
    .replace(/[\t\r\n]/g, '')
    .toLowerCase();

  // in contrast to php, js Date.parse function interprets:
  // dates given as yyyy-mm-dd as in timezone: UTC,
  // dates with "." or "-" as MDY instead of DMY
  // dates with two-digit years differently
  // etc...etc...
  // ...therefore we manually parse lots of common date formats
  match = text.match(
    /^(\d{1,4})([\-\.\/\:])(\d{1,2})([\-\.\/\:])(\d{1,4})(?:\s(\d{1,2}):(\d{2})?:?(\d{2})?)?(?:\s([A-Z]+)?)?$/);

  if (match && match[2] === match[4]) {
    if (match[1] > 1901) {
      switch (match[2]) {
        case '-':
          { // YYYY-M-D
            if (match[3] > 12 || match[5] > 31) {
              return fail;
            }

            return new Date(match[1], parseInt(match[3], 10) - 1, match[5],
              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
          }
        case '.':
          { // YYYY.M.D is not parsed by strtotime()
            return fail;
          }
        case '/':
          { // YYYY/M/D
            if (match[3] > 12 || match[5] > 31) {
              return fail;
            }

            return new Date(match[1], parseInt(match[3], 10) - 1, match[5],
              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
          }
      }
    } else if (match[5] > 1901) {
      switch (match[2]) {
        case '-':
          { // D-M-YYYY
            if (match[3] > 12 || match[1] > 31) {
              return fail;
            }

            return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
          }
        case '.':
          { // D.M.YYYY
            if (match[3] > 12 || match[1] > 31) {
              return fail;
            }

            return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
          }
        case '/':
          { // M/D/YYYY
            if (match[1] > 12 || match[3] > 31) {
              return fail;
            }

            return new Date(match[5], parseInt(match[1], 10) - 1, match[3],
              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
          }
      }
    } else {
      switch (match[2]) {
        case '-':
          { // YY-M-D
            if (match[3] > 12 || match[5] > 31 || (match[1] < 70 && match[1] > 38)) {
              return fail;
            }

            year = match[1] >= 0 && match[1] <= 38 ? +match[1] + 2000 : match[1];
            return new Date(year, parseInt(match[3], 10) - 1, match[5],
              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
          }
        case '.':
          { // D.M.YY or H.MM.SS
            if (match[5] >= 70) { // D.M.YY
              if (match[3] > 12 || match[1] > 31) {
                return fail;
              }

              return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
                match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
            }
            if (match[5] < 60 && !match[6]) { // H.MM.SS
              if (match[1] > 23 || match[3] > 59) {
                return fail;
              }

              today = new Date();
              return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
                match[1] || 0, match[3] || 0, match[5] || 0, match[9] || 0) / 1000;
            }

            return fail; // invalid format, cannot be parsed
          }
        case '/':
          { // M/D/YY
            if (match[1] > 12 || match[3] > 31 || (match[5] < 70 && match[5] > 38)) {
              return fail;
            }

            year = match[5] >= 0 && match[5] <= 38 ? +match[5] + 2000 : match[5];
            return new Date(year, parseInt(match[1], 10) - 1, match[3],
              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
          }
        case ':':
          { // HH:MM:SS
            if (match[1] > 23 || match[3] > 59 || match[5] > 59) {
              return fail;
            }

            today = new Date();
            return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
              match[1] || 0, match[3] || 0, match[5] || 0) / 1000;
          }
      }
    }
  }

  // other formats and "now" should be parsed by Date.parse()
  if (text === 'now') {
    return now === null || isNaN(now) ? new Date()
      .getTime() / 1000 | 0 : now | 0;
  }
  if (!isNaN(parsed = Date.parse(text))) {
    return parsed / 1000 | 0;
  }

  date = now ? new Date(now * 1000) : new Date();
  days = {
    'sun': 0,
    'mon': 1,
    'tue': 2,
    'wed': 3,
    'thu': 4,
    'fri': 5,
    'sat': 6
  };
  ranges = {
    'yea': 'FullYear',
    'mon': 'Month',
    'day': 'Date',
    'hou': 'Hours',
    'min': 'Minutes',
    'sec': 'Seconds'
  };

  function lastNext(type, range, modifier) {
    var diff, day = days[range];

    if (typeof day !== 'undefined') {
      diff = day - date.getDay();

      if (diff === 0) {
        diff = 7 * modifier;
      } else if (diff > 0 && type === 'last') {
        diff -= 7;
      } else if (diff < 0 && type === 'next') {
        diff += 7;
      }

      date.setDate(date.getDate() + diff);
    }
  }

  function process(val) {
    var splt = val.split(' '), // Todo: Reconcile this with regex using \s, taking into account browser issues with split and regexes
      type = splt[0],
      range = splt[1].substring(0, 3),
      typeIsNumber = /\d+/.test(type),
      ago = splt[2] === 'ago',
      num = (type === 'last' ? -1 : 1) * (ago ? -1 : 1);

    if (typeIsNumber) {
      num *= parseInt(type, 10);
    }

    if (ranges.hasOwnProperty(range) && !splt[1].match(/^mon(day|\.)?$/i)) {
      return date['set' + ranges[range]](date['get' + ranges[range]]() + num);
    }

    if (range === 'wee') {
      return date.setDate(date.getDate() + (num * 7));
    }

    if (type === 'next' || type === 'last') {
      lastNext(type, range, num);
    } else if (!typeIsNumber) {
      return false;
    }

    return true;
  }

  times = '(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec' +
    '|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?' +
    '|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)';
  regex = '([+-]?\\d+\\s' + times + '|' + '(last|next)\\s' + times + ')(\\sago)?';

  match = text.match(new RegExp(regex, 'gi'));
  if (!match) {
    return fail;
  }

  for (i = 0, len = match.length; i < len; i++) {
    if (!process(match[i])) {
      return fail;
    }
  }

  // ECMAScript 5 only
  // if (!match.every(process))
  //    return false;

  return (date.getTime() / 1000);
}

Date.prototype.formatDate = function(format)
{
    var date = this;
    if (!format)
      format="MM/dd/yyyy";               
 
    var month = date.getMonth() + 1;
    var year = date.getFullYear();    
 
    format = format.replace("MM",month.toString().padL(2,"0"));        
 
    if (format.indexOf("yyyy") > -1)
        format = format.replace("yyyy",year.toString());
    else if (format.indexOf("yy") > -1)
        format = format.replace("yy",year.toString().substr(2,2));
 
    format = format.replace("dd",date.getDate().toString().padL(2,"0"));
 
    var hours = date.getHours();       
    if (format.indexOf("t") > -1)
    {
       if (hours > 11)
        format = format.replace("t","pm")
       else
        format = format.replace("t","am")
    }
    if (format.indexOf("HH") > -1)
        format = format.replace("HH",hours.toString().padL(2,"0"));
    if (format.indexOf("hh") > -1) {
        if (hours > 12) hours - 12;
        if (hours == 0) hours = 12;
        format = format.replace("hh",hours.toString().padL(2,"0"));        
    }
    if (format.indexOf("mm") > -1)
       format = format.replace("mm",date.getMinutes().toString().padL(2,"0"));
    if (format.indexOf("ss") > -1)
       format = format.replace("ss",date.getSeconds().toString().padL(2,"0"));
    return format;
}


function timeSince(date) {

    var seconds = Math.floor((new Date() - date) / 1000);

    var interval = Math.floor(seconds / 31536000);
    
    if (seconds < 60){
	    return 'just now';
    } else if (seconds <= 120){
	    return 'a minute ago';
    }

    if (interval > 1) {
        return interval + " years ago";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + " months ago";
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + " days ago";
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + " hours ago";
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + " minutes ago";
    }
    return Math.floor(seconds) + " seconds ago";
}



// var blop = new Audio('assets/audio/blop.wav');

function beep(){
	// blop.play();	
}






var base = {
	_nav_path: [],
	init: function(){
		
		// navigation events
		
		that = this;
		
		
		if (system == 'pms'){
			this.loadPriorityProjects();
			this.loadStatuses();
			this.loadCategories();
		}
		
		if (system == 'crm'){
			this.hideSidebar();
		}
		
		
		that = this;
		
		this.bind();
		
		var urls = location.href;
		urls = urls.split('#');
		var base_url = urls[0];
		var target = urls[1];
		
		if (target) this.go(target);
		else this.loadDashboard();
		
				
		this.bind();
		
		$('#sidebar').prepend('<a onclick="base.hideSidebar()" class="hide-sidebar"></a>')
	},
	hideSidebar: function(){
		$('#sidebar').hide();
		$('#main').css('left','10px');
		$('#container').prepend('<a onclick="base.showSidebar()" class="show-sidebar"></a>')
	},
	showSidebar: function(){
		$('#sidebar').show();
		$('#main').css('left','200px');
		$('.show-sidebar').remove();
	},
	go: function(url, data, method){
		if (!url) return;
		
		this.showLoading();
		
		var urls = location.href;
		urls = urls.split('#');
		var base_url = urls[0];
		
		url = url.replace('#','');
		
		location.href = base_url + '#' + url;
		
		$.ajax({
			url: url,
			type: method ? method : 'post',
			data: data,
			success: function(res){
				base.hideLoading();
				$('#main').html(res);
				base.bind();
				

			}
		})		
	},
	back: function(){
		
	},
	forward: function(){
		
	},
	
	loadDashboard: function(){
		
		if (system == 'pms'){
			this.go('projects/dashboard');
		} else if (system == 'crm'){
			this.go('crm/calendar');
		}
		

	},

	loadPriorityProjects: function(){
		$.ajax({
			url: 'projects/ajax/get_priority_projects/html',
			type: 'post',
			success: function(res){
				$('ul.priority-projects').html(res)
			}
		});
	},
	loadStatuses: function(){
		$.ajax({
			url: 'projects/ajax/get_statuses/html',
			type: 'post',
			success: function(res){
				$('ul.statuses').html(res);
			}
		})
	},
	loadCategories: function(){
		$.ajax({
			url: 'projects/ajax/get_categories/html',
			type: 'post',
			success: function (res){
				$('ul.categories').html(res);
			}
		})
	},
	bind: function(){


		$('input.autocomplete-tag').textboxlist({unique: true, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: false,
			remote: {url: base_url + 'autocomplete/search/tag'}
		}}});
		
		
		$('input.autocomplete-company-single').textboxlist({unique: true, max: 1, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: false,
			remote: {url: base_url + 'autocomplete/search/company'}
		}}});


		$('input.autocomplete-contact').textboxlist({unique: true, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: true,
			remote: {url: base_url + 'autocomplete/search/contact'}
		}}});


		$('input.autocomplete-contact-single').textboxlist({unique: true, max: 1, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: true,
			remote: {url: base_url + 'autocomplete/search/contact'}
		}}});

		
		$('input.autocomplete-user-single').textboxlist({unique: true, max: 1, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: true,
			remote: {url: base_url + 'autocomplete/search/user'}
		}}});
		
		$('input.autocomplete-user').textboxlist({unique: true, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: true,
			remote: {url: base_url + 'autocomplete/search/user'}
		}}});
		
		$('input.autocomplete-category-single').textboxlist({unique: true, max: 1, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: true,
			remote: {url: base_url + 'autocomplete/search/category'}
		}}});
		
		$('input.autocomplete-target-market').textboxlist({unique: true, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: true,
			remote: {url: base_url + 'autocomplete/search/target_market'}
		}}});
		
		$('input.autocomplete-target-customer').textboxlist({unique: true, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: true,
			remote: {url: base_url + 'autocomplete/search/target_customer'}
		}}});
		
		
		$('input.autocomplete-materials').textboxlist({unique: true, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: false,
			remote: {url: base_url + 'autocomplete/search/materials'}
		}}});
		
		$('.date').datetimepicker({
			timepicker: false,
			format: 'd/m/Y'
		});
		
		$('input.time').timeEntry({spinnerImage: 'images/spinnerDefault.png'});
		$('input.date').dateEntry({dateFormat: 'dmy/',spinnerImage: 'images/spinnerDefault.png'});

	
	},
	formSubmitted: function(status,response){
		
		if (status == 1){
			$('div.overlay').fadeOut(function(){
				$(this).remove();
				_response = response;
				eval(_callback);
			})
		}
		
		if (status == 0){
			alert(response);
			$('div.overlay').fadeOut(function(){
				$(this).remove();
			});
			
		}
	},
	showLoading: function(){
		$('body').append('<div class="overlay" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3);"></div>');
	},
	hideLoading: function(){
		$('div.overlay').fadeOut(function(){
			$(this).remove();
		});
	}
}




function getNotifications(){
	$.ajax({
		url: 'ajax/get_notifications',
		success: function(res){
			$('ul.notifications').html(res)
			if (res){
				// $('ul.notifications').append('<p style="margin-left: 10px; min-width: 200px"><small><a href="#" class="notification-mark-as-read">Mark all as read</a></small></p>');
			} else {
				$('ul.notifications').append('<p style="margin-left: 10px; min-width: 200px">No notifications</p>')
			}
			var count = $('ul.notifications li.unseen').length
			$('.ncount').text(count);
			
			$('.notification-mark-as-read').click(function(e){
				e.preventDefault();
				$.ajax({
					url: 'ajax/mark_all_as_read'
				});
			})
			
			if (!count){
				$('.ncount').hide();
			} else {
				$('.ncount').show();
			}
		}
	})
}


