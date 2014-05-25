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
	 * @method clear
	 * @param $token - .
	 */
	private function clear(&$token) {
		$token = "";
		return $token;
	}

	/**
	 * @method comparePairsOperators
	 * @param $pos - .
	 */
	private function comparePairsOperators(&$pos) {
		$arr = ["&&","||","==","!=","<=",">=",
		        "++","--","+=","-=","*="];
		$auxToken = $this->javaCode[$pos].$this->javaCode[$pos+1];
		$this->token = $this->javaCode[$pos];

		if ($this->isOperator($this->javaCode[$pos+1]) && (in_array($auxToken, $arr))) {
			$this->token = $auxToken;
			array_push($this->tokensTable, array("OPERATOR" => $this->token));
			$this->clear($this->token);
			$pos += 1;
			$this->passed = true;
		}
		else {
			array_push($this->tokensTable, array("OPERATOR" => $this->token));
			$this->clear($this->token);
			$this->passed = true;
		}
	}

	/**
	 * @method checkWord
	 * @param $pos - .
	 */
	private function checkWord(&$pos) {
		$this->token .= ($this->isLetter($this->javaCode[$pos]) || 
						 $this->isNumber($this->javaCode[$pos])) ? $this->javaCode[$pos] : "";

		if ($this->isReservedtoken($this->token)) {
			array_push($this->tokensTable, array("RESERVED_WORD" => $this->token));
			$this->clear($this->token);
			$this->passed = true;
		}
		elseif ($this->isSpace($this->javaCode[$pos]) || 
			    $this->isOperator($this->javaCode[$pos])) {
					array_push($this->tokensTable, array("ID" => $this->token));
					$this->clear($this->token);
					$pos -= 1;
					$this->passed = true;
		}
		else {
			$pos += 1;
			$this->checkWord($pos);
		}
	}

	/**
	 * @method mergeNumber
	 * @param $pos - .
	 */
	private function mergeNumber(&$pos) {
		$this->token .= $this->javaCode[$pos];

		if ($this->isNumber($this->javaCode[$pos+1])) {
			$pos += 1;
			$this->mergeNumber($pos);
		}
		else {
			array_push($this->tokensTable, array("NUM" => $this->token));
			$this->clear($this->token);
			$this->passed = true;	
		}
	}

	/**
	 * @method scanner
	 */
	private function scanner() {
		for ($i = 0; $i < strlen($this->javaCode); $i++) { 
			switch ($this->javaCode[$i]) {
				case $this->isLetter($this->javaCode[$i]):
					$this->checkWord($i);
					break;
				case $this->isNumber($this->javaCode[$i]):
					$this->mergeNumber($i);
					break;
				case $this->isOperator($this->javaCode[$i]):
					$this->comparePairsOperators($i);
					break;
				default:
					if ($this->isSpace($this->javaCode[$i])) {
						$this->passed = true;	
					}
					else {
						return "Lexical analyzer Java: DENIED <br> Operator error => ".$this->javaCode[$i];
					}
					break;
			}
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