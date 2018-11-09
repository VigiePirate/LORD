<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordDeathCausesPrimary
 *
 * @ORM\Table(name="lord_death_causes_primary")
 * @ORM\Entity
 */
class LordDeathCausesPrimary
{
    /**
     * @var int
     *
     * @ORM\Column(name="death_cause_primary_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $deathCausePrimaryId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="death_cause_primary_name_fr", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $deathCausePrimaryNameFr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="death_cause_primary_name_en", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $deathCausePrimaryNameEn;

    public function getDeathCausePrimaryId() : ? int
    {
        return $this->deathCausePrimaryId;
    }

    public function getDeathCausePrimaryNameFr() : ? string
    {
        return $this->deathCausePrimaryNameFr;
    }

    public function setDeathCausePrimaryNameFr(? string $deathCausePrimaryNameFr) : self
    {
        $this->deathCausePrimaryNameFr = $deathCausePrimaryNameFr;

        return $this;
    }

    public function getDeathCausePrimaryNameEn() : ? string
    {
        return $this->deathCausePrimaryNameEn;
    }

    public function setDeathCausePrimaryNameEn(? string $deathCausePrimaryNameEn) : self
    {
        $this->deathCausePrimaryNameEn = $deathCausePrimaryNameEn;

        return $this;
    }


}
