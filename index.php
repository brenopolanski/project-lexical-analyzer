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
		<a href="javascript:void(0)" id="btn-run">Executar</a>
		<span id="msg"></span>
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
		    		// alert(data);
		    		$('#msg').text(data);
		    	});
		    },
			readOnly: true
		});
	</script>
</body>
</html>