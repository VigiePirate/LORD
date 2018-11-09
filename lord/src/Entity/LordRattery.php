<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordRatteries
 *
 * @ORM\Table(name="lord_ratteries", indexes={@ORM\Index(name="fk_lord_ratteries_lord_users1", columns={"user_owner_id"})})
 * @ORM\Entity
 */
class LordRattery
{
    /**
     * @var int
     *
     * @ORM\Column(name="rattery_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ratteryId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rattery_name", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $ratteryName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="raterie_prefix", type="string", length=3, nullable=true, options={"default"="NULL"})
     */
    private $rateriePrefix;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rattery_comments", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $ratteryComments;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rattery_picture", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $ratteryPicture;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="rattery_status", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $ratteryStatus;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="rattery_validated", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $ratteryValidated;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="rattery_date_birth", type="date", nullable=true, options={"default"="NULL"})
     */
    private $ratteryDateBirth;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="rattery_date_creation", type="date", nullable=true, options={"default"="NULL"})
     */
    private $ratteryDateCreation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="rattery_date_last_update", type="date", nullable=true, options={"default"="NULL"})
     */
    private $ratteryDateLastUpdate;

    /**
     * @var \LordUser
     *
     * @ORM\ManyToOne(targetEntity="LordUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_owner_id", referencedColumnName="id")
     * })
     */
    private $userOwner;

    public function getRatteryId() : ? int
    {
        return $this->ratteryId;
    }

    public function getRatteryName() : ? string
    {
        return $this->ratteryName;
    }

    public function setRatteryName(? string $ratteryName) : self
    {
        $this->ratteryName = $ratteryName;

        return $this;
    }

    public function getRateriePrefix() : ? string
    {
        return $this->rateriePrefix;
    }

    public function setRateriePrefix(? string $rateriePrefix) : self
    {
        $this->rateriePrefix = $rateriePrefix;

        return $this;
    }

    public function getRatteryComments() : ? string
    {
        return $this->ratteryComments;
    }

    public function setRatteryComments(? string $ratteryComments) : self
    {
        $this->ratteryComments = $ratteryComments;

        return $this;
    }

    public function getRatteryPicture() : ? string
    {
        return $this->ratteryPicture;
    }

    public function setRatteryPicture(? string $ratteryPicture) : self
    {
        $this->ratteryPicture = $ratteryPicture;

        return $this;
    }

    public function getRatteryStatus() : ? bool
    {
        return $this->ratteryStatus;
    }

    public function setRatteryStatus(? bool $ratteryStatus) : self
    {
        $this->ratteryStatus = $ratteryStatus;

        return $this;
    }

    public function getRatteryValidated() : ? bool
    {
        return $this->ratteryValidated;
    }

    public function setRatteryValidated(? bool $ratteryValidated) : self
    {
        $this->ratteryValidated = $ratteryValidated;

        return $this;
    }

    public function getRatteryDateBirth() : ? \DateTimeInterface
    {
        return $this->ratteryDateBirth;
    }

    public function setRatteryDateBirth(? \DateTimeInterface $ratteryDateBirth) : self
    {
        $this->ratteryDateBirth = $ratteryDateBirth;

        return $this;
    }

    public function getRatteryDateCreation() : ? \DateTimeInterface
    {
        return $this->ratteryDateCreation;
    }

    public function setRatteryDateCreation(? \DateTimeInterface $ratteryDateCreation) : self
    {
        $this->ratteryDateCreation = $ratteryDateCreation;

        return $this;
    }

    public function getRatteryDateLastUpdate() : ? \DateTimeInterface
    {
        return $this->ratteryDateLastUpdate;
    }

    public function setRatteryDateLastUpdate(? \DateTimeInterface $ratteryDateLastUpdate) : self
    {
        $this->ratteryDateLastUpdate = $ratteryDateLastUpdate;

        return $this;
    }

    public function getUserOwner() : ? LordUser
    {
        return $this->userOwner;
    }

    public function setUserOwner(? LordUser $userOwner) : self
    {
        $this->userOwner = $userOwner;

        return $this;
    }


}
