<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordDilutions
 *
 * @ORM\Table(name="lord_dilutions")
 * @ORM\Entity
 */
class LordDilution
{
    /**
     * @var int
     *
     * @ORM\Column(name="dilution_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $dilutionId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dilution_name_fr", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $dilutionNameFr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dilution_name_en", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $dilutionNameEn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dilution_picture", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $dilutionPicture;

    public function getDilutionId() : ? int
    {
        return $this->dilutionId;
    }

    public function getDilutionNameFr() : ? string
    {
        return $this->dilutionNameFr;
    }

    public function setDilutionNameFr(? string $dilutionNameFr) : self
    {
        $this->dilutionNameFr = $dilutionNameFr;

        return $this;
    }

    public function getDilutionNameEn() : ? string
    {
        return $this->dilutionNameEn;
    }

    public function setDilutionNameEn(? string $dilutionNameEn) : self
    {
        $this->dilutionNameEn = $dilutionNameEn;

        return $this;
    }

    public function getDilutionPicture() : ? string
    {
        return $this->dilutionPicture;
    }

    public function setDilutionPicture(? string $dilutionPicture) : self
    {
        $this->dilutionPicture = $dilutionPicture;

        return $this;
    }


}
