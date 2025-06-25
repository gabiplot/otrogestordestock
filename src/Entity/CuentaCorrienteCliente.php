<?php

namespace App\Entity;

use App\Repository\CuentaCorrienteClienteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CuentaCorrienteClienteRepository::class)]
class CuentaCorrienteCliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cuentaCorrienteClientes')]
    private ?Cliente $cliente = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $concepto = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo_movimiento = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $debe = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $haber = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $saldo = null;

    #[ORM\ManyToOne(inversedBy: 'cuentaCorrienteClientes')]
    private ?Venta $venta = null;

    #[ORM\ManyToOne(inversedBy: 'cuentaCorrienteClientes')]
    private ?CobroCliente $cobro_cliente = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo_referencia = null;

    public function __toString(): string
    {
        return strval($this->id);
    }  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

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

    public function getVenta(): ?Venta
    {
        return $this->venta;
    }

    public function setVenta(?Venta $venta): static
    {
        $this->venta = $venta;

        return $this;
    }

    public function getCobroCliente(): ?CobroCliente
    {
        return $this->cobro_cliente;
    }

    public function setCobroCliente(?CobroCliente $cobro_cliente): static
    {
        $this->cobro_cliente = $cobro_cliente;

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
}
