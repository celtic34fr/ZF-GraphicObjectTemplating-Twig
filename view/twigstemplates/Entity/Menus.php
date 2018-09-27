<?php

namespace Application\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered menus.
 * @ORM\Entity()
 * @ORM\Table(name="MENUS", options={"collate"="utf8_general_ci", "charset"="utf8","engine"="MyISAM"})
 */

/*
 *  id          : identifiant auto incrémenté de l'enregistrement
 *  menuRef     : nom ou référence identifiant le menu et sa fonctionnamité
 *  type        : type du menu
 *  label       : texte affiché de l'option de menu
 *  link        : url de la page sur laquelle pointe l'option de menu
 *  authorize   : niveau d'autorisation pour déterminer l'affichage de l'option suivant l'utilisateur
 *  ord         : numéro d'ordre de présentation de l'option de menu dans son niveau
 *  target      : mode de traitement de link, par défaut '_self'
 *
 *  liens vers d'autre(s) table(s)
 *  parent      : lien n à 1 table Menus (menu de niveau supérieur)
 *  children    : lien 1 à n table Menus (menu de niveau inférieur)
 */
class Menus
{
    const OPTIONTYPE_CLASS_METHOD   = 'class_method';
    const OPTIONTYPE_GOT_OBJECT     = 'got_object';
    const OPTIONTYPE_LINK_URL       = 'link_url';
    const OPTIONTYPE_TEMPLATE       = 'template';

    const ODMENUTARGET_SELF         = '_self';
    const ODMENUTARGET_BLANK        = '_blank';
    const ODMENUTARGET_PARENT       = '_parent';
    const ODMENUTARGET_TOP          = '_Top';

    private $const_target;

    /**
     * @ORM\Id
     * @ORM\Column(name="ID_MENUS", type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @var  string $menuRef
     * @ORM\Column(name="MENU_REF", type="string", length=64, nullable=false) */
    protected $menuRef;

    /** @var  string $type
     * @ORM\Column(name="TYPE", type="string", length=8, nullable=false) */
    protected $type;

    /** @var  string $label
     * @ORM\Column(name="LABEL", type="string", length=64, nullable=false)
     * */
    protected $label;

    /** @var  string $link
     * @ORM\Column(name="LINK", type="string", length=255, nullable=true)
     */
    protected $link;

    /** @var string $authorize
     * @ORM\Column(name="AUTHORIZE", type="string", length=1, options={"fixed" = true}
     * , nullable=true)
     */
    protected $authorize = "0";

    /** @var  int $ord
     * @ORM\Column(name="ORD", type="integer", nullable=false)
     */
    protected $ord;

    /** @var  string $target
     * @ORM\Column(name="TARGET", type="string", length=255, nullable=false)
     */
    protected $target;


    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Menus", inversedBy="children")
     * @ORM\JoinColumn(name="PARENT_ID", referencedColumnName="ID_MENUS")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Application\Entity\Menus", mappedBy="parent")
     */
    protected $children;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ord      = 1;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set menuRef.
     *
     * @param string $menuRef
     *
     * @return Menus
     */
    public function setMenuRef($menuRef)
    {
        $this->menuRef = $menuRef;

        return $this;
    }

    /**
     * Get menuRef.
     *
     * @return string
     */
    public function getMenuRef()
    {
        return $this->menuRef;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Menus
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set label.
     *
     * @param string $label
     *
     * @return Menus
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set link.
     *
     * @param string|null $link
     *
     * @return Menus
     */
    public function setLink($link = null)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link.
     *
     * @return string|null
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set authorize.
     *
     * @param string $authorize
     *
     * @return Menus
     */
    public function setAuthorize($authorize)
    {
        $this->authorize = $authorize;

        return $this;
    }

    /**
     * Get authorize.
     *
     * @return string
     */
    public function getAuthorize()
    {
        return $this->authorize;
    }

    /**
     * Set ord.
     *
     * @param int $ord
     *
     * @return Menus
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;

        return $this;
    }

    /**
     * Get ord.
     *
     * @return int
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * Set target.
     *
     * @param string $ord
     *
     * @return Menus
     */
    public function setTarget($target = self::ODMENUTARGET_SELF)
    {
        $targets    = $this->getTargetConstants();
        $target     = (string) $target;
        if (!in_array($target, $targets)) { $target = self::ODMENUTARGET_SELF; }

        $this->target = $target;

        return $this;
    }

    /**
     * Get target.
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set parent.
     *
     * @param Menus|null $parent
     *
     * @return Menus
     */
    public function setParent(Menus $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \Application\Entity\Menus|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child.
     *
     * @param Menus $child
     *
     * @return Menus
     */
    public function addChild(Menus $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child.
     *
     * @param Menus $child
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChild(Menus $child)
    {
        return $this->children->removeElement($child);
    }

    /**
     * Get children.
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children ?? null;
    }


    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function getConstants()
    {
        $ref = new \ReflectionClass($this);
        return $ref->getConstants();
    }

    private function getTargetConstants()
    {
        $retour = [];
        if (empty($this->const_target)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMENUTARGET_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_target = $retour;
        } else {
            $retour = $this->const_target;
        }

        return $retour;
    }

}
