<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
 
namespace User\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;
use Zend\Form\Annotation;

/**
 * An example of how to implement a role aware user entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 *
 */
class User implements UserInterface, ProviderInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @Annotation\Attributes({"type":"hidden"})
     */
    protected $Id;

    /**
     * @var $email
     * @ORM\Column(type="string", unique=true,  length=255)
     * 
     */
    protected $email;
    

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $FirstName;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     */
    protected $LastName;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     * @Annotation\Exclude()
     */
    protected $Password;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $Status;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Annotation\Exclude()
     */
    protected $Created;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Annotation\Exclude()
     */
    protected $Updated;
    
    /**
     * @var int
     * @Annotation\Exclude()
     */
    protected $state;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="User\Entity\Role" )
     * @ORM\JoinTable(name="user_role",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="Id", onDelete = "cascade" )},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     * 
     * @Annotation\Name("roles")
     * @Annotation\Type("DoctrineORMModule\Form\Element\EntityRadio")
     * @Annotation\Options({"target_class":"User\Entity\Role"})
     * @Annotation\Attributes({"class":"form-control"})
     */
    protected $roles;
    
    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->setCreated(new \DateTime('now'));
        $this->setUpdated(new \DateTime('now'));
        $this->Status = \Application\Response\Status::PENDING;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getRoles()
    {
        return $this->roles->getValues();
    }
    
    public function getTheRoles()
    {
        return $this->roles;
    }
    
    public function addRole($role)
    {
        $this->roles[] = $role;
    }
    
    public function removeRole($RoleId)
    {
        foreach($this->roles as $index=>$role)
        {
            if($role->getId() == $RoleId)
            {
                unset($this->roles[$index]);
            }
        }
    }

    public function getId() {
        return $this->Id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getType() {
        return $this->Type;
    }

    public function getFirstName() {
        return $this->FirstName;
    }

    public function getLastName() {
        return $this->LastName;
    }

    public function getPassword() {
        return $this->Password;
    }
    
    public function getCreated() {
        return $this->CreatedAt;
    }

    public function getUpdated() {
        return $this->Updated;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function setEmail($Email) {
        $this->email = $Email;
    }

    public function setType($Type) {
        $this->Type = $Type;
    }

    public function setFirstName($FirstName) {
        $this->FirstName = $FirstName;
    }

    public function setLastName($LastName) {
        $this->LastName = $LastName;
    }

    public function setPassword($Password) {
        $this->Password = $Password;
    }

    public function setCreated(\DateTime $CreatedAt) {
        $this->Created = $CreatedAt;
    }

    public function setUpdated(\DateTime $UpdatedAt) {
        $this->Updated = $UpdatedAt;
    }
    
    public function getUsername() {
        ;
    }

    public function setUsername($username) {
        ;
    }
    
    public function getDisplayName() {
        ;
    }
    
    public function setDisplayName($displayName) {
        ;
    }
    
    /************************************************************************/
    public function toArray(){
        
        $data = array(
            'email' => $this->getEmail(),
            'firstname' => $this->getFirstName(),
            'lastname' => $this->getLastName(),
            'username' => $this->getUsername(),
            'displayName' => $this->getDisplayName(),
            'state'     => $this->getState()
        );
        
        return $data;
    }
}
