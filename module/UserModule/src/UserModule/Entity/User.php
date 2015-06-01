<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
 
namespace UserModule\Entity;

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
     * @Annotation\Name("email")
     * @Annotation\Attributes({"type":"Zend\Form\Element\Email"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":4,"max":128}})
     * @Annotation\Validator({"name":"EmailAddress","options":{"domain":true}})
     * @Annotation\Attributes({"class":"form-control"})
     * @Annotation\Required(true)
     */
    protected $email;
    
    /**
     * @var string
     * @ORM\Column(type="string",  length=255)
     * @Annotation\Exclude()
     */
    protected $Type;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * @Annotation\Name("FirstName")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":2,"max":64}})
     * @Annotation\Attributes({"class":"form-control"})
     * @Annotation\Required(true)
     */
    protected $FirstName;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * @Annotation\Name("LastName")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":2,"max":64}})
     * @Annotation\Attributes({"class":"form-control"})
     * @Annotation\Required(true)
     */
    protected $LastName;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     * @Annotation\Exclude()
     */
    protected $Password;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable = true)
     * @Annotation\Exclude()
     */

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Annotation\Exclude()
     */
    protected $CreatedAt;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Annotation\Exclude()
     */
    protected $UpdatedAt;
    
    /**
     * @var int
     * @Annotation\Exclude()
     */
    protected $state;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="UserModule\Entity\Role" )
     * @ORM\JoinTable(name="user_role",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="Id", onDelete = "cascade" )},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     * 
     * @Annotation\Name("roles")
     * @Annotation\Type("DoctrineORMModule\Form\Element\EntityRadio")
     * @Annotation\Options({"target_class":"UserModule\Entity\Role"})
     * @Annotation\Attributes({"class":"form-control"})
     */
    protected $roles;
    
    /**
     * @ORM\OneToMany(targetEntity="Engine\Entity\SpecificationCategory", mappedBy="Category", cascade={"persist"})
     * @Annotation\Exclude()
     */
    private $SpecificationCategories;
    
    /**
     * @ORM\OneToMany(targetEntity="UserAddress", mappedBy="User")
     **/
    private $UserAddresses;
    
    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->UserAddresses = new ArrayCollection();
        $this->setType(0);
        $this->setCreatedAt(new \DateTime('now'));
        $this->setUpdatedAt(new \DateTime('now'));
        $this->SpecificationCategories = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->getValues();
    }
    
    public function getTheRoles()
    {
        return $this->roles;
    }
    
    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
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
    
    public function getCreatedAt() {
        return $this->CreatedAt;
    }

    public function getUpdatedAt() {
        return $this->UpdatedAt;
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

    public function setCreatedAt(\DateTime $CreatedAt) {
        $this->CreatedAt = $CreatedAt;
    }

    public function setUpdatedAt(\DateTime $UpdatedAt) {
        $this->UpdatedAt = $UpdatedAt;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function exchangeArray($Data) {
        
        $this->FirstName = isset($Data['FirstName']) ? $Data['FirstName'] : null;
        $this->LastName = isset($Data['LastName']) ? $Data['LastName'] : null;
        $this->Email = isset($Data['Email']) ? $Data['Email'] : null;
//        $this->CreatedAt = isset($Data['CreatedAt']) ? $Data['Name'] : null;
        $this->UpdatedAt = isset($Data['UpdatedAt']) ? $Data['UpdatedAt'] : new \DateTime('now');
        $this->Type = isset($Data['Type']) ? $Data['Type'] : null;
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
    
    public function getSpecificationCategories() {
        return $this->SpecificationCategories;
    }

    public function getUserAddresses() {
        return $this->UserAddresses;
    }

    public function setSpecificationCategories($SpecificationCategories) {
        $this->SpecificationCategories = $SpecificationCategories;
        return $this;
    }

    public function setUserAddresses($UserAddresses) {
        $this->UserAddresses = $UserAddresses;
        return $this;
    }


}
