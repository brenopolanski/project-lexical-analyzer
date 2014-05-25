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

	// Constant of numbers
	private $NUMBER = ['0','1','2','3','4','5','6','7','8','9'];

	// Constant of letters
	private $LOW_LETTER = ['a','b','c','d','e','f','g','h','i',
	                       'j','k','l','m','n','o','p','q','r',
	                       's','t','u','v','w','x','y','z'];
    
    // Constant of reserved words
    private $RESERVED_WORD = ["while","if","else","public","private",
    						  "class","new","length","System",
    						  "out","println","return","int",
    						  "boolean","String","static","double",
    						  "void","main","true","false","extends"];

    // Constant of operators
    private $OPERATOR = ['(',')','&','<','>','+','*','!','-',
                       '{','}','.','=',';','[',']','"',','];

    private $javaCode;
    private $token;
    private $tokensTable = [];
    private $tokenInvalid;
    private $passed = false;
	
	/**
	 * @method __construct()
	 * @param $javaCode - String with Java code.
	 */
	public function __construct($javaCode) {
		$this->javaCode = $javaCode;
	}

	/**
	 * Checks whether the token is a number.
	 * @method isNumber
	 * @param {String} $token.
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
	 * Checks whether the token is a letter.
	 * @method isLetter
	 * @param {String} $token.
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
     * Checks whether the token is a reserved word.
	 * @method isReservedWord
	 * @param {String} $token.
	 */
	private function isReservedWord($token) {
		if (in_array($token, $this->RESERVED_WORD)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Checks whether the token is a operator.
	 * @method isOperator
	 * @param {String} $token.
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
	 * Checks whether the token is a space.
	 * @method isSpace
	 * @param {String} $token.
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
	 * Clear token.
	 * @method clear
	 * @param {String} $token.
	 */
	private function clear(&$token) {
		$token = "";
		return $token;
	}

	/**
	 * Compare pairs of operators.
	 * @method comparePairsOperators
	 * @param {String} $pos - Position of token.
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
	 * Checks whether word is a reserved word or id.
	 * @method checkWord
	 * @param {String} $pos - Position of token.
	 */
	private function checkWord(&$pos) {
		if ($this->isLetter($this->javaCode[$pos]) || $this->isNumber($this->javaCode[$pos])) {
			$this->token .= $this->javaCode[$pos];		

			if ($this->isReservedWord($this->token)) {
				if ($this->isSpace($this->javaCode[$pos+1]) || 
			    	$this->isOperator($this->javaCode[$pos+1])) {
						array_push($this->tokensTable, array("RESERVED_WORD" => $this->token));
						$this->clear($this->token);
						$this->passed = true;
				}
			}
			else {
				$pos += 1;
				$this->checkWord($pos);
			}
		} 
		elseif ($this->isSpace($this->javaCode[$pos]) || 
			    $this->isOperator($this->javaCode[$pos])) {
					array_push($this->tokensTable, array("ID" => $this->token));
					$this->clear($this->token);
					$pos -= 1;
					$this->passed = true;
		} 
		else {
			$this->tokenInvalid = $this->javaCode[$pos];
			$pos = strlen($this->javaCode);
			$this->passed = false;
		}
	}

	/**
	 * Merge numbers.
	 * @method mergeNumbers
	 * @param {String} $pos - Position of token.
	 */
	private function mergeNumbers(&$pos) {
		$this->token .= $this->javaCode[$pos];

		if ($this->isNumber($this->javaCode[$pos+1])) {
			$pos += 1;
			$this->mergeNumbers($pos);
		}
		else {
			array_push($this->tokensTable, array("NUM" => $this->token));
			$this->clear($this->token);
			$this->passed = true;	
		}
	}

	/**
	 * Scanner Java code and separates tokens (RESERVED_WORD, ID, NUM and OPERATOR).
	 * @method scanner
	 * @return {String} Lexical analyzer Java: PASSED or DENIED
	 */
	private function scanner() {
		for ($i = 0; $i < strlen($this->javaCode); $i++) { 
			if ($this->isLetter($this->javaCode[$i])) {
				$this->checkWord($i);
			}
			elseif ($this->isNumber($this->javaCode[$i])) {
				$this->mergeNumbers($i);
			}
			elseif ($this->isOperator($this->javaCode[$i])) {
				$this->comparePairsOperators($i);
			}
			else {
				if ($this->isSpace($this->javaCode[$i])) {
					$this->passed = true;	
				}
				else {
					return "Lexical analyzer Java: DENIED <br> Token error => ".$this->javaCode[$i];
				}
			}
		}

		// print_r($this->tokensTable);
		// echo $this->token;

		if ($this->passed) {
			// return "Lexical analyzer Java: PASSED";
			return $this->tokensTable;
		}
		else {
			return "Lexical analyzer Java: DENIED <br> Token error => ".$this->tokenInvalid;
		}
	}

	/**
	 * Return table with tokens (RESERVED_WORD, ID, NUM and OPERATOR).
	 * @method getScanner
	 * @return {Array} Table with tokens.
	 */
	public function getScanner() {
		return $this->scanner();
	}
}

?>