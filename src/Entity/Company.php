<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $companyPhoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyEmail;

    public function getId()
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyPhoneNumber(): ?string
    {
        return $this->companyPhoneNumber;
    }

    public function setCompanyPhoneNumber(string $companyPhoneNumber): self
    {
        $this->companyPhoneNumber = $companyPhoneNumber;

        return $this;
    }

    public function getCompanyEmail(): ?string
    {
        return $this->companyEmail;
    }

    public function setCompanyEmail(string $companyEmail): self
    {
        $this->companyEmail = $companyEmail;

        return $this;
    }
}
