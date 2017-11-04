<?php
require_once 'PHPUnit/Framework/TestCase.php';
 
include './autores.php';

class autoresTest extends PHPUnit_Framework_TestCase {
	
	public function testGetLinkName(){
		
		$content = "sssss[[autor1]]dddd[[autor2]]";
		$this->assertEquals("autor1", getLinkName($content));	
	
	} 
		
	public function testAuthors(){
		
		$data[0]['abdant'] = "abel dantas";
		$igualar = "<b>Autores: </b><br><i>"."abel dantas"."</i><br>";		
		$this->assertEquals(authors($data), $igualar);
		
		$data[0]['abdant'] = "abel dantas";
		$data[1]['voliv'] = "vitor oliveira";
		$data[2]['abdant'] = "abel dantas";
		$igualar = "<b>Autores: </b><br><i>"."abel dantas"."</i><br><i>"."vitor oliveira"."</i><br>";		
		$this->assertEquals(authors($data), $igualar);
		
		//sem autores
		$igualar = "<b>Autores: </b><br>";		
		$this->assertEquals(authors(null), $igualar);
	
		
	}
	
	
}


?>
