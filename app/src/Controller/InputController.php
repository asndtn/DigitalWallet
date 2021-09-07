<?php
/**
 * Input controller.
 */

namespace App\Controller;

use App\Entity\Balance;
use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Wallet;
use App\Form\InputType;
use App\Service\InputService;
use App\Service\WalletService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InputController.
 *
 * @Route("/input")
 *
 * @IsGranted("ROLE_USER")
 */
class InputController extends AbstractController
{
    /**
     * Input service.
     *
     * @var InputService
     */
    private $inputService;

    /**
     * InputController constructor.
     *
     * @param InputService $inputService
     */
    public function __construct(InputService $inputService)
    {
        $this->inputService = $inputService;
    }

    /**
     * Index input.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="input_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');
        $filters['tag_id'] = $request->query->getInt('filters_tag_id');

        $page = $request->query->getInt('page', 1);
        $pagination = $this->inputService->createPaginatedList($page, $this->getUser(), $filters);

        return $this->render(
            'input/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show Input.
     *
     * @param Input $input Input entity
     *
     * @return Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="input_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @IsGranted(
     *     "VIEW",
     *     subject="input",
     * )
     */
    public function show(Input $input): Response
    {
        return $this->render(
            'input/show.html.twig',
            ['input' => $input]
        );
    }

    /**
     * Create action.
     *
     * @param Request  $request  HTTP request
     * @param Wallet   $wallet   Wallet entity
     * @param Balance  $balance  Balance enitty
     * @param Category $category Category entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="input_create",
     * )
     */
    public function create(Request $request, Wallet $wallet, Balance $balance, Category $category): Response
    {
        $input = new Input();
        $form = $this->createForm(InputType::class, $input);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wallet = $input->getWallet();
            $balance = $wallet->getBalance();
            $balance_amount = $balance->getBalanceAmount();
            $input_category = $input->getCategory();
            $category = $input_category->getName();
            $amount = $input->getAmount();
            $input->setDate(new \DateTime());
            $this->inputService->save($input);

            if ($category === 'Income') {
                $balance->setBalanceAmount($balance_amount += $amount);
            } elseif ($category === 'Expense') {
                $balance->setBalanceAmount($balance_amount -= $amount);
            }

            $this->addFlash('success', 'input_created_successfully');

            return $this->redirectToRoute('input_index');
        }

        return $this->render(
            'input/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Input   $input   Input entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="input_edit",
     * )
     *
     * @IsGranted(
     *    "EDIT",
     *     subject="input",
     * )
     */
    public function edit(Request $request, Input $input): Response
    {
        $form = $this->createForm(InputType::class, $input, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->inputService->save($input);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('input_index');
        }

        return $this->render(
            'input/edit.html.twig',
            [
                'form' => $form->createView(),
                'input' => $input,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Input   $input   Input entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="input_delete",
     * )
     *
     * @IsGranted(
     *     "DELETE",
     *     subject="input",
     * )
     */
    public function delete(Request $request, Input $input): Response
    {
        $form = $this->createForm(FormType::class, $input, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->inputService->delete($input);

            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('input_index');
        }

        return $this->render(
            'input/delete.html.twig',
            [
                'form' => $form->createView(),
                'input' => $input,
            ]
        );
    }
}
