<?php
class BOL_ProvinceDao extends OW_BaseDao
{
	const PROVINCEID = 'provinceID';
	//省份名称
	const PROVINCE   = 'province';
	//是否直辖市字段
	const IS_MUNICITY = 'isMuniCity';

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
		return 'BOL_ProvinceDao';
	}
	
	/**
	 * 获取当前数据表名
	 * @see OW_BaseDao::getTableName()
	 */
	public function getTableName()
	{
		return OW_DB_PREFIX . 'base_province';
	}
	
	/**
	 * 获取所有省份(直辖市除外)和对应省份的城市
	 * @return array;
	 */
	public function getAllProvincesWithCity(){
		
		$sql = "SELECT * FROM `".$this->getTableName()."` WHERE ".self::IS_MUNICITY." !=1";
		
		$provinces = $this->dbo->queryForList($sql);
		
		foreach ($provinces as $key=>$province){
			$provinces[$key]['cities'] =  $this->getProvinceCities($province['provinceID']);
		}
		
		return $provinces;
	}
	
	/**
	 * 获取指定省份下所有的城市
	 * @param integer $provinceid
	 */
	public function getProvinceCities($provinceid){
		$sql = "SELECT * FROM `".BOL_CityDao::getInstance()->getTableName()."` WHERE fatherID =$provinceid ;";
		return $this->dbo->queryForList($sql);
	}
	
	/**
	 * 获取直辖市
	 */
	public function getMuniCities(){
		$sql = "SELECT * FROM `".BOL_ProvinceDao::getInstance()->getTableName()."` WHERE isMuniCity=1";
		$muni_cities = $this->dbo->queryForList($sql);
		foreach ($muni_cities as $key=>$city){
			$muni_cities[$key]['city'] = $city['province'];
			$muni_cities[$key]['cityID'] = $city['provinceID'];
			unset($muni_cities[$key]['province']);
			unset($muni_cities[$key]['provinceID']);
		}
		return $muni_cities;
	}
}