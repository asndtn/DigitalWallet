<?php
/**
 * DateRange type.
 */

namespace App\Form;

use App\Entity\Input;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DateRangeType.
 */
class DateRangeType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder->add(
//            'date', 'date', ['from' => \DateTime::class, 'to' => \DateTime::class]
//        );
        $builder->add(
            'fromDate',
            DateType::class,
            [
                'label' => 'label_from',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'datepicker',
                ],
            ]
        );

        $builder->add(
            'to',
            DateType::class,
            [
                'label' => 'label_to',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'datepicker',
                ],
            ]
        );
    }
}
