<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity("email")]
#[ORM\Table(name: "users")]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\Length(min: 2, max: 180)]
    #[Assert\Email()]

    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 60)]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 60)]

    private ?string $nom = null;
    #[ORM\Column(type: 'string', length: 60)]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 60)]
    private ?string $postnom = null;


    #[ORM\Column(type: 'string', length: 60)]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 60)]
    private ?string $prenom = null;


    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    private ?string $password = null;

    #[Assert\NotBlank]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 16)]
    private ?string $telephone = null;

    #[ORM\Column(type: 'json')]
    #[Assert\NotNull()]
    private array $roles = [];

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    /**
     * @var Collection<int, Plainte>
     */
    #[ORM\OneToMany(targetEntity: Plainte::class, mappedBy: 'user')]
    private Collection $plaintes;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'user')]
    private Collection $commentaire;

    /**
     * @var Collection<int, Reponse>
     */
    #[ORM\OneToMany(targetEntity: Reponse::class, mappedBy: 'user')]
    private Collection $Reponse;

    /**
     * @var Collection<int, Contact>
     */
    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'user')]
    private Collection $contact;

    public function __construct()
    {
        $this->plaintes = new ArrayCollection();
        $this->commentaire = new ArrayCollection();
        $this->Reponse = new ArrayCollection();
        $this->contact = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPostnom(): ?string
    {
        return $this->postnom;
    }

    public function setPostnom(string $postnom): static
    {
        $this->postnom = $postnom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary sensitive data, clear it here
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        //$roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        $roles = $this->roles;
        if (!in_array('ROLE_ABONNE', $roles)) {
            $roles[] = 'ROLE_ABONNE';
        }

        return array_unique($roles);
        //return $this->roles;
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;

        return $this;
    }



    /**
     * @return Collection<int, Plainte>
     */
    public function getPlainte(): Collection
    {
        return $this->plaintes;
    }

    public function addPlainte(Plainte $plainte): static
    {
        if (!$this->plaintes->contains($plainte)) {
            $this->plaintes->add($plainte);
            $plainte->setUser($this);
        }

        return $this;
    }

    public function removePlainte(Plainte $plainte): static
    {
        if ($this->plaintes->removeElement($plainte)) {
            // set the owning side to null (unless already changed)
            if ($plainte->getUser() === $this) {
                $plainte->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire->add($commentaire);
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponse(): Collection
    {
        return $this->Reponse;
    }

    public function addReponse(Reponse $reponse): static
    {
        if (!$this->Reponse->contains($reponse)) {
            $this->Reponse->add($reponse);
            $reponse->setUser($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): static
    {
        if ($this->Reponse->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getUser() === $this) {
                $reponse->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contact->contains($contact)) {
            $this->contact->add($contact);
            $contact->setUser($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contact->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getUser() === $this) {
                $contact->setUser(null);
            }
        }

        return $this;
    }

    /*public function __toString(): string
    {
        return "{{$this->nom} . ' ' . {$this->prenom} . ' (' . {$this->email} . ')'}";
    }*/

    public function __toString(): string
    {
        return $this->nom . ' ' . $this->prenom . ' (' . $this->email . ')';
    }
}