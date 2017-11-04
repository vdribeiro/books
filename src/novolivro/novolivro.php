<?php

function createBook($name){
	
	if($name == null) {return false;}
	
	$ret .= '<div class="new">';
	$ret .= '<a href=\'doku.php?id='.$name.'\' >'.$name.'</a>';
	$ret .= '</div>';
	return $ret;
	
}

function newBookToBook($content, $name){
	
	$content = str_replace("<novolivro>".$name."</novolivro>", 
				"[[".$name."]]", $content);
				
	return $content;
	
}