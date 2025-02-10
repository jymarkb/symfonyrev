<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findPostByIdWithCategory(int $id){

        $builder = $this->createQueryBuilder('post');
        $builder->select('post.title AS post_title', 'post.imgSrc as post_img')
                ->addSelect('category.name AS category_name')
                ->innerJoin('post.category', 'category')
                ->where('post.id = :id')
                ->setParameter('id', $id);

        return $builder->getQuery()->getResult();
    }

    public function findPostByCategoryId(int $id){
        
        $builder = $this->createQueryBuilder('post');
        $builder->select('post')
                ->where('post.category = :id')
                ->setParameter('id', $id);
        
        return $builder->getQuery()->getResult();

    }

    //    /**
    //     * @return Post[] Returns an array of Post objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
