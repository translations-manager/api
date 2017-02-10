<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\FileLocation;
use AppBundle\Entity\Phrase;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhraseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file_location', EntityType::class, [
                'property_path' => 'fileLocation',
                'class' => FileLocation::class
            ])
            ->add('domain')
            ->add('key')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Phrase::class
        ]);
    }
}
