<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Locale;
use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Intl\Intl;

class LocaleRepository extends EntityRepository
{
    /**
     * @param Project $project
     * @param string $localeCode
     *
     * @return Locale
     */
    public function mergeLocale(Project $project, $localeCode)
    {
        $locale = $this
            ->createQueryBuilder('l')
            ->where('l.project = :project')
            ->andWhere('l.code = :code')
            ->setParameter('project', $project)
            ->setParameter('code', $localeCode)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$locale) {
            $explodedlocaleCode = explode('_', $localeCode);
            $regionCode = isset($explodedlocaleCode[1]) ? isset($explodedlocaleCode[1]) : null;
            $languageName = Intl::getLanguageBundle()->getLanguageName(
                $explodedlocaleCode[0],
                $regionCode,
                $localeCode
            );
            $locale = new Locale();
            $locale->setProject($project);
            $locale->setCode($localeCode);
            $locale->setName($languageName ? : $localeCode);
            $this->getEntityManager()->persist($locale);
            $this->getEntityManager()->flush();
        }

        return $locale;
    }
}
