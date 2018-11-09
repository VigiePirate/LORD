<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordEarsets
 *
 * @ORM\Table(name="lord_earsets")
 * @ORM\Entity
 */
class LordEarset
{
    /**
     * @var int
     *
     * @ORM\Column(name="earset_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $earsetId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="earset_name_fr", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $earsetNameFr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="earset_name_en", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $earsetNameEn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="earset_picture", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $earsetPicture;

    public function getEarsetId() : ? int
    {
        return $this->earsetId;
    }

    public function getEarsetNameFr() : ? string
    {
        return $this->earsetNameFr;
    }

    public function setEarsetNameFr(? string $earsetNameFr) : self
    {
        $this->earsetNameFr = $earsetNameFr;

        return $this;
    }

    public function getEarsetNameEn() : ? string
    {
        return $this->earsetNameEn;
    }

    public function setEarsetNameEn(? string $earsetNameEn) : self
    {
        $this->earsetNameEn = $earsetNameEn;

        return $this;
    }

    public function getEarsetPicture() : ? string
    {
        return $this->earsetPicture;
    }

    public function setEarsetPicture(? string $earsetPicture) : self
    {
        $this->earsetPicture = $earsetPicture;

        return $this;
    }


}
