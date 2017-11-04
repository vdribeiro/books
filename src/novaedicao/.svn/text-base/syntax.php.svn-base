<?php
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
include 'novaedicao.php';
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_novaedicao extends DokuWiki_Syntax_Plugin {
 
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
	
	 $this->Lexer->addSpecialPattern("<novaedicao>.+?</novaedicao>",$mode,'plugin_novaedicao');
	 $this->Lexer->addSpecialPattern("<novaedicao>+?</novaedicao>",$mode,'plugin_novaedicao');
	}
	 
    /**
     * Handle the match
     */
			function handle($match, $state, $pos, &$handler){
			
				global $ID;	
				$content = rawWiki($ID);
				$ret = strstr($content, "<livro>");
				if($ret === FALSE) {echo"<script> alert('A pagina nao e um livro!')</script>"; return;}//TODO por js
//TODO por js		
				
				$vazio = false;				
				
				if(strlen($match) == 25) {
					$my_t=getdate(date("U"));	
					$matches[0] = $my_t[mday].$my_t[mon].$my_t[year].$my_t[hours].$my_t[minutes].$my_t[seconds]; 
					$vazio = true;
				}
				else $matches = explode("?", substr($match, 12, -13));							
							
				$matches[1] = tpl_pagetitle(null, true); 
				$matches[2] = saveOldRevision($ID);
				$matches[3] = $ID;
				$matches[4] = $vazio;
				
				return $matches;
			}
			 
	 
	    function render($mode, &$renderer, $data) {
			
			$renderer->doc .= createEdition($data);	
			$retornou = getRevisionInfo($data[3], $data[2], 0);
			$retornou = dformat($retornou['date']);
			$content = rawWiki($data[3]);
			$content = newEditionToEdition($data, $content, $retornou);
			$renderer->doc .= saveWikiText($data[1],$content,"selection created"); 
            return true;
        
    }
 

}