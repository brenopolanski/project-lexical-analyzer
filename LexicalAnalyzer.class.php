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
	
	/**
	* @method __construct($javaCode)
	* @param $javaCode - String with Java code.
	*/
	public function __construct($javaCode) {
		$this->javaCode = $javaCode;
	}

	public function getJavaCode() {
		return $this->javaCode;
	}
}

?>