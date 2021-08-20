<?php
/**
 * Currency fixture.
 */

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CurrencyFixtures.
 */
class CurrencyFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'currencies', function ($i) {
            $currency = new Currency();
            $currency->setName($this->faker->currencyCode);

            return $currency;
        });

        $manager->flush();
    }
}