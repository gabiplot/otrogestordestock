<?php

namespace App\Entity;

use App\Repository\CobroClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CobroClienteRepository::class)]
class CobroCliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cobroClientes')]
    private ?Cliente $cliente = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $monto = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $metodo_pago = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_recibo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observacion = null;

    #[ORM\ManyToOne(inversedBy: 'cobroClientes')]
    private ?User $user = null;

    /**
     * @var Collection<int, CuentaCorrienteCliente>
     */
    #[ORM\OneToMany(targetEntity: CuentaCorrienteCliente::class, mappedBy: 'cobro')]
    private Collection $cuentaCorrienteClientes;

    public function __construct()
    {
        $this->cuentaCorrienteClientes = new ArrayCollection();
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

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(string $monto): static
    {
        $this->monto = $monto;

        return $this;
    }

    public function getMetodoPago(): ?string
    {
        return $this->metodo_pago;
    }

    public function setMetodoPago(?string $metodo_pago): static
    {
        $this->metodo_pago = $metodo_pago;

        return $this;
    }

    public function getNumeroRecibo(): ?string
    {
        return $this->numero_recibo;
    }

    public function setNumeroRecibo(?string $numero_recibo): static
    {
        $this->numero_recibo = $numero_recibo;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
            $cuentaCorrienteCliente->setCobro($this);
        }

        return $this;
    }

    public function removeCuentaCorrienteCliente(CuentaCorrienteCliente $cuentaCorrienteCliente): static
    {
        if ($this->cuentaCorrienteClientes->removeElement($cuentaCorrienteCliente)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorrienteCliente->getCobro() === $this) {
                $cuentaCorrienteCliente->setCobro(null);
            }
        }

        return $this;
    }
}
