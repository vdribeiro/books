<?php

//msg('dfnsjkfnmdc');

// autores ---------------------------------------------------------

function getLinkName($content){
	
	
					$ret = strstr($content, '[[');
					$ret = strstrb($ret, ']]');
					$ret = strrev($ret);
					$ret = strstrb($ret, "[[");
					$ret = strrev($ret);
					return $ret;
	
}

function authors($data){
	
					
					$k = 0;
					$names[0] = "";
					$ret .= "<b>Autores: </b><br>";

					for($j = 0; $j < sizeof($data); $j++)
					{
						foreach($data[$j] as $i => $value)
						{
								
								if(in_array($data[$j][$i], $names) === false)
								{
									$names[$k] = $data[$j][$i];
									$k++;
									$ret .= "<i>".$data[$j][$i]."</i><br>";
								}
						}
					}	
					return $ret;
}