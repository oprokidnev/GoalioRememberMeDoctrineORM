<?php
return [
    'goaliorememberme'          => [
        'remember_me_entity_class' => 'GoalioRememberMeDoctrineORM\Entity\RememberMe', // 'GoalioRememberMeDoctrineORM\Document\RememberMe'
    ],
    /**
     * Doctrine configuration
     */
    'doctrine' => array(
        'driver' => array(
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
    ),
];
