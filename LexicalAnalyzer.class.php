<?php

/**
* @author       Breno Polanski <breno.polanski@gmail.com>
* @copyright    2014 Breno Polanski, All Rights Reseverd.
* @license      {@link http://brenopolanski.mit-license.org}
*/

/**
* The lexical analyzer Java grammar.
* @class LexicalAnalyzer
*/
class LexicalAnalyzer {

	// 
	private $NUMBER = ['1','2','3','4','5','6','7','8','9','0'];

	// 
	private $LOW_LETTER = ['a','b','c','d','e','f','g','h','i',
	                       'j','k','l','m','n','o','p','q','r',
	                       's','t','u','v','w','x','y','z'];

    //
    private $SYMBOL = ['(',')','&','<','+','*','!','-','{',
                       '}','.','=',';','[',']','"',','];
	
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
		} else {
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
		} else {
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
		} else {
			return false;
		}
	}

	/**
	* @method isSpace
	* @param $value - .
	*/
	private function isSpace($value) {
		if ($value === ' ') {
			return true;
		} else {
			return false;
		}
	}

	/**
	* @method parser
	*/
	private function parser() {
		$aux = false;

		for ($i = 0; $i < strlen($this->javaCode); $i++) { 
			if ($this->isNumber($this->javaCode[$i]) || 
				$this->isLetter($this->javaCode[$i]) || 
				$this->isSymbol($this->javaCode[$i]) ||
				$this->isSpace($this->javaCode[$i])) {
				$aux = true;
			} 
			else {
				return "Lexical analyzer Java: DENIED <br> Symbol error => ".$this->javaCode[$i];
			}
		}

		if ($aux) {
			return "Lexical analyzer Java: PASSED";
		}
	}

	/**
	* @method getParser
	*/
	public function getParser() {
		return $this->parser();
	}
}

?>