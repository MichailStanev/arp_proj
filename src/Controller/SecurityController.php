<?php

namespace App\Controller;

use App\Entity\User;
use App\Doctrine\Paginator;
use App\Form\EditUserFormType;
use App\Form\RegistrationFormType;
use App\Form\UserSettingsFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController {
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/user-settings', name: 'app_user_settings')]
    public function userSettings(EntityManagerInterface $entityManager, Request $request): Response {
        $id = $this->getUser()->getId();
        $user = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(UserSettingsFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_user_settings');
        }

        return $this->render('security/users/user-settings.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/users', name: 'app_users')]
    public function users( UserRepository $userRepository, Request $request ): Response {
        if (!in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true)) {
            return $this->redirectToRoute('app_dashboard');
        }
        $form = null;

        return $this->render('security/users/users.html.twig', [
            'paginator' => (new Paginator($userRepository->getFilterQuery($form, $request)))->paginate($request->get('page',1))
        ]);
    }

    #[Route(path: '/users/edit/{id}', name: 'app_edit_user')]
    public function editUser($id, EntityManagerInterface $entityManager, Request $request): Response {
        $user = $entityManager->getRepository(User::class)->find($id);
        if (NULL === $user){
            return $this->redirectToRoute('app_users');
        }
        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_users');
        }

        return $this->render('security/users/edit-user.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/users/delete/{id}', name: 'app_delete_user')]
    public function deleteUser($id, EntityManagerInterface $entityManager): Response {
        $vehicle = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($vehicle);
        $entityManager->flush();

        return $this->redirectToRoute('app_users');
    }

    #[Route(path: '/users/add', name: 'app_add_user')]
    public function addUser(): Response {
        return $this->render('security/users/add-user.html.twig');
    }
}
