<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

function ru_plural($number, $one, $two, $five) 
{
	if (($number - $number % 10) % 100 != 10) {
		if ($number % 10 == 1) {
			$result = $one;
		} elseif ($number % 10 >= 2 && $number % 10 <= 4) {
			$result = $two;
		} else {
			$result = $five;
		}
	} else {
		$result = $five;
	}
	return $result;
}

function cut_string($string, $maxlen) {
    $len = (mb_strlen($string) > $maxlen)
        ? mb_strripos(mb_substr($string, 0, $maxlen), ' ')
        : $maxlen
    ;
    $cutStr = mb_substr($string, 0, $len);
    return (mb_strlen($string) > $maxlen)
        ? $cutStr.'...'
        : $cutStr
    ;
}