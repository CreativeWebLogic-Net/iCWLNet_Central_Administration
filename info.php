<pre>
	Hello There:- 
	
<?php

	print "open file->".$_SERVER["PHP_SELF"];
	print $_SERVER['SERVER_NAME']."-<br>";
	$host_name=gethostname();
	print $host_name."-<br>";
	$current_dir=pathinfo(__DIR__);
	print_r($current_dir)."<br>";
?>
</pre>
<?php
	phpinfo();


?>