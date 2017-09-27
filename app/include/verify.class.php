<?php   

class verify {   

    public static $codeSet;   
    public static $fontSize = 16;
    public static $useCurve = true;
    public static $useNoise = true;
    public static $imageH;
    public static $imageL;
    public static $length;
	public static $code_filetype;
    public static $bg = array(243, 251, 254);
    
    protected static $_image = null;
    protected static $_color = null;
     
	function __construct($width='110',$height='40',$strlength='4',$filetype='gif',$code_type='3'){
	  
      self::$imageL = $width;
      self::$imageH = $height;
	  self::$length = $strlength;
	  self::$code_filetype = $filetype;
	  if($code_type=='1'){
		 self::$codeSet = '1234567890';
	  }elseif($code_type=='2'){
		 self::$codeSet = 'ABCDEFGHJKLMNPQRTUVWXY';
	  }else{
		 self::$codeSet = '3456789ABCDEFGHJKLMNPQRTUVWXY';
	  }
	 
    
    }

    public static function entry() {

        self::$imageL || self::$imageL = self::$length * self::$fontSize * 1.5 + self::$fontSize*1.5;    

        self::$imageH || self::$imageH = self::$fontSize * 2;   
   
        self::$_image = imagecreate(self::$imageL, self::$imageH);    
       
        imagecolorallocate(self::$_image, self::$bg[0], self::$bg[1], self::$bg[2]);    

        self::$_color = imagecolorallocate(self::$_image, mt_rand(1,120), mt_rand(1,120), mt_rand(1,120));   

        $ttf = dirname(__FILE__) . '/ttfs/t' . 2 . '.ttf';     
  
        if (self::$useNoise) {
            self::_writeNoise();   
        }    
        if (self::$useCurve) {
            self::_writeCurve();   
        }   

        $code = array();   
        $codeNX = 0;
		
        for ($i = 0; $i<self::$length; $i++) {   
			
            $code[$i] = self::$codeSet[mt_rand(0, strlen(self::$codeSet)-1)];
            $codeNX += mt_rand(self::$fontSize*1.2, self::$fontSize*1.6);
            imagettftext(self::$_image, self::$fontSize, mt_rand(-40, 70), $codeNX, self::$fontSize*1.5, self::$_color, $ttf, $code[$i]);   
        }   

        isset($_SESSION) || session_start();   
        $_SESSION['authcode'] = md5(strtolower(join('', $code))); 
       
                       
        header('Pragma: no-cache');
		if(self::$code_filetype=="png"){
			@header("Content-Type:image/png");
		}elseif(self::$code_filetype=="jpg"){
			@header("Content-Type:image/jpeg");
		}else{
			@header("Content-Type:image/gif");
		}

        imageJPEG(self::$_image);    
        imagedestroy(self::$_image);   
    }   

    protected static function _writeCurve() {   
        $A = mt_rand(1, self::$imageH/2);
        $b = mt_rand(-self::$imageH/4, self::$imageH/4);
        $f = mt_rand(-self::$imageH/4, self::$imageH/4);
        $T = mt_rand(self::$imageH*1.5, self::$imageL*2);
        $w = (2* M_PI)/$T;   
                           
        $px1 = 0;
        $px2 = mt_rand(self::$imageL/2, self::$imageL * 0.667);
        for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {   
            if ($w!=0) {   
                $py = $A * sin($w*$px + $f)+ $b + self::$imageH/2;
                $i = (int) ((self::$fontSize - 6)/4);   
                while ($i > 0) {    
                    imagesetpixel(self::$_image, $px + $i, $py + $i, self::$_color);  
                    $i--;   
                }   
            }   
        }   
           
        $A = mt_rand(1, self::$imageH/2);
        $f = mt_rand(-self::$imageH/4, self::$imageH/4);
        $T = mt_rand(self::$imageH*1.5, self::$imageL*2);
        $w = (2* M_PI)/$T;         
        $b = $py - $A * sin($w*$px + $f) - self::$imageH/2;   
        $px1 = $px2;   
        $px2 = self::$imageL;   
        for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {   
            if ($w!=0) {   
                $py = $A * sin($w*$px + $f)+ $b + self::$imageH/2;
                $i = (int) ((self::$fontSize - 8)/4);   
                while ($i > 0) {            
                    imagesetpixel(self::$_image, $px + $i, $py + $i, self::$_color); 
                    $i--;   
                }   
            }   
        }   
    }   

    protected static function _writeNoise() {   
        for($i = 0; $i < 10; $i++){   
            $noiseColor = imagecolorallocate(   
                              self::$_image,    
                              mt_rand(150,225),    
                              mt_rand(150,225),    
                              mt_rand(150,225)   
                          );   
            for($j = 0; $j < 5; $j++) {   
                imagestring(   
                    self::$_image,   
                    5,    
                    mt_rand(-10, self::$imageL),    
                    mt_rand(-10, self::$imageH),    
                    self::$codeSet[mt_rand(0, strlen(self::$codeSet)-1)],
                    $noiseColor  
                );   
            }   
        }   
    }   
}   
  

?>