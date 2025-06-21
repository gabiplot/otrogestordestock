<?php

namespace App\Entity;

use App\Repository\LoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoteRepository::class)]
class Lote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha_produccion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha_vencimiento = null;

    #[ORM\Column]
    private ?int $cantidad_inicial = null;

    #[ORM\Column]
    private ?int $cantidad_actual = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    /**
     * @var Collection<int, Stock>
     */
    #[ORM\OneToMany(targetEntity: Stock::class, mappedBy: 'lote')]
    private Collection $stocks;

    /**
     * @var Collection<int, MovimientoStock>
     */
    #[ORM\OneToMany(targetEntity: MovimientoStock::class, mappedBy: 'lote')]
    private Collection $movimientoStocks;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
        $this->movimientoStocks = new ArrayCollection();
    }

    public function __toString(): string
    {
        return strval($this->numero);
    }    

    public function getId(): ?int
    {
        return $this->id;
    }    

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getFechaProduccion(): ?\DateTime
    {
        return $this->fecha_produccion;
    }

    public function setFechaProduccion(?\DateTime $fecha_produccion): static
    {
        $this->fecha_produccion = $fecha_produccion;

        return $this;
    }

    public function getFechaVencimiento(): ?\DateTime
    {
        return $this->fecha_vencimiento;
    }

    public function setFechaVencimiento(?\DateTime $fecha_vencimiento): static
    {
        $this->fecha_vencimiento = $fecha_vencimiento;

        return $this;
    }

    public function getCantidadInicial(): ?int
    {
        return $this->cantidad_inicial;
    }

    public function setCantidadInicial(int $cantidad_inicial): static
    {
        $this->cantidad_inicial = $cantidad_inicial;

        return $this;
    }

    public function getCantidadActual(): ?int
    {
        return $this->cantidad_actual;
    }

    public function setCantidadActual(int $cantidad_actual): static
    {
        $this->cantidad_actual = $cantidad_actual;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

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
            $stock->setLote($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getLote() === $this) {
                $stock->setLote(null);
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
            $movimientoStock->setLote($this);
        }

        return $this;
    }

    public function removeMovimientoStock(MovimientoStock $movimientoStock): static
    {
        if ($this->movimientoStocks->removeElement($movimientoStock)) {
            // set the owning side to null (unless already changed)
            if ($movimientoStock->getLote() === $this) {
                $movimientoStock->setLote(null);
            }
        }

        return $this;
    }
}
