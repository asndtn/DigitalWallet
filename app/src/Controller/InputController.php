<?php
/**
 * Input controller.
 */

namespace App\Controller;
require_once __DIR__.'/../../vendor/autoload.php';

use App\Entity\Balance;
use App\Entity\Input;
use App\Form\DateRangeType;
use App\Form\InputType;
use App\Service\InputService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
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
     * @param InputService $inputService Input service
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
     *     methods={"GET", "POST"},
     *     name="input_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');
        $filters['tag_id'] = $request->query->getInt('filters_tag_id');

        $page = $request->query->getInt('page', 1);

        $form = $this->createForm(DateRangeType::class);
        $form->handleRequest($request);

        $fromDate = new \DateTime('1997-01-01');
        $to = new \DateTime('now');

        if ($form->isSubmitted() && $form->isValid()) {
            $fromDate = $form['fromDate']->getData();
            $to = $form['to']->getData();

            $pagination = $this->inputService->filterByDate($fromDate, $to, $page, $this->getUser(), $filters);

            $balance = 0;

            foreach ($pagination as $input) {
                $amount = $input->getAmount();
                $category = $input->getCategory();
                $categoryName = $category->getName();

                if ('Income' === $categoryName) {
                    $balance += $amount;
                } elseif ('Expense' === $categoryName) {
                    $balance -= $amount;
                }
            }

            $cache = new FilesystemAdapter();
            $balanceCache = $cache->getItem('balance.balanceAmount');
            $balanceCache->set($balance);
            $cache->save($balanceCache);
        } else {
            $pagination = $this->inputService->createPaginatedList($page, $this->getUser(), $filters);
        }

//        $balanceCache = new Balance();
//        $this->getEntityManager()->getReference($balanceCache->getId);

//        $loader = new \Twig\Loader\FilesystemLoader('templates');
//        $twig = new \Twig\Environment($loader);
//        $twig->addGlobal('balance', $balance);

        return $this->render(
            'input/index.html.twig',
            [
                'pagination' => $pagination,
                'form' => $form->createView(),
            ]
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
     * @param Request $request HTTP request
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
    public function create(Request $request): Response
    {
        $input = new Input();
        $form = $this->createForm(InputType::class, $input);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $input->setDate(new \DateTime());

            $wallet = $input->getWallet();
            $balance = $wallet->getBalance();
            $balanceAmount = $balance->getBalanceAmount();

            $amount = $input->getAmount();

            if ($balanceAmount + $amount >= 0) {
                $total = $balanceAmount + $amount;
                $balance->setBalanceAmount($total);
                $this->inputService->save($input);
                $this->addFlash('success', 'message_created_successfully');
            } else {
                $this->addFlash('warning', 'message_balance_0');
            }

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
        $ogAmount = $input->getAmount();

        $form = $this->createForm(InputType::class, $input, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wallet = $input->getWallet();
            $balance = $wallet->getBalance();
            $balanceAmount = $balance->getBalanceAmount();

            $newAmount = $input->getAmount();
            $diff = $newAmount - $ogAmount;

            if ($balanceAmount + $diff >= 0) {
                $total = $balanceAmount + $diff;
                $balance->setBalanceAmount($total);
                $this->inputService->save($input);

                $this->addFlash('success', 'congrats');
            } else {
                $this->addFlash('warning', 'message_balance_0');
            }

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
            $wallet = $input->getWallet();
            $balance = $wallet->getBalance();
            $balanceAmount = $balance->getBalanceAmount();

            $amount = $input->getAmount();

            if ($balanceAmount - $amount >= 0) {
                $total = $balanceAmount - $amount;
                $balance->setBalanceAmount($total);
                $this->inputService->delete($input);
                $this->addFlash('success', 'message_deleted_successfully');
            } else {
                $this->addFlash('warning', 'message_balance_0');
            }

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
