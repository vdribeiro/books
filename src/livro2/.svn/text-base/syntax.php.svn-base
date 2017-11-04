<?php
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
include 'livro2.php';

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_livro2 extends DokuWiki_Syntax_Plugin {
 
    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Grupo1',
            'date'   => '25/11/2010',
            'name'   => 'Livro Plugin',
            'desc'   => 'livro2',
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
	 $this->Lexer->addSpecialPattern("<livro>",$mode,'plugin_livro2');
    }
	 
    /**
     * Handle the match
     */
			function handle($match, $state, $pos, &$handler){				
			
				return $match;
			}
			 
	 
	    function render($mode, &$renderer, $data) {
		
			global $ID, $REV;
			if($mode == 'xhtml'){ //->para integrar com os outros grupos
				if(isAnEdition())
				{
					dbg("Edicao do Livro \"".bookFormat(tpl_pagetitle(null, true))."\"");
				}
			   else if(isABook())
			   {
					dbg("Livro \"".bookFormat(tpl_pagetitle(null, true))."\"");
					$content = rawWiki($ID);
					$content = endTag($content);
					$renderer->doc .= saveWikiText(tpl_pagetitle(null, true),$content,"selection created");	//axo k isto nao faz nada

			   }
				
		return true;
    }
	return false;
	}
 

}