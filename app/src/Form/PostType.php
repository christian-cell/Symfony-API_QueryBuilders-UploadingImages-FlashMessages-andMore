<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function PHPSTORM_META\type;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //en builder construimos el formulario , con el campo title el boton de submit con su funcion
        // como clase y los estilos con la propiedad atributo attr
        $builder
            ->add('title')
            //vamos a crear un input para poder cargar las imágenes 
            ->add('attachment' , FileType::class, [
                'mapped' => false
            ])
            ->add('category' , EntityType::class , [
                'class' => Category::class
            ])
            ->add('save', SubmitType::class, [
                'attr'=>[
                    'class' => 'btn btn-primary float-right'
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
