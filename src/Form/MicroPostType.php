<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 25.10.18
 * Time: 11:21
 */

namespace App\Form;


use App\Entity\MicroPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MicroPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // добавляем два поля
        $builder->add('text', TextareaType::class, ['label' => false])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // устанавлием обработчик, говорим что после сабмита формы нам должен вернуть экземпляр данного класса
        $resolver->setDefaults(
            ['data_class' => MicroPost::class]
        );
    }

}