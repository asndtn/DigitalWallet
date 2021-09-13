<?php
/**
 * Input entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Input.
 *
 * @ORM\Entity(repositoryClass="App\Repository\InputRepository")
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
    private int $id;

    /**
     * Wallet.
     *
     * @var Wallet Wallet
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Wallet",
     *     inversedBy="inputs",
     *     fetch="EXTRA_LAZY",
     * )
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Wallet")
     */
    private Wallet $wallet;

    /**
     * Amount.
     *
     * @var float
     *
     * @ORM\Column(type="float")
     *
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Type("float")
     */
    private float $amount;

    /**
     * Date.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private DateTimeInterface $date;

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
     *
     * @Assert\Length(
     *     min = 2,
     *     max = 255,
     *     minMessage = "Description must be at least {{ limit }} characters long.",
     *     maxMessage = "Description cannot be longer than {{ limit }} characters.",
     *     allowEmptyString = false
     * )
     */
    private string $description;

    /**
     * Category.
     *
     * @var ArrayCollection|Category[] Categories
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Category",
     *     inversedBy="input",
     *     fetch="EXTRA_LAZY"
     * )
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Category")
     */
    private $category;

    /**
     * Tags.
     *
     * @var array
     *
     * @ORM\ManyToMany(
     *     targetEntity="\App\Entity\Tag",
     *     inversedBy="inputs",
     *     fetch="EXTRA_LAZY",
     * )
     * @ORM\JoinTable(name="inputs_tags")
     */
    private $tags;

    /**
     * Input constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
     * Getter for Amount.
     *
     * @return float|null Amount
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * Setter for Amount.
     *
     * @param float $amount Amount
     */
    public function setAmount(float $amount): void
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
    public function setDate(DateTimeInterface $date): void
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

    /**
     * Getter for Category.
     *
     * @return ArrayCollection|Category[]
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Setter for Category.
     *
     * @param Category|null $category Category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Getter for tags.
     *
     * @return Collection|Tag[] Tags collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add tag to collection.
     *
     * @param Tag $tag Tag entity
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }
    }

    /**
     * Remove tag from collection.
     *
     * @param Tag $tag Tag entity
     */
    public function removeTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
    }
}
