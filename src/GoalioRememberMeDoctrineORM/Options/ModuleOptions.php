<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GoalioRememberMeDoctrineORM\Options;

/**
 * Description of newPHPClass
 *
 * @author oprokidnev
 */
class ModuleOptions extends \Zend\Stdlib\AbstractOptions
{
    /**
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \static
     */
    public static function createViaServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator){
        $config = $serviceLocator->get('config');
        return new static(isset($config['goaliorememberme_doctrine']) ? $config['goaliorememberme_doctrine'] : array());
    }

    protected $objectManager;
    protected $targetModel;
    
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    public function setObjectManager($objectManager)
    {
        $this->objectManager = $objectManager;
        return $this;
    }

    public function getTargetModel()
    {
        return $this->targetModel;
    }

    public function setTargetModel($targetModel)
    {
        $this->targetModel = $targetModel;
        return $this;
    }



}
