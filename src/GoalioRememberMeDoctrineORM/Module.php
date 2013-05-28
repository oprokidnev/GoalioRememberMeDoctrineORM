<?php

namespace GoalioRememberMeDoctrineORM;

use Zend\ModuleManager\Feature;
use Users\View\Helper\SectionMenu;
use Zend\Authentication\AuthenticationService;

class Module extends \WmBase\Module\AbstractModule
    implements Feature\ServiceProviderInterface
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

    public function init()
    {
        $namespace = 'Gedmo\Mapping\Annotation';
        $lib = 'vendor/gedmo/doctrine-extensions/lib';
        \Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace($namespace,
            $lib);
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'doctrine_dm' => 'doctrine.entitymanager.orm_default',
            ),
            'factories' => array(
                'goaliorememberme_rememberme_mapper' => function ($sm) {
                    $options = $sm->get('zfcuser_module_options');
                    $rememberOptions = $sm->get('goaliorememberme_module_options');
                    $mapper = new \GoalioRememberMeDoctrineORM\Mapper\RememberMe;
                    $mapper->setServiceManager($sm);
                    // $mapper->setDbAdapter($sm->get('zfcuser_zend_db_adapter'));
                    $entityClass = $rememberOptions->getRememberMeEntityClass();
                    $mapper->setEntityPrototype(new $entityClass);
                    
                    $mapper->setHydrator(new \GoalioRememberMe\Mapper\RememberMeHydrator());
                    
                    return $mapper;
                },
            ),
        );
    }

    /**
     * 
     * @return array
     */
    public function getAutoloaderConfig()
    {
       return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
           
        ];
    }

}
