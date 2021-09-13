<?php
/**
 * Type fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TypeFixtures.
 */
class TypeFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'types', function ($i) {
            $type = new Type();
            $type->setName($this->faker->word);

            return $type;
        });
        $manager->flush();
    }
}
