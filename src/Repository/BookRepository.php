<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param Book $book
     * @return int|mixed|string
     */
    public function getBooks(Book $book)
    {
        $qb = $this->createQueryBuilder('b');

        if ($book->getTitle()) {
            $qb->andWhere('b.title LIKE :title');
            $qb->setParameter('title', '%' . $book->getTitle() . '%');
        }

        if ($book->getIsbn()) {
            $qb->andWhere('b.isbn = :isbn');
            $qb->setParameter('isbn', $book->getIsbn());
        }

        if ($book->getAuthorId()) {
            $qb->andWhere('b.author_id = :authorId');
            $qb->setParameter('authorId', $book->getAuthorId());
        }

        return $qb->getQuery()
            ->getResult();
    }
}
