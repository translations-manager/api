<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Translation
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Phrase
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Phrase", inversedBy="translations")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $phrase;

    /**
     * @var Locale
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Locale")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $content;

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
     * @return Phrase
     */
    public function getPhrase()
    {
        return $this->phrase;
    }

    /**
     * @param Phrase $phrase
     */
    public function setPhrase($phrase)
    {
        $this->phrase = $phrase;
    }

    /**
     * @return Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param Locale $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
