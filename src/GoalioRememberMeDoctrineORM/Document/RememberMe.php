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

namespace GoalioRememberMeDoctrineORM\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 *
 * @author oprokidnev <oprokidnev@webmotor.ru>
 * @ODM\Document(
 *     collection="cookie_adapter",
 *     repositoryClass="GoalioRememberMeDoctrineORM\Repository\EntityRepository"
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
