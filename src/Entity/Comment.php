<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ad", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $positiveComment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $negativeComment;


    /**
     * Permet de mettre en place une date de création
     * 
     * @ORM\PrePersist
     *
     * @return void
     */
    public function PrePersist()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }


    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPositiveComment(): ?string
    {
        return $this->positiveComment;
    }

    public function setPositiveComment(?string $positiveComment): self
    {
        $this->positiveComment = $positiveComment;

        return $this;
    }

    public function getNegativeComment(): ?string
    {
        return $this->negativeComment;
    }

    public function setNegativeComment(?string $negativeComment): self
    {
        $this->negativeComment = $negativeComment;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validateFields(ExecutionContextInterface $context)
    {
        if ('' === $this->positiveComment && '' === $this->negativeComment) {
            $context->addViolation('Un commentaire positif ou bien négatif doit être ajouté');
        }
    }
}
