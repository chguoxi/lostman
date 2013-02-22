<?php

class BOL_AreaDao extends OW_BaseDao
{
    const AREA_ID = 'areaID';
    const AREA    = 'area';
    const FATHER_ID = 'fatherID';
    /**
     * @var BOL_ProvinceDao
     */
    private static $classInstance;
    
    /**
     * 实例化模型
     * 享元模式
     */
    public static function getInstance(){
        if (self::$classInstance===null){
            self::$classInstance = new self();
        }
        return self::$classInstance;
    }
    
    protected function __construct(){
        parent::__construct();
    }
    /**
     * 获取类名
     * @see OW_BaseDao::getDtoClassName()
     */
    public function getDtoClassName(){
        return 'BOL_AreaDao';
    }
    
    /**
     * 获取当前数据表名
     * @see OW_BaseDao::getTableName()
     */
    public function getTableName(){
        return OW_DB_PREFIX . 'base_area'; 
    }
    
    /**
     * 获取一个城市的所有地区
     * @param int $cityid
     */
    public function findAreasByCity($cityid){
    	$sql = 'SELECT * FROM `'.$this->getTableName().'` WHERE `fatherID` ='.$cityid;
    	return $this->dbo->queryForObjectList($sql, $this->getDtoClassName());
    }

}
?>
