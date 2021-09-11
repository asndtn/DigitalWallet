<?php
/**
 * Balance entity.
 */

namespace App\Entity;

use App\Repository\BalanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Balance.
 *
 * @ORM\Entity(repositoryClass=BalanceRepository::class)
 * @ORM\Table(name="balances")
 */
class Balance
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * balanceAmount.
     *
     * @var float
     *
     * @ORM\Column(type="float")
     *
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\PositiveOrZero
     * @Assert\Type(type="float")
     */
    private $balanceAmount = 0;

    /**
     * Wallet.
     *
     * @ORM\OneToOne(
     *     targetEntity="\App\Entity\Wallet",
     *     inversedBy="balance",
     *     cascade={"persist", "remove"},
     * )
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Wallet")
     */
    private $wallet;

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for balanceAmount.
     *
     * @return float|null balanceAmount
     */
    public function getBalanceAmount(): ?float
    {
        return $this->balanceAmount;
    }

    /**
     * Setter for Balance_Amount.
     *
     * @param float $balanceAmount balance_Amount
     */
    public function setBalanceAmount(float $balanceAmount): void
    {
        $this->balanceAmount = $balanceAmount;
    }

    /**
     * Getter for Wallet.
     *
     * @return Wallet|null Wallet entity
     */
    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    /**
     * Setter for Wallet.
     *
     * @param Wallet $wallet Wallet entity
     */
    public function setWallet(Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }
}
