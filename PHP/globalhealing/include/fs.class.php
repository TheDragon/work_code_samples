<?
class fs {
	
	function scan($dir){
		$files = scandir($dir);
		$ret_array = array();
		foreach ($files as $file){
			if ((stristr($file,'.mp4')) || (stristr($file,'.txt'))){
				$ret_array[] = $file;
			}
		}
		$this->file_array = $ret_array;
	}
	
	function check_pairs(){
		foreach ($this->file_array as $file){
			$splode = explode('.',$file);
			$ext = $splode[count($splode)-1];
			if ($ext == 'mp4'){
				if (in_array($splode[0].'.txt',$this->file_array)){
					$ret_array[] = $file;
					$ret_array[] = $splode[0].'.txt';
				}
			}
		}
		$this->pair_array = $ret_array;

	}
	function check_unmatched($dir){
		$this->scan($dir);
		$ret_array = array();
		foreach ($this->file_array as $file){
			$splode = explode('.',$file);
			$ext = $splode[count($splode)-1];
			if ($ext == 'mp4'){
				if (!in_array($splode[0].'.txt',$this->file_array)){
					$ret_array[] = $splode[0];
				}
			}
		}
		return $ret_array;
	}
	function get_titles($dir){
		$this->scan($dir);
		$this->check_pairs();
		$filename_array = array();
		foreach ($this->pair_array as $file){
			$splode = explode('.',$file);
			if (!in_array($splode[0],$filename_array)){
				$filename_array[] = $splode[0];
			}
		}
		return $filename_array;
	}
	
	function process_file($file){
		$handle = fopen($file.'.txt', "r");
		$contents = fread($handle,filesize($file.'.txt'));
		$cont_array = explode(':',$contents);
		$return_array = array();
		if (count($cont_array) == 6){
			$return_array['date_published'] = date("D, d M Y H:i:s \C\S\T",filemtime($file.'.mp4'));
			$return_array['file_link'] = htmlentities('http://globalhealing.brainwor.ms/'.str_replace(' ','%20',$file.'.mp4'));
			$return_array['file_size'] = filesize($file.'.mp4');
			$return_array['title'] = htmlentities($cont_array[0]);
			$return_array['summary'] = htmlentities($cont_array[1]);
			$return_array['subtitle'] = htmlentities($cont_array[2]);
			$return_array['author'] = $cont_array[3];
			$return_array['duration'] = str_replace(',',':',$cont_array[4]);
			$return_array['keywords'] = htmlentities($cont_array[5]);
		}
		return $return_array;
	}
}
