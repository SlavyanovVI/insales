<?php
    
    namespace App\Core\Domain\Infrastructure\Form\Application;

    use App\Core\Domain\Model;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    /**
     * Class Authentication
     * @package App\Core\Domain\Infrastructure\Form\Application
     */
    final class Authentication extends AbstractType
    {
        
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->add(
                    'login',
                    TextType::class,
                    [
                        'required' => true,
                        'label' => 'configuration.auth.login',
                    ]
                )
                ->add(
                    'password',
                    PasswordType::class,
                    [
                        'required' => true,
                        'label' => 'configuration.auth.password',
                    ]
                )
            ;
        }
    
        /**
         * @param OptionsResolver $resolver
         * @return void
         */
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(
                [
                    'data_class' => Model\Insales\Embed\Authentication::class,
                ]
            );
        }
    }