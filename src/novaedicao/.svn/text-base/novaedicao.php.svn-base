<?php


function createEdition($data){

			if($data == null) {return false;}


			$ret .= '<div class="new">';
			$ret .= '<a href=\'doku.php?id='.$data[1]."&rev=".$data[2].'\' >'.$data[0].'</a>';
            $ret .= '</div>';
			
			return $ret;
}

function newEditionToEdition($data, $content, $retornou){
	
	if($data[4] == false){
				$content = str_replace("<novaedicao>".$data[0]."</novaedicao>", 
				"<edicao>".$data[0]."|".$retornou."</edicao>", $content);
			}
	else{ 
				$content = str_replace("<novaedicao></novaedicao>", 
				"<edicao>".$data[0]."|".$retornou."</edicao>", $content);
	}
	
	return $content;
}