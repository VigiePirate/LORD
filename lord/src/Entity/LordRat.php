<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LordRats
 *
 * @ORM\Table(name="lord_rats", uniqueConstraints={@ORM\UniqueConstraint(name="rat_id_UNIQUE", columns={"rat_id"}), @ORM\UniqueConstraint(name="rat_numero_UNIQUE", columns={"rat_pedigree_identifier"})}, indexes={@ORM\Index(name="FK_origine", columns={"rattery_mother_id"}), @ORM\Index(name="FK_pere", columns={"rat_father_id"}), @ORM\Index(name="FK_mere", columns={"rat_mother_id"}), @ORM\Index(name="Fk_proprietaire", columns={"user_owner_id"}), @ORM\Index(name="FK_couleur", columns={"color_id"}), @ORM\Index(name="FK_oreilles", columns={"earset_id"}), @ORM\Index(name="FK_yeux", columns={"eyecolor_id"}), @ORM\Index(name="fk_dilutions", columns={"dilution_id"}), @ORM\Index(name="fk_poils", columns={"coat_id"}), @ORM\Index(name="fk_marquage", columns={"marking_id"}), @ORM\Index(name="FK_deces", columns={"death_cause_primary_id"}), @ORM\Index(name="FK_enregistreur", columns={"user_creator_id"}), @ORM\Index(name="fk_origine_raterie_2", columns={"rattery_father_id"}), @ORM\Index(name="fk_deces_secondaire", columns={"death_cause_secondary_id"}), @ORM\Index(name="fk_lord_rats_lord_litters1", columns={"litter_id"})})
 * @ORM\Entity
 */
class LordRat
{
    /**
     * @var int
     *
     * @ORM\Column(name="rat_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ratId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rat_name_owner", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $ratNameOwner = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="rat_name_pup", type="string", length=70, nullable=true, options={"default"="NULL"})
     */
    private $ratNamePup = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="rat_sex", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $ratSex;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rat_pedigree_identifier", type="string", length=10, nullable=true, options={"default"="NULL"})
     */
    private $ratPedigreeIdentifier = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="rat_date_birth", type="date", nullable=true, options={"default"="NULL"})
     */
    private $ratDateBirth = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="rat_date_death", type="date", nullable=true, options={"default"="NULL"})
     */
    private $ratDateDeath = 'NULL';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="rat_death_euthanized", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $ratDeathEuthanized = 'NULL';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="rat_death_diagnosed", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $ratDeathDiagnosed = 'NULL';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="rat_death_necropsied", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $ratDeathNecropsied = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="rat_picture", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $ratPicture = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="rat_picture_thumbnail", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $ratPictureThumbnail = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="rat_comments", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $ratComments = 'NULL';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="rat_validated", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $ratValidated = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="singularity_id_list", type="string", length=15, nullable=true, options={"default"="NULL"})
     */
    private $singularityIdList = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="rat_date_create", type="date", nullable=true, options={"default"="NULL"})
     */
    private $ratDateCreate = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="rat_date_last_update", type="date", nullable=true, options={"default"="NULL"})
     */
    private $ratDateLastUpdate = 'NULL';

    /**
     * @var \LordColors
     *
     * @ORM\ManyToOne(targetEntity="LordColors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="color_id", referencedColumnName="color_id")
     * })
     */
    private $color;

    /**
     * @var \LordDeathCausesPrimary
     *
     * @ORM\ManyToOne(targetEntity="LordDeathCausesPrimary")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="death_cause_primary_id", referencedColumnName="death_cause_primary_id")
     * })
     */
    private $deathCausePrimary;

    /**
     * @var \LordUsers
     *
     * @ORM\ManyToOne(targetEntity="LordUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_creator_id", referencedColumnName="user_id")
     * })
     */
    private $userCreator;

    /**
     * @var \LordRats
     *
     * @ORM\ManyToOne(targetEntity="LordRats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rat_mother_id", referencedColumnName="rat_id")
     * })
     */
    private $ratMother;

    /**
     * @var \LordEarsets
     *
     * @ORM\ManyToOne(targetEntity="LordEarsets")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="earset_id", referencedColumnName="earset_id")
     * })
     */
    private $earset;

    /**
     * @var \LordRatteries
     *
     * @ORM\ManyToOne(targetEntity="LordRatteries")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rattery_mother_id", referencedColumnName="rattery_id")
     * })
     */
    private $ratteryMother;

    /**
     * @var \LordRats
     *
     * @ORM\ManyToOne(targetEntity="LordRats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rat_father_id", referencedColumnName="rat_id")
     * })
     */
    private $ratFather;

    /**
     * @var \LordEyecolors
     *
     * @ORM\ManyToOne(targetEntity="LordEyecolors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="eyecolor_id", referencedColumnName="eyecolor_id")
     * })
     */
    private $eyecolor;

    /**
     * @var \LordUsers
     *
     * @ORM\ManyToOne(targetEntity="LordUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_owner_id", referencedColumnName="user_id")
     * })
     */
    private $userOwner;

    /**
     * @var \LordDeathCausesSecondary
     *
     * @ORM\ManyToOne(targetEntity="LordDeathCausesSecondary")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="death_cause_secondary_id", referencedColumnName="death_cause_secondary_id")
     * })
     */
    private $deathCauseSecondary;

    /**
     * @var \LordDilutions
     *
     * @ORM\ManyToOne(targetEntity="LordDilutions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dilution_id", referencedColumnName="dilution_id")
     * })
     */
    private $dilution;

    /**
     * @var \LordLitters
     *
     * @ORM\ManyToOne(targetEntity="LordLitters")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="litter_id", referencedColumnName="litter_id")
     * })
     */
    private $litter;

    /**
     * @var \LordMarkings
     *
     * @ORM\ManyToOne(targetEntity="LordMarkings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marking_id", referencedColumnName="marking_id")
     * })
     */
    private $marking;

    /**
     * @var \LordRatteries
     *
     * @ORM\ManyToOne(targetEntity="LordRatteries")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rattery_father_id", referencedColumnName="rattery_id")
     * })
     */
    private $ratteryFather;

    /**
     * @var \LordCoats
     *
     * @ORM\ManyToOne(targetEntity="LordCoats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="coat_id", referencedColumnName="coat_id")
     * })
     */
    private $coat;

    public function getRatId() : ? int
    {
        return $this->ratId;
    }

    public function getRatNameOwner() : ? string
    {
        return $this->ratNameOwner;
    }

    public function setRatNameOwner(? string $ratNameOwner) : self
    {
        $this->ratNameOwner = $ratNameOwner;

        return $this;
    }

    public function getRatNamePup() : ? string
    {
        return $this->ratNamePup;
    }

    public function setRatNamePup(? string $ratNamePup) : self
    {
        $this->ratNamePup = $ratNamePup;

        return $this;
    }

    public function getRatSex() : ? string
    {
        return $this->ratSex;
    }

    public function setRatSex(string $ratSex) : self
    {
        $this->ratSex = $ratSex;

        return $this;
    }

    public function getRatPedigreeIdentifier() : ? string
    {
        return $this->ratPedigreeIdentifier;
    }

    public function setRatPedigreeIdentifier(? string $ratPedigreeIdentifier) : self
    {
        $this->ratPedigreeIdentifier = $ratPedigreeIdentifier;

        return $this;
    }

    public function getRatDateBirth() : ? \DateTimeInterface
    {
        return $this->ratDateBirth;
    }

    public function setRatDateBirth(? \DateTimeInterface $ratDateBirth) : self
    {
        $this->ratDateBirth = $ratDateBirth;

        return $this;
    }

    public function getRatDateDeath() : ? \DateTimeInterface
    {
        return $this->ratDateDeath;
    }

    public function setRatDateDeath(? \DateTimeInterface $ratDateDeath) : self
    {
        $this->ratDateDeath = $ratDateDeath;

        return $this;
    }

    public function getRatDeathEuthanized() : ? bool
    {
        return $this->ratDeathEuthanized;
    }

    public function setRatDeathEuthanized(? bool $ratDeathEuthanized) : self
    {
        $this->ratDeathEuthanized = $ratDeathEuthanized;

        return $this;
    }

    public function getRatDeathDiagnosed() : ? bool
    {
        return $this->ratDeathDiagnosed;
    }

    public function setRatDeathDiagnosed(? bool $ratDeathDiagnosed) : self
    {
        $this->ratDeathDiagnosed = $ratDeathDiagnosed;

        return $this;
    }

    public function getRatDeathNecropsied() : ? bool
    {
        return $this->ratDeathNecropsied;
    }

    public function setRatDeathNecropsied(? bool $ratDeathNecropsied) : self
    {
        $this->ratDeathNecropsied = $ratDeathNecropsied;

        return $this;
    }

    public function getRatPicture() : ? string
    {
        return $this->ratPicture;
    }

    public function setRatPicture(? string $ratPicture) : self
    {
        $this->ratPicture = $ratPicture;

        return $this;
    }

    public function getRatPictureThumbnail() : ? string
    {
        return $this->ratPictureThumbnail;
    }

    public function setRatPictureThumbnail(? string $ratPictureThumbnail) : self
    {
        $this->ratPictureThumbnail = $ratPictureThumbnail;

        return $this;
    }

    public function getRatComments() : ? string
    {
        return $this->ratComments;
    }

    public function setRatComments(? string $ratComments) : self
    {
        $this->ratComments = $ratComments;

        return $this;
    }

    public function getRatValidated() : ? bool
    {
        return $this->ratValidated;
    }

    public function setRatValidated(? bool $ratValidated) : self
    {
        $this->ratValidated = $ratValidated;

        return $this;
    }

    public function getSingularityIdList() : ? string
    {
        return $this->singularityIdList;
    }

    public function setSingularityIdList(? string $singularityIdList) : self
    {
        $this->singularityIdList = $singularityIdList;

        return $this;
    }

    public function getRatDateCreate() : ? \DateTimeInterface
    {
        return $this->ratDateCreate;
    }

    public function setRatDateCreate(? \DateTimeInterface $ratDateCreate) : self
    {
        $this->ratDateCreate = $ratDateCreate;

        return $this;
    }

    public function getRatDateLastUpdate() : ? \DateTimeInterface
    {
        return $this->ratDateLastUpdate;
    }

    public function setRatDateLastUpdate(? \DateTimeInterface $ratDateLastUpdate) : self
    {
        $this->ratDateLastUpdate = $ratDateLastUpdate;

        return $this;
    }

    public function getColor() : ? LordColors
    {
        return $this->color;
    }

    public function setColor(? LordColors $color) : self
    {
        $this->color = $color;

        return $this;
    }

    public function getDeathCausePrimary() : ? LordDeathCausesPrimary
    {
        return $this->deathCausePrimary;
    }

    public function setDeathCausePrimary(? LordDeathCausesPrimary $deathCausePrimary) : self
    {
        $this->deathCausePrimary = $deathCausePrimary;

        return $this;
    }

    public function getUserCreator() : ? LordUsers
    {
        return $this->userCreator;
    }

    public function setUserCreator(? LordUsers $userCreator) : self
    {
        $this->userCreator = $userCreator;

        return $this;
    }

    public function getRatMother() : ? self
    {
        return $this->ratMother;
    }

    public function setRatMother(? self $ratMother) : self
    {
        $this->ratMother = $ratMother;

        return $this;
    }

    public function getEarset() : ? LordEarsets
    {
        return $this->earset;
    }

    public function setEarset(? LordEarsets $earset) : self
    {
        $this->earset = $earset;

        return $this;
    }

    public function getRatteryMother() : ? LordRatteries
    {
        return $this->ratteryMother;
    }

    public function setRatteryMother(? LordRatteries $ratteryMother) : self
    {
        $this->ratteryMother = $ratteryMother;

        return $this;
    }

    public function getRatFather() : ? self
    {
        return $this->ratFather;
    }

    public function setRatFather(? self $ratFather) : self
    {
        $this->ratFather = $ratFather;

        return $this;
    }

    public function getEyecolor() : ? LordEyecolors
    {
        return $this->eyecolor;
    }

    public function setEyecolor(? LordEyecolors $eyecolor) : self
    {
        $this->eyecolor = $eyecolor;

        return $this;
    }

    public function getUserOwner() : ? LordUsers
    {
        return $this->userOwner;
    }

    public function setUserOwner(? LordUsers $userOwner) : self
    {
        $this->userOwner = $userOwner;

        return $this;
    }

    public function getDeathCauseSecondary() : ? LordDeathCausesSecondary
    {
        return $this->deathCauseSecondary;
    }

    public function setDeathCauseSecondary(? LordDeathCausesSecondary $deathCauseSecondary) : self
    {
        $this->deathCauseSecondary = $deathCauseSecondary;

        return $this;
    }

    public function getDilution() : ? LordDilutions
    {
        return $this->dilution;
    }

    public function setDilution(? LordDilutions $dilution) : self
    {
        $this->dilution = $dilution;

        return $this;
    }

    public function getLitter() : ? LordLitters
    {
        return $this->litter;
    }

    public function setLitter(? LordLitters $litter) : self
    {
        $this->litter = $litter;

        return $this;
    }

    public function getMarking() : ? LordMarkings
    {
        return $this->marking;
    }

    public function setMarking(? LordMarkings $marking) : self
    {
        $this->marking = $marking;

        return $this;
    }

    public function getRatteryFather() : ? LordRatteries
    {
        return $this->ratteryFather;
    }

    public function setRatteryFather(? LordRatteries $ratteryFather) : self
    {
        $this->ratteryFather = $ratteryFather;

        return $this;
    }

    public function getCoat() : ? LordCoats
    {
        return $this->coat;
    }

    public function setCoat(? LordCoats $coat) : self
    {
        $this->coat = $coat;

        return $this;
    }


}
