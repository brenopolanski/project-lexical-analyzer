<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Project Java Compiler</title>

	<!-- CSS -->
	<link rel="stylesheet" href="css/app.css">
</head>
<body>
	<div id="editor">public class HelloWorld {
	public static void main(String args[]) {
		System.out.println("Hello, World!!!");
	}
}</div>
	<div id="console">
		<span id="msg"></span>
		<button id="btn-run">Executar</button>
	</div>
	
	<!-- JavaScript -->
	<script src="http://code.jquery.com/jquery.min.js"></script>
	<script src="http://ace.c9.io/build/src-min-noconflict/ace.js"></script>
	<script src="js/app.js"></script>
	<script>
		var editor = ace.edit('editor');
		editor.setTheme('ace/theme/monokai');
		editor.getSession().setMode('ace/mode/java');
		editor.commands.addCommand({
		    name: 'Run Project',
		    bindKey: {win: 'Ctrl-Enter', mac: 'Command-Enter'},
		    exec: function(editor) {
		    	$.post('main.php', {
		    		javaCode: editor.getValue()
		    	}, function(data) {
		    		if (data.ok) {
		    			$('#msg').removeClass('msg-error');
		    			$('#msg').addClass('msg-ok');
		    			$('#msg').text(data.ok);
		    		} else {
		    			$('#msg').removeClass('msg-ok');
		    			$('#msg').addClass('msg-error');
		    			$('#msg').text(data.error);
		    		}
		    	}, 'json');
		    },
			readOnly: true
		});

		$('#btn-run').on('click', function() {
			$.post('main.php', {
	    		javaCode: editor.getValue()
	    	}, function(data) {
	    		if (data.ok) {
	    			$('#msg').removeClass('msg-error');
	    			$('#msg').addClass('msg-ok');
	    			$('#msg').text(data.ok);
	    		} else {
	    			$('#msg').removeClass('msg-ok');
	    			$('#msg').addClass('msg-error');
	    			$('#msg').text(data.error);
	    		}
	    	}, 'json');
		});
	</script>
</body>
</html>