<?php

namespace App\Entity;

use App\Repository\MovimientoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovimientoRepository::class)]
class Movimiento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'movimientos')]
    private ?Venta $venta = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $entrada = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $salida = null;

    #[ORM\ManyToOne(inversedBy: 'movimientos')]
    private ?User $usuario = null;

    #[ORM\Column(length: 255)]
    private ?string $motivo = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo = null;

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

    public function getVenta(): ?Venta
    {
        return $this->venta;
    }

    public function setVenta(?Venta $venta): static
    {
        $this->venta = $venta;

        return $this;
    }

    public function getEntrada(): ?string
    {
        return $this->entrada;
    }

    public function setEntrada(string $entrada): static
    {
        $this->entrada = $entrada;

        return $this;
    }

    public function getSalida(): ?string
    {
        return $this->salida;
    }

    public function setSalida(string $salida): static
    {
        $this->salida = $salida;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getMotivo(): ?string
    {
        return $this->motivo;
    }

    public function setMotivo(string $motivo): static
    {
        $this->motivo = $motivo;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }
}
