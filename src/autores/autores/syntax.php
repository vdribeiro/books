<?php
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
include 'autores.php';
 

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_autores extends DokuWiki_Syntax_Plugin {
 
    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Grupo1',
            'date'   => '22/11/2010',
            'name'   => 'NovaEdicao Plugin',
            'desc'   => 'Cria uma nova edicao do livro',
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
	 $this->Lexer->addSpecialPattern("<autores>",$mode,'plugin_autores');
	}
	 
    /**
     * Handle the match
     */
			function handle($match, $state, $pos, &$handler){
			
				global $ID;	
				$content = rawWiki($ID);
				$author = p_get_metadata($ID, 'contributor' );
				$matches[0] = $author;
				$i = 0;
				
				do
				{
					getLinkName($content);
					$new = explode('|', $ret);
					$i++;
					$aauthor = p_get_metadata($new[0], 'contributor' );
					$matches[$i] = $aauthor;
					$content = str_replace('[['.$ret.']]', "", $content);
				}while(gettype($aauthor) !== 'NULL');	
				
				
				
				return $matches;
			}
		
	    function render($mode, &$renderer, $data) {
		if($mode == 'xhtml'){ //->para integrar com os outros grupos
			//verifica se a pagina actual é livro
			if(isABook())
				{
					$renderer->doc .= authors($data);
					return true;
				}
			}
     

return false;
 }
 
}
 
//Setup VIM: ex: et ts=4 enc=utf-8 :
?>