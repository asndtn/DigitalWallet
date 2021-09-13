<?php
/**
 * DateRange type.
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

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
        $builder->add(
            'fromDate',
            DateType::class,
            [
                'widget' => 'single_text',
                'label' => 'label_from',
                'html5' => 'false',
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ]
        );

        $builder->add(
            'to',
            DateType::class,
            [
                'widget' => 'single_text',
                'label' => 'label_to',
                'html5' => 'false',
                'attr' => [
                    'class' => 'js-datepicker',
                ],
            ]
        );
    }
}
