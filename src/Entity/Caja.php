<?php

namespace App\Entity;

use App\Repository\CajaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CajaRepository::class)]
class Caja
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $concepto = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo_movimiento = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $ingreso = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $egreso = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $saldo = null;

    #[ORM\Column(length: 255)]
    private ?string $metodo_pago = null;

    #[ORM\Column(length: 255)]
    private ?string $categoria = null;

    #[ORM\ManyToOne(inversedBy: 'cajas')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getConcepto(): ?string
    {
        return $this->concepto;
    }

    public function setConcepto(?string $concepto): static
    {
        $this->concepto = $concepto;

        return $this;
    }

    public function getTipoMovimiento(): ?string
    {
        return $this->tipo_movimiento;
    }

    public function setTipoMovimiento(string $tipo_movimiento): static
    {
        $this->tipo_movimiento = $tipo_movimiento;

        return $this;
    }

    public function getIngreso(): ?string
    {
        return $this->ingreso;
    }

    public function setIngreso(string $ingreso): static
    {
        $this->ingreso = $ingreso;

        return $this;
    }

    public function getEgreso(): ?string
    {
        return $this->egreso;
    }

    public function setEgreso(string $egreso): static
    {
        $this->egreso = $egreso;

        return $this;
    }

    public function getSaldo(): ?string
    {
        return $this->saldo;
    }

    public function setSaldo(string $saldo): static
    {
        $this->saldo = $saldo;

        return $this;
    }

    public function getMetodoPago(): ?string
    {
        return $this->metodo_pago;
    }

    public function setMetodoPago(string $metodo_pago): static
    {
        $this->metodo_pago = $metodo_pago;

        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
