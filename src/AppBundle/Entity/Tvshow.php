<?php

namespace AppBundle\Entity;

use AppBundle\Form\Enum\WatchStatusTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Tvshow
 *
 * @ORM\Table(name="tvshow")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TvshowRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Tvshow
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"default","ROLE_ADMIN"})
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     * @Serializer\Groups({"default","ROLE_ADMIN"})
     * @Serializer\Expose()
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="tvshow_id", type="integer")
     * @Serializer\Groups({"default","ROLE_ADMIN"})
     * @Serializer\Expose()
     */
    private $tvshowId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Serializer\Groups({"default","ROLE_ADMIN"})
     * @Serializer\Expose()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="watch_status", type="string", length=255)
     * @Serializer\Groups({"default","ROLE_ADMIN"})
     * @Serializer\Expose()
     */
    private $watchStatus;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Tvshow
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set tvshowId
     *
     * @param integer $tvshowId
     *
     * @return Tvshow
     */
    public function setTvshowId($tvshowId)
    {
        $this->tvshowId = $tvshowId;

        return $this;
    }

    /**
     * Get tvshowId
     *
     * @return int
     */
    public function getTvshowId()
    {
        return $this->tvshowId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Tvshow
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set watchStatus
     *
     * @param string $watchStatus
     *
     * @return Tvshow
     */
    public function setWatchStatus($watchStatus)
    {
        if(!in_array($watchStatus, WatchStatusTypeEnum::getAvailableTypes()))
        {
            throw new \InvalidArgumentException("Invalid Enum Type");
        }

        $this->watchStatus = $watchStatus;

        return $this;
    }

    /**
     * Get watchStatus
     *
     * @return string
     */
    public function getWatchStatus()
    {
        return $this->watchStatus;
    }
}

