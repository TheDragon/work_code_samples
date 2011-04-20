<?php
/**
 * Removed all identifying information to employer for security reasons.
 * Requiring library items that we need for configuration, and format helping.
 */
require_once 'Newstool/Constants.php';


require_once 'Xend/Path.php';
require_once 'Xend/String.php';


class Newstool_FTP {
	/**
	 * We establish the FTP connection on instantiation so multiple uploads can be managed
	 * in one connection. FTP connection is closed in __destruct()
	 */
	public function __construct(){
		$connectConfig = Newstool_Constants::FTP();
		
		$this->connection = ftp_connect($connectConfig['server']);
		
		if (!ftp_login($this->connection, $connectConfig['username'], $connectConfig['password']))
		{
			require_once 'Newstool/FTP/Exception.php';
			throw new Newstool_FTP_Exception('The FTP connection could not be established');
		}

	}
	/**
	 * Takes the source file (full path to the file), destination filename (no path appended), and the 
	 * path we're attempting to write to on the remote server. Passes it off to the path creation method
	 * to make sure our destination path exists, and creates the full tree to ensure that upload doesn't
	 * fail.
	 * TODO: create config item for flagging directory creation on or off.
	 */
	public function FTPUpload($source,$destFile,$path) {		
		if (file_exists($source)){
			$this->_FTPCreatePath($path);
			if (!@ftp_put($this->connection,$destFile,$source,FTP_BINARY)){
				require_once 'Newstool/FTP/Exception.php';
				throw new Newstool_FTP_Exception('The file could not be uploaded');
			}
		} else {
			require_once 'Newstool/FTP/Exception.php';
			throw new Newstool_FTP_Exception("Source file doesn't exist: $source");
		}
	}
	
	public function FTPDelete($file){	
		if (!@ftp_delete($this->connection,$file)){
			require_once 'Newstool/FTP/Exception.php';
			throw new Newstool_FTP_Exception('Could not delete the file');
		}
	}
	
	public function __destruct(){
		ftp_close($this->connection);
	}
	/**
	 * This takes the path we're attempting to save to, and the last element of the path.
	 * (This should not be overwritten, it's populated in successive traversal)
	 */
	private function _FTPCreatePath($path,$last = array()){
		if (!@ftp_chdir($this->connection,$path)){
			$last[] = Xend_Path::getLastPathComponent($path);
			$path = Xend_Path::stripLastPathComponent($path);
			$this->_FTPCreatePath($path,$last);
		} else if ($last){
			$last = array_reverse($last);
			foreach ($last as $dir){
				if ((!ftp_mkdir($this->connection,$dir)) || (!ftp_chdir($this->connection,ftp_pwd($this->connection).'/'.$dir))){
					require_once 'Newstool/Image/Processor/Exception.php';
					throw new Newstool_Image_Processor_Exception("Could not create directory for saving.");
				}
			}
		}
	}
}