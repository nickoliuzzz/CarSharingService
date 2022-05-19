<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ProfileController extends AbstractController
{
    public function index(#[CurrentUser]User $user, Request $request): Response
    {
        $form = $this->createForm(UserUpdateType::class, $user);



        return $this->renderForm('profile/index.html.twig', [
            'form' => $form
        ]);
    }
}
