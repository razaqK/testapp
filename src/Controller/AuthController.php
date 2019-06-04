<?php


namespace App\Controller;


use App\Constant\Messages;
use App\Entity\User;
use App\Security\Authenticator;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends BaseController
{
    private $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function generateJWTToken(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $validator = $this->validateParameters($data, ['email' => 'required']);
        if (!$validator['status']) {
            return $this->sendError($validator['message'], 400, $validator['data']);
        }

        $user = $this->getDoctrine()->getManager()->getRepository(User::class)
            ->findOneBy(['email' => $data['email']]);
        if (!$user) {
            return $this->sendError(sprintf(Messages::NOT_FOUND, 'user'), 404);
        }

        $token = $this->authenticator->generate(['role' => $user->getRole(), 'token' => $user->getToken()]);

        return $this->sendSuccess($token);
    }

    public function getCustomerOrders(Request $request, $id)
    {
        $user = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findOneBy(['id' => $id]);
        if (empty($user)) {
            return $this->sendError(sprintf(Messages::NOT_FOUND, 'user'), 404);
        }

        $page = $request->get('page');
        $limit = $request->get('limit');

        $page = !empty($page) ? $page : 0;
        $limit = !empty($limit) ? $limit : 20;
        $products = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAllOrders($page, $limit, $user->getId());

        return $this->sendSuccess(User::normalizer($products));
    }
}