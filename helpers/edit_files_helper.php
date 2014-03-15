<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

#масштабировать изображение в соответсвии с массивом [директория], [имя], [лого], [массив = [ [ ширина, высота, вписать, маска ], [..] ] ]
/*
array(
		''=>array(1024, 768, true, true),
		'big'=>array(660, 402, true, true),
		'middle'=>array(90, 55, true, false),
		'small'=>array(323, 202, true, false)
	);
*/
function edit_image_settings($pathFile, $dir, $name, $logoDir, $settings, $quality = 100, $rewrite = true)
{
	copy($pathFile, $dir.$name);
	foreach ($settings as $k=>$v)
	{
		if ($k != '') edit_image_settings_item($dir, $name, $logoDir, $quality, $v, $k, $rewrite);
	}
	if (isset ($settings[''])) edit_image_settings_item($dir, $name, $logoDir, $quality, $settings[''], '', $rewrite);
}
function edit_image_settings_item($dir, $name, $logoDir, $quality, $v, $k, $rewrite)
{
	if (count ($v) == 4)
	{
		if (!(!$rewrite and is_file($dir.$k.$name))) 
		{
			if ($v[3]) $quality_resize = 100;
			else $quality_resize = $quality;
			
			if ($v[0] and $v[1])
			{
				if ($v[2]) edit_image_resize_fixed($dir.$name, $dir.$k.$name, $v[0], $v[1], $quality_resize);
				else edit_image_resize($dir.$name, $dir.$k.$name, $v[0], $v[1], $quality_resize);
			}
		}
		if ($v[3]) edit_image_watermark($dir.$k.$name, $dir.$k.$name, $logoDir, $quality);
	}
}

# создать диреторию
function check_dir($dir)
{
	if (!is_dir ($dir)) 
	{
		mkdir ($dir, 0777);
		//chmod ($dir, 0777);
		return true;
	}
	return false;
}

#удалить файл
function delete_file($file)
{
	if (is_file ($file)) 
	{
		chmod ($file, 0777);
		unlink ($file);
		return true;
	}
	return false;
}

# транслитиряция символов
function translit_str($str = false) 
{
	// переводим в транслит
	$str = rus2translit($str);
	// в нижний регистр
	$str = strtolower($str);
	// заменям все ненужное нам на "-"
	$str = preg_replace('~[^-a-z0-9_\.]+~u', '-', $str);
	// удаляем начальные и конечные '-'
	$str = trim($str, "-");
	return $str;
}
function rus2translit($string) {
	$converter = array(
		'а' => 'a',   'б' => 'b',   'в' => 'v',
		'г' => 'g',   'д' => 'd',   'е' => 'e',
		'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
		'и' => 'i',   'й' => 'y',   'к' => 'k',
		'л' => 'l',   'м' => 'm',   'н' => 'n',
		'о' => 'o',   'п' => 'p',   'р' => 'r',
		'с' => 's',   'т' => 't',   'у' => 'u',
		'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
		'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
		
		'А' => 'A',   'Б' => 'B',   'В' => 'V',
		'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
		'И' => 'I',   'Й' => 'Y',   'К' => 'K',
		'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		'О' => 'O',   'П' => 'P',   'Р' => 'R',
		'С' => 'S',   'Т' => 'T',   'У' => 'U',
		'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
		'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
		'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
		'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
	);
	return strtr($string, $converter);
}

# удалить директории и файлы
function delete_directory($dirname) {
	if (is_dir($dirname)) $dir_handle = opendir($dirname);
	if (empty ($dir_handle)) return true;
	while($file = readdir($dir_handle)) {
		if ($file != "." && $file != "..") {
			if (!is_dir($dirname."/".$file))
				unlink($dirname."/".$file);
			else
				delete_directory($dirname.'/'.$file);
		}
	}
	closedir($dir_handle);
	rmdir($dirname);
	return true;
}

# удаление файлов
function delete_files($dirname) {
	if (is_dir($dirname)) $dir_handle = opendir($dirname);
	if (empty ($dir_handle)) return true;
	while($file = readdir($dir_handle)) {
		if ($file != "." && $file != "..") {
			if (!is_dir($dirname."/".$file))
				unlink($dirname."/".$file);
			else
				delete_directory($dirname.'/'.$file);
		}
	}
	closedir($dir_handle);
	return true;
}

# водяной знак [старый файл], [новый файл], [водяной знак], [качество]
function edit_image_watermark($imgDir, $imgNew, $logoDir = 'uploads/watermark.png', $quality = 100)
{
	list($im, $type) = edit_image_check_type($imgDir);
	$wm = imagecreatefrompng($logoDir);

	/*imagecopy($im, $wm, ImageSX($im)-ImageSX($wm)-20, ImageSY($im)-ImageSY($wm)-20, 0, 0, ImageSX($wm), ImageSY($wm));*/
	$imSX = ImageSX($im);
	$imSY = ImageSY($im);
	$wmSX = ImageSX($wm);
	$wmSY = ImageSY($wm);
	for ($xx = 0; $xx <= $imSX; $xx = $xx + $wmSX)
	{
		for ($yy = 0; $yy <= $imSY; $yy = $yy + $wmSY)
		{
			imagecopy($im, $wm, $xx, $yy, 0, 0, ImageSX($wm), ImageSY($wm));
		}
	}
	
	save_image_type($im, $imgNew, $type, $quality);
	
	imagedestroy($im);
	imagedestroy($wm);
	
	return true;
}

# объединение фотографий [массив объединяемых файлов], [новый файл], [качество]
function edit_image_merge($imgMaskA = array(), $imgNew = false, $quality = 100)
{
	if ( count($imgMaskA) < 2 ) return false;
	
	$imgBG = array_shift($imgMaskA);

	list($res, $type) = edit_image_check_type($imgBG);
	
	$srcWidth = ImageSX($res);
	$srcHeight = ImageSY($res);

	foreach($imgMaskA as $imgI)
	{
		if (is_file($imgI)) 
		{
			list($mask, $type_mask) = edit_image_check_type($imgI);  
			imagecopy($res, $mask, 0, 0, 0, 0, $srcWidth, $srcHeight);
		}
	}
	
	save_image_type($res, $imgNew, $type, $quality);
	
	imagedestroy($res);
	imagedestroy($mask);
	
	return true;
}

# вписать изображение в рамку [исходный файл], [новый файл], [ширина], [высота], [качество]
function edit_image_resize_fixed( $imgname, $outfile, $neww = 220, $newh = 220, $quality = 100)
{
	list($im, $type) = edit_image_check_type($imgname);

	$size = getimagesize( $imgname );
	
	$width_orig = $size[0];
	$height_orig = $size[1];

	$ratio_orig = $width_orig/$height_orig;
   
	if ( $neww/$newh > $ratio_orig ) {
	   $new_height = $neww/$ratio_orig;
	   $new_width = $neww;
	} else {
	   $new_width = $newh*$ratio_orig;
	   $new_height = $newh;
	}

	$ky = 0.5;
	$kx = 0.5;
	$x_mid = $new_width*$kx;  
	$y_mid = $new_height*$ky;
   
	$process = imagecreatetruecolor(round($new_width), round($new_height));
	$thumb = imagecreatetruecolor($neww, $newh);
	
	imagefill($process, 0, 0, 0xffffff); 
	imagefill($thumb, 0, 0, 0xffffff); 

	imagecopyresampled($process, $im, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
	imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($neww*$kx)), ($y_mid-($newh*$ky)), $neww, $newh, $neww, $newh);
   
	save_image_type($thumb, $outfile, $type, $quality);

	imagedestroy($process);
	imagedestroy($im);
   
	return true;
}

# вписать изображение в рамку, сохранив соотношение сторон исходного изображения [исходный файл], [новый файл], [ширина], [высота], [качество]
function edit_image_resize($imgDir, $imgNew, $new_width = 220, $new_height = 220, $quality = 100)
{
	list($srcImage, $type) = edit_image_check_type($imgDir);
	
	$srcWidth = ImageSX($srcImage);
	$srcHeight = ImageSY($srcImage);
	
	$ratioWidth = $srcWidth/$new_width;
	$ratioHeight = $srcHeight/$new_height;
	
	if ($srcWidth <= $new_width and $srcHeight <= $new_height) 
	{
		copy($imgDir, $imgNew);
		return true;
	}
	
	if( $ratioWidth < $ratioHeight)
	{
		$destWidth = $srcWidth/$ratioHeight;
		$destHeight = $new_height;
	}
	else
	{
		$destWidth = $new_width;
		$destHeight = $srcHeight/$ratioWidth;
	}
	
	$destImage = ImageCreateTrueColor($destWidth, $destHeight);
	ImageCopyResampled($destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);

	save_image_type($destImage, $imgNew, $type, $quality);
	
	ImageDestroy($srcImage);
	ImageDestroy($destImage);
	
	return true;
}

# прочие методы

function edit_image_check_type($img = false)
{
	$size = getimagesize( $img );

	switch($size["mime"]){

		case "image/jpeg":
			$res = imagecreatefromjpeg($img); //jpeg file
			$type = 'jpeg';
		case "image/jpg":
			$res = imagecreatefromjpeg($img); //jpeg file
			$type = 'jpeg';
		break;
	   
		case "image/gif":
			$res = imagecreatefromgif($img); //gif file
			$type = 'gif';
		break;
	   
		case "image/png":
			$res = imagecreatefrompng($img); //png file
			$type = 'png';
		break;
		
		case "image/bmp":
			$res = imagecreatefrombmp($img); //bmp file
			$type = 'jpeg';
		break;
	   
		default:
			return array(false, false);
		break;
	}
	return array($res, $type);
}

function save_image_type($img = false, $imgNew, $type, $quality)
{
	if ($type !== 'jpeg') $quality = ($quality / 100)*9;
	$func = 'image'.$type;
	$func($img, $imgNew, $quality);
	chmod($imgNew, 0777);
}

if (!function_exists("imagecreatefrombmp")) {
    function imagecreatefrombmp( $filename ) {
        $file = fopen( $filename, "rb" );
        $read = fread( $file, 10 );
        while( !feof( $file ) && $read != "" )
        {
            $read .= fread( $file, 1024 );
        }
        $temp = unpack( "H*", $read );
        $hex = $temp[1];
        $header = substr( $hex, 0, 104 );
        $body = str_split( substr( $hex, 108 ), 6 );
        if( substr( $header, 0, 4 ) == "424d" )
        {
            $header = substr( $header, 4 );
            // Remove some stuff?
            $header = substr( $header, 32 );
            // Get the width
            $width = hexdec( substr( $header, 0, 2 ) );
            // Remove some stuff?
            $header = substr( $header, 8 );
            // Get the height
            $height = hexdec( substr( $header, 0, 2 ) );
            unset( $header );
        }
        $x = 0;
        $y = 1;
        $image = imagecreatetruecolor( $width, $height );
        foreach( $body as $rgb )
        {
            $r = hexdec( substr( $rgb, 4, 2 ) );
            $g = hexdec( substr( $rgb, 2, 2 ) );
            $b = hexdec( substr( $rgb, 0, 2 ) );
            $color = imagecolorallocate( $image, $r, $g, $b );
            imagesetpixel( $image, $x, $height-$y, $color );
            $x++;
            if( $x >= $width )
            {
                $x = 0;
                $y++;
            }
        }
        return $image;
    }
}
