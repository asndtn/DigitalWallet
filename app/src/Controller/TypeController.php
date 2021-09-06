<?php
/**
 * Type controller.
 */

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Service\TypeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TypeController.
 *
 * @Route("/type")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class TypeController extends AbstractController
{
    /**
     * Type service.
     *
     * @var \App\Service\TypeService
     */
    private $typeService;

    /**
     * Type controller constructor.
     *
     * @param TypeService $typeService Type service
     */
    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="type_index",
     * )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->typeService->createPaginatedList($page);

        return $this->render(
            'type/index.html.twig',
            ['pagination' => $pagination ]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Wallet $wallet Wallet entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="type_show",
     *     requirements={"id": "[1-9]\d*"}
     * )
     */
    public function show(Type $type): Response
    {
        return $this->render(
            'type/show.html.twig',
            ['type' => $type]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="type_create",
     * )
     */
    public function create(Request $request): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeService->save($type);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('type_index');
        }

        return $this->render(
            'type/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Type                      $type           Type entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="type_edit",
     * )
     */
    public function edit(Request $request, Type $type): Response
    {
        $form = $this->createForm(TypeType::class, $type, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeService->save($type);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('type_index');
        }

        return $this->render(
            'type/edit.html.twig',
            [
                'form' => $form->createView(),
                'type' => $type,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Type                      $type           Type entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="type_delete",
     * )
     */
    public function delete(Request $request, Type $type): Response
    {
        $form = $this->createForm(FormType::class, $type, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeService->delete($type);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('type_index');
        }

        return $this->render(
            'type/delete.html.twig',
            [
                'form' => $form->createView(),
                'type' => $type,
            ]
        );
    }
}