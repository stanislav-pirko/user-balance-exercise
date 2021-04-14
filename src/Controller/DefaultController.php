<?php

namespace User\Balance\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Balance\Entity\User;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'user_list')]
    public function index(): Response
    {;
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('controller/default/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/{id}', name: 'user_info', requirements: ['id' => '\d+'])]
    public function user(int $id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        return $this->render('controller/default/user.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route(
        '/balance/{id}/decrease/{value}',
        methods: ['GET'],
        name: 'user_balance_decrease',
        requirements: ['id' => '\d+', 'value' => '^[0-9]+(\.[0-9]{1,2})?$']
    )]
    public function decreaseBalance(int $id, float $value): Response
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
        $result = $user->decreaseBalance($value);

        if ($result) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $result ? $this->json(['result' => true]) : $this->json(['result' => false], 400);
    }

    #[Route(
        '/balance/{id}/increase/{value}',
        name: 'user_balance_increase',
        methods: ['GET'],
        requirements: ['id' => '\d+', 'value' => '^[0-9]+(\.[0-9]{1,2})?$']
    )]
    public function increaseBalance(int $id, float $value): Response
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
        $user->increaseBalance($value);
        $this->getDoctrine()->getManager()->flush();

        return $this->json(['result' => true]);
    }
}
