<?php
require_once 'PHPUnit/Framework/TestCase.php';

include './syntax.php';

class livroTest extends PHPUnit_Framework_TestCase {
    public function testLivro() {
        $doc = '';
		$data = Array(
		0 => "livro1",
		1 => "ID"
		);
		$this->assertTrue(renderiza($doc, $data));

        // Assert that the size of the Array fixture is 0.
        $this->assertEquals($doc, '<div class="new"><a href=\'doku.php?id=livro1\'>livro1</a></div>');
    }
}