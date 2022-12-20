<?php
/*
 * This file is part of the Sulu Securitytxt bundle.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpert\Sulu\SecuritytxtBundle\Entity;

use BitExpert\Sulu\SecuritytxtBundle\Repository\SecuritytxtRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SecuritytxtRepository::class)]
class Securitytxt
{
    final public const RESOURCE_KEY = 'securitytxt';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, nullable: false)]
    private ?string $webspace_key = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $contact = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $expires = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $encryption = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $acknowledgments = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $policy = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $hiring = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWebspaceKey(): ?string
    {
        return $this->webspace_key;
    }

    public function setWebspaceKey(?string $webspace_key): self
    {
        $this->webspace_key = $webspace_key;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getExpires(): ?string
    {
        return $this->expires;
    }

    public function setExpires(string $expires): self
    {
        $this->expires = $expires;

        return $this;
    }

    public function getEncryption(): ?string
    {
        return $this->encryption;
    }

    public function setEncryption(string $encryption): self
    {
        $this->encryption = $encryption;

        return $this;
    }

    public function getAcknowledgments(): ?string
    {
        return $this->acknowledgments;
    }

    public function setAcknowledgments(string $acknowledgments): self
    {
        $this->acknowledgments = $acknowledgments;

        return $this;
    }

    public function getPolicy(): ?string
    {
        return $this->policy;
    }

    public function setPolicy(string $policy): self
    {
        $this->policy = $policy;

        return $this;
    }

    public function getHiring(): ?string
    {
        return $this->hiring;
    }

    public function setHiring(string $hiring): self
    {
        $this->hiring = $hiring;

        return $this;
    }
}
