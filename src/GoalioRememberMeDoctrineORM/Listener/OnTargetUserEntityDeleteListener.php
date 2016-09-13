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

namespace GoalioRememberMeDoctrineORM\Listener;

/**
 * Description of OnTargetUserEntityDeleteListener
 *
 * @author oprokidnev
 */
class OnTargetUserEntityDeleteListener implements \Doctrine\Common\EventSubscriber
{

    /**
     *
     * @var string
     */
    protected $targetClass = null;

    /**
     *
     * @var callable:\Doctrine\Common\Persistence\ObjectRepository
     */
    protected $rememberMeRepositoryProvider = null;

    /**
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \static
     */
    public static function createViaServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $targetClass                  = $serviceLocator->get('config')['zfcuser']['user_entity_class'];
        $rememberMeRepositoryProvider = function () use ($serviceLocator) {
            static $rememberMeRepository = null;
            if ($rememberMeRepository === null) {
                $rememberMeObjectManager = $serviceLocator->get($serviceLocator->get('config')['goaliorememberme_doctrine'] ['object_manager']);
                if ($rememberMeObjectManager instanceof \Doctrine\ORM\EntityManager) {
                    $rememberMeRepository = $rememberMeObjectManager->getRepository(\GoalioRememberMeDoctrineORM\Entity\RememberMe::class);
                } elseif ($rememberMeObjectManager instanceof \Doctrine\ODM\MongoDB\DocumentManager) {
                    $rememberMeRepository = $rememberMeObjectManager->getRepository(\GoalioRememberMeDoctrineORM\Document\RememberMe::class);
                }
            }
            return $rememberMeRepository;
        };
        return new static($targetClass, $rememberMeRepositoryProvider);
    }

    protected function getRememberMeRepository()
    {
        return call_user_func($this->rememberMeRepositoryProvider);
    }

    public function __construct($targetClass, $rememberMeRepositoryProvider)
    {
        $this->targetClass                  = $targetClass;
        $this->rememberMeRepositoryProvider = $rememberMeRepositoryProvider;
    }

    /**
     * 
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function preRemove(\Doctrine\Common\Persistence\Event\LifecycleEventArgs $args)
    {
        $objectManager = $args->getObjectManager();

        $entity = $args->getObject();

        if (is_a($entity, $this->targetClass, true)) {
            $ids = $objectManager->getMetadataFactory()->getMetadataFor(\Doctrine\Common\Util\ClassUtils::getClass($entity))
                ->getIdentifierValues($entity);

            $this->removeRememberMeByUserId(current(array_values($ids)));
        }
    }

    protected function removeRememberMeByUserId($userId)
    {
        $rememberMeEntries = $this->getRememberMeRepository()->findBy([
            'userId' => $userId,
        ]);

        foreach ($rememberMeEntries as $rememberMeEntry) {
            $this->getRememberMeRepository()
                ->remove($rememberMeEntry);
        }
    }

    /**
     * Mongodb preRemove listener
     * @param \Doctrine\ODM\MongoDB\SoftDelete\Event\LifecycleEventArgs $args
     */
    public function preSoftDelete(\Doctrine\ODM\MongoDB\SoftDelete\Event\LifecycleEventArgs $args)
    {
        $sdm           = $args->getSoftDeleteManager();
        $objectManager = $sdm->getDocumentManager();

        $document = $args->getDocument();
        if (is_a($document, $this->targetClass, true)) {
            $ids = $objectManager->getMetadataFactory()->getMetadataFor(\Doctrine\Common\Util\ClassUtils::getClass($document))
                ->getIdentifierValues($document);

            $this->removeRememberMeByUserId(current(array_values($ids)));
        }
    }

    public function getSubscribedEvents()
    {
        /**
         * Initializa only if target user object is set.
         */
        if ($this->targetClass !== null) {
            return [
                'preRemove',
                'preSoftDelete'
            ];
        }
    }
}
