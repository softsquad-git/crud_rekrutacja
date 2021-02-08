<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Tytuł',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('publication_year', TextType::class, [
                'label' => 'Rok wydania',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('isbn', TextType::class, [
                'label' => 'Numer ISBN',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('cover_src', FileType::class, [
                'label' => 'Zdjęcie okładki',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('author_id', EntityType::class, [
                'label' => 'Autor',
                'class' => Author::class,
                'choice_label' => 'getFullName',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => [
                    'class' => 'btn btn-sm btn-outline-success'
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
