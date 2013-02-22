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
}
