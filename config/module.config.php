<?php

/*
 * Copyright (c) 2015-2016 Andrey Oprokidnev
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and
 * to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

return [
    'service_manager'=>[
        'factories'=>[
            'goaliorememberme_rememberme_mapper'=>[\GoalioRememberMeDoctrineORM\Mapper\RememberMe::class, 'createViaServiceLocator'],
             \GoalioRememberMeDoctrineORM\Options\ModuleOptions::class => [\GoalioRememberMeDoctrineORM\Options\ModuleOptions::class, 'createViaServiceLocator'],
            \GoalioRememberMeDoctrineORM\Listener\OnTargetUserEntityDeleteListener::class=>[\GoalioRememberMeDoctrineORM\Listener\OnTargetUserEntityDeleteListener::class, 'createViaServiceLocator'],
        ],
    ],
    'doctrine'=>[
        'eventmanager' => [
            'odm_default' => [
                'subscribers' => [
                    \GoalioRememberMeDoctrineORM\Listener\OnTargetUserEntityDeleteListener::class,
                ],
            ],
            'orm_default' => [
                'subscribers' => [
                    \GoalioRememberMeDoctrineORM\Listener\OnTargetUserEntityDeleteListener::class,
                ],
            ],
        ],
    ],
    'goaliorememberme_doctrine' => [
        'object_manager' => 'doctrine.entitymanager.orm_default',
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
        'auth_adapters' => [50 => 'GoalioRememberMe\Authentication\Adapter\Cookie'],
    ],
];
