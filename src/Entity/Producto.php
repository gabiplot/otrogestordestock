<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio_de_compra = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio_venta = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unidad_de_medida = null;

    #[ORM\Column]
    private ?int $stock_minimo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPrecioDeCompra(): ?string
    {
        return $this->precio_de_compra;
    }

    public function setPrecioDeCompra(string $precio_de_compra): static
    {
        $this->precio_de_compra = $precio_de_compra;

        return $this;
    }

    public function getPrecioVenta(): ?string
    {
        return $this->precio_venta;
    }

    public function setPrecioVenta(string $precio_venta): static
    {
        $this->precio_venta = $precio_venta;

        return $this;
    }

    public function getUnidadDeMedida(): ?string
    {
        return $this->unidad_de_medida;
    }

    public function setUnidadDeMedida(?string $unidad_de_medida): static
    {
        $this->unidad_de_medida = $unidad_de_medida;

        return $this;
    }

    public function getStockMinimo(): ?int
    {
        return $this->stock_minimo;
    }

    public function setStockMinimo(int $stock_minimo): static
    {
        $this->stock_minimo = $stock_minimo;

        return $this;
    }
}
