<?php

namespace App\Form;

use App\Entity\Project;
use App\Enum\StatusType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',null,array('required'  => true))
            ->add('image', FileType::class, [
                'label' => 'Image (fichier image)',
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
                'data_class' => null,
            ])
           // ->add('filname',null,array('required'  => true))
            ->add('url',null,array('required'  => true))
            ->add('description',null,array('required'  => true))
            ->add('numberTasks',null,array('required'  => true))
            ->add('status',EnumType::class,['class' => StatusType::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
