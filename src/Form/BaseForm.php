<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GroupSequence;

class BaseForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ([] !== $options['transitions']) {
            $builder->add(
                'transition',
                HiddenType::class,
                [
                    'data' => array_values($options['transitions'])[0],
                    'mapped' => false,
                ],
            );
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['submit_enabled'] = $options['submit_enabled'];
        $view->vars['rotation_enabled'] = $options['rotation_enabled'];
        $view->vars['jump_to_pending_enabled'] = $options['jump_to_pending_enabled'];
        $view->vars['previous_entity_edit_url'] = $options['previous_entity_edit_url'];
        $view->vars['next_entity_edit_url'] = $options['next_entity_edit_url'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('previous_entity_edit_url', null);
        $resolver->setDefault('next_entity_edit_url', null);
        $resolver->setDefault('submit_enabled', true);
        $resolver->setDefault('rotation_enabled', true);
        $resolver->setDefault('jump_to_pending_enabled', true);
        $resolver->setDefault('error_bubbling', true);
        $resolver->setRequired(['transitions']);

        $resolver->setDefault('validation_groups', new GroupSequence(['Default']));
    }

    public function getBlockPrefix(): string
    {
        return 'base';
    }
}
