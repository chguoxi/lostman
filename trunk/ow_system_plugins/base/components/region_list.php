<?php

class BASE_CMP_RegionList extends OW_Component {
	
	public function __construct(){
		$regionServiceInstance = BOL_RegionService::getInstance();
		$mainCities = $regionServiceInstance->getMainCities();
		$provinces   = $regionServiceInstance->getAllProvinces();
		$this->assign('mainCities', $mainCities);
		$this->assign('provinces', $provinces);
		$this->render();
	}
}