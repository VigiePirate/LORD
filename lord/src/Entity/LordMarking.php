<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordMarkings
 *
 * @ORM\Table(name="lord_markings")
 * @ORM\Entity
 */
class LordMarking
{
    /**
     * @var int
     *
     * @ORM\Column(name="marking_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $markingId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="marking_name_fr", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $markingNameFr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="marking_name_en", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $markingNameEn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="marking_picture", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $markingPicture;

    public function getMarkingId() : ? int
    {
        return $this->markingId;
    }

    public function getMarkingNameFr() : ? string
    {
        return $this->markingNameFr;
    }

    public function setMarkingNameFr(? string $markingNameFr) : self
    {
        $this->markingNameFr = $markingNameFr;

        return $this;
    }

    public function getMarkingNameEn() : ? string
    {
        return $this->markingNameEn;
    }

    public function setMarkingNameEn(? string $markingNameEn) : self
    {
        $this->markingNameEn = $markingNameEn;

        return $this;
    }

    public function getMarkingPicture() : ? string
    {
        return $this->markingPicture;
    }

    public function setMarkingPicture(? string $markingPicture) : self
    {
        $this->markingPicture = $markingPicture;

        return $this;
    }


}
