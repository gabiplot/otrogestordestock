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

    #[ORM\Column(length: 255)]
    private ?string $tipo_movimiento = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\Column]
    private ?int $stock_anterior = null;

    #[ORM\Column]
    private ?int $stock_actual = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motivo = null;

    #[ORM\ManyToOne(inversedBy: 'movimientoStocks')]
    private ?Lote $lote = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha_movimiento = null;

    #[ORM\ManyToOne(inversedBy: 'movimientoStocks')]
    private ?User $user = null;

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

    public function getTipoMovimiento(): ?string
    {
        return $this->tipo_movimiento;
    }

    public function setTipoMovimiento(string $tipo_movimiento): static
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

    public function getStockAnterior(): ?int
    {
        return $this->stock_anterior;
    }

    public function setStockAnterior(int $stock_anterior): static
    {
        $this->stock_anterior = $stock_anterior;

        return $this;
    }

    public function getStockActual(): ?int
    {
        return $this->stock_actual;
    }

    public function setStockActual(int $stock_actual): static
    {
        $this->stock_actual = $stock_actual;

        return $this;
    }

    public function getMotivo(): ?string
    {
        return $this->motivo;
    }

    public function setMotivo(?string $motivo): static
    {
        $this->motivo = $motivo;

        return $this;
    }

    public function getLote(): ?Lote
    {
        return $this->lote;
    }

    public function setLote(?Lote $lote): static
    {
        $this->lote = $lote;

        return $this;
    }

    public function getFechaMovimiento(): ?\DateTime
    {
        return $this->fecha_movimiento;
    }

    public function setFechaMovimiento(\DateTime $fecha_movimiento): static
    {
        $this->fecha_movimiento = $fecha_movimiento;

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
