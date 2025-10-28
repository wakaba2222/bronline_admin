<?php
function smarty_modifier_mb_truncate($string, $length = 80, $etc = '...')
{
	if ($length == 0) {return '';} 

    if (mb_strlen($string) > $length) { 
      return mb_substr($string, 0, $length).$etc; 
    } else { 
      return $string; 
    }
/*
	$k1 = "<p class=\"intro\">";
	$k2 = "<h3>";
	
	$start = mb_strpos($string, $k1);
	if ($start)
		$start += mb_strlen($k1);
	else
	{
		$start = mb_strpos($string, $k2);
		$start += mb_strlen($k2);
	}

  if ($length == 0)
    return '';
  if (mb_strlen($string,"UTF-8") > $length) {
	$string = mb_substr($string, $start, $length, "UTF-8");
    return $string.$etc;
  } else {
    return $string;
  }
  */
}
