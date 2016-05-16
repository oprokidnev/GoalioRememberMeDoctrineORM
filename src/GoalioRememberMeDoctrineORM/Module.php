<?php

namespace GoalioRememberMeDoctrineORM;

use Zend\ModuleManager\Feature;
use Users\View\Helper\SectionMenu;
use Zend\Authentication\AuthenticationService;

class Module
{

    public function getDir()
    {
        return __DIR__;
    }

    public function getConfig()
    {
        return include $this->getDir() . '/../../config/module.config.php';
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    protected $moduleEnvironment = [];

    /**
     * 
     * @param \Zend\ModuleManager\ModuleManager $moduleManager
     */
    public function init(\Zend\ModuleManager\ModuleManager $moduleManager)
    {
        $this->moduleEnvironment = $moduleManager->getModules();
        $moduleManager->getEventManager()->attach(\Zend\ModuleManager\ModuleEvent::EVENT_MERGE_CONFIG, [$this, 'onMergeConfig']);
    }

    /**
     * 
     * @param \Zend\ModuleManager\ModuleEvent $event
     */
    public function onMergeConfig(\Zend\ModuleManager\ModuleEvent $event)
    {
        $configListener = $event->getConfigListener();
        $unmerged       = $configListener->getMergedConfig(false);
        
        /**
         * Use doctrine odm or doctrine orm.
         */
        if (in_array(\DoctrineORMModule::class, $this->moduleEnvironment)) {
            $configListener->setMergedConfig(\Zend\Stdlib\ArrayUtils::merge($configListener->getMergedConfig(false), require $this->getDir() . '/../../config/doctrine.orm.php'));
        }

        if (in_array(\DoctrineMongoODMModule::class, $this->moduleEnvironment) && stristr($unmerged['goaliorememberme_doctrine']['object_manager'], 'document')) {
            $configListener->setMergedConfig(\Zend\Stdlib\ArrayUtils::merge($configListener->getMergedConfig(false), require $this->getDir() . '/../../config/doctrine.odm.php'));
        }
    }

}
