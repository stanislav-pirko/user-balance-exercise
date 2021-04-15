<?php

namespace User\Balance\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Balance\Entity\User;

class DefaultController extends AbstractController
{
    #[Route(
        '/',
        name: 'user_list',
        methods: ['GET']
    )]
    public function index(): Response
    {;
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->getUsers();

        return $this->json(['users' => $users]);
    }

    #[Route(
        '/user/{id}',
        name: 'user_info',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function user(int $id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->getUser($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        return $this->json(['user' => $user]);
    }

    #[Route(
        '/balance/{id}/decrease',
        methods: ['PUT'],
        name: 'user_balance_decrease',
        requirements: ['id' => '\d+']
    )]
    public function decreaseBalance(int $id, Request $request): Response
    {
        /* @var $user \User\Balance\Entity\User */
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }
        $value = (float) $request->get('value');
        $result = $user->decreaseBalance($value);

        if ($result) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $result ? $this->json(['result' => true]) : $this->json(['result' => false], 400);
    }

    #[Route(
        '/balance/{id}/increase',
        name: 'user_balance_increase',
        methods: ['PUT'],
        requirements: ['id' => '\d+']
    )]
    public function increaseBalance(int $id, Request $request): Response
    {
        /* @var $user \User\Balance\Entity\User */
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }
        $value = (float) $request->get('value');
        $user->increaseBalance($value);
        $this->getDoctrine()->getManager()->flush();

        return $this->json(['result' => true]);
    }
}
