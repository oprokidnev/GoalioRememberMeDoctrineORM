<?php

namespace GoalioRememberMeDoctrineORM\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 *
 * @author oprokidnev <oprokidnev@webmotor.ru>
 * @ODM\Document(
 *     collection="cookie_adapter"
 * )
 * @ODM\Indexes({
 *   @ODM\Index(keys={"sid"="asc"}),
 *   @ODM\Index(keys={"token"="asc"}),
 *   @ODM\Index(keys={"userId"="asc"})
 * })
 * @ODM\UniqueIndex(keys={"sid"="asc", "userId"="asc"})
 */
class RememberMe
{

    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected $sid;

    /**
     * @ODM\Field(type="string")
     */
    protected $token;

    /**
     * @ODM\Field(type="string")
     */
    protected $userId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sid
     *
     * @param string $sid
     * @return RememberMe
     */
    public function setSid($sid)
    {
        $this->sid = $sid;

        return $this;
    }

    /**
     * Get sid
     *
     * @return string 
     */
    public function getSid()
    {
        return $this->sid;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return RememberMe
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set userId
     *
     * @param \Application\Entity\User|integer $userId
     * @return RememberMe
     */
    public function setUserId($userId = null)
    {
        
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
