<?php

/**
 * Wallet fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Wallet;
use Doctrine\Persistence\ObjectManager;

/**
 * Class WalletFixtures.
 */
class WalletFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $wallet = new Wallet();
            $wallet->setIdUser($this->faker->randomDigit);
            $wallet->setIdWalletType($this->faker->randomDigit);
            $wallet->setIdWalletCurrency($this->faker->randomDigit);
            $this->manager->persist($wallet);
        }

        $manager->flush();
    }
}
