<?php
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
include 'comentarios.php';
 

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_comentarios extends DokuWiki_Syntax_Plugin {
 
    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Grupo1',
            'date'   => '22/11/2010',
            'name'   => 'NovaEdicao Plugin',
            'desc'   => 'Cria uma nova edicao do livro',
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
	 $this->Lexer->addSpecialPattern("<comentarios>",$mode,'plugin_comentarios');
	}
		
		
		
	function drawGraph($received){

        // prepare default data
        $return = array(
                     'type'   => 'p3',
                     'data'   => $data,
                     'width'  => 480,
                     'height' => 200,
                     'align'  => 'right',
                     'legend' => false,
                     'value'  => false,
                     'title'  => '',
                     'fg'     => ltrim($this->getConf('fg'),'#'),
                     'bg'     => ltrim($this->getConf('bg'),'#'),
                    );

   
		$j = 0;
		foreach($received as $i => $value)
			$received_parsed .= $i." = ".$received[$i]." \n ";
		$lines = explode("\n",$received_parsed);
        $data = array();
        foreach ( $lines as $line ) {
            //ignore comments (except escaped ones)
            $line = preg_replace('/(?<![&\\\\])#.*$/','',$line);
            $line = str_replace('\\#','#',$line);
            $line = trim($line);
            if(empty($line)) continue;
            $line = preg_split('/(?<!\\\\)=/',$line,2); //split on unescaped equal sign
            $line[0] = str_replace('\\=','=',$line[0]);
            $line[1] = str_replace('\\=','=',$line[1]);
            $data[trim($line[0])] = trim($line[1]);
        }
        $return['data'] = $data;

        return $return;
    }	
		
		
	

    /**
     * Create output
     */
    function renderGraph($mode, &$R, $data) {
        if($mode != 'xhtml') return false;

        $val = array_values($data['data']);
        $max = ceil(max($val));
        $min = min($val);
        $min = floor(min($min,0));
        $val = array_map('rawurlencode',$val);
        $key = array_keys($data['data']);
        $key = array_map('rawurlencode',$key);

        $url  = 'http://chart.apis.google.com/chart?';
        $url .= '&cht='.$data['type'];
        if($data['bg']) $url .= '&chf=bg,s,'.$data['bg'];
        if($data['fg']) $url .= '&chco='.$data['fg'];
        $url .= '&chs='.$data['width'].'x'.$data['height']; # size
        $url .= '&chd=t:'.join(',',$val);
        $url .= '&chds='.$min.','.$max;
        if($data['title']) $url .= '&chtt='.rawurlencode($data['title']);

        switch($data['type']){
            case 'bhs': # horizontal bar
                $url .= '&chxt=y';
                $url .= '&chxl=0%3A|'.join('|',array_reverse($key));
                $url .= '&chbh=a';
                if($data['value']) $url .= '&chm=N*f*,333333,0,-1,11';
                break;
            case 'bvs': # vertical bar
                $url .= '&chxt=y,x';
                $url .= '&chxr=0,'.$min.','.$max;
                $url .= '&chxl=1:|'.join('|',$key);
                $url .= '&chbh=a';
                if($data['value']) $url .= '&chm=N*f*,333333,0,-1,11';
                break;
            case 'lc':  # line graph
                $url .= '&chxt=y,x';
                $url .= '&chxr=0,'.floor(min($min,0)).','.ceil($max);
                $url .= '&chxl=1:|'.join('|',$key);
                if($data['value']) $url .= '&chm=N*f*,333333,0,-1,11';
                break;
            case 'ls':  # spark line
                if($data['value']) $url .= '&chm=N*f*,333333,0,-1,11';
                break;
            case 'p3':  # pie graphs
            case 'p':
                if($data['legend']){
                    $url .= '&chdl='.join('|',$key);
                    if($data['value']) $url .= '&chl='.join('|',$val);
                }else{
                    if($data['value']){
                        $cnt = count($key);
                        for($i = 0; $i < $cnt; $i++){
                            $key[$i] .= ' ('.$val[$i].')';
                        }
                    }
                    $url .= '&chl='.join('|',$key);
                }
                break;
        }

        $url .= '&.png';

        $url = ml($url);

        $align = '';
        if($data['align'] == 'left')  $align=' align="left"';
        if($data['align'] == 'right') $align=' align="right"';

        $R->doc .= '<img src="'.$url.'" class="media'.$data['align'].'" alt="" width="'.$data['width'].'" height="'.$data['height'].'"'.$align.' />';
        return true;
    }
	
	
	 
    /**
     * Handle the match
     */
			function handle($match, $state, $pos, &$handler){				
				
				
				return $matches;
			}
		
	    function render($mode, &$renderer, $data) {
		if($mode == 'xhtml'){ //->para integrar com os outros grupos
			//verifica se a pagina actual é livro
			global $ID;
			if(isABook())
			{
				$comentarios = getCommentsFromBook($ID);
				$return = $this->drawGraph($comentarios);
				$this->renderGraph($mode, $renderer, $return);
				
				$renderer->doc .= "<b>Comentadores: </b><br>";
				$renderer->doc .= displayComments($comentarios);
			}
				
					return true;
				
			}
     

	return false;
 }
 
}