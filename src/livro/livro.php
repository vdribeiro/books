<?php


function bookFormat($rawstring){
	
	if($rawstring == null) { return false; }
	
	$rawstring = strtoupper(substr($rawstring,0,1)).substr($rawstring,1);
	$parsedstring = str_replace("_"," ",$rawstring);
	return $parsedstring;
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


function getLinkNames($content){
	
	$link = strstr($content, '[[');
	$link = array_shift(explode(']]',$link,2));
	$link = substr($link,2);
	$devolve[1] = str_replace('[['.$link.']]', "", $content);
	$devolve[0] = $link;
		
	return $devolve;
}