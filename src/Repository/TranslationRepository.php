<?php

namespace App\Repository;

use App\Entity\Translation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Translation>
 */
class TranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Translation::class);
    }

    public function findTranslationByIsoCode(int $origin_id, string $iso_code): ?Translation
    {
        $builder = $this->createQueryBuilder('transl')
            ->join('transl.language', 'lang')
            ->where('transl.origin = :origin')
            ->andWhere('lang.iso_code = :iso_code')
            ->setParameter('origin', $origin_id)
            ->setParameter('iso_code', $iso_code)
        ;

        $query = $builder->getQuery();

        return $query->getOneOrNullResult();
    }
}
