<?php
/**
 * Wallet entity.
 */

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Wallet.
 *
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 * @ORM\Table(name="wallets")
 */
class Wallet
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
     * Type.
     *
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="wallet", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Type")
     */
    private $type;

    /**
     * Currency.
     *
     * @ORM\ManyToOne(targetEntity=Currency::class, inversedBy="wallets", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Currency")
     */
    private $currency;

    /**
     * Inputs.
     *
     * @var ArrayCollection|Input[] Input
     *
     * @ORM\OneToMany(
     *     targetEntity="\App\Entity\Input",
     *     mappedBy="wallet",
     *     fetch="EXTRA_LAZY"
     * )
     */
    private $inputs;

    /**
     * Owner.
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\User")
     */
    private User $owner;

    /**
     * Balance.
     *
     * @ORM\OneToOne(
     *     targetEntity="\App\Entity\Balance",
     *     mappedBy="wallet",
     *     cascade={"persist", "remove"},
     *     fetch="EXTRA_LAZY"
     * )
     *
     * @Assert\Type(type="App\Entity\Balance")
     */
    private ?Balance $balance;

    /**
     * Wallet constructor.
     */
    public function __construct()
    {
        $this->inputs = new ArrayCollection();
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
     * Getter for Type.
     *
     * @return string|Type|null
     */
    public function getType(): ?Type
    {
        return $this->type;
    }

    /**
     * Setter for Type.
     *
     * @param Type|null $type Type
     */
    public function setType(?Type $type): void
    {
        $this->type = $type;
    }

    /**
     * Getter for Currency.
     *
     * @return string|Currency|null
     */
    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    /**
     * Setter for Currency.
     *
     * @param Currency|null $currency Currency
     */
    public function setCurrency(?Currency $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Getter for inputs.
     *
     * @return Collection|Input[] Inputs collection
     */
    public function getInputs(): Collection
    {
        return $this->inputs;
    }

    /**
     * Add input to collection.
     *
     * @param Input $input Input entity
     */
    public function addInput(Input $input): void
    {
        if (!$this->inputs->contains($input)) {
            $this->inputs[] = $input;
        }
    }

    /**
     * Remove input from collection.
     *
     * @param Input $input Input entity
     */
    public function removeInput(Input $input): void
    {
        if ($this->inputs->contains($input)) {
            $this->inputs->removeElement($input);
        }
    }

    /**
     * Getter for Owner.
     *
     * @return Collection|User[] User collection
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * Setter for Owner.
     *
     * @param User|null $owner Owner
     */
    public function setOwner(?User $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * Getter for Balance.
     *
     * @return Balance|null Balance
     */
    public function getBalance(): ?Balance
    {
        return $this->balance;
    }

    /**
     * Setter for Balance.
     *
     * @param Balance $balance Balance
     */
    public function setBalance(Balance $balance): void
    {
        // set the owning side of the relation if necessary
        if ($balance->getWallet() !== $this) {
            $balance->setWallet($this);
        }

        $this->balance = $balance;
    }
}
