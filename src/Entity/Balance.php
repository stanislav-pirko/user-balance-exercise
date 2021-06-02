<?php

namespace User\Balance\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_balance")
 * @ORM\Entity(repositoryClass="User\Balance\Repository\UserBalanceRepository")
 */
class Balance {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ ORM\ManyToOne(targetEntity="User", inversedBy="balance")
     */
    //private User $user;

    /**
     * @ORM\ManyToOne(targetEntity="TotalBalance", inversedBy="balance")
     */
    private TotalBalance $total_balance;

    /**
     * @ORM\Column(type="float", precision=11, scale=2, nullable=true, options={"default"="0.00"})
     */
    private float $balance;

    /**
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private string $type;
    

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function __construct(TotalBalance $total_balance, float $balance, string $type) {
        $this->total_balance = $total_balance;
        $this->balance = $balance;
        $this->type = $type;
    }

    public function getBalance(): float {
        return $this->balance;
    }

}
