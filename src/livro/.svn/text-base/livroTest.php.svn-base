<?php
require_once 'PHPUnit/Framework/TestCase.php';
 
include './livro.php';

class livroTest extends PHPUnit_Framework_TestCase {
	
	public function testBookFormat(){
		
		$name = "Isto_e_um_livro";
		$igualar = "Isto e um livro";
		$this-> assertEquals(bookFormat($name), $igualar);
		$name = "isto e um livro";
		$this-> assertEquals(bookFormat($name), $igualar);	
		$name = "";
		$this-> assertFalse(bookFormat($name));	
	}
	
	public function testIsDateNewer(){		
		
		//testa dia
		$data1 = "02/02/2010 10:00";
		$data2 = "03/02/2010 10:00";		
		$this-> assertFalse(isDateNewer($data1, $data2));
		$this-> assertTrue(isDateNewer($data2, $data1));
		
		//testa mes
		$data1 = "02/01/2010 10:00";
		$data2 = "02/02/2010 10:00";			
		$this-> assertFalse(isDateNewer($data1, $data2));
		$this-> assertTrue(isDateNewer($data2, $data1));
		
		//testa ano
		$data1 = "02/02/2010 10:00";
		$data2 = "02/02/2011 10:00";			
		$this-> assertFalse(isDateNewer($data1, $data2));
		$this-> assertTrue(isDateNewer($data2, $data1));	
			
		//testa hora
		$data1 = "02/02/2010 10:00";
		$data2 = "02/02/2010 11:00";			
		$this-> assertFalse(isDateNewer($data1, $data2));
		$this-> assertTrue(isDateNewer($data2, $data1));
				
		//testa minuto
		$data1 = "02/02/2010 10:00";
		$data2 = "02/02/2010 10:01";			
		$this-> assertFalse(isDateNewer($data1, $data2));
		$this-> assertTrue(isDateNewer($data2, $data1));		
			
	}	
		
	public function testGetLinkNames(){
		
		$content = "sdsdsd[[a]]djjdjhdjj[[b]]";
		$devolve = getLinkNames($content);
		$this-> assertEquals($devolve[1], "sdsdsddjjdjhdjj[[b]]");
		$this-> assertEquals($devolve[0], "a");
		
		$content = $devolve[1];
		$devolve = getLinkNames($content);
		$this-> assertEquals($devolve[1], "sdsdsddjjdjhdjj");
		$this-> assertEquals($devolve[0], "b");
		
		//sem links
		$content = $devolve[1];
		$devolve = getLinkNames($content);
		$this-> assertEquals($devolve[1], "sdsdsddjjdjhdjj");
		$this-> assertEquals($devolve[0], "");
	}
		
		
}