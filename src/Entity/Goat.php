<?php

namespace App\Entity;

use App\Repository\GoatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: GoatRepository::class)]
#[UniqueEntity(fields:"codigo", message:"Este código já está em uso, tente outro.")]
class Goat
{

    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $codigo = null;

    #[ORM\Column]
    private ?float $leite_prod = null;

    #[ORM\Column]
    private ?float $racao_cons = null;

    #[ORM\Column]
    private ?float $peso = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $data_nasc = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $abatido = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?float
    {
        return $this->codigo;
    }

    public function setCodigo(float $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getLeiteProd(): ?float
    {
        return $this->leite_prod;
    }

    public function setLeiteProd(float $leite_prod): self
    {
        $this->leite_prod = $leite_prod;

        return $this;
    }

    public function getRacaoCons(): ?float
    {
        return $this->racao_cons;
    }

    public function setRacaoCons(float $racao_cons): self
    {
        $this->racao_cons = $racao_cons;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getDataNasc(): ?\DateTimeInterface
    {
        return $this->data_nasc;
    }

    public function setDataNasc(\DateTimeInterface $data_nasc): self
    {
        $this->data_nasc = $data_nasc;

        return $this;
    }

    public function getAbatido(): ?\DateTimeInterface
    {
        return $this->abatido;
    }

    public function setAbatido(?\DateTimeInterface $abatido): self
    {
        $this->abatido = $abatido;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }
}
