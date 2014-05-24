<?php 

@require_once("LexicalAnalyzer.class.php");

// $javaCode = "public class HelloWorld { } ";

// $javaCode = "public class HelloWorld { if (1 + 22) { return true } } ";

// $javaCode = "public class { if (1 +! 22) { return true } } ";

$javaCode = "public class { if (1 == 22) { return true } } ";

$lexicalAnalyzer = new LexicalAnalyzer($javaCode);

echo $lexicalAnalyzer->getScanner();

?>