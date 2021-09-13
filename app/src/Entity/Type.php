<?php
/**
 * Type entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Type.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 * @ORM\Table(name="types")
 *
 * @UniqueEntity(fields={"name"})
 */
class Type
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
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=45,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     */
    private string $name;

    /**
     * Wallet.
     *
     * @var ArrayCollection|Wallet[] Wallet
     *
     * @ORM\OneToMany(targetEntity=Wallet::class, mappedBy="type", fetch="EXTRA_LAZY")
     */
    private $wallet;

    /**
     * Type constructor.
     */
    public function __construct()
    {
        $this->wallet = new ArrayCollection();
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
     * Getter for Name.
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
     * Getter for Wallet.
     *
     * @return Collection|Wallet[]
     */
    public function getWallet(): Collection
    {
        return $this->wallet;
    }

    /**
     * Add wallet to collection.
     *
     * @param Wallet $wallet Wallet
     */
    public function addWallet(Wallet $wallet): void
    {
        if (!$this->wallet->contains($wallet)) {
            $this->wallet[] = $wallet;
        }
    }

    /**
     * Remove wallet from collection.
     *
     * @param Wallet $wallet Wallet
     */
    public function removeWallet(Wallet $wallet): void
    {
        if ($this->wallet->contains($wallet)) {
            $this->wallet->removeElement($wallet);
        }
    }
}
