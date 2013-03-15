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
		$this->assign('regionCss', OW::getPluginManager()->getPlugin('base')->getStaticCssUrl().'kube.css'.'?' . OW::getConfig()->getValue('base', 'cachedEntitiesPostfix'));
		$this->assign('jqueryLib', OW::getPluginManager()->getPlugin('base')->getStaticJsUrl().'jquery-1.7.1.min.js'.'?' . OW::getConfig()->getValue('base', 'cachedEntitiesPostfix'));
		echo $this->render();
		$this->init();
		exit;
	}
	
	public function init(){
		$document = OW::getDocument();
		$document->addStyleSheet(OW::getPluginManager()->getPlugin('base')->getStaticCssUrl().'kube.css'.'?' . OW::getConfig()->getValue('base', 'cachedEntitiesPostfix'), 'all', -100);
		$this->setTemplate(OW::getPluginManager()->getPlugin('base')->getCtrlViewDir() . 'region_index.html');
	}
}
