<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_id_saved;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_id_shared;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getUserIdSaved(): ?int
    {
        return $this->user_id_saved;
    }

    public function setUserIdSaved(?int $user_id_saved): self
    {
        $this->user_id_saved = $user_id_saved;

        return $this;
    }

    public function getUserIdShared(): ?int
    {
        return $this->user_id_shared;
    }

    public function setUserIdShared(?int $user_id_shared): self
    {
        $this->user_id_shared = $user_id_shared;

        return $this;
    }
}
