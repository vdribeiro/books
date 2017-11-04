<?php
require_once 'PHPUnit/Framework/TestCase.php';
 
include './novaedicao.php';

class novaedicaoTest extends PHPUnit_Framework_TestCase {
	
	
	public function testCreateEdition(){
		
		$data[1] = "Livro1";
		$data[2] = "123456222";
		$data[0] = "Edicao1";
		$igualar = '<div class="new"><a href=\'doku.php?id='."Livro1"."&rev="."123456222".'\' >'."Edicao1".'</a></div>';
		
		$this-> assertEquals(createEdition($data), $igualar);		
		
		//erro
		$data2 = null;
		$this-> assertFalse(createEdition($data2));	
		
	}
	
	public function testNewEditionToEdition(){
		
		//com nome de edicao
		$data[4] = false;
		$data[0] = "edicao1";
		$content = "sdsdsdsdsd<novaedicao>edicao1</novaedicao>sddsdd";
		$retornou = "10/2/2010";
		
		$this->assertEquals(newEditionToEdition($data, $content, $retornou), "sdsdsdsdsd<edicao>edicao1|10/2/2010</edicao>sddsdd");
		
		//sem nome de edicao
		$data[4] = true;
		$data[0] = "vaiColocarDataSistema";
		$content = "sdsdsdsdsd<novaedicao></novaedicao>sddsdd";
		$retornou = "10/2/2010";
		$this->assertEquals(newEditionToEdition($data, $content, $retornou), "sdsdsdsdsd<edicao>vaiColocarDataSistema|10/2/2010</edicao>sddsdd");
	
		//caso erro
		$content = "sdsdsdsdsd<novaedicao>sddsdd";
		$this->assertEquals(newEditionToEdition($data, $content, $retornou), "sdsdsdsdsd<novaedicao>sddsdd");
	
	
	}
		
}