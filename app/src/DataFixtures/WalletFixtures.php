<?php
/**
 * Wallet fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Wallet;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class WalletFixtures.
 */
class WalletFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'wallets', function ($i) {
            $wallet = new Wallet();
            $wallet->setType($this->getRandomReference('types'));
            $wallet->setCurrency($this->getRandomReference('currencies'));
            $wallet->setOwner($this->getRandomReference('users'));

            return $wallet;
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
        return [TypeFixtures::class, CurrencyFixtures::class, UserFixtures::class];
    }
}
