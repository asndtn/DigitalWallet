<?php
/**
 * Wallet entity.
 */

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    private $id;

    /**
     * idUser.
     *
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $idUser;

    /**
     * Type.
     *
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="wallets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * Currency.
     *
     * @ORM\ManyToOne(targetEntity=Currency::class, inversedBy="wallets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency;

    /**
     * Inputs.
     *
     * @ORM\OneToMany(targetEntity=Input::class, mappedBy="wallets")
     */
    private $inputs;

/**    public function __construct()
    {
        $this->inputs = new ArrayCollection();
    } **/

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
     * Getter for idUser.
     *
     * @return int|null idUser
     */
    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    /**
     * Setter for idUser.
     *
     * @param int $idUser idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * Getter for Type.
     *
     * @return string|null|Type
     */
    public function getType(): ?Type
    {
        return $this->type;
    }

    /**
     * Setter for Type.
     *
     * @param Type|null $type
     */
    public function setType(?Type $type): void
    {
        $this->type = $type;
    }

    /**
     * Getter for Currency.
     *
     * @return string|null|Currency
     */
    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    /**
     * Setter for Currency.
     *
     * @param Currency|null $currency
     */
    public function setCurrency(?Currency $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return Collection|Input[]
     */
    public function getInputs(): Collection
    {
        return $this->inputs;
    }

    public function addInput(Input $input): self
    {
        if (!$this->inputs->contains($input)) {
            $this->inputs[] = $input;
            $input->setWallet($this);
        }

        return $this;
    }

    public function removeInput(Input $input): self
    {
        if ($this->inputs->removeElement($input)) {
            // set the owning side to null (unless already changed)
            if ($input->getWallet() === $this) {
                $input->setWallet(null);
            }
        }

        return $this;
    }

}
