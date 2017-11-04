<?php
require_once 'PHPUnit/Framework/TestCase.php';
 
include './livro2.php';

class livro2Test extends PHPUnit_Framework_TestCase {
	
	
	public function testEndTag(){
		
		$content = "<livro> jdshjdssjdjhd</livro>aaaa";
		$igualar = "<livro> jdshjdssjdjhdaaaa</livro>";
		$this-> assertEquals(endTag($content), $igualar);		
		
		$content = "<livro> jdshjdssjdjhdaaaa";	
		$this-> assertEquals(endTag($content), $igualar);
	}	
		
}