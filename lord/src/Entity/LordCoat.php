<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordCoats
 *
 * @ORM\Table(name="lord_coats")
 * @ORM\Entity
 */
class LordCoat
{
    /**
     * @var int
     *
     * @ORM\Column(name="coat_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $coatId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="coat_name_fr", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $coatNameFr = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="coat_name_en", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $coatNameEn = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="coat_picture", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $coatPicture = 'NULL';

    public function getCoatId() : ? int
    {
        return $this->coatId;
    }

    public function getCoatNameFr() : ? string
    {
        return $this->coatNameFr;
    }

    public function setCoatNameFr(? string $coatNameFr) : self
    {
        $this->coatNameFr = $coatNameFr;

        return $this;
    }

    public function getCoatNameEn() : ? string
    {
        return $this->coatNameEn;
    }

    public function setCoatNameEn(? string $coatNameEn) : self
    {
        $this->coatNameEn = $coatNameEn;

        return $this;
    }

    public function getCoatPicture() : ? string
    {
        return $this->coatPicture;
    }

    public function setCoatPicture(? string $coatPicture) : self
    {
        $this->coatPicture = $coatPicture;

        return $this;
    }


}
