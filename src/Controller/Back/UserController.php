<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/back/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'back_user', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('back/user/index.html.twig', [
            'users' => $userRepository->findByRoleAdminManager(),
        ]);
    }

    #[Route('/new', name: 'back_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        // Ci dessous on créer le formulaire en utilisant la classe UserType
        $form = $this->createForm(UserType::class, $user);

        // gere la soumission du formulaire
        $form->handleRequest($request);

        // On check si le formulaire a été soumis (donc si un utilisateur vient d'etre ajouté) ou pas
        if ($form->isSubmitted() && $form->isValid()) {

            // on hache le mot de passe avec le "service" adapté
            // le mot de passe en clair se trouve dans l'objet $user mis à jour par le formulaire
            // et contient donc le mot de passe saisi dans le formulaire et acheminé par la requête HTTP
            $plainTextPassword = $user->getPassword();
            // mot de passe haché
            $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword); // password_hash() de PHP
            // on écrase le mot de passe en clair par le mot de passe haché, dans l'objet $user
            $user->setPassword($hashedPassword);

            // on sauve en BDD
            $userRepository->add($user, true);

            return $this->redirectToRoute('back_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'back_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'back_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // doit-on hacher et remplacer le mot de passe ?
            // si le champ de formulaire est rempli, on hache et on remplace
        if ($form->get('password')->getData()) {
            // on récupère le mot de passe *non mappé* saisi dans le formulaire
            $plainTextPassword = $form->get('password')->getData(); // $plainTextPassword = $_POST['password'];
            $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword); // password_hash() de PHP
            $user->setPassword($hashedPassword);
        }
            // }else{
            //     $password = $user->getPassword();
            //     $user->setPassword($password);
            // }

            // dd($user);
            $userRepository->add($user, true);

            return $this->redirectToRoute('back_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'back_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('back_user', [], Response::HTTP_SEE_OTHER);
    }

   
}
