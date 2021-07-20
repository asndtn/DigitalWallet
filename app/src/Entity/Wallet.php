<?php

/**
 * Wallet entity.
 */

namespace App\Entity;


use App\Repository\WalletRepository;
#use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Wallet.
 *
 * @ORM\Entity(repositoryClass="App\Repository\WalletRepository")
 * @ORM\Table(name="wallet")
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
     * id User.
     *
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $idUser;

    /**
     * id Wallet_Type.
     *
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $idWallet_Type;

    /**
     * id Wallet_Currency.
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
     * Getter for IdUser.
     *
     * @return int|null IdUser
     */
    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    /**
     * Setter for IdUser
     *
     * @param int $idUser idUser
     */
    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
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
     * @param int $idWallet_Type idWallet_Type
     */
    public function setIdWalletType(int $idWallet_Type): self
    {
        $this->idWallet_Type = $idWallet_Type;

        return $this;
    }

    /**
     * Getter for idWallet_Currency.
     *
     * @return int|null idWallet_Currency
     */

    public function getIdWalletCurrency(): ?int
    {
        return $this->idWallet_Currency;
    }

    /**
     * Setter for id Wallet_Currency.
     *
     * @param int $idWallet_Currency
     */

    public function setIdWalletCurrency(int $idWallet_Currency): self
    {
        $this->idWallet_Currency = $idWallet_Currency;

        return $this;
    }
}
