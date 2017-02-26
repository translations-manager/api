<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FileLocationRepository")
 */
class FileLocation
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
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Type("string")
     */
    private $path;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Serializer\Exclude
     */
    private $project;

    /**
     * @var Phrase[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Phrase", mappedBy="fileLocation", cascade={"all"}, orphanRemoval=true)
     *
     * @Serializer\Type("array<AppBundle\Entity\Phrase>")
     */
    private $phrases;

    public function __construct()
    {
        $this->phrases = new ArrayCollection();
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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
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

    /**
     * @return Phrase[]
     */
    public function getPhrases()
    {
        return $this->phrases;
    }

    /**
     * @param Phrase[] $phrases
     */
    public function setPhrases($phrases)
    {
        $this->phrases = $phrases;

        foreach ($this->phrases as $phrase) {
            $phrase->setFileLocation($this);
        }
    }
}
