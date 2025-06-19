<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserController extends AbstractController
{

    #[Route('/api/user', name:'api_user', methods:['POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        // on recupère le contenu de la requette vers l'api et on transforme le json en objet/array PHP
        $response = json_decode($request->getContent(), true);

        // on recupere les informations du nouveau utilisateur
        $userName = $response['user_name'];
        $password = $response['password'];
        $email = $response['email'];

        if (empty($userName) || empty($password) || empty($email)) {
            return $this->json([
                'message' => 'Request field is empty'
            ], 400);
        }

        //on verifie que l'email n'existe pas déja dans notre BDD
        $emailEsxist = $userRepository->findBy(['email' => $email]);

        if (!empty($emailEsxist)) {
            return $this->json([
                'message' => 'This email is already used'
            ], 400);
        }

        //verifier que l'email est de type : exemple@exemple.dom
        if (!preg_match('#^[a-z0-9-_.]+@[a-z0-9-_.]+\.[a-z]{2,3}$#', $email) ) {
            return $this->json([
                'message' => 'This email in not valid'
            ], 400);
        }

        //verifier que le mdp doit contenir au mois 8 caracteres, au moins une majuscule, au moins une miniscule et au moins un caractere special 
        if (!preg_match('#^(?=^.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)#', $password) ) {
            return $this->json([
                'message' => 'This password in not valid'
            ], 400);
        }

        //on instancier l'entite user
        $user = new User();

        //hacher le mot de passe avant le sauvgarde
        $hashedPassword = $passwordHasher->hashPassword($user, $password); // password_hash() de PHP

        //on hydrate l'objet user
        $user->setUserName($userName);
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        // on sauvegarde l'entité review (persist et flush)
        $userRepository->add($user, true);

        // on génère le token
        $token = $JWTManager->create($user);

        // on return un message de success
        return $this->json([
            'message' => 'success saving data',
            'token' => $token,
            'username' => $userName,
            'role' => ['ROLE_USER']
        ]);
    }

    #[Route('/api/secure/user', name:'api_user_edit', methods:['PUT'])]
    public function edit(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        // on recupère le contenu de la requette vers l'api et on transforme le json en objet/array PHP
        $response = json_decode($request->getContent(), true);

        // on recupere les informations du nouveau utilisateur
        $userName = $response['user_name'];
        $password = $response['new_password'];
        $email = $response['email'];

        if (empty($userName) || empty($email)) {
            return $this->json([
                'message' => 'Request field is empty'
            ], 400);
        }

        //on recupère l'utilisateur
        $user = $this->getUser();

        //on hydrate l'objet user avec le mot de passe seulement si l'utilisateur veut le changer
         if (!empty($password)) {

            //verifier que le mdp doit contenir au mois 8 caracteres, au moins une majuscule, au moins une miniscule et au moins un caractere special 
            if (!preg_match('#^(?=^.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)#', $password) ) {
                return $this->json([
                    'message' => 'This password in not valid'
                ], 400);
            }

            //hacher le mot de passe avant le sauvgarde
            $hashedPassword = $passwordHasher->hashPassword($user, $password); // password_hash() de PHP
            $user->setPassword($hashedPassword);
        }

        //on verifie que l'email n'existe pas déja dans notre BDD
        $emailEsxist = $userRepository->findBy(['email' => $email]);
        
        // on verfie que l'email n'existe pas et au meme temps que ce n'est pas celui qui est relier avec ce compte 
        if (!empty($emailEsxist) && ($email != $user->getEmail())) {
            return $this->json([
                'message' => 'This email is already used'
            ], 400);
        }

        //verifier que l'email est de type : exemple@exemple.dom
        if (!preg_match('#^[a-z0-9-_.]+@[a-z0-9-_.]+\.[a-z]{2,3}$#', $email) ) {
            return $this->json([
                'message' => 'This email in not valid'
            ], 400);
        }

        //on hydrate l'objet user
        $user->setUserName($userName);
        $user->setEmail($email);

        //on génère le token
        $token = $JWTManager->create($user);

        // on sauvegarde l'entité review (persist et flush)
        $userRepository->add($user, true);

        $role = $user->getRoles();

        // on return un message de success
        return $this->json([
            'message' => 'success editing data',
            'token' => $token,
            'username' => $userName,
            'role' => $role
        ]);
    }

    #[Route('/api/secure/user/details', name:'api_user_details', methods:['GET'])]
    public function userDetails(): JsonResponse
    {
        // Option 1: decoder le token
        // // recuperation du token de header
        // $token = $request->headers->get('Authorization');

        // // decode du token
        // $tokenParts = explode('.', $token);  
        // $tokenPayload = base64_decode($tokenParts[1]);
        // $jwtPayload = json_decode($tokenPayload);
        // $email = $jwtPayload->email;
        // $role = $jwtPayload->roles;

        // Option 2: Utiliser le user connecté
        $user = $this->getUser();
        $userName = $user->getUserIdentifier();
        $userRole = $user->getRoles();

        // on return un message de success
        return $this->json([
            'role' => $userRole,
            'user_name' => $userName
        ]);
    }
}
