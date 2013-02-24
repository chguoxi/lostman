<?php
/**
 * user region action
 * @author goss, <goss@lunluoren.com>
 */
class BASE_CTRL_Region extends OW_ActionController {
	public function index(){
		header('Content-type:text/html;Charset=utf-8');
		$cities = BOL_CityDao::getInstance()->getAllCities();
		var_dump($cities);
		exit;
	}
}
