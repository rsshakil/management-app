<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Capture the intended URL
        $targetPath = $request->getSession()->get('_security.main.target_path', '');

        $translatedEmailLabelText = $this->translator->trans('field.email');
        $translatedPasswordLabelText = $this->translator->trans('field.password');
        // dd($targetPath);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'translation_domain' => 'admin',
            'page_title' => 'ADMIN LOGIN',
            'csrf_token_intention' => 'authenticate',
            'username_label' => $translatedEmailLabelText,
            'password_label' => $translatedPasswordLabelText,
            'sign_in_label' => 'Log in',
            'username_parameter' => 'email',
            'password_parameter' => 'password',
            'target_path' => $targetPath,
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
