<?php

namespace App\Twig\Components;

use App\Form\RegistrationType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class Registration extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    
    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(RegistrationType::class);
    }
}
