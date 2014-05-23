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
    private $SYMBOL = ['(',')','&','<','+','*','!','-','{',
                       '}','.','=',';','[',']','"',','];

    private $javaCode;
    private $tokens = [];
    private $word;
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
	 * @param $value - .
	 */
	private function isNumber($value) {
		if (in_array($value, $this->NUMBER)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @method isLetter
	 * @param $value - .
	 */
	private function isLetter($value) {
		if (in_array(strtolower($value), $this->LOW_LETTER)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @method isReservedWord
	 * @param $value - .
	 */
	private function isReservedWord($value) {
		if (in_array($value, $this->RESERVED_WORD)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @method isSymbol
	 * @param $value - .
	 */
	private function isSymbol($value) {
		if (in_array($value, $this->SYMBOL)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @method isSpace
	 * @param $value - .
	 */
	private function isSpace($value) {
		if ($value === " ") {
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
	// 			$this->isSymbol($this->javaCode[$i]) ||
	// 			$this->isSpace($this->javaCode[$i])) {
	// 			$aux = true;
	// 		} 
	// 		else {
	// 			return "Lexical analyzer Java: DENIED <br> Symbol error => ".$this->javaCode[$i];
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
	private function clear(&$value) {
		$value = "";
		return $value;
	}

	// (1

	// && ++ -- ==
	private function comparePairsSymbols($pos) {
		$arr = ['&','+','-','='];
		$aux = $pos + 1;
		if ($this->javaCode[$aux] === " ") {
			$this->word .= $this->javaCode[$pos];
			array_push($this->tokens, array("SYMBOL" => $this->word));
			$this->clear($this->word);
			$this->passed = true;	
		}
		elseif ($this->isSymbol($this->javaCode[$aux])) {
			$this->word .= $this->javaCode[$pos];
			if (in_array($this->javaCode[$aux], $arr)) {
				$this->word .= $this->javaCode[$pos];
				array_push($this->tokens, array("SYMBOL" => $this->word));
				$this->clear($this->word);
				$this->passed = true;
			}
		}
	}

	/**
	 * @method scanner
	 */

	// public class HelloWorld { if (1 + 22) { return true } } 

	// public class { if (1 + 22) { return true } } 

	private function scanner() {
		for ($i = 0; $i < strlen($this->javaCode); $i++) { 
			switch ($this->javaCode[$i]) {
				case $this->isLetter($this->javaCode[$i]):
					$this->word .= $this->javaCode[$i];
					break;

				case $this->isSpace($this->javaCode[$i]):
					if ($this->isReservedWord($this->word)) {
						array_push($this->tokens, array("RESERVED_WORD" => $this->word));
						$this->clear($this->word);
						$this->passed = true;
					}
					// else {
					// 	array_push($this->tokens, array("ID" => $this->word));
					// 	$this->clear($this->word);
					// 	$this->passed = true;
					// }
					break;

				case $this->isSymbol($this->javaCode[$i]):
					$this->comparePairsSymbols($i);
					break;
				
				// default:
				// 	return "Lexical analyzer Java: DENIED <br> Symbol error => ".$this->javaCode[$i];
				// 	break;
			}







			// if ($this->isNumber($this->javaCode[$i]) || 
			// 	$this->isLetter($this->javaCode[$i]) || 
			// 	$this->isSymbol($this->javaCode[$i])) {
			// 	$this->word .= $this->javaCode[$i];
			// } 
			// elseif ($this->isSpace($this->javaCode[$i])) {
			// 	if ($this->isReservedWord($this->word)) {
			// 		array_push($this->tokens, array("RESERVED_WORD" => $this->word));
			// 		$this->clear($this->word);
			// 		$this->passed = true;
			// 	}
			// 	elseif ($this->isNumber($this->word)) {
			// 		array_push($this->tokens, array("NUM" => $this->word));
			// 		$this->clear($this->word);
			// 		$this->passed = true;	
			// 	}
			// 	elseif ($this->isSymbol($this->word)) {
			// 		array_push($this->tokens, array("SYMBOL" => $this->word));
			// 		$this->clear($this->word);
			// 		$this->passed = true;	
			// 	}
			// 	else {
			// 		array_push($this->tokens, array("ID" => $this->word));
			// 		$this->clear($this->word);
			// 		$this->passed = true;
			// 	}
			// } 
			// else {
			// 	return "Lexical analyzer Java: DENIED <br> Symbol error => ".$this->javaCode[$i];
			// }
		}

		print_r($this->tokens);
		// echo $this->word;

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