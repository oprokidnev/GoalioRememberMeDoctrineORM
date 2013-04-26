<?php

$moduleName = basename(dirname(__DIR__));
return array(
    'doctrine' => array(
        'driver' => array(
            'goalio_remember_me_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/GoalioRememberMeDoctrineORM/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'GoalioRememberMeDoctrineORM\Entity' => 'goalio_remember_me_annotation_driver',
                ),
            ),
        ),
        'eventmanager' => array(
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
