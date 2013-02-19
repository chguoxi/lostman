<?php
/**
 * user region action
 * @author goss, <goss@lunluoren.com>
 */
class BASE_CTRL_Region extends OW_ActionController {
	public function index(){
		
		$data = BOL_AreaDao::getInstance()->findAll();
		print_r($data);
		exit;
	}
}
