<?php

class BOL_AreaDao extends OW_BaseDao
{
    const AREA_ID = 'areaID';
    const AREA    = 'area';
    const FATHER_ID = 'fatherID';
    
    private static $classInstance;
    
    /**
     * 实例化模型
     * 享元模式
     */
    public function getInstance(){
        if (self::$classInstance===null){
            self::$classInstance = new self();
        }
        return self::$classInstance;
    }
    
    protected function __construct(){
        parent::__construct();
    }
    
    public function getDtoClassNmae(){
        return 'BOL_AreaDao';
    }
    
    public function getTableName(){
        return OW_DB_PREFIX . 'base_area'; 
    }
    
    public function findAreasByCity(int $cityid){
        return $this->findAll('cityID='.$cityid);
    }
}
