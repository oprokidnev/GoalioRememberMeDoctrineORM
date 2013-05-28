<?php

namespace GoalioRememberMeDoctrineORM\Mapper;

use ZfcBase\Mapper\AbstractDbMapper,
    \ServiceLocatorFactory\ServiceLocatorFactory;

class RememberMe
{
    /**
     *
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;
    
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

        
    protected $tableName = 'user_remember_me';

    public function setEntityPrototype($entityPrototype)
    {
        $this->entityPrototype = $entityPrototype;
        $this->resultSetPrototype = null;
        return $this;
    }

    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
        $this->resultSetPrototype = null;
        return $this;
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceManager()->get('doctrine.entitymanager.orm_default');
    }

    public function findById($userId)
    {

        $select = $this->getSelect()
            ->where(array('user_id' => $userId));

        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this,
            array('entity' => $entity));
        return $entity;
    }

    public function findByIdSerie($userId, $serieId)
    {
        $em = $this->getEntityManager();

        $entity = $em->getRepository('\GoalioRememberMeDoctrineORM\Entity\RememberMe')->findOneBy([
            'userId' => $userId,
            'sid' => $serieId,
        ]);

        return $entity;
    }

    public function updateSerie($entity)
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();
        
        return $this;
    }

    public function createSerie($entity)
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();

        return $this;
    }

    public function removeAll($userId)
    {
        $em = $this->getEntityManager();
        $entities = $em->getRepository('\GoalioRememberMeDoctrineORM\Entity\RememberMe')->findBy([
            'userId' => $userId,
        ]);
        foreach ($entities as $entity) {
        $em->remove($entity);
        }
        $em->flush();
        return $this;
    }

    public function remove($entity)
    {
        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();
        return $this;
    }

    public function removeSerie($userId, $serieId)
    {
       $em = $this->getEntityManager();

        $entity = $em->getRepository('\GoalioRememberMeDoctrineORM\Entity\RememberMe')->findOneBy([
            'userId' => $userId,
            'sid' => $serieId,
        ]);
        $em->remove($entity);
        $em->flush();
        return $this;
    }

}