<?php
/**
 * Input controller.
 */

namespace App\Controller;

use App\Entity\Input;
use App\Repository\InputRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InputController.
 *
 * @Route("/input")
 */
class InputController extends AbstractController
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
     *     name="input_index",
     * )
     */
    public function index(Request $request, InputRepository $inputRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $inputRepository->queryAll(),
            $request->query->getInt('page', 1),
            InputRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'input/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Input $input Input entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="input_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Input $input): Response
    {
        return $this->render(
            'input/show.html.twig',
            ['input' => $input]
        );
    }
}
