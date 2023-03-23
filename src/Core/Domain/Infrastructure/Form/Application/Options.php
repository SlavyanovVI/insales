<?php
    
    namespace App\Core\Domain\Infrastructure\Form\Application;

    use App\Core\Domain\Model;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class Options extends AbstractType
    {
    
        /**
         * @param FormBuilderInterface $builder
         * @param array $options
         * @return void
         */
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder->add('');
        }
    
        /**
         * @param OptionsResolver $resolver
         * @return void
         */
        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults(
                [
                    'data_class' => Model\Insales\Embed\Options::class,
                ]
            );
        }
    }