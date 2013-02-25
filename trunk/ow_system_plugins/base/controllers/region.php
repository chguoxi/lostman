<?php
/**
 * user region action
 * @author goss, <goss@lunluoren.com>
 */
class BASE_CTRL_Region extends OW_ActionController {
	
	public function index(){
		$regionServiceInstance = BOL_RegionService::getInstance();
		
		$cities = $regionServiceInstance->getMainCities();
		$this->setTemplate(OW::getPluginManager()->getPlugin('base')->getCtrlViewDir() . 'region_index.html');
		$this->addComponent('region', new BASE_CMP_RegionList());
		$this->render();
		//exit;
	}
}
