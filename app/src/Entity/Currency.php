<?php
/**
 * Currency entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Currency.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyRepository")
 * @ORM\Table(name="currencies")
 *
 * @UniqueEntity(fields={"name"})
 */
class Currency
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
    private int $id;

    /**
     * Name.
     *
     * @ORM\Column(
     *     type="string",
     *     length=3,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Currency
     * @Assert\Length(
     *     min="3",
     *     max="3",
     *     exactMessage = "This value should have exactly {{ limit }} characters.",
     * )
     */
    private ?string $name;

    /**
     * Wallets.
     *
     * @var ArrayCollection|Wallet[] Wallets
     *
     * @ORM\OneToMany(
     *     targetEntity=Wallet::class,
     *     mappedBy="currency",
     *     fetch="EXTRA_LAZY",
     * )
     */
    private $wallets;

    /**
     * Currency entity constructor.
     */
    public function __construct()
    {
        $this->wallets = new ArrayCollection();
    }

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
     * Getter for name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for Name.
     *
     * @param string $name Name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for Wallets.
     *
     * @return Collection|Wallet[]
     */
    public function getWallets(): Collection
    {
        return $this->wallets;
    }

    /**
     * Add wallet to collection.
     *
     * @param Wallet $wallet Wallet entity
     */
    public function addWallet(Wallet $wallet): void
    {
        if (!$this->wallets->contains($wallet)) {
            $this->wallets[] = $wallet;
        }
    }

    /**
     * Remove wallet.
     *
     * @param Wallet $wallet Wallet entity
     */
    public function removeWallet(Wallet $wallet): void
    {
        if ($this->wallets->contains($wallet)) {
            $this->wallets->removeElement($wallet);
        }
    }
}
