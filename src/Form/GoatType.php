<?php

namespace App\Form;

use App\Entity\Goat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;




class GoatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codigo', IntegerType::class, [
            'label' => 'Código',
            ])       
            ->add('leite_prod', NumberType::class, [
                'label' => 'Leite',
                ])               
            ->add('racao_cons', NumberType::class, [
                'label' => 'Ração',
                ])
            ->add('peso', NumberType::class, [
                'label' => 'Peso',
                ])
            ->add('data_nasc', DateType::class,[
            'label' => 'Data de Nascimento',
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'max' => (new \DateTime())->format('Y-m-d'), // Define o valor máximo para a data de hoje
                ],

                'format' => 'yyyy-MM-dd',
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
