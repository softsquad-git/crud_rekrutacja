<?php

namespace App\Service;

use App\Entity\Author;
use \Exception;

class AuthorService extends BaseService
{
    /**
     * @param Author $data
     * @param Author|null $author
     * @return Author|null
     * @throws Exception
     */
    public function save(Author $data, Author $author = null): ?Author
    {
        if ($author) {
            $this->em->flush();

            return $author;
        }

        $this->saveObject($data);

        return $author;
    }

    /**
     * @param Author $author
     * @return bool|null
     * @throws Exception
     */
    public function remove(Author $author): ?bool
    {
        return $this->removeObject($author);
    }
}