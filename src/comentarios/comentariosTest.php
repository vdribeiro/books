<?php
require_once 'PHPUnit/Framework/TestCase.php';
 
include './comentarios.php';

class comentariosTest extends PHPUnit_Framework_TestCase {
	
	public function testJoinComments(){
		
		$primeiro['abeldantas'] = 2;
		$primeiro['vitor'] = 1;
		$segundo['abeldantas'] = 3;
		$segundo['manuel'] = 2;
		
		$devolve['abeldantas'] = 5;
		$devolve['vitor'] = 1;
		$devolve['manuel'] = 2;
		
		$this-> assertEquals(joinComments($primeiro, $segundo), $devolve);

		$devolve['abeldantas'] = 1;
		$this-> assertNotEquals(joinComments($primeiro, $segundo), $devolve);
	}
	
	public function testDisplayComments(){
		
		$comentario['abeldantas'] = 2;
		$comentario['vitor'] = 8;
		$igualar = "abeldantas: 20%<br>vitor: 80%<br>";
		
		$this-> assertEquals(displayComments($comentario), $igualar);
	}
 
		
}