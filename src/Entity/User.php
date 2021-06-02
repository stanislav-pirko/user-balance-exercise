<?php

namespace User\Balance\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="User\Balance\Repository\UserRepository")
 */
class User {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=256, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="gender", type="boolean", nullable=true)
     */
    private $gender;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="text", length=65535, nullable=true)
     */
    private $address;


    /**
     * @var bool|null
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @ORM\OneToOne(targetEntity=TotalBalance::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $totalBalance;

    public function __construct(string $name, string $email, string $address) {
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->totalBalance = new \User\Balance\Entity\TotalBalance($this);
        $this->createdAt = new Datetime();
        $this->updatedAt = new Datetime();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(?string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getGender(): ?bool {
        return $this->gender;
    }

    public function setGender(?bool $gender): self {
        $this->gender = $gender;

        return $this;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(?string $address): self {
        $this->address = $address;

        return $this;
    }

    public function getTotalBalance_(): float {
        return $this->total_balance;
    }
    
    public function getTotalBalance(): TotalBalance {
        return $this->totalBalance;
    }


    public function getStatus(): ?bool {
        return $this->status;
    }

    public function setStatus(?bool $status): self {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }



    public function setTotalBalance(TotalBalance $totalBalance): self
    {
        // set the owning side of the relation if necessary
        if ($totalBalance->getUserId() !== $this) {
            $totalBalance->setUserId($this);
        }

        $this->totalBalance = $totalBalance;

        return $this;
    }

}
