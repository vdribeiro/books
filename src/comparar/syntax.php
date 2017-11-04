<?php
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
if(!defined('NL')) define('NL',"\n");

require_once(DOKU_PLUGIN.'syntax.php');
require_once(DOKU_INC.'inc/DifferenceEngine.php');
require_once(DOKU_INC.'inc/html.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_comparar extends DokuWiki_Syntax_Plugin {

	function diffedi($edi1,$edi2){
		$df  = new Diff(explode("\n",htmlspecialchars(rawWiki(tpl_pagetitle(null, true),$edi1))),
						explode("\n",htmlspecialchars(rawWiki(tpl_pagetitle(null, true),$edi2))));
					
		$tdf = new TableDiffFormatter();
		$renderer->doc.= '<table>';
		$renderer->doc.= '<tr><th colspan="2" width="50%">Diferencas</th>';
		$renderer->doc.= '<th colspan="2" width="50%">'.$lang['current'].'</th></tr>';
		$renderer->doc.= $tdf->format($df);
		$renderer->doc.= '</table>';
	}
	
	//se true a 1 è maior que a segunda
	//se false a 1 é menor ou igual à segunda
	function isDateNewer($primeira,$segunda)
	{
		$data1 = explode(' ', $primeira);
		$data2 = explode(' ', $segunda);
		//se o dia mes ano for igual
		if($data1[0] == $data2[0])
			{
				$horaMin1 = explode(':', $data1[1]);
				$horaMin2 = explode(':', $data2[1]);
				//se a hora for igual
				if($horaMin1[0] == $horaMin2[0])
				{
					return (int)$horaMin1[1] > (int)$horaMin2[1];
				}else
				{
					return (int)$horaMin1[0] > (int)$horaMin2[0];
				}
			}else{
			$anoMesDia1 = explode('/', $data1[0]);
			$anoMesDia2 = explode('/', $data2[0]);
			
			if($anoMesDia1[0] == $anoMesDia2[0])//se o ano for igual
			{
				if($anoMesDia1[1] == $anoMesDia2[1])//se o mes for igual
					return (int)$anoMesDia1[2] > (int)$anoMesDia2[2];
				else
					return (int)$anoMesDia1[1] > (int)$anoMesDia2[1];
			}else
				return (int)$anoMesDia1[0] > (int)$anoMesDia2[0];
			
			
			return false;}//se forem de dias diferentes
	}

	function strstrb($h,$n){
		return array_shift(explode($n,$h,2));
	}
 
    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Grupo1',
            'date'   => '2/12/2010',
            'name'   => 'Comparar Plugin',
            'desc'   => 'Compara edicoes',
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
	
	 $this->Lexer->addSpecialPattern("<comparar>.+?</comparar>",$mode,'plugin_comparar');
	 $this->Lexer->addSpecialPattern("<comparar></comparar>",$mode,'plugin_comparar');
    }

    /**
     * Handle the match
     */
	function handle($match, $state, $pos, &$handler){
		global $ID;
		global $INFO;
		global $conf;
		global $lang;
		$matches = explode("?", substr($match, 10, -11));	
		
		$matches[1] = $ID;
		$matches[2] = tpl_pagetitle(null, true);
		$matches[3] = $INFO;
		$matches[4] = $conf;
		$matches[5] = $lang;
		
		return $matches;
	}

 
    /**
     * Create output
     */
	function render($mode, &$renderer, $data) {
	
	if($mode == 'xhtml') { 
		$content = rawWiki($data[1]);
		//elimina a tag
		//$content = str_replace("<comparar>".$data[0]."</comparar>", "", $content);
		
		//content auxiliar
		$contentaux=$content;
		
		//escreve content
		$content = $content.DOKU_LF;
		$renderer->doc .= saveWikiText($data[1],$content,"modify"); 
		//msg($contentaux);
		//msg($renderer->doc);
		
		//teste de output de dados
		//$renderer->doc.=$data[0].'STOP'.$data[1].'STOP'.$data[2];
		//<comparar>?|?</comparar>
		
		//testes de coerencia
		if (strstr($contentaux,"<livro>") == FALSE) { //se nao for livro sai
			return false;
		} else if (strstr($contentaux,"<edicao>")==FALSE) { //se nao existir pelo menos uma edicao sai
			return false;
		} else if (strstr(substr(strstr($contentaux,"<edicao>"),8),"<edicao>")== FALSE) { //se nao existirem pelo menos duas edicoes sai
			return false;
		}else if (strstr($data[0], '|') == FALSE) { //testa tag
		
			//devolve todos os links de todas as edicoes
			/*$i=0;
			do {
				$caux=strstr($contentaux,"<edicao>");
				$contentaux=$caux;
				if ($caux<>FALSE) {
					$tempstr=strstrb($caux,"</edicao>");
					$links[$i]=substr(strstr($tempstr,"|"), 1);
					//rawWiki($links);
					$i=$i+1;
				}
			} while ($contentaux<>FALSE);*/
			
			//se nao existir pelo menos duas edicoes sai
			/*if ($i<2) {
				return false;
			}*/
			
			//obtem datas
			//$datas=2010/12/21 00:12;
			$tempexp = explode ("</edicao>", $contentaux);
			$contaexp = count($tempexp);
			$q=0;
			for ($t = 0; $t < $contaexp; $t++) {
				$tempexp2[$t] = strstr($tempexp[$t],"|");
				//msg($tempexp2[$t]);
				if ($tempexp2[$t]<>FALSE) {
					$datas[$q]=substr($tempexp2[$t],1);
					//msg($datas[$q]);
					$q++;
				}
			}
			
			//obtem id's das revisoes pelas datas
			$countd = count($datas);
			//busca todas as revisoes
			$revisoes = getRevisions($data[2], 0,0);
			$countr = count($revisoes);
			//percorre o array
			$l=0;
			for ($i = 0; $i < $countd; $i++) {
				for ($j = 0; $j < $countr; $j++) {
					$meta = getRevisionInfo($data[1], $revisoes[$j], 0);
					if(dformat($meta['date']) == $datas[$i]){						
						$revisions[$l]=$revisoes[$j];
						//msg($revisions[$l]);
						$l++;
						$j = $countr;
					}
				}
			}
			
			//chama comparacao
			$first = isset($_REQUEST['first']) ? intval($_REQUEST['first']) : 0;
			//msg($first);
			
			/**
			 * html_editions - Modified html_revisions core function
			 **/ 
			
			//filtrar revisions
			//$revisions[0]=1291654600;
			//$revisions[1]=1291831986;
			
			/*$revisions = getRevisions($data[1], $first, $data[4]['recent']+1);
			if(count($revisions)==0 && $first!=0){
				$first=0;
				$revisions = getRevisions($data[1], $first, $data[4]['recent']+1);;
			}*/
			
			/* we need to get one additionally log entry to be able to
			 * decide if this is the last page or is there another one.
			 * see html_recent()
			 */
			$hasNext = false;
			//se forem mais de 20 revisoes dividimos em paginas -> $data[4]['recent']=20
			if (count($revisions)>$data[4]['recent']) {
				$hasNext = true;
				array_pop($revisions); // remove extra log entry
			}

			$date = dformat($data[3]['lastmod']);

			//form com as edicoes
			//Nome
			//print 'EDICOES';
			print '<h1 class="sectionedit1"><a name="old_revisions" id="old_revisions">Edicoes</a></h1>';
			//Form a usar
			$form = new Doku_Form(array('id' => 'page__revisions'));
			//tags para ordenar como uma lista
			$form->addElement(form_makeOpenTag('ul'));
			
			//revisao actual - nao necessario, as edicoes a comparar sao sempre revisoes antigas
			//e ja e implementada a opcao de comparar com a revisao actual (simbolo dos oculos) - 
			//logo redundante a nao ser que se queira por na lista por questoes dde aparencia
			/*if($data[3]['exists'] && $first==0){
				if (isset($data[3]['meta']) && isset($data[3]['meta']['last_change']) && 
				$data[3]['meta']['last_change']['type']===DOKU_CHANGE_TYPE_MINOR_EDIT)
					$form->addElement(form_makeOpenTag('li', array('class' => 'minor')));
				else
					$form->addElement(form_makeOpenTag('li'));
					
				$form->addElement(form_makeOpenTag('div', array('class' => 'li')));
				$form->addElement(form_makeTag('input', array(
								'type' => 'checkbox',
								'name' => 'rev2[]',
								'value' => 'current')));

				$form->addElement(form_makeOpenTag('span', array('class' => 'date')));
				$form->addElement($date);
				$form->addElement(form_makeCloseTag('span'));

				$form->addElement(form_makeTag('img', array(
								'src' =>  DOKU_BASE.'lib/images/blank.gif',
								'width' => '15',
								'height' => '11',
								'alt'    => '')));

				$form->addElement(form_makeOpenTag('a', array(
								'class' => 'wikilink1',
								'href'  => wl($data[1]))));
				$form->addElement($data[1]);
				$form->addElement(form_makeCloseTag('a'));

				$form->addElement(form_makeOpenTag('span', array('class' => 'sum')));
				$form->addElement(' &ndash; ');
				$form->addElement(htmlspecialchars($data[3]['sum']));
				$form->addElement(form_makeCloseTag('span'));

				$form->addElement(form_makeOpenTag('span', array('class' => 'user')));
				$form->addElement((empty($data[3]['editor']))?('('.$data[5]['external_edit'].')'):
				editorinfo($data[3]['editor']));
				$form->addElement(form_makeCloseTag('span'));

				$form->addElement('('.$data[5]['current'].')');
				$form->addElement(form_makeCloseTag('div'));
				$form->addElement(form_makeCloseTag('li'));
			}*/

			//imprime revisoes / edicoes
			foreach($revisions as $rev){
				$date   = dformat($rev);
				$info   = getRevisionInfo($data[1],$rev,true);
				$exists = page_exists($data[1],$rev);

				//tipo de revisao
				if ($info['type']===DOKU_CHANGE_TYPE_MINOR_EDIT)
					$form->addElement(form_makeOpenTag('li', array('class' => 'minor')));
				else
					$form->addElement(form_makeOpenTag('li'));
					
				//faz checkbox
				$form->addElement(form_makeOpenTag('div', array('class' => 'li')));
				if($exists){
					$form->addElement(form_makeTag('input', array(
									'type' => 'checkbox',
									'name' => 'rev2[]',
									'value' => $rev)));
				}else{
					$form->addElement(form_makeTag('img', array(
									'src' => DOKU_BASE.'lib/images/blank.gif',
									'width' => 14,
									'height' => 11,
									'alt' => '')));
				}

				//escreve data para identificar a edicao
				$form->addElement(form_makeOpenTag('span', array('class' => 'date')));
				$form->addElement($date);
				$form->addElement(form_makeCloseTag('span'));

				//e acrescenta o link
				if($exists){
					$form->addElement(form_makeOpenTag('a', array('href' => wl($data[1],"rev=$rev,do=diff", false, '&'), 'class' => 'diff_link')));
					$form->addElement(form_makeTag('img', array(
									'src'    => DOKU_BASE.'lib/images/diff.png',
									'width'  => 15,
									'height' => 11,
									'title'  => $data[5]['diff'],
									'alt'    => $data[5]['diff'])));
					$form->addElement(form_makeCloseTag('a'));

					$form->addElement(form_makeOpenTag('a', array('href' => wl($data[1],"rev=$rev",false,'&'), 'class' => 'wikilink1')));
					$form->addElement($data[1]);
					$form->addElement(form_makeCloseTag('a'));
				}else{
					$form->addElement(form_makeTag('img', array(
									'src' => DOKU_BASE.'lib/images/blank.gif',
									'width' => '15',
									'height' => '11',
									'alt'   => '')));
					$form->addElement($data[1]);
				}

				//autores das revisoes
				$form->addElement(form_makeOpenTag('span', array('class' => 'sum')));
				$form->addElement(' &ndash; ');
				$form->addElement(htmlspecialchars($info['sum']));
				$form->addElement(form_makeCloseTag('span'));

				$form->addElement(form_makeOpenTag('span', array('class' => 'user')));
				if($info['user']){
					$form->addElement(editorinfo($info['user']));
					if(auth_ismanager()){
						$form->addElement(' ('.$info['ip'].')');
					}
				}else{
					$form->addElement($info['ip']);
				}
				
				//fecha tags de lista
				$form->addElement(form_makeCloseTag('span'));
				$form->addElement(form_makeCloseTag('div'));
				$form->addElement(form_makeCloseTag('li'));
			}
			$form->addElement(form_makeCloseTag('ul'));
			//msg($data[5][1]);
			//desenha o botao de comparacao
			//$form->addElement(form_makeButton('submit', 'diff', $data[5]['diff2']));
			$form->addElement(form_makeButton('submit', 'diff', "Mostrar diferencas entre edicoes"));
			//imprime form
			html_form('editions', $form);

			//se forem mais de 20 cria paginas
			print '<div class="pagenav">';
			$last = $first + $data[4]['recent'];
			if ($first > 0) {
				$first -= $data[4]['recent'];
				if ($first < 0) $first = 0;
				print '<div class="pagenav-prev">';
				print html_btn('newer',$data[1],"p",array('do' => 'revisions', 'first' => $first));
				print '</div>';
			}
			if ($hasNext) {
				print '<div class="pagenav-next">';
				print html_btn('older',$data[1],"n",array('do' => 'revisions', 'first' => $last));
				print '</div>';
			}
			print '</div>';	
			
		} else { //se forem dadas as edicoes vai busca-las e faz diff
		
			//busca as edicoes da string
			$edi=explode("|", $data[0]);
			
			//procura os url's no conteudo
			$str_temp1="<edicao>".$edi[0];
			$str_temp2="<edicao>".$edi[1];
			
			$caux1=strstr($contentaux,$str_temp1);
			$caux2=strstr($contentaux,$str_temp2);
			
			$tempstr1=strstrb($caux1,"</edicao>");
			$tempstr2=strstrb($caux2,"</edicao>");
			
			$link1=substr(strstr($tempstr1,"|"), 1);
			$link2=substr(strstr($tempstr2,"|"), 1);
			
			//busca url
			//$url1 = tpl_pagetitle($link1, true);
			//$url2 = tpl_pagetitle($link2, true);
			
			//busca revisions
			//$rev1 = substr(strstr($link1,"="), 1);
			//$rev2 = substr(strstr($link2,"="), 1);
			
			//obtem id's das revisoes pelas datas
			//busca todas as revisoes
			$revisoes = getRevisions($data[2], 0,0);
			$countr = count($revisoes);
			
			//Primeiro ID
			for ($i = 0; $i < $countr; $i++) {
				$meta = getRevisionInfo($data[1], $revisoes[$i], 0);
				if(dformat($meta['date']) == $link1){						
					$rev1=$revisoes[$i];
					$i = $countr;
				}
			}
			
			//Segundo ID
			for ($j = 0; $j < $countr; $j++) {
				$meta = getRevisionInfo($data[1], $revisoes[$j], 0);
				if(dformat($meta['date']) == $link2){						
					$rev2=$revisoes[$j];
					$j = $countr;
				}
			}
			
			//debug
			/*msg($edi[0]);
			msg($edi[1]);
			msg($str_temp1);
			msg($str_temp2);
			msg($caux1);
			msg($caux2);
			msg($tempstr1);
			msg($tempstr2);
			msg($link1);
			msg($link2);
			msg($rev1);
			msg($rev2);*/
			
			//constroi os arrays de linhas a comparar incluindo as tags com htmlspecialchars
			$comp1=explode("\n",htmlspecialchars(rawWiki($data[1],$rev1)));
			$comp2=explode("\n",htmlspecialchars(rawWiki($data[1],$rev2)));
			
			//procura links nas linhas e expande para se fazer a comparacao de profundidade
			//Para o primeiro link
			//msg($link1);
			$v=0;
			$countl1 = count($comp1);
			for ($k = 0; $k < $countl1; $k++) {
				$exlink1=strstr($comp1[$k],"[[");
				if ($exlink1<>FALSE) { //encontrou um link
					//isolar o link
					$unomas1[$v]=substr(strstrb(strstrb($exlink1,"]]"),"|"),2);
					
					//buscar revisao daquela data
					$revisoes1 = getRevisions($unomas1[$v], 0,0);
					$countr1 = count($revisoes1);
					for ($i1 = 0; $i1 < $countr1; $i1++) {
						$meta1 = getRevisionInfo($unomas1[$v], $revisoes1[$i1], 0);
						//msg(dformat($meta1['date']));
						//se edicao tiver uma data maior ou igual da pagina entao e essa pagina
						if((isDateNewer($link1,dformat($meta1['date']))) || ($link1==dformat($meta1['date']))){
						//if ($link1==dformat($meta1['date'])) {
							$revl1=$revisoes[$i1];
							$i1 = $countr1;
							//msg($revl1);
						}
					}
					
					//e separa em linhas para comparacao
					$complink1[$v]=explode("\n",htmlspecialchars(rawWiki($unomas1[$v],$revl1)));
					$v++;
				}
			}
			
			//Para o segundo link
			//msg($link2);
			$s=0;
			$countl2 = count($comp2);
			for ($p = 0; $p < $countl2; $p++) {
				$exlink2=strstr($comp2[$p],"[[");
				if ($exlink2<>FALSE) { //encontrou um link
					//isolar o link
					$unomas2[$s]=substr(strstrb(strstrb($exlink2,"]]"),"|"),2);
					
					//buscar revisao daquela data
					$revisoes2 = getRevisions($unomas2[$s], 0,0);
					$countr2 = count($revisoes2);
					for ($i2 = 0; $i2 < $countr2; $i2++) {
						$meta2 = getRevisionInfo($unomas2[$s], $revisoes2[$i2], 0);
						//msg(dformat($meta2['date']));
						//se edicao tiver uma data maior ou igual da pagina entao e essa pagina
						if((isDateNewer($link2,dformat($meta2['date']))) || ($link2 == dformat($meta2['date']))){
						//if ($link2 == dformat($meta2['date'])) {
							$revl2=$revisoes[$i2];
							$i2 = $countr2;
							//msg($revl2);
						}
					}
					
					//e separa em linhas para comparacao
					$complink2[$s]=explode("\n",htmlspecialchars(rawWiki($unomas2[$s],$revl2)));
					$s++;
				}
			}
			
			//diferenca entre edicoes
			$df  = new Diff($comp1,$comp2);
			
			//compara
			$tdf = new TableDiffFormatter();
			$renderer->doc.= '<table>';
			$renderer->doc.= '<tr><th colspan="2" width="50%">'.$edi[0].' <-> '.$edi[1].'</th>';
			$renderer->doc.= '<th colspan="2" width="50%">'.$lang['current'].'</th></tr>';
			$renderer->doc.= $tdf->format($df);
			$renderer->doc.= '</table>';
			
			//diferenca entre paginas
			//procura quais os links comuns
			$cntnl1 = count($unomas1);
			$cntnl2 = count($unomas2);
			$pagcom = $cntnl1;
			for ($h = 0; $h < $pagcom; $h++) {
				if ($unomas1[$h]==$unomas2[$h]) {
					$df  = new Diff($complink1[$h],$complink2[$h]);
				
					$tdf = new TableDiffFormatter();
					$renderer->doc.= '<table>';
					$renderer->doc.= '<tr><th colspan="2" width="50%">'.$unomas1[$h].' <-> '.$unomas2[$h].'</th>';
					$renderer->doc.= '<th colspan="2" width="50%">'.$lang['current'].'</th></tr>';
					$renderer->doc.= $tdf->format($df);
					$renderer->doc.= '</table>';
				}
			}
		}						
		
		return true;

		}
	}
 			
}