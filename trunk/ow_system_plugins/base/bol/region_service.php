<?php
class BOL_RegionService {
	/**
	 * @var BOL_ProvindDao
	 */
	private $provinceDao;
	
	/**
	 * @var BOL_CityDao
	 */
	private $cityDao;
	
	/**
	 * @var BOL_AreaDao
	 */
	private $areaDao;
	
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
	
	public function __construct(){
		$this->provinceDao = BOL_ProvindDao::getInstance();
		$this->cityDao     = BOL_CityDao::getInstance();
		$this->areaDao     = BOL_AreaDao::getInstance();
	}
	
	/**
	 * get all provinces
	 */
	public function getAllProvinces(){
		return $this->provinceDao->findAll();
	}
	
	/**
	 * get all cities
	 */
	public function getAllCities(){
		return $this->cityDao->findAll();
	}
	
	/**
	 * get one province citys
	 */
	public function getProvinceCitys(int $provinceid){
		//return $this->cityDao->
	}
}