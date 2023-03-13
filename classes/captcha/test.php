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

session_start();
?>
<html>

<head>
<title>Demo Captcha</title>
</head>

<body>
<?php
	if ($_POST['submit'])
	{		
		if ($_SESSION['code'] == $_POST['code'] && !empty($_SESSION['code'])) 
	   	{
			/**
			 * you should add other codes in here
			 * in this section, means that the captcha and code are match
			 */
			
	   		echo "captcha is correct";
			unset($_SESSION['code']);
		}
		else
	   	{
	   		echo "captcha is wrong";	   		
	   	}
	}

	echo "<form action='$_SERVER[SELF]' method=POST>";
	echo "Security code: <img src=captcha.class.php?length=4&font=&size=24&angel=5&file=><p>";
	echo "Input code: <input type=text name=code><br>";
	echo "<input type='submit' name='submit' value='Submit'>";
	echo "</form>";
?>		
</body>

</html>