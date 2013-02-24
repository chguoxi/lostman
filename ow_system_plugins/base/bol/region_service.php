<?php
class BOL_RegionService {

	//直辖市
	private $specialCities = array(500000,110000,120000,310000);
	//主要城市
	private $mainCities = array(210300,150200,130600,130600,220100,430100,510100,320400,430700,
			210200,441900,210600,230600,150600,350100,440600,210400,440100,520100,360700,230100,
			330100,340100,460100,150100,441300,430400,320800,330500,130400,370100,330400,330700,
			220200,440700,421000,370800,360400,530100,620100,131000,371300,410300,320700,450200,
			510700,320100,330200,360100,320600,450100,370200,350500,130300,441800,440300,210100,
			130100,320500,460200,330600,440500,140100,331000,130200,321200,211200,420100,320200,
			330300,650100,340200,370700,371000,610100,350200,320300,430300,610400,370600,321000,
			420500,320900,210800,640100,350600,410100,442000,440400,321100,430200,440800,441200,
			130700,370300
			);
	
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
		return BOL_ProvinceDao::getInstance()->getAllProvincesWithCity();
	}
	
	/**
	 * get all cities
	 */
	public function getAllCities(){
		return BOL_CityDao::getInstance()->getAllCities();
	}
	
	public function cityClassify(){
		
	}
}