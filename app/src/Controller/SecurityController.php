<?php
/**
 * Security controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\PasswordChangeType;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController.
 */
class SecurityController extends AbstractController
{
    /**
     * Login action.
     *
     * @param AuthenticationUtils $authenticationUtils Authentication Utils
     *
     * @return Response HTTP response
     *
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error,
            ]
        );
    }

    /**
     * Register action.
     *
     * @param Request                      $request         HTTP request
     * @param UserRepository               $userRepository  User repository
     * @param UserPasswordEncoderInterface $passwordEncoder Password encoder
     *
     * @return Response Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/register",
     *     methods={"GET", "POST"},
     *     name="app_register",
     * )
     */
    public function register(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles([User::ROLE_USER]);
            $userRepository->save($user);

            $this->addFlash('success', 'message_registered_successfully');

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'security/register.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Password change action.
     *
     * @param Request                      $request         HTTP Request
     * @param User                         $user            User entity
     * @param UserRepository               $userRepository  User Repository
     * @param UserPasswordEncoderInterface $passwordEncoder Password Encoder
     *
     * @return Response HTTP Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "user/{id}/passwordChange",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="app_changePassword",
     * )
     */
    public function passwordChange(Request $request, User $user, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(PasswordChangeType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                )
            );

            $userRepository->save($user);

            $this->addFlash('success', 'message_updated_successfully');
        }

        return $this->render(
            'security/passwordchange.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }

    /**
     * Logout action.
     *
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
