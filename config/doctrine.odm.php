<?php

namespace GoalioRememberMeDoctrineORM;

return [
    'goaliorememberme'          => [
        'remember_me_entity_class' => 'GoalioRememberMeDoctrineORM\Document\RememberMe', // 'GoalioRememberMeDoctrineORM\Document\RememberMe'
    ],
    /**
     * Doctrine configuration
     */ 
    'doctrine' => [
        'driver' => [
            Mongo::class  => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Document',
            ),
            'odm_default' => array(
                'drivers' => array(
                    Document::class => Mongo::class,
                ),
            ),
        ],
    ],
];
