<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Form\SearchType;
use App\Repository\BookRepository;
use App\Service\BookService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Exception;

class BookController extends AbstractController
{
    /**
     * @var BookService $bookService
     */
    private $bookService;

    /**
     * @var BookRepository $bookRepository
     */
    private $bookRepository;

    /**
     * @var PaginatorInterface $paginator
     */
    private $paginator;

    public function __construct(BookRepository $bookRepository, BookService $bookService, PaginatorInterface $paginator)
    {
        $this->bookService = $bookService;
        $this->bookRepository = $bookRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(SearchType::class, $book, [
            'method' => 'GET',
            'action' => $this->generateUrl('book.index')
        ]);
        $form->handleRequest($request);

        $data = $this->paginator->paginate(
            $this->bookRepository->getBooks($book), $request->query->getInt('page', 1),
            $request->query->getInt('pagination', 5)
        );

        return $this->render('pages/book/index.html.twig', [
            'data' => $data,
            'search' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function create(Request $request)
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data->file = $form->get('cover_src')->getData();
            $this->bookService->save($data);

            return $this->redirectToRoute('book.index');
        }

        return $this->render('pages/book/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function edit(Request $request, int $id)
    {
        $book = $this->bookRepository->find($id);

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data->file = $form->get('cover_src')->getData();
            $this->bookService->save($data, $book);

            return $this->redirectToRoute('book.index');
        }

        return $this->render('pages/book/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function remove(int $id): RedirectResponse
    {
        $book = $this->bookRepository->find($id);
        $this->bookService->remove($book);

        return $this->redirectToRoute('book.index');
    }
}
