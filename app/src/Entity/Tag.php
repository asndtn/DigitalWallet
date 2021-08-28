<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tags")
 *
 * @UniqueEntity(fields={"name"})
 */
class Tag
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
     *     nullable=true
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
    private $code;

    /**
     * Inputs.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Input[] Inputs
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Input", mappedBy="tags")
     */
    private $inputs;

    /**
     * Tag constructor.
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
     * Getter for name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for name.
     *
     * @param string|null $name Name
     */
    public function setName(?string $name): void
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
     * Getter for inputs.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Input[] Inputs collection
     */
    public function getInputs(): Collection
    {
        return $this->inputs;
    }

    /**
     * Add input to collection.
     *
     * @param \App\Entity\Input $input Input entity
     */
    public function addInput(Input $input): void
    {
        if (!$this->inputs->contains($input)) {
            $this->inputs[] = $input;
            $input->addTag($this);
        }
    }

    /**
     * Remove input from collection.
     *
     * @param \App\Entity\Input $input Input entity
     */
    public function removeInput(Input $input): void
    {
        if ($this->inputs->contains($input)) {
            $this->inputs->removeElement($input);
            $input->removeTag($this);
        }
    }
}