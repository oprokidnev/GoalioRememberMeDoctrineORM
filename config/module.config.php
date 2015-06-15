<?php

$moduleName = basename(dirname(__DIR__));
return array(
    'goaliorememberme' => [

        /**
         * RememberMe Model Entity Class
         *
         * Name of Entity class to use. Useful for using your own entity class
         * instead of the default one provided. Default is ZfcUser\Entity\User.
         */
        'remember_me_entity_class' => 'GoalioRememberMeDoctrineORM\Entity\RememberMe',
        /**
         * Remember me cookie expire time
         *
         * How long will the user be remembered for, in seconds?
         *
         * Default value: 2592000 seconds = 30 days
         * Accepted values: the number of seconds the user should be remembered
         */
        'cookie_expire'            => 2592000,
        /**
         * Remember me cookie domain
         *
         * Default value: null (current domain)
         * Accepted values: a string containing the domain (example.com), subdomains (sub.example.com) or the all subdomains qualifier (.example.com)
         */
        'cookie_domain'            => null,
    /**
     * End of GoalioRememberMe configuration
     */
    ],
    'zfcuser'          => [
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
    'doctrine'         => array(
        'driver'        => array(
            'goalio_remember_me_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/GoalioRememberMeDoctrineORM/Entity'),
            ),
            'orm_default'                          => array(
                'drivers' => array(
                    'GoalioRememberMeDoctrineORM\Entity' => 'goalio_remember_me_annotation_driver',
                ),
            ),
        ),
        'eventmanager'  => array(
            'orm_default' => array(
                'subscribers' => array(
                    'Gedmo\Timestampable\TimestampableListener',
                    'Gedmo\SoftDeleteable\SoftDeleteableListener',
                ),
            ),
        ),
        'configuration' => array(
            'orm_default' => array(
                'string_functions' => array(
                    'MD5' => '' . $moduleName . '\Doctrine\Md5'
                ),
            ),
        ),
    ),
);
