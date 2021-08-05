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
        $this->faker = Factory::create();
        $this->manager = $manager;

        for ($i = 0; $i < 10; ++$i) {
            $wallet = new Wallet();
            $wallet->setIdUser($this->faker->randomDigitNotNull);
            $wallet->setIdWalletType($this->faker->randomDigitNotNull);
            $wallet->setIdWalletCurrency($this->faker->randomDigitNotNull);
            $this->manager->persist($wallet);
        }
        $manager->flush();
    }
}
