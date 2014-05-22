<?php 

@require_once("LexicalAnalyzer.class.php");

// $javaCode = "public class HelloWorld { } ";

$javaCode = "public class HelloWorld { if ( 1 + 1 ) { return true } } ";

$lexicalAnalyzer = new LexicalAnalyzer($javaCode);

echo $lexicalAnalyzer->getScanner();

?>