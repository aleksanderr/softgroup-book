<?
class func {
	
	// =====================================================================================
	#Function:	TextClean
	// =====================================================================================
	public function TextClean($text){
		
		$array_find    = array("`", "<", ">", "^", '"', "~", "\\");
		$array_replace = array("&#96;", "&lt;", "&gt;", "&circ;", "&quot;", "&tilde;", "");
		
		return str_replace($array_find, $array_replace, $text);
		
	}

	// =====================================================================================
	#Function:	TextClean
	// =====================================================================================
	public function TextReverse($text){
		
		$array_replace = array("`", "<", ">", "^", '"', "~", "\\");
		$array_find    = array("&#96;", "&lt;", "&gt;", "&circ;", "&quot;", "&tilde;", "");
		
		return str_replace($array_find, $array_replace, $text);
		
	}
	
	/*======================================================================*\
	Function:	IsMail
	\*======================================================================*/
	public function IsMail($mail){
		
		if(is_array($mail) && empty($mail) && strlen($mail) > 255 && strpos($mail,'@') > 64) return false;
			return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $mail)) ? false : strtolower($mail);
			
	}
	
	/*======================================================================*\
	Function:	IsLogin
	\*======================================================================*/
	public function IsLogin($login){
		
		return (is_array($login)) ? false : (preg_match('/[^\w]/u', $login)) ? $login : false;
	
	}
	/*======================================================================*\
	Function:	IsPassword
	\*======================================================================*/
	public function IsPassword($password, $mask = "^[a-zA-Z0-9]", $len = "{4,50}"){
		
		return (is_array($password)) ? false : (preg_match("/{$mask}{$len}$/", $password)) ? $password : false;
	
	}
	
	/*======================================================================*\
	Function:	GetTime
	\*======================================================================*/
	public function GetTime($tis = 0, $unix = true, $template = "d.m.Y H:i:s"){
		
		if($tis == 0){
			return ($unix) ? time() : date($template,time());
		}else return date($template,$unix);
	}
	/*=======================================================================*\
	Function:   NumFormat
	\*=======================================================================*/
	public function NumFormat( $digit, $width ) { 
	    while( strlen( $digit ) < $width ) { 
	        $digit = '0' . $digit; 
	    } 
	    return $digit; 
	}

}
?>