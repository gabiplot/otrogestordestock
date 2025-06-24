<?php

namespace App\Entity;

use App\Repository\VentaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VentaRepository::class)]
class Venta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ventas')]
    private ?Cliente $cliente = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $subtotal = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $descuento = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $impuestos = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\Column(length: 255)]
    private ?string $forma_pago = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observacion = null;

    #[ORM\ManyToOne(inversedBy: 'ventas')]
    private ?User $usuario = null;

    /**
     * @var Collection<int, DetalleVenta>
     */
    #[ORM\OneToMany(targetEntity: DetalleVenta::class, mappedBy: 'venta')]
    private Collection $detalleVentas;

    /**
     * @var Collection<int, CuentaCorrienteCliente>
     */
    #[ORM\OneToMany(targetEntity: CuentaCorrienteCliente::class, mappedBy: 'venta')]
    private Collection $cuentaCorrienteClientes;

    public function __construct()
    {
        $this->detalleVentas = new ArrayCollection();
        $this->cuentaCorrienteClientes = new ArrayCollection();
    }

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

    public function getSubtotal(): ?string
    {
        return $this->subtotal;
    }

    public function setSubtotal(string $subtotal): static
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getDescuento(): ?string
    {
        return $this->descuento;
    }

    public function setDescuento(string $descuento): static
    {
        $this->descuento = $descuento;

        return $this;
    }

    public function getImpuestos(): ?string
    {
        return $this->impuestos;
    }

    public function setImpuestos(string $impuestos): static
    {
        $this->impuestos = $impuestos;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): static
    {
        $this->total = $total;

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

    public function getFormaPago(): ?string
    {
        return $this->forma_pago;
    }

    public function setFormaPago(string $forma_pago): static
    {
        $this->forma_pago = $forma_pago;

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

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

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
            $detalleVenta->setVenta($this);
        }

        return $this;
    }

    public function removeDetalleVenta(DetalleVenta $detalleVenta): static
    {
        if ($this->detalleVentas->removeElement($detalleVenta)) {
            // set the owning side to null (unless already changed)
            if ($detalleVenta->getVenta() === $this) {
                $detalleVenta->setVenta(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CuentaCorrienteCliente>
     */
    public function getCuentaCorrienteClientes(): Collection
    {
        return $this->cuentaCorrienteClientes;
    }

    public function addCuentaCorrienteCliente(CuentaCorrienteCliente $cuentaCorrienteCliente): static
    {
        if (!$this->cuentaCorrienteClientes->contains($cuentaCorrienteCliente)) {
            $this->cuentaCorrienteClientes->add($cuentaCorrienteCliente);
            $cuentaCorrienteCliente->setVenta($this);
        }

        return $this;
    }

    public function removeCuentaCorrienteCliente(CuentaCorrienteCliente $cuentaCorrienteCliente): static
    {
        if ($this->cuentaCorrienteClientes->removeElement($cuentaCorrienteCliente)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorrienteCliente->getVenta() === $this) {
                $cuentaCorrienteCliente->setVenta(null);
            }
        }

        return $this;
    }
}
