<?php

	function getDates(){
		
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
			
		return $datas;
		
	}