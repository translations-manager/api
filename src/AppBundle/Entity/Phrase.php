<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhraseRepository")
 */
class Phrase
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Type("integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="phrase_key", type="string", length=1024)
     *
     * @Serializer\Type("string")
     */
    private $key;

    /**
     * @var Domain
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Domain", inversedBy="phrases")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Serializer\Exclude
     */
    private $domain;

    /**
     * @var FileLocation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FileLocation", inversedBy="phrases")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Serializer\Exclude
     */
    private $fileLocation;

    /**
     * @var Translation[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Translation", mappedBy="phrase", cascade={"all"}, orphanRemoval=true)
     *
     * @Serializer\Exclude
     */
    private $translations;

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
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param Domain $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return FileLocation
     */
    public function getFileLocation()
    {
        return $this->fileLocation;
    }

    /**
     * @param FileLocation $fileLocation
     */
    public function setFileLocation($fileLocation)
    {
        $this->fileLocation = $fileLocation;
    }

    /**
     * @return Translation[]
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param Translation[] $translations
     */
    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }
}
