<?php

namespace App\Entity;

use App\Repository\SharedContactsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SharedContactsRepository::class)
 */
class SharedContacts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $contact_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id_shared_to;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id_shared_by;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactId(): ?int
    {
        return $this->contact_id;
    }

    public function setContactId(int $contact_id): self
    {
        $this->contact_id = $contact_id;

        return $this;
    }

    public function getUserIdSharedTo(): ?int
    {
        return $this->user_id_shared_to;
    }

    public function setUserIdSharedTo(int $user_id_shared_to): self
    {
        $this->user_id_shared_to = $user_id_shared_to;

        return $this;
    }

    public function getUserIdSharedBy(): ?int
    {
        return $this->user_id_shared_by;
    }

    public function setUserIdSharedBy(int $user_id_shared_by): self
    {
        $this->user_id_shared_by = $user_id_shared_by;

        return $this;
    }
}
