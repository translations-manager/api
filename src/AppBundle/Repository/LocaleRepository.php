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
            $locale = new Locale();
            $locale->setProject($project);
            $locale->setCode($localeCode);
            $locale->setName(Intl::getLanguageBundle()->getLanguageName($localeCode));
            $this->getEntityManager()->persist($locale);
            $this->getEntityManager()->flush();
        }

        return $locale;
    }
}
