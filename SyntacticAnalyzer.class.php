<?php  

/**
 * @author       Breno Polanski <breno.polanski@gmail.com>
 * @copyright    2014 Breno Polanski, All Rights Reserved.
 * @license      {@link http://brenopolanski.mit-license.org}
 */

/**
 * The syntactic analyzer Java grammar.
 * @class SyntacticAnalyzer
 */
class SyntacticAnalyzer {

	private $ERROR_TABLE = [" OPS :(",
							", encontrado, quando deveria existir 'public'!",
	                        ", encontrado, quando deveria iniciar com 'public'!",
	                        ", encontrado, quando deveria existir 'class'!",
	                        ", encontrado, quando deveria existir um 'ID'!"];

	private $tokensTable = [];
	private $passed = false;
	private $typeError;
	
	/**
	 * @method __construct()
	 * @param tokensTable - .
	 */
	function __construct($tokensTable) {
		$this->tokensTable = $tokensTable;
	}

	private function getTypeError($token, $pos) {
		return $token . $this->ERROR_TABLE[$pos];
	}

	// [public][class][id][{]
	private function analysisOrderTokensA1(&$pos) {
		foreach ($this->tokensTable[$pos] as $key => $value) {
			if (strtolower($value) === "public") {
				if ($key === "RESERVED_WORD") {
					$pos += 1;
					$this->analysisOrderTokensA11($pos);
					// $this->passed = true;
				}
				else {
					$pos = sizeof($this->tokensTable);
					$this->typeError = $this->getTypeError($value, 1);
					$this->passed = false;
				}
			}
			else {
				$pos = sizeof($this->tokensTable);
				$this->typeError = $this->getTypeError($value, 2);
				$this->passed = false;
			}
		}
	}

	private function analysisOrderTokensA11(&$pos) {
		foreach ($this->tokensTable[$pos] as $key => $value) {
			if (strtolower($value) === "class") {
				if ($key === "RESERVED_WORD") {
					$pos += 1;
					$this->analysisOrderTokensA12($pos);
					// $this->passed = true;
				}
				else {
					$pos = sizeof($this->tokensTable);
					$this->typeError = $this->getTypeError($value, 3);
					$this->passed = false;
				}
			}
			else {
				$pos = sizeof($this->tokensTable);
				$this->typeError = $this->getTypeError($value, 3);
				$this->passed = false;
			}
		}
	}

	private function analysisOrderTokensA12(&$pos) {
		foreach ($this->tokensTable[$pos] as $key => $value) {
			if ($key === "ID") {
				// $pos += 1;
				// $this->analysisOrderTokensA11($pos);
				$this->passed = true;
			}
			else {
				$pos = sizeof($this->tokensTable);
				$this->typeError = $this->getTypeError($value, 4);
				$this->passed = false;
			}
		}
	}

	private function parser() {
		for ($i = 0; $i < sizeof($this->tokensTable); $i++) {
			$this->analysisOrderTokensA1($i);
		}

		if ($this->passed) {
			return "Passed";
		}
		else {
			return $this->typeError;
		}
	}

	public function getTokensTable() {
		// return $this->tokensTable[0];
		// return $this->tokensTable[0]['RESERVED_WORD'];
		// return $this->tokensTable;
		return $this->parser();
	}
}

?>