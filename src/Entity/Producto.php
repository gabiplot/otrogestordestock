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

    //[ORM\Column]
    //private ?int $stock_minimo = null;

    #[ORM\ManyToOne(inversedBy: 'productos')]
    private ?Categoria $categoria = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sku = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?bool $activo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio_de_costo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio_de_venta = null;

    /**
     * @var Collection<int, Stock>
     */
    #[ORM\OneToMany(targetEntity: Stock::class, mappedBy: 'producto')]
    private Collection $stocks;

    /**
     * @var Collection<int, MovimientoStock>
     */
    #[ORM\OneToMany(targetEntity: MovimientoStock::class, mappedBy: 'producto')]
    private Collection $movimientoStocks;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
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
    
    /*
    public function getStockMinimo(): ?int
    {
        return $this->stock_minimo;
    }

    public function setStockMinimo(int $stock_minimo): static
    {
        $this->stock_minimo = $stock_minimo;

        return $this;
    }
    */

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): static
    {
        $this->sku = $sku;

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

    /**
     * @return Collection<int, Stock>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setProducto($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getProducto() === $this) {
                $stock->setProducto(null);
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
