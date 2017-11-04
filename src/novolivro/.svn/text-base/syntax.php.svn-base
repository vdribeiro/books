<?php
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
include 'novolivro.php';
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_novolivro extends DokuWiki_Syntax_Plugin {
 
    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Grupo1',
            'date'   => '13/11/2010',
            'name'   => 'NovoLivro Plugin',
            'desc'   => 'Cria um novo Livro',
        );
    }
 
	function curPageURL() {
		
		return $pageURL;
	}
 
 
    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }
 
    /**
     * Where to sort in?
     */
    function getSort(){
        return 106;
    }
 
    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
	
	 $this->Lexer->addSpecialPattern("<novolivro>.+?</novolivro>",$mode,'plugin_novolivro');
    }
	 
    /**
     * Handle the match
     */
			function handle($match, $state, $pos, &$handler){
				
				global $ID;
				$matches = explode("?", substr($match, 11, -12));					
				$matches[1] = $ID;				
				resolve_pageid(getNS($ID), $matches[0], $exists);
				
				return $matches;
			}

 
    /**
     * Create output
     */
			function render($mode, &$renderer, $data) {
			
				
				$content = rawWiki($data[1]);
				
				$renderer->doc .= createBook($data[0]);
				
				$content = newBookToBook($content, $data[0]);				
				
				$renderer->doc .= saveWikiText($data[1],$content,"selection created"); 
				$renderer->doc .= saveWikiText($data[0],"<livro>","selection created"); 
				
				return true;

			}
 			
}