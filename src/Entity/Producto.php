<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unidad_de_medida = null;

    #[ORM\Column]
    private ?int $stock_minimo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?bool $activo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio_de_costo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio_de_venta = null;

    #[ORM\Column]
    private ?int $stock_actual = null;

    /**
     * @var Collection<int, DetalleVenta>
     */
    #[ORM\OneToMany(targetEntity: DetalleVenta::class, mappedBy: 'producto')]
    private Collection $detalleVentas;

    /**
     * @var Collection<int, DetalleCompra>
     */
    #[ORM\OneToMany(targetEntity: DetalleCompra::class, mappedBy: 'producto')]
    private Collection $detalleCompras;

    /**
     * @var Collection<int, MovimientoStock>
     */
    #[ORM\OneToMany(targetEntity: MovimientoStock::class, mappedBy: 'producto')]
    private Collection $movimientoStocks;

    public function __construct()
    {
        $this->detalleVentas = new ArrayCollection();
        $this->detalleCompras = new ArrayCollection();
        $this->movimientoStocks = new ArrayCollection();
    }

    public function __toString(): string
    {
        return strval($this->nombre);
    }

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }

    public function getPrecioDeCosto(): ?string
    {
        return $this->precio_de_costo;
    }

    public function setPrecioDeCosto(string $precio_de_costo): static
    {
        $this->precio_de_costo = $precio_de_costo;

        return $this;
    }

    public function getPrecioDeVenta(): ?string
    {
        return $this->precio_de_venta;
    }

    public function setPrecioDeVenta(string $precio_de_venta): static
    {
        $this->precio_de_venta = $precio_de_venta;

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

    /**
     * @return Collection<int, DetalleVenta>
     */
    public function getDetalleVentas(): Collection
    {
        return $this->detalleVentas;
    }

    public function addDetalleVenta(DetalleVenta $detalleVenta): static
    {
        if (!$this->detalleVentas->contains($detalleVenta)) {
            $this->detalleVentas->add($detalleVenta);
            $detalleVenta->setProducto($this);
        }

        return $this;
    }

    public function removeDetalleVenta(DetalleVenta $detalleVenta): static
    {
        if ($this->detalleVentas->removeElement($detalleVenta)) {
            // set the owning side to null (unless already changed)
            if ($detalleVenta->getProducto() === $this) {
                $detalleVenta->setProducto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DetalleCompra>
     */
    public function getDetalleCompras(): Collection
    {
        return $this->detalleCompras;
    }

    public function addDetalleCompra(DetalleCompra $detalleCompra): static
    {
        if (!$this->detalleCompras->contains($detalleCompra)) {
            $this->detalleCompras->add($detalleCompra);
            $detalleCompra->setProducto($this);
        }

        return $this;
    }

    public function removeDetalleCompra(DetalleCompra $detalleCompra): static
    {
        if ($this->detalleCompras->removeElement($detalleCompra)) {
            // set the owning side to null (unless already changed)
            if ($detalleCompra->getProducto() === $this) {
                $detalleCompra->setProducto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovimientoStock>
     */
    public function getMovimientoStocks(): Collection
    {
        return $this->movimientoStocks;
    }

    public function addMovimientoStock(MovimientoStock $movimientoStock): static
    {
        if (!$this->movimientoStocks->contains($movimientoStock)) {
            $this->movimientoStocks->add($movimientoStock);
            $movimientoStock->setProducto($this);
        }

        return $this;
    }

    public function removeMovimientoStock(MovimientoStock $movimientoStock): static
    {
        if ($this->movimientoStocks->removeElement($movimientoStock)) {
            // set the owning side to null (unless already changed)
            if ($movimientoStock->getProducto() === $this) {
                $movimientoStock->setProducto(null);
            }
        }

        return $this;
    }
}
