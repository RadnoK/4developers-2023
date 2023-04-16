<?php

class Model {}
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

$builder = null;

$builder
    ->add('type', ChoiceType::class, [
        'choices' => [],
        'choice_value' => fn (?Model $company): string => $company->code ?? '',
        'choice_label' => fn (?Model $company): string => $company->name ?? '',
    ])
    ->add('startDate', DateType::class, [
        'widget' => 'single_text'
    ])
    ->add('endDate', DateType::class, [
        'widget' => 'single_text'
    ])
    ->add('email', EmailType::class)
    ->add('submit', SubmitType::class, [
        'label' => 'app.ui.historical_data.submit',
    ])
;
