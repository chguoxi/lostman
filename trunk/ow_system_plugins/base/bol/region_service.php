<?php
class region_service {
	/**
	 * province dao class
	 * @var BOL_Province
	 */
	private $provinceDao;
	
	/**
	 * city dao class
	 * @var object
	 */
	private $cityDao;
	
	/**
	 * area dao class
	 * @var object
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
}