<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordBackofficeRatMessages
 *
 * @ORM\Table(name="lord_backoffice_rat_messages", indexes={@ORM\Index(name="fk_lord_sav_lord_utilisateurs1", columns={"user_staff_id"}), @ORM\Index(name="fk_lord_backoffice_rat_messages_lord_backoffice_rat_entries1", columns={"backoffice_rat_entry_id"})})
 * @ORM\Entity
 */
class LordBackofficeRatMessage
{
    /**
     * @var int
     *
     * @ORM\Column(name="backoffice_rat_message_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $backofficeRatMessageId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="backoffice_rat_message_staff_comments", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $backofficeRatMessageStaffComments = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="backoffice_rat_message_owner_comments", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $backofficeRatMessageOwnerComments = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="backoffice_rat_message_date_staff_comments", type="date", nullable=true, options={"default"="NULL"})
     */
    private $backofficeRatMessageDateStaffComments = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="backoffice_rat_message_date_owner_comments", type="date", nullable=true, options={"default"="NULL"})
     */
    private $backofficeRatMessageDateOwnerComments = 'NULL';

    /**
     * @var \LordBackofficeRatEntries
     *
     * @ORM\ManyToOne(targetEntity="LordBackofficeRatEntries")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="backoffice_rat_entry_id", referencedColumnName="lord_backoffice_rat_entry_id")
     * })
     */
    private $backofficeRatEntry;

    /**
     * @var \LordUsers
     *
     * @ORM\ManyToOne(targetEntity="LordUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_staff_id", referencedColumnName="user_id")
     * })
     */
    private $userStaff;

    public function getBackofficeRatMessageId() : ? int
    {
        return $this->backofficeRatMessageId;
    }

    public function getBackofficeRatMessageStaffComments() : ? string
    {
        return $this->backofficeRatMessageStaffComments;
    }

    public function setBackofficeRatMessageStaffComments(? string $backofficeRatMessageStaffComments) : self
    {
        $this->backofficeRatMessageStaffComments = $backofficeRatMessageStaffComments;

        return $this;
    }

    public function getBackofficeRatMessageOwnerComments() : ? string
    {
        return $this->backofficeRatMessageOwnerComments;
    }

    public function setBackofficeRatMessageOwnerComments(? string $backofficeRatMessageOwnerComments) : self
    {
        $this->backofficeRatMessageOwnerComments = $backofficeRatMessageOwnerComments;

        return $this;
    }

    public function getBackofficeRatMessageDateStaffComments() : ? \DateTimeInterface
    {
        return $this->backofficeRatMessageDateStaffComments;
    }

    public function setBackofficeRatMessageDateStaffComments(? \DateTimeInterface $backofficeRatMessageDateStaffComments) : self
    {
        $this->backofficeRatMessageDateStaffComments = $backofficeRatMessageDateStaffComments;

        return $this;
    }

    public function getBackofficeRatMessageDateOwnerComments() : ? \DateTimeInterface
    {
        return $this->backofficeRatMessageDateOwnerComments;
    }

    public function setBackofficeRatMessageDateOwnerComments(? \DateTimeInterface $backofficeRatMessageDateOwnerComments) : self
    {
        $this->backofficeRatMessageDateOwnerComments = $backofficeRatMessageDateOwnerComments;

        return $this;
    }

    public function getBackofficeRatEntry() : ? LordBackofficeRatEntries
    {
        return $this->backofficeRatEntry;
    }

    public function setBackofficeRatEntry(? LordBackofficeRatEntries $backofficeRatEntry) : self
    {
        $this->backofficeRatEntry = $backofficeRatEntry;

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
