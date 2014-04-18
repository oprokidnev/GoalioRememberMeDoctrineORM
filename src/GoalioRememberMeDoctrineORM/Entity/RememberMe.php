<?php

namespace GoalioRememberMeDoctrineORM\Entity;

use Doctrine\ORM\Mapping as ORM,
    Gedmo\Mapping\Annotation as Gedmo,
    Zend\Form\Annotation as Form;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="WM2_User_Cookie_Provider",indexes={@ORM\Index(name="idx", columns={"sid", "userId"})}
 * )
 */
class RememberMe
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=255)
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Form\Exclude()
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $sid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $token;

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
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
