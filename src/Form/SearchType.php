<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Tytuł',
                'required' => false
            ])
            ->add('isbn', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Number ISBN',
                'required' => false
            ])
            ->add('author_id', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'getFullName',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Autor',
                'required' => false
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Szukaj',
                'attr' => [
                    'class' => 'btn btn-outline-primary w-100'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
