<?php
/**
 * Category entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 *
 * @UniqueEntity(fields={"name"})
 */
class Category
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
    private ?string $name;

    /**
     * Input.
     *
     * @var ArrayCollection|Input[] Input
     *
     * @ORM\OneToMany(targetEntity=Input::class, mappedBy="category", fetch="EXTRA_LAZY")
     *
     * @Assert\Type(type="Doctrine\Common\Collections\ArrayCollection")
     */
    private $input;

    /**
     * Code.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=45
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     *
     * @Gedmo\Slug(fields={"name"})
     */
    private string $code;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->input = new ArrayCollection();
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
     * Getter for Code.
     *
     * @return string|null Code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Setter for Code.
     *
     * @param string $code Code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Getter for Input.
     *
     * @return Collection|Input[] Input collection
     */
    public function getInput(): Collection
    {
        return $this->input;
    }

    /**
     * Add input to collection.
     *
     * @param Input $input Input entity
     */
    public function addInput(Input $input): void
    {
        if (!$this->input->contains($input)) {
            $this->input[] = $input;
        }
    }

    /**
     * Remove input from collection.
     *
     * @param Input $input Input entity
     */
    public function removeInput(Input $input): void
    {
        if ($this->input->contains($input)) {
            $this->input->removeElement($input);
        }
    }
}
