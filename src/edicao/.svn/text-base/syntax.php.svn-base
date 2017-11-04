<?php
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
include 'edicao.php';
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_edicao extends DokuWiki_Syntax_Plugin {
 
    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Grupo1',
            'date'   => '25/11/2010',
            'name'   => 'Edicao Plugin',
            'desc'   => 'Linka edicao do livro',
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
	 $this->Lexer->addSpecialPattern("<edicao>.+?</edicao>",$mode,'plugin_edicao');
    
	}
	 
    /**
     * Handle the match
     */
			function handle($match, $state, $pos, &$handler){
				
				$matches = explode("|", substr($match, 8, -9));				
											
				global $ID;					
				$matches[3] = $ID;
				$matches[4] = tpl_pagetitle(null, true); 
				return $matches;
			}
			 
	 
	    function render($mode, &$renderer, $data) {
        if($mode == 'xhtml'){ //<- para integrar com os outros grupos
			if(IsABook()){
				//vai buscar um array associativo das revisions do livro
				//ou seja das edicoes
				$revisoes = getRevisions($data[4], 0,0);
				
				//percorre o array
				$count = count($revisoes);
				for ($i = 0; $i < $count; $i++) {
					$meta = getRevisionInfo($data[3], $revisoes[$i], 0);
					//se o tempo de cada edicao for igual a data1 ( data introduzida pelo user),
					//adiciona ao render um link para a revisao correspondente
					if(dformat($meta['date']) == $data[1]){		
						
						$renderer->doc .= '<div class="new">';
						$renderer->doc .= '<a href=\'doku.php?id='.$data[4].'&rev='.$revisoes[$i].'\' >'.$data[0].'</a>';
						$renderer->doc .= '</div>';				
						//apenas faz isso para o primeiro que encontrar
						$i = $count;
					}
				}
					
					return true;
				
			}
				
				
        }
        return false;
    }
 

}