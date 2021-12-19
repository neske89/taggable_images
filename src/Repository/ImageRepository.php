<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function save(string $provider, string $tags, string $filename): int
    {
        $image = new Image();
        $image->setProvider($provider);
        $image->setTags($tags);
        $image->setFilename($filename);

        $this->getEntityManager()->persist($image);
        $this->getEntityManager()->flush();
        return $image->getId();
    }

    // /**
    //  * @return Image[] Returns an array of Image objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Image
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function filter(?string $provider, ?array $tags, ?int $page, ?int $pageSize):array
    {
        $sql = 'SELECT provider,filename,tags';
        $params = [];
        if (!empty($tags)) {
            $tagsSearchArray = [];
            foreach ($tags as $key => $tag) {
                $paramKey = "tag_{$key}";
                $tagsSearchArray[] = "(tags like :{$paramKey})";
                $params[$paramKey] = " %{$tag}% ";
            }
            $tagsSearch = implode(' + ', $tagsSearchArray);
            $sql = "{$sql}, ({$tagsSearch}) as hits";
        }
        $sql = "{$sql} from images";
        if ($provider) {
            $sql = "{$sql} WHERE provider = :provider";
            $params['provider'] = $provider;
        }

        if (!empty($tags)) {
            $sql = "{$sql} having hits > 0";
        }
        if (!$pageSize) {
            $pageSize = 35;
        }
        $startPage = $page && $page > 0 ? $page - 1 : 0;
        $sql = "{$sql} LIMIT {$startPage},${pageSize}";


        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        $results = $stmt->executeQuery($params);
        return $results->fetchAllAssociative();
    }
}
