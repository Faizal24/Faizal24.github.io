var jsql = {
	_result: [],
	query: function(q, data, callback){
		$.ajax({
			url: 'ajax/query',
			type: 'post',
			data: 'query='+ encodeURIComponent(q),
			success: function(res){
				jsql._jsonstring_result = res;
				jsql._result = JSON.parse(res);
				
				if (jsql.verbose_mode == 1){
					$('.jsql-console').html(res.replace("\n",'<br />'));
				}
				
				try {
					callback(jsql._result, data);
				} catch (e){
					// do nothing
				}
			},
			error: function(){
				console.log('Query error: ' + q);
			}
		})
	},
	result: function (){
		return jsql._result;
	},
	row: function(){
		return jsql._result[0];
	},
	verbose: function(){
		var json = JSON.stringify(jsql._result);
		json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
		return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
	        var cls = 'number';
	        if (/^"/.test(match)) {
	            if (/:$/.test(match)) {
	                cls = 'key';
	            } else {
	                cls = 'string';
	            }
	        } else if (/true|false/.test(match)) {
	            cls = 'boolean';
	        } else if (/null/.test(match)) {
	            cls = 'null';
	        }
	        return '<span class="' + cls + '">' + match + '</span>';
	    });

	}
}