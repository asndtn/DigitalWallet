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
     * @ORM\Column(type="integer")
     */
    private $idWallet_Type;

    /**
     * idWallet_Currency.
     *
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $idWallet_Currency;

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
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * Getter for idWallet_Type.
     *
     * @return int|null idWallet_Type
     */
    public function getIdWalletType(): ?int
    {
        return $this->idWallet_Type;
    }

    /**
     * Setter for idWallet_Type.
     *
     * @param int $idWallet_Type
     */
    public function setIdWalletType(int $idWallet_Type): void
    {
        $this->idWallet_Type = $idWallet_Type;
    }

    /**
     * Getter for idWallet_Currency.
     *
     * @return int|null
     */
    public function getIdWalletCurrency(): ?int
    {
        return $this->idWallet_Currency;
    }

    /**
     * Setter for idWallet_Currency.
     *
     * @param int $idWallet_Currency
     */
    public function setIdWalletCurrency(int $idWallet_Currency): void
    {
        $this->idWallet_Currency = $idWallet_Currency;
    }
}
