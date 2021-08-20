<?php
/**
 * Wallet entity.
 */

namespace App\Entity;

use App\Repository\WalletRepository;
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
     * idWallet_Type.
     *
     * @var int
     *
     * @ORM\ManyToOne(targetEntity=Type::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idWallet_Type;

    /**
     * @ORM\ManyToOne(targetEntity=Currency::class, inversedBy="wallets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency;

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
     * Getter for idWallet_Type.
     *
     * @return Type|int|null
     */
    public function getIdWalletType()
    {
        return $this->idWallet_Type;
    }

    /**
     * Setter for idWallet_Type.
     *
     * @param Type|null $idWallet_Type
     */
    public function setIdWalletType(?Type $idWallet_Type): void
    {
        $this->idWallet_Type = $idWallet_Type;
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

}
