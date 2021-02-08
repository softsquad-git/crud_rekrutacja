<?php

namespace App\Service;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use \Exception;
use Symfony\Component\String\Slugger\SluggerInterface;

class BookService extends BaseService
{
    /**
     * @var string
     */
    const IMAGE_PATH = 'assets/data/media/';

    /**
     * @var SluggerInterface $slugger
     */
    private $slugger;

    /**
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     */
    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger)
    {
        parent::__construct($em);
        $this->slugger = $slugger;
    }

    /**
     * @param Book $data
     * @param Book|null $book
     * @return Book|object|null
     * @throws Exception
     */
    public function save(Book $data, Book $book = null)
    {
        if ($book) {
            $book->setCoverSrc($this->upload($data->file));
            $this->em->flush();
            return $book;
        }

        $data->setCoverSrc($this->upload($data->file));

        return $this->saveObject($data);
    }

    /**
     * @param Book $book
     * @return bool|null
     * @throws Exception
     */
    public function remove(Book $book): ?bool
    {
        return $this->removeObject($book);
    }

    /**
     * @param $file
     * @return false|string
     * @throws Exception
     */
    private function upload($file)
    {
        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

            try {
                $file->move(
                    self::IMAGE_PATH,
                    $newFilename
                );

                return $newFilename;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        return false;
    }
}