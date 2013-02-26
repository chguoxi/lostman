<?php
/**
 * user region action
 * @author goss, <goss@lunluoren.com>
 */
class BASE_CTRL_Region extends OW_ActionController {
	
	public function index(){
		header('Content-type:text/html;Charset=utf-8');
		$regionServiceInstance = BOL_RegionService::getInstance();
		
		$mainCities = $regionServiceInstance->getMainCities();
		$provinces = $regionServiceInstance->getAllProvinces();
		
		$this->assign('mainCities', $mainCities);
		$this->assign('provinces', $provinces);
// 		OW_RequestHandler::getInstance()->dispatch();
// 		debug_print_backtrace();
	}
	
	public function init(){
		$this->setTemplate(OW::getPluginManager()->getPlugin('base')->getCtrlViewDir() . 'region_index.html');
	}
}
