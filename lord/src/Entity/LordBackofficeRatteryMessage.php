<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordBackofficeRatteryMessages
 *
 * @ORM\Table(name="lord_backoffice_rattery_messages", indexes={@ORM\Index(name="fk_lord_backoffice_rattery_messages_lord_ratteries1", columns={"rattery_id"}), @ORM\Index(name="fk_lord_backoffice_rattery_messages_lord_users1", columns={"user_staff_id"})})
 * @ORM\Entity
 */
class LordBackofficeRatteryMessage
{
    /**
     * @var int
     *
     * @ORM\Column(name="backoffice_rattery_message_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $backofficeRatteryMessageId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="backoffice_rattery_message_staff_comments", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $backofficeRatteryMessageStaffComments = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="backoffice_rattery_message_owner_comments", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $backofficeRatteryMessageOwnerComments = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="backoffice_rattery_messages_date_staff_comments", type="date", nullable=true, options={"default"="NULL"})
     */
    private $backofficeRatteryMessagesDateStaffComments = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="backoffice_rattery_messages_date_owner_comments", type="date", nullable=true, options={"default"="NULL"})
     */
    private $backofficeRatteryMessagesDateOwnerComments = 'NULL';

    /**
     * @var \LordRatteries
     *
     * @ORM\ManyToOne(targetEntity="LordRatteries")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rattery_id", referencedColumnName="rattery_id")
     * })
     */
    private $rattery;

    /**
     * @var \LordUsers
     *
     * @ORM\ManyToOne(targetEntity="LordUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_staff_id", referencedColumnName="user_id")
     * })
     */
    private $userStaff;

    public function getBackofficeRatteryMessageId() : ? int
    {
        return $this->backofficeRatteryMessageId;
    }

    public function getBackofficeRatteryMessageStaffComments() : ? string
    {
        return $this->backofficeRatteryMessageStaffComments;
    }

    public function setBackofficeRatteryMessageStaffComments(? string $backofficeRatteryMessageStaffComments) : self
    {
        $this->backofficeRatteryMessageStaffComments = $backofficeRatteryMessageStaffComments;

        return $this;
    }

    public function getBackofficeRatteryMessageOwnerComments() : ? string
    {
        return $this->backofficeRatteryMessageOwnerComments;
    }

    public function setBackofficeRatteryMessageOwnerComments(? string $backofficeRatteryMessageOwnerComments) : self
    {
        $this->backofficeRatteryMessageOwnerComments = $backofficeRatteryMessageOwnerComments;

        return $this;
    }

    public function getBackofficeRatteryMessagesDateStaffComments() : ? \DateTimeInterface
    {
        return $this->backofficeRatteryMessagesDateStaffComments;
    }

    public function setBackofficeRatteryMessagesDateStaffComments(? \DateTimeInterface $backofficeRatteryMessagesDateStaffComments) : self
    {
        $this->backofficeRatteryMessagesDateStaffComments = $backofficeRatteryMessagesDateStaffComments;

        return $this;
    }

    public function getBackofficeRatteryMessagesDateOwnerComments() : ? \DateTimeInterface
    {
        return $this->backofficeRatteryMessagesDateOwnerComments;
    }

    public function setBackofficeRatteryMessagesDateOwnerComments(? \DateTimeInterface $backofficeRatteryMessagesDateOwnerComments) : self
    {
        $this->backofficeRatteryMessagesDateOwnerComments = $backofficeRatteryMessagesDateOwnerComments;

        return $this;
    }

    public function getRattery() : ? LordRatteries
    {
        return $this->rattery;
    }

    public function setRattery(? LordRatteries $rattery) : self
    {
        $this->rattery = $rattery;

        return $this;
    }

    public function getUserStaff() : ? LordUsers
    {
        return $this->userStaff;
    }

    public function setUserStaff(? LordUsers $userStaff) : self
    {
        $this->userStaff = $userStaff;

        return $this;
    }


}
