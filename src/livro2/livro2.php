<?php

	function endTag($content){
			
			$content = str_replace('</livro>', "", $content);
			$content .= "</livro>";
			return $content;
	}