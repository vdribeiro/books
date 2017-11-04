<?php
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
include 'livro.php';
 

//é livro se tiver a lag livro
function isABookbyID($id){
	$content = rawWiki($id);
	$ret = strstr($content, '<livro>');
	if($ret !== FALSE)
		return true;
	else
		return false;
}


function isABook(){
	global $ID;
	return isABookbyID($ID);
}


function isARevision()
{
	global $REV;
	return $REV != null;

}

//se a pagina for uma edicao
//ou seja se for um livro e uma revisao antiga
function isAnEdition(){
	return (IsABook() && isARevision());
}
 
function rawPage($id,$rev=''){
         if(auth_quickaclcheck($id) < AUTH_READ){
              return new IXR_Error(1, 'You are not allowed to read this page');
         }
         $text = rawWiki($id,$rev);
         if(!$text) {
            return pageTemplate($id);
         } else {
             return $text;
         }
}

function strstrb($h,$n){
		return array_shift(explode($n,$h,2));
}
	

//vai receber uma string(conteudo do render, renderer)
//um nome de um link, e uma data
//vai um retornar uma string com o link alterado para a rev
//imediatamente anterior à data recebida
function linkRevReplace($rend,$link,$date)
{
		//vai buscar um array associativo das revisions do livro
		//ou seja das edicoes
		$revisoes = getRevisions($link, 0,0);
		
		//percorre o array
		$count = count($revisoes);
		msg($count);
		//se o link for fail
		if($count == 0 && rawWiki($link) == "") 
		{
			$search = "doku.php?id=".$link."\" class=\"wikilink1";
			$replace = "doku.php?id=".$link."&rev=-1\" class=\"wikilink2";
			return str_replace($search,$replace,$rend);
		}
		
		if($count == 0 && rawWiki($link) != "")
		{
			$page_meta = p_get_metadata($link, 'date');
			if(isDateNewer(dformat($page_meta['created']), $date))
			{
				$search = "doku.php?id=".$link."\" class=\"wikilink1";
				$replace = "doku.php?id=".$link."&rev=-1\" class=\"wikilink2";
			}
			else
			{
				$search = "doku.php?id=".$link."\" class=\"wikilink1";
				$replace = "doku.php?id=".$link."\" class=\"wikilink1";
			}
			return str_replace($search,$replace,$rend);
		}
		
		
		$meta = getRevisionInfo($link, $revisoes[0], 0);
		$max = dformat($meta['date']);
		$maxrev = $revisoes[0];
		for ($i = 0; $i < $count; $i++) {
			$meta = getRevisionInfo($link, $revisoes[$i], 0);
			//se o tempo de cada edicao for igual a data1 ( data introduzida pelo user),
			//adiciona ao render um link para a revisao correspondente
			if(isDateNewer($date,dformat($meta['date']))){				//funcao de comparar datas
				if(isDateNewer(dformat($meta['date']),$max))
				{
					$maxrev = $revisoes[$i];
					$max = dformat($meta['date']);
				}
			}
		}
		msg($link);
		
		if(isDateNewer($max, $date))
		{
			$search = "doku.php?id=".$link."\" class=\"wikilink1";
			$replace = "doku.php?id=".$link."&rev=-1\" class=\"wikilink2";
			return str_replace($search,$replace,$rend);
		}
		
		$search = "doku.php?id=".$link."\" class=\"wikilink1";
		$filter_search = "doku.php?id=".$link;
		$replace = $filter_search."&rev=".$maxrev."\" class=\"wikilink1";
		$ret = str_replace($search,$replace,$rend);
		return $ret;
		
}

 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_livro extends DokuWiki_Syntax_Plugin {
 
    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Grupo1',
            'date'   => '25/11/2010',
            'name'   => 'Livro Plugin',
            'desc'   => 'livro',
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
	 $this->Lexer->addSpecialPattern("</livro>",$mode,'plugin_livro');
    }
	 
    /**
     * Handle the match
     */
			function handle($match, $state, $pos, &$handler){		

		
				return $match;
			}
			 
	 
	    function render($mode, &$renderer, $data) {
		
			global $ID, $REV;
			
				if(isAnEdition())
				{
					$metaD = getRevisionInfo(tpl_pagetitle(null, true), $REV, 0);
					$content = rawPage($ID,$REV);
					
					do{
						$devolve = getLinkNames($content);
						$content = $devolve[1];
						$link = $devolve[0];
						if($link != "")
						{
							//vai receber uma string(conteudo do render, renderer)
							//um nome de um link, e uma data
							//vai um retornar uma string com o link alterado para a rev
							//imediatamente anterior à data recebida
							$ret = linkRevReplace($renderer->doc,$link,dformat($metaD['date']));
							$renderer->doc = $ret;
						}
					}while($link != "");
					
						
				}
				return true;			
		
	}
 

}