<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocaleRepository")
 */
class Locale
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Type("integer")
     * @Serializer\Groups({"read"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=5)
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"read"})
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"read"})
     */
    private $name;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project", inversedBy="locales")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Serializer\Exclude
     */
    private $project;

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }
}
