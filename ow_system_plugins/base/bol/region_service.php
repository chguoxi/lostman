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
		return BOL_ProvinceDao::getInstance()->getAllProvincesWithCity();
	}
	
	/**
	 * get all cities
	 */
	public function getAllCities(){
		return BOL_CityDao::getInstance()->getAllCities();
	}
	
	/**
	 * get main cities 
	 */
	public function getMainCities(){
		$cities = BOL_CityDao::getInstance()->getMainCities();
		$cities = $this->cityClassify($cities);
		ksort($cities);
		return $cities;
	}
	
	/**
	 * cities classify with the first char
	 * @param unknown_type $cities
	 */
	public function cityClassify($cities){
		$classifyCities = array();
		foreach ($cities as $key=>$city){
			if ($city[BOL_CityDao::CITYID]==500000){
				$classifyCities["C"][] = $city;
			}
			else{
				$cityFirstChar = BASE_CLASS_Pinyin::getFirstChar($city['city']);
				$cityFirstChar = ucfirst($cityFirstChar);
				$classifyCities["$cityFirstChar"][] = $city;
			}
		}
		return $classifyCities;
	}
	
	
}