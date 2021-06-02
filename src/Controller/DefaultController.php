<?php

namespace User\Balance\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Balance\Entity\User;
use User\Balance\Entity\Balance;
use Doctrine\DBAL\LockMode;

class DefaultController extends AbstractController {

    #[Route(
                '/',
                name: 'user_list',
                methods: ['GET']
        )]
    public function index(): Response {
        ;
        $users = $this->getDoctrine()
                ->getRepository(User::class)
                ->getUsers();

        return $this->json(['users' => $users]);
    }

    #[Route(
                '/user/create',
                name: 'user_create',
                methods: ['GET']
        )]
    public function createUser(): Response {

        $em = $this->getDoctrine()->getManager();
        $user = new User("user4", "user4@mail.com", "user4 address");
        $em->persist($user);
        $em->flush();
        return $this->json(['user' => $user]);
    }

    #[Route(
                '/user/{id}',
                name: 'user_info',
                requirements: ['id' => '\d+'],
                methods: ['GET']
        )]
    public function user(int $id): Response {
        $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->getUser($id);

        if (!$user) {
            throw $this->createNotFoundException(
                            'No user found for id ' . $id
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
    public function decreaseBalance(int $id, Request $request): Response {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        try {
            $user = $em->find(User::class, $id, LockMode::PESSIMISTIC_READ);

            if (!$user) {
                throw $this->createNotFoundException(
                                'No user found for id ' . $id
                );
            }
            $value = (float) $request->get('value');
            $tb = $user->getTotalBalance();
            $result = $tb->decreaseBalance($value);
            $b = new Balance($tb, $value, "debit");
            $tb->syncBalance();
            
            $em->persist($tb);
            $em->persist($b);
            $em->flush();

            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            throw $e;
        }

        //return $this->json(['result' => true, "balance" => $tb->getAmount()]);
        return $result ? $this->json(['result' => true, "balance" => $tb->getBalance(), "amount" => $tb->getAmount()]) : $this->json(['result' => false], 400);
    }

    #[Route(
                '/balance/{id}/increase',
                name: 'user_balance_increase',
                methods: ['PUT'],
                requirements: ['id' => '\d+']
        )]
    public function increaseBalance(int $id, Request $request): Response {

        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->beginTransaction(); // suspend auto-commit
        try {
            $user = $em->find(User::class, $id, LockMode::PESSIMISTIC_READ);

            if (!$user) {
                throw $this->createNotFoundException(
                                'No user found for id ' . $id
                );
            }
            $value = (float) $request->get('value');
            $tb = $user->getTotalBalance();
            $result = $tb->increaseBalance($value);
            $b = new Balance($tb, $value, "credit");
            $tb->syncBalance();

            $em->persist($tb);
            $em->persist($b);
            
            $em->flush();

            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            throw $e;
        }

        return $this->json(['result' => true, "balance" => $tb->getBalance(), "amount" => $tb->getAmount()]);
    }

}
