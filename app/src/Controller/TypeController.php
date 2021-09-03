<?php
/**
 * Type controller.
 */

namespace App\Controller;

use App\Entity\Type;
use App\Repository\TypeRepository;
use App\Form\TypeType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TypeController.
 *
 * @Route("/type")
 */
class TypeController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\TypeRepository $typeRepository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator Paginator
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="type_index",
     * )
     */
    public function index(Request $request, TypeRepository $typeRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $typeRepository->queryAll(),
            $request->query->getInt('page', 1),
            TypeRepository::PAGINATOR_ITEMS_PER_PAGE
        );

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
     * @param \App\Repository\TypeRepository        $typeRepository Type repository
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
    public function create(Request $request, TypeRepository $typeRepository): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRepository->save($type);

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
     * @param \App\Repository\TypeRepository        $typeRepository Type repository
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
    public function edit(Request $request, Type $type, TypeRepository $typeRepository): Response
    {
        $form = $this->createForm(TypeType::class, $type, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRepository->save($type);

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
     * @param \App\Repository\TypeRepository        $typeRepository Type repository
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
    public function delete(Request $request, Type $type, TypeRepository $typeRepository): Response
    {
        $form = $this->createForm(FormType::class, $type, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRepository->delete($type);
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