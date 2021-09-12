<?php
/**
 * Type entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
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
    private $id;

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
    private $name;

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
     * Getter fo Wallet.
     *
     * @return Collection|Wallet[]
     */
    public function getWallet(): Collection
    {
        return $this->wallet;
    }

    /**
     * Add Wallet.
     *
     * @param Wallet $wallet
     *
     * @return $this
     */
    public function addWallet(Wallet $wallet): self
    {
        if (!$this->wallet->contains($wallet)) {
            $this->wallet[] = $wallet;
            $wallet->setCategory($this);
        }

        return $this;
    }

    /**
     * Remove Wallet.
     *
     * @param Wallet $wallet
     *
     * @return $this
     */
    public function removeWallet(Wallet $wallet): self
    {
        if ($this->wallet->contains($wallet)) {
            $this->wallet->removeElement($wallet);
            // set the owning side to null (unless already changed)
            if ($wallet->getCategory() === $this) {
                $wallet->setCategory(null);
            }
        }

        return $this;
    }
}
