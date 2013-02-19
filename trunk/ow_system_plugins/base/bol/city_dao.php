<?php

class BOL_CityDao extends OW_BaseDao 
{
	const CITYID = 'cityID';
	const CITY   = 'city';
	const FATHERID = 'fatherID';
	
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
    	return OW_DB_PREFIX . 'base_city';
    }
    
    /**
     * 根据id取得城市名称
     * @param int $cityid
     */
    public function getCityNameById(int $cityid)
    {
    	return $this->findById($cityid)->CITY;
    }
    
    /**
     * 获取指定省份的城市
     * @param int $proviceid
     */
    public function getProvinceCitys( int $proviceid )
    {
    	return BOL_ProvindDao::getInstance()->findAll(BOL_ProvindDao::PROVINCEID.'='.$proviceid);
    }
}

?>