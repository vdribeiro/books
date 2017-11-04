<?php
require_once 'PHPUnit/Framework/TestCase.php';
 
include './novolivro.php';

class novolivroTest extends PHPUnit_Framework_TestCase {
	
	
	public function testCreateBook(){
		
		$name = "Livro1";
		$igualar = '<div class="new"><a href=\'doku.php?id='."Livro1".'\' >'."Livro1".'</a></div>';
		
		$this-> assertEquals(createBook($name), $igualar);		
		
		//erro
		$name = "";
		$this-> assertFalse(createBook($name));	
		
	}
	
	public function testNewBookToBook(){
		
		$name = "ABC";
		$content = "jdjs<novolivro>ABC</novolivro>sifisufisfuuisf";
		$this->assertEquals(newBookToBook($content, $name), "jdjs[[ABC]]sifisufisfuuisf");
		
		//tag errada
		$content = 	"jdjs<novolivro>ABCsifisufisfuuisf";
		$this->assertEquals(newBookToBook($content, $name), "jdjs<novolivro>ABCsifisufisfuuisf");
	}
		
}