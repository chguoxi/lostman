<?php
/**
 * user region action
 * @author goss, <goss@lunluoren.com>
 */
class BASE_CTRL_Region extends OW_ActionController {
	public function index(){

		$sql = 'SELECT * FROM `ls_base_city`';
		$data = BOL_CityDao::getInstance()->getAllCities();
		var_dump($data);
		exit;
	}
	
	public function pykey( $py_key)
	{
		$pinyin = 65536 + $this->pys($py_key);
		if ( 45217 <= $pinyin && $pinyin <= 45252 )
		{
			return "A";
		}
		if ( 45253 <= $pinyin && $pinyin <= 45760 )
		{
			return "B";
		}
		if ( 45761 <= $pinyin && $pinyin <= 46317 )
		{
			return "C";
		}
		if ( 46318 <= $pinyin && $pinyin <= 46825 )
		{
			return "D";
		}
		if ( 46826 <= $pinyin && $pinyin <= 47009 )
		{
			return "E";
		}
		if ( 47010 <= $pinyin && $pinyin <= 47296 )
		{
			return "F";
		}
		if ( 47297 <= $pinyin && $pinyin <= 47613 )
		{
			return "G";
		}
		if ( 47614 <= $pinyin && $pinyin <= 48118 )
		{
			return "H";
		}
		if ( 48119 <= $pinyin && $pinyin <= 49061 )
		{
			return "J";
		}
		if ( 49062 <= $pinyin && $pinyin <= 49323 )
		{
			return "K";
		}
		if ( 49324 <= $pinyin && $pinyin <= 49895 )
		{
			return "L";
		}
		if ( 49896 <= $pinyin && $pinyin <= 50370 )
		{
			return "M";
		}
		if ( 50371 <= $pinyin && $pinyin <= 50613 )
		{
			return "N";
		}
		if ( 50614 <= $pinyin && $pinyin <= 50621 )
		{
			return "O";
		}
		if ( 50622 <= $pinyin && $pinyin <= 50905 )
		{
			return "P";
		}
		if ( 50906 <= $pinyin && $pinyin <= 51386 )
		{
			return "Q";
		}
		if ( 51387 <= $pinyin && $pinyin <= 51445 )
		{
			return "R";
		}
		if ( 51446 <= $pinyin && $pinyin <= 52217 )
		{
			return "S";
		}
		if ( 52218 <= $pinyin && $pinyin <= 52697 )
		{
			return "T";
		}
		if ( 52698 <= $pinyin && $pinyin <= 52979 )
		{
			return "W";
		}
		if ( 52980 <= $pinyin && $pinyin <= 53640 )
		{
			return "X";
		}
		if ( 53689 <= $pinyin && $pinyin <= 54480 )
		{
			return "Y";
		}
		if ( 54481 <= $pinyin && $pinyin <= 62289 )
		{
			return "Z";
		}
		return $py_key;
	}
	
	public function pys( $pysa )
	{
	$pyi = "";
	$i= 0;
	for ( ; $i < strlen( $pysa ); $i++)
	{
	$_obfuscate_8w= ord( substr( $pysa,$i,1) );
	if ( 160 < $_obfuscate_8w)
	{
	$_obfuscate_Bw = ord( substr( $pysa, $i++, 1 ) );
	$_obfuscate_8w = $_obfuscate_8w * 256 + $_obfuscate_Bw - 65536;
	}
	$pyi.= $_obfuscate_8w;
	}
	return $pyi;
	} 
}
