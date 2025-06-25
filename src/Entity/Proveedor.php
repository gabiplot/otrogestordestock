<?php

namespace App\Entity;

use App\Repository\ProveedorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProveedorRepository::class)]
class Proveedor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, CuentaCorrienteProveedor>
     */
    #[ORM\OneToMany(targetEntity: CuentaCorrienteProveedor::class, mappedBy: 'proveedor')]
    private Collection $cuentaCorrienteProveedors;

    /**
     * @var Collection<int, PagoProveedor>
     */
    #[ORM\OneToMany(targetEntity: PagoProveedor::class, mappedBy: 'proveedor')]
    private Collection $pagoProveedors;

    /**
     * @var Collection<int, Compra>
     */
    #[ORM\OneToMany(targetEntity: Compra::class, mappedBy: 'proveedor')]
    private Collection $compras;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $direccion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cuit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contacto = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha_registro = null;

    #[ORM\Column]
    private ?bool $activo = null;

    public function __construct()
    {
        $this->cuentaCorrienteProveedors = new ArrayCollection();
        $this->pagoProveedors = new ArrayCollection();
        $this->compras = new ArrayCollection();
    }

    public function __toString(): string
    {
        return strval($this->nombre);
    }

    public function getContactoCompleto(): string
    {
        $e = ($this->email == null) ? "" : strval($this->email). ", ";

        $t = ($this->telefono == null) ? "" : strval($this->telefono) . ", ";

        $d = ($this->direccion == null) ? "" : strval($this->direccion) . ", ";

        $c = ($this->contacto == null) ? "" : strval($this->contacto);
        
        $cadena = $e . $t . $d . $c;

        if (str_ends_with($cadena, ', ')) {
            $cadena = substr($cadena, 0, -2);
        }

        return $cadena;

        //return strval($e . $t . $d . $c);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, CuentaCorrienteProveedor>
     */
    public function getCuentaCorrienteProveedors(): Collection
    {
        return $this->cuentaCorrienteProveedors;
    }

    public function addCuentaCorrienteProveedor(CuentaCorrienteProveedor $cuentaCorrienteProveedor): static
    {
        if (!$this->cuentaCorrienteProveedors->contains($cuentaCorrienteProveedor)) {
            $this->cuentaCorrienteProveedors->add($cuentaCorrienteProveedor);
            $cuentaCorrienteProveedor->setProveedor($this);
        }

        return $this;
    }

    public function removeCuentaCorrienteProveedor(CuentaCorrienteProveedor $cuentaCorrienteProveedor): static
    {
        if ($this->cuentaCorrienteProveedors->removeElement($cuentaCorrienteProveedor)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorrienteProveedor->getProveedor() === $this) {
                $cuentaCorrienteProveedor->setProveedor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PagoProveedor>
     */
    public function getPagoProveedors(): Collection
    {
        return $this->pagoProveedors;
    }

    public function addPagoProveedor(PagoProveedor $pagoProveedor): static
    {
        if (!$this->pagoProveedors->contains($pagoProveedor)) {
            $this->pagoProveedors->add($pagoProveedor);
            $pagoProveedor->setProveedor($this);
        }

        return $this;
    }

    public function removePagoProveedor(PagoProveedor $pagoProveedor): static
    {
        if ($this->pagoProveedors->removeElement($pagoProveedor)) {
            // set the owning side to null (unless already changed)
            if ($pagoProveedor->getProveedor() === $this) {
                $pagoProveedor->setProveedor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Compra>
     */
    public function getCompras(): Collection
    {
        return $this->compras;
    }

    public function addCompra(Compra $compra): static
    {
        if (!$this->compras->contains($compra)) {
            $this->compras->add($compra);
            $compra->setProveedor($this);
        }

        return $this;
    }

    public function removeCompra(Compra $compra): static
    {
        if ($this->compras->removeElement($compra)) {
            // set the owning side to null (unless already changed)
            if ($compra->getProveedor() === $this) {
                $compra->setProveedor(null);
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

    public function getContacto(): ?string
    {
        return $this->contacto;
    }

    public function setContacto(?string $contacto): static
    {
        $this->contacto = $contacto;

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
