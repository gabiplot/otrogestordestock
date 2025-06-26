<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Venta>
     */
    #[ORM\OneToMany(targetEntity: Venta::class, mappedBy: 'cliente')]
    private Collection $ventas;

    /**
     * @var Collection<int, CuentaCorrienteCliente>
     */
    #[ORM\OneToMany(targetEntity: CuentaCorrienteCliente::class, mappedBy: 'cliente')]
    private Collection $cuentaCorrienteClientes;

    /**
     * @var Collection<int, CobroCliente>
     */
    #[ORM\OneToMany(targetEntity: CobroCliente::class, mappedBy: 'cliente')]
    private Collection $cobroClientes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $direccion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cuit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo_cliente = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha_registro = null;

    #[ORM\Column]
    private ?bool $activo = null;

    public function __construct()
    {
        $this->ventas = new ArrayCollection();
        $this->cuentaCorrienteClientes = new ArrayCollection();
        $this->cobroClientes = new ArrayCollection();
    }

    public function __toString(): string
    {
        $cuit = ($this->cuit == null) ? "" : strval(", " . $this->cuit);

        return strval($this->nombre . $cuit);
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

    /**
     * @return Collection<int, Venta>
     */
    public function getVentas(): Collection
    {
        return $this->ventas;
    }

    public function addVenta(Venta $venta): static
    {
        if (!$this->ventas->contains($venta)) {
            $this->ventas->add($venta);
            $venta->setCliente($this);
        }

        return $this;
    }

    public function removeVenta(Venta $venta): static
    {
        if ($this->ventas->removeElement($venta)) {
            // set the owning side to null (unless already changed)
            if ($venta->getCliente() === $this) {
                $venta->setCliente(null);
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
            $cuentaCorrienteCliente->setCliente($this);
        }

        return $this;
    }

    public function removeCuentaCorrienteCliente(CuentaCorrienteCliente $cuentaCorrienteCliente): static
    {
        if ($this->cuentaCorrienteClientes->removeElement($cuentaCorrienteCliente)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorrienteCliente->getCliente() === $this) {
                $cuentaCorrienteCliente->setCliente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CobroCliente>
     */
    public function getCobroClientes(): Collection
    {
        return $this->cobroClientes;
    }

    public function addCobroCliente(CobroCliente $cobroCliente): static
    {
        if (!$this->cobroClientes->contains($cobroCliente)) {
            $this->cobroClientes->add($cobroCliente);
            $cobroCliente->setCliente($this);
        }

        return $this;
    }

    public function removeCobroCliente(CobroCliente $cobroCliente): static
    {
        if ($this->cobroClientes->removeElement($cobroCliente)) {
            // set the owning side to null (unless already changed)
            if ($cobroCliente->getCliente() === $this) {
                $cobroCliente->setCliente(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getCuit(): ?string
    {
        return $this->cuit;
    }

    public function setCuit(?string $cuit): static
    {
        $this->cuit = $cuit;

        return $this;
    }

    public function getTipoCliente(): ?string
    {
        return $this->tipo_cliente;
    }

    public function setTipoCliente(?string $tipo_cliente): static
    {
        $this->tipo_cliente = $tipo_cliente;

        return $this;
    }

    public function getFechaRegistro(): ?\DateTime
    {
        return $this->fecha_registro;
    }

    public function setFechaRegistro(?\DateTime $fecha_registro): static
    {
        $this->fecha_registro = $fecha_registro;

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
}
