<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Translation;
use Doctrine\ORM\EntityRepository;

class TranslationRepository extends EntityRepository
{
    /**
     * @param array $domainIds
     * @param array $locationIds
     * @param array $localeIds
     *
     * @return Translation[]
     */
    public function export(array $domainIds, array $locationIds, array $localeIds)
    {
        if (!$domainIds || !$locationIds || !$localeIds) {
            return [];
        }

        return $this
            ->createQueryBuilder('t')
            ->join('t.phrase', 'p')
            ->join('p.fileLocation', 'l')
            ->join('p.domain', 'd')
            ->join('t.locale', 'loca')
            ->where('loca.id in (:locales)')
            ->andWhere('l.id in (:locations)')
            ->andWhere('d.id in (:domains)')
            ->setParameter('locales', $localeIds)
            ->setParameter('locations', $locationIds)
            ->setParameter('domains', $domainIds)
            ->getQuery()
            ->getResult()
        ;
    }
}
