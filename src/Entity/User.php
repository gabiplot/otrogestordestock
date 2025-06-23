<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @var Collection<int, Venta>
     */
    #[ORM\OneToMany(targetEntity: Venta::class, mappedBy: 'usuario')]
    private Collection $ventas;

    /**
     * @var Collection<int, CobroCliente>
     */
    #[ORM\OneToMany(targetEntity: CobroCliente::class, mappedBy: 'user')]
    private Collection $cobroClientes;

    public function __construct()
    {
        $this->movimientoStocks = new ArrayCollection();
        $this->ventas = new ArrayCollection();
        $this->cobroClientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getNewPassword(): ?string
    {
        return null;
    }

    public function setNewPassword(?string $newpassword): self
    {
        return $this;
    }    

    public function getRoles(): array
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getRol()
    {
        return $this->roles[0];
    }

    public function setRol(string $rol)
    {
        $this->roles[0] = $rol;

        return $this->roles[0];
    }     

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials(): void
    {
        // Si almacenas datos temporales sensibles en el usuario, límpialos aquí
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
            $venta->setUsuario($this);
        }

        return $this;
    }

    public function removeVenta(Venta $venta): static
    {
        if ($this->ventas->removeElement($venta)) {
            // set the owning side to null (unless already changed)
            if ($venta->getUsuario() === $this) {
                $venta->setUsuario(null);
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
            $cobroCliente->setUser($this);
        }

        return $this;
    }

    public function removeCobroCliente(CobroCliente $cobroCliente): static
    {
        if ($this->cobroClientes->removeElement($cobroCliente)) {
            // set the owning side to null (unless already changed)
            if ($cobroCliente->getUser() === $this) {
                $cobroCliente->setUser(null);
            }
        }

        return $this;
    }

}
