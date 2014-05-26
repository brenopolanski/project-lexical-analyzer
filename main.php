<?php 

@require_once("LexicalAnalyzer.class.php");
@require_once("SyntacticAnalyzer.class.php");

// $javaCode = "public class HelloWorld { } ";

// $javaCode = "public class HelloWorld { if (1 + 22) { return true } } ";

// $javaCode = "public class { if (1 +! 22) { return true } } ";

// $javaCode = "public class HelloWorld { if (num1 == 123829382938) { return true } } ";

// $javaCode = 'public class HelloWorld { public static void main(String args[]) { System.out.println("Hello, World!!!"); } } ';

// $javaCode = 'public class HelloWorld ';

// $javaCode = 'public class HelloWorld {
// 	public static void main(String args[]) {
// 		System.out.println("Hello, World!!!");
// 	}
// }';

extract($_POST);

$javaCode = preg_replace("/\n/"," ",$javaCode)." ";

$lexicalAnalyzer = new LexicalAnalyzer($javaCode);
// $syntacticAnalyzer = new SyntacticAnalyzer($lexicalAnalyzer->getScanner());

// echo $javaCode;
echo $lexicalAnalyzer->getScanner();
// print_r($lexicalAnalyzer->getScanner());
// print_r($syntacticAnalyzer->getTokensTable());

?>