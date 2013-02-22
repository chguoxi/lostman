<?php
class BOL_RegionService {

	/**
	 * 
	 * @var BOL_VoteService
	 */
	private static $classInstance;
	
	/**
	 * Returns an instance of class (singleton pattern implementation).
	 *
	 * @return BOL_VoteService
	 */
	public static function getInstance()
	{
		if ( self::$classInstance === null )
		{
			self::$classInstance = new self();
		}
	
		return self::$classInstance;
	}
	
	/**
	 * get all provinces
	 */
	public function getAllProvinces(){
		$sql = 'SELECT * FROM `'.BOL_ProvinceDao::getInstance()->getTableName().'`';
		return BOL_ProvinceDao::getInstance()->queryForList($sql);
	}
	
	/**
	 * get all cities
	 */
	public function getAllCities(){
		$sql = 'SELECT * FROM `'.BOL_CityDao::getInstance()->getTableName().'`';
		return BOL_CityDao::getInstance()->queryForList($sql);
	}
	
	/**
	 * get one province citys
	 */
	public function getProvinceCitys($provinceid){
		$sql = 'SELECT * FROM `'.BOL_CityDao::getInstance()->getTableName().'` WHERE fatherID='.$provinceid;
		return BOL_CityDao::getInstance()->queryForList($sql);
	}
}