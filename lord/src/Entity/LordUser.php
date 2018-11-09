<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * LordUsers
 *
 * @ORM\Table(name="lord_users")
 * @ORM\Entity(repositoryClass="App\Repository\LordUserRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class LordUser implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * On limite à 190 caractères pour éviter une erreur sur MySQL 5.6
     * @ORM\Column(type="string", length=190, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_sex", type="string", length=1, nullable=true, options={"default"="NULL","fixed"=true})
     */
    private $gender;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_name_first", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_name_last", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $lastName;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="user_date_birth", type="date", nullable=true, options={"default"="NULL"})
     */
    private $userDateBirth;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="user_newsletter", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $userNewsletter;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="user_date_creation", type="date", nullable=true, options={"default"="NULL"})
     */
    private $userDateCreation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="user_date_last_update", type="date", nullable=true, options={"default"="NULL"})
     */
    private $userDateLastUpdate;

    /**
     * @ORM\Column(name="roles", type="array", nullable=true)
     */
    private $roles = array();

    /**
     * @var bool|null
     *
     * @ORM\Column(name="user_is_locked", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $userIsLocked;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="user_failed_login_attempts", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $userFailedLoginAttempts;

    public function __construct()
    {
        $this->isActive = false;
        $this->roles = array('ROLE_USER');
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getIsActive() : ? bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive) : self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getUsername() : ? string
    {
        return $this->username;
    }

    public function setUsername(string $username) : self
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail() : ? string
    {
        return $this->email;
    }
    public function setEmail(string $email) : self
    {
        $this->email = $email;
        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPlainPassword() : ? string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password) : self
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles() : array
    {
        return $this->roles;
    }

    public function setRoles(array $roles) : self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->email,
            $this->isActive,
            $this->gender,
            $this->firstName,
            $this->lastName,
            $this->userDateBirth,
            $this->userNewsletter,
            $this->userDateCreation,
            $this->userDateLastUpdate,
            $this->roles,
            $this->userIsLocked,
            $this->userFailedLoginAttempts,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->email,
            $this->isActive,
            $this->gender,
            $this->firstName,
            $this->lastName,
            $this->userDateBirth,
            $this->userNewsletter,
            $this->userDateCreation,
            $this->userDateLastUpdate,
            $this->roles,
            $this->userIsLocked,
            $this->userFailedLoginAttempts,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

    public function getGender() : ? string
    {
        return $this->gender;
    }

    public function setGender(? string $gender) : self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstName() : ? string
    {
        return $this->firstName;
    }

    public function setFirstName(? string $firstName) : self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName() : ? string
    {
        return $this->lastName;
    }

    public function setLastName(? string $lastName) : self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUserDateBirth() : ? \DateTimeInterface
    {
        return $this->userDateBirth;
    }

    public function setUserDateBirth(? \DateTimeInterface $userDateBirth) : self
    {
        $this->userDateBirth = $userDateBirth;

        return $this;
    }

    public function getUserNewsletter() : ? bool
    {
        return $this->userNewsletter;
    }

    public function setUserNewsletter(? bool $userNewsletter) : self
    {
        $this->userNewsletter = $userNewsletter;

        return $this;
    }

    public function getUserDateCreation() : ? \DateTimeInterface
    {
        return $this->userDateCreation;
    }

    public function setUserDateCreation(? \DateTimeInterface $userDateCreation) : self
    {
        $this->userDateCreation = $userDateCreation;

        return $this;
    }

    public function getUserDateLastUpdate() : ? \DateTimeInterface
    {
        return $this->userDateLastUpdate;
    }

    public function setUserDateLastUpdate(? \DateTimeInterface $userDateLastUpdate) : self
    {
        $this->userDateLastUpdate = $userDateLastUpdate;

        return $this;
    }

    public function getUserIsLocked() : ? bool
    {
        return $this->userIsLocked;
    }

    public function setUserIsLocked(? bool $userIsLocked) : self
    {
        $this->userIsLocked = $userIsLocked;

        return $this;
    }

    public function getUserFailedLoginAttempts() : ? bool
    {
        return $this->userFailedLoginAttempts;
    }

    public function setUserFailedLoginAttempts(? bool $userFailedLoginAttempts) : self
    {
        $this->userFailedLoginAttempts = $userFailedLoginAttempts;

        return $this;
    }


}
