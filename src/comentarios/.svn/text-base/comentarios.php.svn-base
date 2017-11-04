<?php

function getCommentsFromPage($link) {
		
		$path = "/data/meta/discussion/";
		if($dir = @opendir(getcwd().$path))
		{
			while ($files = @readdir($dir))
			{
				if(($files != '.') && ($files != '..') && ($files[0] != '.'))
				{
					$name = explode('.', $files);
					if($name[0] === $link && $name[2] === "comments")
					{
						$file = fopen(getcwd().$path.$files,'r');
						if (!$file) die ("could not open file ".$files);
						$filesize = filesize(getcwd().$path.$files);
						$file_contents = fread($file, filesize(getcwd().$path.$files));
						while($file_contents !== FALSE)
						{
							$file_contents = strstr($file_contents, "user");
							$file_contents = strstr($file_contents, "name");
							$name = substr($file_contents, 7, 100);
							$name_ex = explode('"', $name);
							if(!array_key_exists($name_ex[1], $ret_names) && $name_ex[1] !== FALSE)
							{
								$ret_names[$name_ex[1]] = 1;
							}
							else
							{
								$ret_names[$name_ex[1]]++;
							}
							
						}
						
						fclose($file);
						
						if(array_key_exists("", $ret_names))
							unset($ret_names[""]);
					}
				}
			}
			closedir($dir);
		}
		else
			msg('Directory can\'t be opened.');
			
		return $ret_names;

	}
	
	function joinComments($total, $paged)
	{
		foreach($paged as $i => $value)
			if(!array_key_exists($i, $total))
				$total[$i] = $paged[$i];
			else
				$total[$i] += $paged[$i];
				
		return $total;
	}
	
	function getCommentsFromBook($link)
	{
				$content = rawWiki($link);
				do
				{
					$ret = strstr($content, '[[');
					$ret = strstrb($ret, ']]');
					$ret = strrev($ret);
					$ret = strstrb($ret, "[[");
					$ret = strrev($ret);
					$new = explode('|', $ret);
					
					$comentarios = getCommentsFromPage($new[0]);
						
					if(empty($total_comments))
						$total_comments = $comentarios;
					else
						$total_comments = joinComments($total_comments, $comentarios);
					
					$content = str_replace('[['.$ret.']]', "", $content);
				}while($ret != "");	
				
				return joinComments($total_comments, getCommentsFromPage($link));
	}
 
	function displayComments($comentarios)
	{
 				foreach($comentarios as $i => $value)
						$soma += $comentarios[$i];
						
				foreach($comentarios as $i => $value)
						$ret .= $i.": ".(int)($comentarios[$i]/$soma*100)."%"."<br>";
 
				return $ret;
	}