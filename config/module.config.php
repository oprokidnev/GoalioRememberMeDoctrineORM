<?php

return array(
    'service_manager'=>[
        'factories'=>[
            'goaliorememberme_rememberme_mapper'=>[\GoalioRememberMeDoctrineORM\Mapper\RememberMe::class, 'createViaServiceLocator'],
             \GoalioRememberMeDoctrineORM\Options\ModuleOptions::class => [\GoalioRememberMeDoctrineORM\Options\ModuleOptions::class, 'createViaServiceLocator'],
        ],
    ],
    'goaliorememberme_doctrine' => [
        'object_manager' => 'doctrine.entity_manager.orm_default',
    ],
    'zfcuser'                   => [
        /**
         * Authentication Adapters
         *
         * Specify the adapters that will be used to try and authenticate the user
         *
         * Default value: array containing 'ZfcUser\Authentication\Adapter\Db'
         * Accepted values: array containing services that implement 'ZfcUser\Authentication\Adapter\ChainableAdapter'
         */
        'auth_adapters' => array(50 => 'GoalioRememberMe\Authentication\Adapter\Cookie'),
    ],
);
