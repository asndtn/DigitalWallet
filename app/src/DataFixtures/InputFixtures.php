<?php
/**
 * Input fixture.
 */

namespace App\DataFixtures;

use App\Entity\Input;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class InputFixtures.
 */
class InputFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'inputs', function ($i) {
            $input = new Input();
            $input->setWallet($this->getRandomReference('wallets'));
            $input->setCategory($this->getRandomReference('categories'));
            $input->setAmount($this->faker->randomFloat(null, 0, null));
            $input->setDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $input->setDescription($this->faker->sentence);

            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0, 5)
            );

            foreach ($tags as $tag) {
                $input->addTag($tag);
            }

            return $input;
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
        return [WalletFixtures::class, CategoryFixtures::class, TagFixtures::class];
    }
}
