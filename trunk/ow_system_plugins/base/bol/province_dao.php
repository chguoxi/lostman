<?php
class BOL_ProvindDao extends OW_BaseDao
{
	const PROVINCEID = 'provinceID';
	const PROVINCE   = 'province';
	
	public function getInstance()
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
		return 'BOL_ProvindDao';
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
	 * 根据省份id获取省份名称
	 * @param int $provinceid
	 */
	public function getProvinceNameById( int $provinceid )
	{
		return $this->findById($provinceid)->PROVINCE;
	}
}