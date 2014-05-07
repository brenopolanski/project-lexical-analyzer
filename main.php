<?php 

@require_once("LexicalAnalyzer.class.php");

$javaCode = "public class HelloWorld {}";

$lexicalAnalyzer = new LexicalAnalyzer($javaCode);

echo $lexicalAnalyzer->getJavaCode();

?>