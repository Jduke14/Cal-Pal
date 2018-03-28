<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
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
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $customerID;

    /**
     * @ORM\Column(type="integer")
     */
    private $providerID;

    /**
     * @ORM\Column(type="integer")
     */
    private $serviceID;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="integer")
     */
    private $companyID;

    public function getId()
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCustomerID(): ?int
    {
        return $this->customerID;
    }

    public function setCustomerID(int $customerID): self
    {
        $this->customerID = $customerID;

        return $this;
    }

    public function getProviderID(): ?int
    {
        return $this->providerID;
    }

    public function setProviderID(int $providerID): self
    {
        $this->providerID = $providerID;

        return $this;
    }

    public function getServiceID(): ?int
    {
        return $this->serviceID;
    }

    public function setServiceID(int $serviceID): self
    {
        $this->serviceID = $serviceID;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getCompanyID(): ?int
    {
        return $this->companyID;
    }

    public function setCompanyID(int $companyID): self
    {
        $this->companyID = $companyID;

        return $this;
    }

}