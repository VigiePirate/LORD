<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordColors
 *
 * @ORM\Table(name="lord_colors", indexes={@ORM\Index(name="fk_lord_colors_lord_eyecolors1", columns={"eyecolor_id"})})
 * @ORM\Entity
 */
class LordColor
{
    /**
     * @var int
     *
     * @ORM\Column(name="color_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $colorId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="color_name_fr", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $colorNameFr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="color_genotype", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $colorGenotype;

    /**
     * @var string|null
     *
     * @ORM\Column(name="color_name_en", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $colorNameEn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="color_picture", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $colorPicture;

    /**
     * @var \LordEyecolor
     *
     * @ORM\ManyToOne(targetEntity="LordEyecolor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="eyecolor_id", referencedColumnName="eyecolor_id")
     * })
     */
    private $eyecolor;

    public function getColorId() : ? int
    {
        return $this->colorId;
    }

    public function getColorNameFr() : ? string
    {
        return $this->colorNameFr;
    }

    public function setColorNameFr(? string $colorNameFr) : self
    {
        $this->colorNameFr = $colorNameFr;

        return $this;
    }

    public function getColorGenotype() : ? string
    {
        return $this->colorGenotype;
    }

    public function setColorGenotype(? string $colorGenotype) : self
    {
        $this->colorGenotype = $colorGenotype;

        return $this;
    }

    public function getColorNameEn() : ? string
    {
        return $this->colorNameEn;
    }

    public function setColorNameEn(? string $colorNameEn) : self
    {
        $this->colorNameEn = $colorNameEn;

        return $this;
    }

    public function getColorPicture() : ? string
    {
        return $this->colorPicture;
    }

    public function setColorPicture(? string $colorPicture) : self
    {
        $this->colorPicture = $colorPicture;

        return $this;
    }

    public function getEyecolor() : ? LordEyecolor
    {
        return $this->eyecolor;
    }

    public function setEyecolor(? LordEyecolor $eyecolor) : self
    {
        $this->eyecolor = $eyecolor;

        return $this;
    }


}
