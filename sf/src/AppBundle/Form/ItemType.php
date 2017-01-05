<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['required'=>false, 'attr'=>['placeholder'=>'12345']]) // Symfony select type, form in view get data from here
            ->add('price')
            ->add('content')
            ->add('category',
                EntityType::class,
                [
                    'class'=>'AppBundle\Entity\Category',
                    'choice_label'=>'name',
//                    'expanded'=>true,
//                    'multiple'=>false
                ]
            )
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Item' // null for for form without entity, $form->getData()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_item';
    }


}
