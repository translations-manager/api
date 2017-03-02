<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 */
class Project
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Type("integer")
     * @Serializer\Groups({"list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"list"})
     */
    private $name;

    /**
     * @var Domain[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Domain", mappedBy="project", orphanRemoval=true, cascade={"all"})
     *
     * @Serializer\Type("array<AppBundle\Entity\Domain>")
     */
    private $domains;

    /**
     * @var Locale[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Locale", mappedBy="project", orphanRemoval=true, cascade={"all"})
     *
     * @Serializer\Type("array<AppBundle\Entity\Locale>")
     */
    private $locales;

    /**
     * @var FileLocation[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FileLocation", mappedBy="project", cascade={"all"}, orphanRemoval=true)
     *
     * @Serializer\Type("array<AppBundle\Entity\FileLocation>")
     */
    private $fileLocations;

    public function __construct()
    {
        $this->domains = new ArrayCollection();
        $this->locales = new ArrayCollection();
        $this->fileLocations = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Domain[]
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * @param Domain[] $domains
     */
    public function setDomains($domains)
    {
        $this->domains = $domains;
    }

    /**
     * @param Domain $domain
     */
    public function addDomain(Domain $domain)
    {
        $this->domains->add($domain);
        $domain->setProject($this);
    }

    /**
     * @param Domain $domain
     */
    public function removeDomain(Domain $domain)
    {
        $this->domains->removeElement($domain);
    }

    /**
     * @return Locale[]
     */
    public function getLocales()
    {
        return $this->locales;
    }

    /**
     * @param Locale[] $locales
     */
    public function setLocales($locales)
    {
        $this->locales = $locales;
    }

    /**
     * @param Locale $locale
     */
    public function addLocale(Locale $locale)
    {
        $this->locales->add($locale);
        $locale->setProject($this);
    }

    /**
     * @param Locale $locale
     */
    public function removeLocale(Locale $locale)
    {
        $this->locales->removeElement($locale);
    }

    /**
     * @return FileLocation[]
     */
    public function getFileLocations()
    {
        return $this->fileLocations;
    }

    /**
     * @param FileLocation[] $fileLocations
     */
    public function setFileLocations($fileLocations)
    {
        $this->fileLocations = $fileLocations;
    }

    /**
     * @param FileLocation $fileLocation
     */
    public function addFileLocation(FileLocation $fileLocation)
    {
        $this->fileLocations->add($fileLocation);
        $fileLocation->setProject($this);
    }

    /**
     * @param FileLocation $fileLocation
     */
    public function removeFileLocation(FileLocation $fileLocation)
    {
        $this->fileLocations->removeElement($fileLocation);
    }
}
