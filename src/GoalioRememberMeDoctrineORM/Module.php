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

namespace GoalioRememberMeDoctrineORM;

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
