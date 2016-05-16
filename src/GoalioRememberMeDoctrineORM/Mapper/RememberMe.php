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

namespace GoalioRememberMeDoctrineORM\Mapper;

class RememberMe extends \ZfcBase\Mapper\AbstractDbMapper
{

    public static function createViaServiceLocator($serviceLocator)
    {
        $moduleConfig  = $serviceLocator->get(\GoalioRememberMeDoctrineORM\Options\ModuleOptions::class);
        $objectManager = $serviceLocator->get($moduleConfig->getObjectManager());

        $rememberOptions = $serviceLocator->get('goaliorememberme_module_options');

        return new static($objectManager, $rememberOptions);
    }

    protected $objectManager     = null;
    protected $rememberMeOptions = null;

    public function __construct(\Doctrine\Common\Persistence\ObjectManager $objectManager, \GoalioRememberMe\Options\ModuleOptions $rememberMeOptions)
    {
        list($this->objectManager, $this->rememberMeOptions) = [$objectManager, $rememberMeOptions];
        if ($objectManager instanceof \Doctrine\ORM\EntityManager) {
            $this->setEntityPrototype(new \GoalioRememberMeDoctrineORM\Entity\RememberMe);
        } elseif ($objectManager instanceof \Doctrine\ODM\MongoDB\DocumentManager) {
            $this->setEntityPrototype(new \GoalioRememberMeDoctrineORM\Document\RememberMe);
        }

        $this->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());

        return $this;
    }

    public function setEntityPrototype($entityPrototype)
    {
        $this->entityPrototype    = $entityPrototype;
        $this->resultSetPrototype = null;
        return $this;
    }

    protected $objectRepository = null;

    protected function getRepository()
    {
        if ($this->objectRepository === null) {
            $this->objectRepository = $this->objectManager->getRepository($this->getMappedObjectClass());
        }
        return $this->objectRepository;
    }

    protected $mappedObjectClass = null;

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getMappedObjectClass()
    {
        if ($this->mappedObjectClass === null) {
            $this->mappedObjectClass = get_class($this->entityPrototype);
        }
        return $this->mappedObjectClass;
    }

    public function findById($userId)
    {
        $select = $this->getSelect()
            ->where(['user_id' => $userId]);

        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, ['entity' => $entity]);
        return $entity;
    }

    public function findByIdSerie($userId, $serieId)
    {
        $em = $this->objectManager;

        $entity = $this->getRepository()->findOneBy([
            'userId' => $userId,
            'sid'    => $serieId,
        ]);

        return $entity;
    }

    public function updateSerie($entity)
    {
        $em = $this->objectManager;

        $em->persist($entity);
        $em->flush($entity);

        return $this;
    }

    public function createSerie($entity)
    {
        $em = $this->objectManager;

        $em->persist($entity);
        $em->flush($entity);

        return $this;
    }

    public function removeAll($userId)
    {
        $em       = $this->objectManager;
        $entities = $this->getRepository()->findBy([
            'userId' => $userId,
        ]);
        foreach ($entities as $entity) {
            $em->remove($entity);
        }
        $em->flush($entity);
        return $this;
    }

    public function remove($entity)
    {
        $em = $this->objectManager;
        $em->remove($entity);
        $em->flush($entity);
        return $this;
    }

    /**
     * 
     * @param type $userId
     * @param type $serieId
     * @return \GoalioRememberMeDoctrineORM\Mapper\RememberMe
     */
    public function removeSerie($userId, $serieId)
    {
        $em     = $this->objectManager;
        $entity = $this->findByIdSerie($userId, $serieId);

        $entity = $this->getRepository()->findOneBy([
            'userId' => $userId,
            'sid'    => $serieId,
        ]);
        if ($entity) {
            $em->remove($entity);
            $em->flush($entity);
        }

        return $this;
    }
}
