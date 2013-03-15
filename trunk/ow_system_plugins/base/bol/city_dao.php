<?php

class BOL_CityDao extends OW_BaseDao 
{
	const CITYID = 'cityID';
	const CITY   = 'city';
	const FATHERID = 'fatherID';

	/**
	 * @var BOL_ProvinceDao
	 */
	private static $classInstance;
	
    public static function getInstance()
    {
        if (self::$classInstance===null){
            self::$classInstance = new self();
        }
        return self::$classInstance;
    }
    
    protected function __construct()
    {
    	parent::__construct();
    }
    
    /**
     * 获取类名
     * @see OW_BaseDao::getDtoClassName()
     */
    public function getDtoClassName()
    {
    	return 'BOL_CityDao';
    }
    
    /**
     * 获取当前数据表名
     * @see OW_BaseDao::getTableName()
     */
    public function getTableName()
    {
    	return OW_DB_PREFIX .'base_city';
    }
    
    /**
     * 获取所有城市
     */
    public function getAllCities(){
    	//获取普通城市
    	$sql = 'SELECT * FROM `'.$this->getTableName(). '`';
    	$general_cities = $this->dbo->queryForList($sql);
    	//获取直辖市
    	$muni_cities = BOL_ProvinceDao::getInstance()->getMuniCities();
    	return array_merge($general_cities,$muni_cities);
    }
    
    /**
     * 获取主要城市
     */
    public function getMainCities(){
    	//主要城市
    	$sql = 'SELECT `id`,`provinceID` as `cityID`,`province` as `city`,`isMuniCity` as `isImpCity` ,`priority`
    	FROM `ls_base_province` WHERE `isMuniCity`=1  UNION 
    	SELECT  `id`, `cityID`,`city` ,`isImpCity`, `priority` FROM `ls_base_city` WHERE `isMainCity`=1 ORDER BY `priority` DESC';
    	$main_cities = $this->dbo->queryForList($sql);
    	//直辖市
    	//$muni_cities = BOL_ProvinceDao::getInstance()->getMuniCities();
    	return $main_cities;
    }
}

?>