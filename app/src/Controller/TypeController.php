<?php
/**
 * Type controller.
 */

namespace App\Controller;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\TypeRepository            $typeRepository Type repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator      Paginator
     *
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
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Type $type Type entity
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
}