<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Domain;
use AppBundle\Entity\FileLocation;
use AppBundle\Entity\Locale;
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

    /**
     * @param Domain $domain
     * @param FileLocation $fileLocation
     * @param Locale $locale
     *
     * @return Translation[]
     */
    public function findForImport(Domain $domain, FileLocation $fileLocation, Locale $locale)
    {
        return $this
            ->createQueryBuilder('t')
            ->join('t.phrase', 'p')
            ->where('p.domain = :domain')
            ->andWhere('p.fileLocation = :fileLocation')
            ->andWhere('t.locale = :locale')
            ->setParameter('domain', $domain)
            ->setParameter('fileLocation', $fileLocation)
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getResult();
    }
}
