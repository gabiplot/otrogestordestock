<?php

namespace App\Entity;

use App\Repository\CuentaCorrienteProveedorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CuentaCorrienteProveedorRepository::class)]
class CuentaCorrienteProveedor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cuentaCorrienteProveedors')]
    private ?Proveedor $proveedor = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $concepto = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo_movimiento = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo_referencia = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $debe = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $haber = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $saldo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProveedor(): ?Proveedor
    {
        return $this->proveedor;
    }

    public function setProveedor(?Proveedor $proveedor): static
    {
        $this->proveedor = $proveedor;

        return $this;
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

    public function setTipoMovimiento(?string $tipo_movimiento): static
    {
        $this->tipo_movimiento = $tipo_movimiento;

        return $this;
    }

    public function getTipoReferencia(): ?string
    {
        return $this->tipo_referencia;
    }

    public function setTipoReferencia(?string $tipo_referencia): static
    {
        $this->tipo_referencia = $tipo_referencia;

        return $this;
    }

    public function getDebe(): ?string
    {
        return $this->debe;
    }

    public function setDebe(string $debe): static
    {
        $this->debe = $debe;

        return $this;
    }

    public function getHaber(): ?string
    {
        return $this->haber;
    }

    public function setHaber(string $haber): static
    {
        $this->haber = $haber;

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
}
