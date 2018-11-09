<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordEyecolors
 *
 * @ORM\Table(name="lord_eyecolors")
 * @ORM\Entity
 */
class LordEyecolor
{
    /**
     * @var int
     *
     * @ORM\Column(name="eyecolor_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $eyecolorId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="eyecolor_name_fr", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $eyecolorNameFr = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="eyecolor_name_en", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $eyecolorNameEn = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="eyecolor_picture", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $eyecolorPicture = 'NULL';

    public function getEyecolorId() : ? int
    {
        return $this->eyecolorId;
    }

    public function getEyecolorNameFr() : ? string
    {
        return $this->eyecolorNameFr;
    }

    public function setEyecolorNameFr(? string $eyecolorNameFr) : self
    {
        $this->eyecolorNameFr = $eyecolorNameFr;

        return $this;
    }

    public function getEyecolorNameEn() : ? string
    {
        return $this->eyecolorNameEn;
    }

    public function setEyecolorNameEn(? string $eyecolorNameEn) : self
    {
        $this->eyecolorNameEn = $eyecolorNameEn;

        return $this;
    }

    public function getEyecolorPicture() : ? string
    {
        return $this->eyecolorPicture;
    }

    public function setEyecolorPicture(? string $eyecolorPicture) : self
    {
        $this->eyecolorPicture = $eyecolorPicture;

        return $this;
    }


}
