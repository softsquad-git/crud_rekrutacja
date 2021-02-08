<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Service\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use \Exception;

class AuthorController extends AbstractController
{
    /**
     * @var AuthorRepository $authorRepository
     */
    private $authorRepository;

    /**
     * @var AuthorService $authorService
     */
    private $authorService;

    /**
     * @param AuthorRepository $authorRepository
     * @param AuthorService $authorService
     */
    public function __construct(AuthorRepository $authorRepository, AuthorService $authorService)
    {
        $this->authorRepository = $authorRepository;
        $this->authorService = $authorService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $data = $this->authorRepository->findAll();

        return $this->render('pages/author/index.html.twig', [
            'data' => $data
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function create(Request $request)
    {
        $author = new Author();

        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->authorService->save($form->getData());

            return $this->redirectToRoute('author.index');
        }

        return $this->render('pages/author/form.html.twig', [
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
        $author = $this->authorRepository->find($id);

        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->authorService->save($form->getData(), $author);

            return $this->redirectToRoute('author.index');
        }

        return $this->render('pages/author/form.html.twig', [
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
        $author = $this->authorRepository->find($id);
        $this->authorService->remove($author);

        return $this->redirectToRoute('author.index');
    }
}
