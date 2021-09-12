<?php
/**
 * Balance fixture.
 */

namespace App\DataFixtures;

use App\Entity\Balance;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class BalanceFixtures.
 */
class BalanceFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'balances', function ($i) {
            $balance = new Balance();
            //$balance->setWallet($this->getRandomReference('wallets'));
            $balance->setWallet($this->getReference(WalletFixtures::BALANCE_WALLET));
            $balance->setBalanceAmount($this->faker->randomFloat(2, 0, 1000000));

            return $balance;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [WalletFixtures::class];
    }
}
