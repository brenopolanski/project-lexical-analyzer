<?php

/**
 * @author       Breno Polanski <breno.polanski@gmail.com>
 * @copyright    2014 Breno Polanski, All Rights Reserved.
 * @license      {@link http://brenopolanski.mit-license.org}
 */

/**
 * The lexical analyzer Java grammar.
 * @class LexicalAnalyzer
 */
class LexicalAnalyzer {

	// 
	private $NUMBER = ['0','1','2','3','4','5','6','7','8','9'];

	// 
	private $LOW_LETTER = ['a','b','c','d','e','f','g','h','i',
	                       'j','k','l','m','n','o','p','q','r',
	                       's','t','u','v','w','x','y','z'];

    private $RESERVED_WORD = ["while","if","else","public","private",
    						  "class","new","length","System",
    						  "out","println","return","int",
    						  "boolean","String","static","double",
    						  "void","main","true","false","extends"];

    //
    private $OPERATOR = ['(',')','&','<','>','+','*','!','-',
                       '{','}','.','=',';','[',']','"',','];

    private $javaCode;
    private $tokensTable = [];
    private $token;
    private $passed = false;
	
	/**
	 * @method __construct()
	 * @param $javaCode - String with Java code.
	 */
	public function __construct($javaCode) {
		$this->javaCode = $javaCode;
	}

	/**
	 * @method isNumber
	 * @param $token - .
	 */
	private function isNumber($token) {
		if (in_array($token, $this->NUMBER)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @method isLetter
	 * @param $token - .
	 */
	private function isLetter($token) {
		if (in_array(strtolower($token), $this->LOW_LETTER)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @method isReservedtoken
	 * @param $token - .
	 */
	private function isReservedtoken($token) {
		if (in_array($token, $this->RESERVED_WORD)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @method isOperator
	 * @param $token - .
	 */
	private function isOperator($token) {
		if (in_array($token, $this->OPERATOR)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @method isSpace
	 * @param $token - .
	 */
	private function isSpace($token) {
		if ($token === " ") {
			return true;
		} 
		else {
			return false;
		}
	}

	/**
	 * @method parser
	 */
	// private function parser() {
	// 	$aux = false;

	// 	for ($i = 0; $i < strlen($this->javaCode); $i++) { 
	// 		if ($this->isNumber($this->javaCode[$i]) || 
	// 			$this->isLetter($this->javaCode[$i]) || 
	// 			$this->isOperator($this->javaCode[$i]) ||
	// 			$this->isSpace($this->javaCode[$i])) {
	// 			$aux = true;
	// 		} 
	// 		else {
	// 			return "Lexical analyzer Java: DENIED <br> Operator error => ".$this->javaCode[$i];
	// 		}
	// 	}

	// 	if ($aux) {
	// 		return "Lexical analyzer Java: PASSED";
	// 	}
	// }

	// public class HelloWorld { }

	/**
	 * @method clear
	 */
	private function clear(&$token) {
		$token = "";
		return $token;
	}

	// (1

	/* ------------------
	 * | Pair operators |
	 * |----------------|
	 * |	   &&       |
	 * |----------------|
	 * |	   ||       |
	 * |----------------|
	 * |	   ==       |
	 * |----------------|
	 * |	   !=       |
	 * |----------------|
	 * |	   <=       |
	 * |----------------|
	 * |	   >=       |
	 * |----------------|
	 * |	   ++       |
	 * |----------------|
	 * |	   --       |
	 * |----------------|
	 * |	   +=       |
	 * |----------------|
	 * |	   -=       |
	 * |----------------|
	 * |	   *=       |
	 * |----------------|
	 */
	// public class { if (1 +! 22) { return true } }
	private function comparePairsOperators($pos) {
		$arr = ['&','|','=','!','<','>','+','-','*'];
		$aux = $pos + 1;
		$this->token .= $this->javaCode[$pos];
		if (in_array($this->javaCode[$aux], $arr)) {
			$this->token .= $this->javaCode[$aux];
			array_push($this->tokensTable, array("OPERATOR" => $this->token));
			$this->clear($this->token);
			$this->passed = true;
		}
		else {
			array_push($this->tokensTable, array("OPERATOR" => $this->token));
			$this->clear($this->token);
			$this->passed = true;
		}



		// $aux = $pos + 1;
		// if ($this->javaCode[$aux] === " ") {
		// 	$this->token .= $this->javaCode[$pos];
		// 	array_push($this->tokensTable, array("OPERATOR" => $this->token));
		// 	$this->clear($this->token);
		// 	$this->passed = true;	
		// }
		// elseif ($this->isOperator($this->javaCode[$aux])) {
		// 	$this->token .= $this->javaCode[$pos];
		// 	if (in_array($this->javaCode[$aux], $arr)) {
		// 		$this->token .= $this->javaCode[$pos];
		// 		array_push($this->tokensTable, array("OPERATOR" => $this->token));
		// 		$this->clear($this->token);
		// 		$this->passed = true;
		// 	}
		// }
	}

	/**
	 * @method scanner
	 */

	// public class HelloWorld { if (1 + 22) { return true } } 

	// public class { if (1 +! 22) { return true } } 

	private function scanner() {
		for ($i = 0; $i < strlen($this->javaCode); $i++) { 
			switch ($this->javaCode[$i]) {
				case $this->isLetter($this->javaCode[$i]):
					$this->token .= $this->javaCode[$i];
					break;

				case $this->isSpace($this->javaCode[$i]):
					if ($this->isReservedtoken($this->token)) {
						array_push($this->tokensTable, array("RESERVED_WORD" => $this->token));
						$this->clear($this->token);
						$this->passed = true;
					}
					// else {
					// 	array_push($this->tokensTable, array("ID" => $this->token));
					// 	$this->clear($this->token);
					// 	$this->passed = true;
					// }
					break;

				case $this->isOperator($this->javaCode[$i]):
					// echo $this->javaCode[$i]."<br>"; 
					$this->comparePairsOperators($i);
					break;
				
				// default:
				// 	return "Lexical analyzer Java: DENIED <br> Operator error => ".$this->javaCode[$i];
				// 	break;
			}







			// if ($this->isNumber($this->javaCode[$i]) || 
			// 	$this->isLetter($this->javaCode[$i]) || 
			// 	$this->isOperator($this->javaCode[$i])) {
			// 	$this->token .= $this->javaCode[$i];
			// } 
			// elseif ($this->isSpace($this->javaCode[$i])) {
			// 	if ($this->isReservedtoken($this->token)) {
			// 		array_push($this->tokensTable, array("RESERVED_WORD" => $this->token));
			// 		$this->clear($this->token);
			// 		$this->passed = true;
			// 	}
			// 	elseif ($this->isNumber($this->token)) {
			// 		array_push($this->tokensTable, array("NUM" => $this->token));
			// 		$this->clear($this->token);
			// 		$this->passed = true;	
			// 	}
			// 	elseif ($this->isOperator($this->token)) {
			// 		array_push($this->tokensTable, array("OPERATOR" => $this->token));
			// 		$this->clear($this->token);
			// 		$this->passed = true;	
			// 	}
			// 	else {
			// 		array_push($this->tokensTable, array("ID" => $this->token));
			// 		$this->clear($this->token);
			// 		$this->passed = true;
			// 	}
			// } 
			// else {
			// 	return "Lexical analyzer Java: DENIED <br> Operator error => ".$this->javaCode[$i];
			// }
		}

		print_r($this->tokensTable);
		// echo $this->token;

		if ($this->passed) {
			return "Lexical analyzer Java: PASSED";
		}
	}

	/**
	 * @method getScanner
	 */
	public function getScanner() {
		return $this->scanner();
	}
}

?>