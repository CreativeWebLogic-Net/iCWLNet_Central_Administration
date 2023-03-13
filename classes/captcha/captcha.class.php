<?php
/**
 * @author Dodit Suprianto
 * Email: d0dit@yahoo.com
 * Website: http://doditsuprianto.com, http://goiklan.co.nr
 * Website: http://www.meozit.com, http://easyads.co.nr
 * 
 * call captcha code <img src=captcha.class.php?length=&font=&size=&angel=&file=>
 * 
 * You can enter the parameter or not. Explaination:
 * 
 * length	: how much character will be shown. 4 character by default.
 * font		: Type of font (ex. Arial.ttf). Georgia font by default
 * size		: Size of font character. 20 by default
 * angel	: angel of font character. 0 by default, it means horizontal position
 * file		: if you want subtitute the background image. "eyes.gif" by default.
 * 
 * You must copy several file to current directory
 * if you want to subtitute the default setting. 
 * such as font file, background file
 * 
 */
	echo"ccc";
	session_start();
	
	class captcha
	{
		private $length;		
		private $font;
		private $size;
		private $angel;
		private $file;
		
		public function __construct()
		{
			$this->length = 4;
			$this->font = "georgia.ttf";
			$this->size = 20;
			$this->angel = 0;
			$this->file = "eyes.gif";
		}
		
		public function setFile($file)
		{
			$this->file = $file;	
		}
		
		public function setLength($length)
		{
			$this->length = $length;
		}
		
		public function setFont($font)
		{
			$this->font = $font;
		}
		
		public function setSize($size)
		{
			$this->size = $size;
		}
		
		public function setAngel($angel)
		{
			$this->angel = $angel;
		}
		
		private function RandomText()
		{
			$output = "";
			$input = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
			//srand((float) microtime() * 10000000);			
			//$rand_keys = array_rand($input, count($input));			
			
			for ($i=0; $i < $this->length; $i++)			
			{
				$rannum=rand(0,count($input));
				$output .= $input[$rannum];
			}
			return $output;
		}
		
		public function ConvertFontToImage()
		{
			$type = getimagesize($this->file);
			$random = $this->RandomText();
			switch ($type[2])
			{
				case IMAGETYPE_GIF:
					header("Content-type: image/gif");
					$im = imagecreatefromgif($this->file);
					$white = imagecolorallocate($im, 255, 255, 255);
					$textbox = imagettfbbox($this->size, 0, $this->font, $this->RandomText());
					$px = ($type[0] - $textbox[4])/2;
					$py = ($type[1] - $textbox[5])/2;
					imagettftext($im, $this->size, $this->angel, $px, $py, $white, $this->font, $random);
					imagegif($im);
					imagedestroy($im);
				break;
				case IMAGETYPE_JPEG:
					header("Content-type: image/jpeg");
					$im = imagecreatefromjpeg($this->file);
					$white = imagecolorallocate($im, 255, 255, 255);
					$textbox = imagettfbbox($this->size, 0, $this->font, $this->RandomText());
					$px = ($type[0] - $textbox[4])/2;
					$py = ($type[1] - $textbox[5])/2;
					imagettftext($im, $this->size, $this->angel, $px, $py, $white, $this->font, $random);
					imagejpeg($im);
					imagedestroy($im);					
				break;
				case IMAGETYPE_PNG:
					header("Content-type: image/png");
					$im = imagecreatefrompng($this->file);
					$white = imagecolorallocate($im, 255, 255, 255);
					$textbox = imagettfbbox($this->size, 0, $this->font, $this->RandomText());
					$px = ($type[0] - $textbox[4])/2;
					$py = ($type[1] - $textbox[5])/2;
					imagettftext($im, $this->size, $this->angel, $px, $py, $white, $this->font, $random);
					imagepng($im);
					imagedestroy($im);
				break;
			}	
			$_SESSION['code'] = $random;				
		}
	}		
	
	$handle = new captcha();	
	if (!empty($_GET['length'])) $handle->setLength($_GET['length']);
	if (!empty($_GET['font'])) $handle->setFont($_GET['font']);
	if (!empty($_GET['size'])) $handle->setSize($_GET['size']);
	if (!empty($_GET['angel'])) $handle->setAngel($_GET['angel']);
	if (!empty($_GET['file'])) $handle->setFile($_GET['file']);	
	//$handle->ConvertFontToImage();
?>