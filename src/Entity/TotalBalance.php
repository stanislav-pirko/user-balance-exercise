<?php

namespace User\Balance\Entity;

use User\Balance\Repository\TotalBalanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TotalBalanceRepository::class)
 */
class TotalBalance {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", precision=11, scale=2, nullable=true, options={"default"="0.00"})
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity="Balance", mappedBy="total_balance", cascade={"persist", "remove"})
     */
    private $balance;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="totalBalance", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * as alternative - datetime 
     * @ORM\Column(type="integer") 
     * @ORM\Version
     */
    private int $version;

    public function __construct(User $user) {
        $this->user = $user;
        $this->balance = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getAmount(): ?float {
        return $this->amount;
    }

    public function setAmount(float $amount): self {
        $this->amount = $amount;

        return $this;
    }

    public function getUserId(): ?User {
        return $this->user;
    }

    public function setUserId(User $user): self {
        $this->user = $user;

        return $this;
    }

    public function getBalance(): ?float {
        $balance = 0;
        foreach ($this->balance as $ub) {
            $balance += $ub->getType() === "credit" ? $ub->getBalance() : -1 * abs($ub->getBalance());
        }

        return $balance;
    }

    private function isDebitAllowed(float $amount): bool {
        $newBalance = $this->getAmount() + -1 * abs($amount);
        $allowedMinimalBalance = 0; //let's assume that 0 is minimum
        if ($newBalance < $allowedMinimalBalance) {
            //throw new Exception("Balance limit exceeded, operation is not allowed!");
            return false;
        }
        return true;
    }

    public function decreaseBalance(float $decrease): bool {

        if ($this->isDebitAllowed($decrease)) {
            $br = new Balance($this, $decrease, "debit");
            $this->balance[] = $br;
            $this->amount += -1 * abs($decrease);
            return true;
        } else {
            return false;
        }
    }

    public function syncBalance(): void {
        $balance = 0;
        foreach ($this->balance as $ub) {
            $balance += $ub->getType() === "credit" ? $ub->getBalance() : -1 * abs($ub->getBalance());
        }
        $this->amount = $balance;
    }

    public function increaseBalance(float $increase): void {
        $br = new Balance($this, $increase, "credit");
        $this->entries[] = $br;
        $this->amount += $increase;
    }

}
