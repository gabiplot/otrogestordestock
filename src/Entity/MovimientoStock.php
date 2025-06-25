<?php

namespace App\Entity;

use App\Repository\MovimientoStockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovimientoStockRepository::class)]
class MovimientoStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'movimientoStocks')]
    private ?Producto $producto = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo_movimiento = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio_costo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observacion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo_referencia = null;

    #[ORM\ManyToOne(inversedBy: 'movimientoStocks')]
    private ?User $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): static
    {
        $this->producto = $producto;

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

    public function getTipoMovimiento(): ?string
    {
        return $this->tipo_movimiento;
    }

    public function setTipoMovimiento(?string $tipo_movimiento): static
    {
        $this->tipo_movimiento = $tipo_movimiento;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPrecioCosto(): ?string
    {
        return $this->precio_costo;
    }

    public function setPrecioCosto(string $precio_costo): static
    {
        $this->precio_costo = $precio_costo;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): static
    {
        $this->observacion = $observacion;

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

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }
}
