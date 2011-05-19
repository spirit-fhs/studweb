<?php
/**
 * Entry model
 *
 * Utilizes the Data Mapper pattern to persist data. Represents a single 
 * entry.
 * @author	   Florian Schuhmann
 * @uses       Default_Model_EntryDbMapper
 * @uses       Default_Model_EntryRestMapper
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Entry
{
    /**
     * @var int
     */
    protected $_id;
    /**
     * @var string
     */
    protected $_owner;
    /**
     * @var string
     */
    protected $_title;
    /**
     * @var string
     */
    protected $_content;
    /**
     * @var string
     */
    protected $_creationDate;
    /**
     * @var Array 
     */
    protected $_comments;
    /**
     * @var Default_Model_EntryDbMapper / Default_Model_EntryRestMapper
     */
    protected $_mapper;
    /**
     * @var string
     */
    protected $_displayedName;
    /**
     * TODO change Type
     * @var unknown_type
     */
    protected $_classes;
    /**
     * @return the $_comments
     */
    public function getComments ()
    {
        return $this->_comments;
    }
    /**
     * @param field_type $_comments
     */
    public function setComments ($_comments)
    {
        $this->_comments = $_comments;
        return $this;
    }
    /**
     * Constructor
     * 
     * @param  array|null $options 
     * @return void
     */
    public function __construct (array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @param  mixed $value 
     * @return void
     */
    public function __set ($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw Exception('Invalid property specified');
        }
        $this->$method($value);
    }
    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @return mixed
     */
    public function __get ($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw Exception('Invalid property specified');
        }
        return $this->$method();
    }
    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Default_Model_Entry
     */
    public function setOptions (array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    /**
     * Set entry content
     * 
     * @param  string $content 
     * @return Default_Model_Entry
     */
    public function setContent ($content)
    {
        $this->_content = (string) $content;
        return $this;
    }
    /**
     * Get entry content
     * 
     * @return null|string
     */
    public function getContent ()
    {
        return $this->_content;
    }
    /**
     * Set entry title
     * 
     * @param  string $title
     * @return Default_Model_Entry
     */
    public function setTitle ($title)
    {
        $this->_title = (string) $title;
        return $this;
    }
    /**
     * Get entry title
     * 
     * @return null|string
     */
    public function getTitle ()
    {
        return $this->_title;
    }
    /**
     * Set created timestamp
     * 
     * @param  string $ts 
     * @return Default_Model_Entry
     */
    public function setCreationDate ($ts)
    {
        $this->_creationDate = $ts;
        return $this;
    }
    /**
     * Get entry timestamp
     * 
     * @return string
     */
    public function getCreationDate ()
    {
        return $this->_creationDate;
    }
    /**
     * Set created owner
     * 
     * @param  string $owner 
     * @return Default_Model_Entry
     */
    public function setOwner ($owner)
    {
        $this->_owner = $owner;
        return $this;
    }
    /**
     * Get entry owner
     * 
     * @return string
     */
    public function getOwner ()
    {
        return $this->_owner;
    }
    /**
     * Set entry id
     * 
     * @param  int $id 
     * @return Default_Model_Entry
     */
    public function setId ($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    /**
     * Retrieve entry id
     * 
     * @return null|int
     */
    public function getId ()
    {
        return $this->_id;
    }
    /**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Default_Model_Entry
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * Get data mapper
     *
     * Lazy loads Default_Model_EntryDbMapper / Default_Model_EntryRestMapper instance if no mapper registered.
     * 
     * @return Default_Model_EntryDbMapper / Default_Model_EntryRestMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            if ('development' == APPLICATION_ENV)
                $this->setMapper(new Default_Model_EntryDbMapper());
            else
                $this->setMapper(new Default_Model_EntryRestMapper());
        }
        return $this->_mapper;
    }
    /**
     * Find an entry
     *
     * Resets entry state if matching id found.
     * 
     * @param  int $id 
     * @return Default_Model_Entry
     */
    public function find ($id)
    {
        $this->getMapper()->find($id, $this);
        return $this;
    }
    /**
     * Fetch all entries
     * 
     * @return array
     */
    public function fetchAll (array $filterParams = array())
    {
        return $this->getMapper()->fetchAll($filterParams);
    }
    /**
     * @return null|string
     */
    public function getDisplayedName ()
    {
        return $this->_displayedName;
    }
    /**
     * @param string $_displayedName
     * @return Default_Model_Entry
     */
    public function setDisplayedName ($_displayedName)
    {
        $this->_displayedName = $_displayedName;
        return $this;
    }
    /**
     * @return null|string
     */
    public function getClasses ()
    {
        return $this->_classes;
    }
    /**
     * @param string $_classes
     * @return Default_Model_Entry
     */
    public function setClasses ($_classes)
    {
        $this->_classes = $_classes;
        return $this;
    }
}
