<?php
/**
 * Input entity.
 */

namespace App\Entity;

use App\Repository\InputRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Input.
 *
 * @ORM\Entity(repositoryClass=InputRepository::class)
 * @ORM\Table(name="inputs")
 */
class Input
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
     * Wallet.
     *
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="inputs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wallet;

    /**
     * Category.
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $category;

    /**
     * Amount.
     *
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * Date.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * Description.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    private $description;

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
     * Getter for Wallet.
     *
     * @return Wallet|null Wallet
     */
    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    /**
     * Setter for Wallet.
     *
     * @param Wallet|null $wallet Wallet
     */
    public function setWallet(?Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }

    /**
     * Getter for Category.
     *
     * @return string|null Category
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * Setter for Category.
     *
     * @param string $category Category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * Getter for Amount.
     *
     * @return string|null Amount
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * Setter for Amount.
     *
     * @param string $amount Amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Getter for Date.
     *
     * @return DateTimeInterface|null Date
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Setter for Date.
     *
     * @param DateTimeInterface $date Date
     */
    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    /**
     * Getter for Description.
     *
     * @return string|null Description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for Description.
     *
     * @param string|null $description Description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
