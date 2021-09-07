<?php
/**
 * Input controller.
 */

namespace App\Controller;

use App\Entity\Input;
use App\Form\InputType;
use App\Service\InputService;
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
            $this->inputService->save($input);

            $this->addFlash('success', 'message_created_successfully');

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

            $this->addFlash('success', 'message_deleted_successfully');

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
