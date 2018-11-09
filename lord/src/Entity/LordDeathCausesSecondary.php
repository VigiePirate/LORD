<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordDeathCausesSecondary
 *
 * @ORM\Table(name="lord_death_causes_secondary", indexes={@ORM\Index(name="fk_lord_deces_secondaire_lord_deces_principal1", columns={"deces_principal_id"})})
 * @ORM\Entity
 */
class LordDeathCausesSecondary
{
    /**
     * @var int
     *
     * @ORM\Column(name="death_cause_secondary_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $deathCauseSecondaryId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="death_cause_secondary_name_fr", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $deathCauseSecondaryNameFr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="death_cause_secondary_name_en", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $deathCauseSecondaryNameEn;

    /**
     * @var \LordDeathCausesPrimary
     *
     * @ORM\ManyToOne(targetEntity="LordDeathCausesPrimary")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="deces_principal_id", referencedColumnName="death_cause_primary_id")
     * })
     */
    private $decesPrincipal;

    public function getDeathCauseSecondaryId() : ? int
    {
        return $this->deathCauseSecondaryId;
    }

    public function getDeathCauseSecondaryNameFr() : ? string
    {
        return $this->deathCauseSecondaryNameFr;
    }

    public function setDeathCauseSecondaryNameFr(? string $deathCauseSecondaryNameFr) : self
    {
        $this->deathCauseSecondaryNameFr = $deathCauseSecondaryNameFr;

        return $this;
    }

    public function getDeathCauseSecondaryNameEn() : ? string
    {
        return $this->deathCauseSecondaryNameEn;
    }

    public function setDeathCauseSecondaryNameEn(? string $deathCauseSecondaryNameEn) : self
    {
        $this->deathCauseSecondaryNameEn = $deathCauseSecondaryNameEn;

        return $this;
    }

    public function getDecesPrincipal() : ? LordDeathCausesPrimary
    {
        return $this->decesPrincipal;
    }

    public function setDecesPrincipal(? LordDeathCausesPrimary $decesPrincipal) : self
    {
        $this->decesPrincipal = $decesPrincipal;

        return $this;
    }


}
