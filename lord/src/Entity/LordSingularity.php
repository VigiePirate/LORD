<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordSingularities
 *
 * @ORM\Table(name="lord_singularities")
 * @ORM\Entity
 */
class LordSingularity
{
    /**
     * @var int
     *
     * @ORM\Column(name="singularity_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $singularityId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="singularity_name_fr", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $singularityNameFr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="singularity_name_en", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $singularityNameEn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="singularity_picture", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $singularityPicture;

    public function getSingularityId() : ? int
    {
        return $this->singularityId;
    }

    public function getSingularityNameFr() : ? string
    {
        return $this->singularityNameFr;
    }

    public function setSingularityNameFr(? string $singularityNameFr) : self
    {
        $this->singularityNameFr = $singularityNameFr;

        return $this;
    }

    public function getSingularityNameEn() : ? string
    {
        return $this->singularityNameEn;
    }

    public function setSingularityNameEn(? string $singularityNameEn) : self
    {
        $this->singularityNameEn = $singularityNameEn;

        return $this;
    }

    public function getSingularityPicture() : ? string
    {
        return $this->singularityPicture;
    }

    public function setSingularityPicture(? string $singularityPicture) : self
    {
        $this->singularityPicture = $singularityPicture;

        return $this;
    }


}
