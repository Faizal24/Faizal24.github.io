var bindlist = {};
var _callback = '';
var _response;

var base = {
	_nav_path: [],
	init: function(){
		
		// navigation events
		
		that = this;
		
		
		$('#main').css('overflow','auto');
		

		// this.hideSidebar();
		
		
		that = this;
		
		this.bind();
		
		var urls = location.href;
	
		urls = urls.split('#');
		var base_url = urls[0];
		var target = urls[1];
		try {		
			var d = target.split('?');
			var data = d[1];
		} catch (e){
			
		}
		

		if (target) this.go(target);
		else {
			if (mredir){
				this.go(mredir);
			} else {
				this.loadDashboard();
			}
		}
		
				
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
		var d = url.split('?');
		if (d[1]) method = 'get';
		
		if (method == 'get' || !method){
			location.href = base_url + '#' + url;
		}
		
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
		
		this.go('main/dashboard');

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

		$('input.autocomplete-trainer').textboxlist({unique: true, max: 1, plugins: {autocomplete: {
			minLength: 1,
			queryRemote: true,
			onlyFromValues: false,
			remote: {url: base_url + 'autocomplete/search/trainer'}
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
				try {
					eval(_callback);
				} catch (e){
					
				}
			})
		}
		
		if (status == 0){
			$('div.overlay').fadeOut(function(){
				$(this).remove();
			});
			
			if (response){
				alert(response);
			}
			
		}
	},
	showLoading: function(){
		$('body').append('<div class="overlay" style="position: fixed; z-index: 500; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3);"></div>');
	},
	hideLoading: function(){
		$('div.overlay').fadeOut(function(){
			$(this).remove();
		});
	},
	confirmAlert: function(message, yes, no){
		base.showLoading();
		
		var top = ($(window).height() / 2) - 100;
		var left = ($(window).width() / 2) - 200;
		
		$('body').append('<div style="width: 400px; z-index: 1000; position: absolute; top: '+top+'px; left: '+left+'px; padding: 15px; background: #fff; box-shadow: 0 5px 5px rbga(0,0,0,0.5); border-radius: 5px;" class="confirm-dialog"><p>'+message+'</p><p style="padding: 10px 0; text-align: center"><a style="display: inline-block; width: 80px" class="btn btn-no">No</a> <a class="btn btn-yes">Yes</a></p></div>');
		$('.btn-yes').click(function(){
			if (yes){
				yes();
			}
			$('div.confirm-dialog').remove();
			base.hideLoading();				
		})
		
		$('.btn-no').click(function(){
			if (no){
				no();
			}
			$('div.confirm-dialog').remove();
			base.hideLoading();
		})
	},
	alert: function(message,ok){
		base.showLoading();
		
		var top = ($(window).height() / 2) - 100;
		var left = ($(window).width() / 2) - 200;
		
		$('body').append('<div style="width: 400px; z-index: 1000; position: absolute; top: '+top+'px; left: '+left+'px; padding: 15px; background: #fff; box-shadow: 0 5px 5px rbga(0,0,0,0.5); border-radius: 5px;" class="confirm-dialog"><p>'+message+'</p><p style="padding: 10px 0; text-align: center"><a style="display: inline-block; width: 80px" class="btn btn-ok">OK</a></p></div>');
		$('.btn-ok').click(function(){
			if (ok){
				ok();
			}
			$('div.confirm-dialog').remove();
			base.hideLoading();				
		})
		
	
	}
}

$(document).ready(function(){
	

	$(document).on('mouseup','.multi-select label', function(){
		$(this).toggleClass('checked');
	})
	
	
	$('body').append('<iframe style="display:none" id="postframe" src="'+base_url+'empty" name="postframe"></iframe>');
	
	$(document).on('click','.link',function(e){
		e.preventDefault();
		if ($(this).hasClass('delete-confirm')) return;
		if ($(this).hasClass('disabled')) return;
		base.go($(this).attr('href'))
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
	
	$(document).on('submit','form.submit',function(e){
		e.preventDefault();
		
		var ok = true;
		$(':input').each(function(){
			if ($(this).hasClass('mandatory')){
				if (!$(this).val()) ok = false;
			}
		});
		
		if (!ok){
			alert('Please make sure you have filled in the mandatory fields.');
			return false;
		}
		
		var data = $(this).serialize();
		
		var method	= $(this).attr('method');
		if (method == 'get'){
			var href = $(this).attr('action') + '?' + data;
		} else {
			var href = $(this).attr('action');
		}
		base.go(href,data,method);
	})
	
	$(document).on('click','a.delete-confirm',function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		if (confirm('Are you sure you want to delete?')){
			base.go(url);
		}
	})
	
	$(document).on('click','ul.tabs a',function(e){
		$(this).parents('ul.tabs').find('a').removeClass('tab-current');
		$(this).addClass('tab-current')
	})
	
	$(document).on('click','.click-submit',function(e){
		var that = this;
		setTimeout(function(){
			$(that).parents('form').submit();
		}, 10);
	})
	
	$(document).on('change','.change-submit',function(e){
		var that = this;
		setTimeout(function(){
			$(that).parents('form').submit();
		}, 10);
	})
		
	base.init();
	
	setInterval(function(){
		// getNotifications();
	}, 2000);
	
	// getNotifications();
})


function getNotifications(){
	$.ajax({
		url: 'ajax/get_notifications',
		success: function(res){
			$('ul.notifications').html(res)
			if (res){
				$('ul.notifications').append('<p style="margin-left: 10px; min-width: 200px"><small><a href="#" class="notification-mark-as-read">Mark all as read</a></small></p>');
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






function number_format (number, decimals, decPoint, thousandsSep) { // eslint-disable-line camelcase


  number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
  var n = !isFinite(+number) ? 0 : +number
  var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
  var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
  var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
  var s = ''

  var toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec)
    return '' + (Math.round(n * k) / k)
      .toFixed(prec)
  }

  // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || ''
    s[1] += new Array(prec - s[1].length + 1).join('0')
  }

  return s.join(dec)
}