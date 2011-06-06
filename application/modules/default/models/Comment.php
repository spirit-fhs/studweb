<?php
/**
 * Comment model
 *
 * Utilizes the Data Mapper pattern to persist data. Represents a single 
 * comment.
 * @author	   Florian Schuhmann
 * @uses       Default_Model_Mapper_CommentMapper
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Comment
{
    /**
     * @var int
     */
    protected $_id;
    /**
     * @var int
     */
    protected $_entryId;
    /**
     * @var string
     */
    protected $_owner;
    /**
     * @var string
     */
    protected $_content;
    /**
     * @var string
     */
    protected $_creationDate;
    /**
     * @var Default_Model_Mapper_CommentMapper
     */
    protected $_mapper;
    /**
     * @var string
     */
    protected $_displayedName;
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
            die($method);
            throw Exception('Invalid property specified');
        }
        return $this->$method();
    }
    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Default_Model_Comment
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
     * Set content
     * 
     * @param  string $content 
     * @return Default_Model_Comment
     */
    public function setContent ($content)
    {
        $this->_content = (string) $content;
        return $this;
    }
    /**
     * Get content
     * 
     * @return null|string
     */
    public function getContent ()
    {
        return $this->_content;
    }
    /**
     * Set created timestamp
     * 
     * @param  string $ts 
     * @return Default_Model_Comment
     */
    public function setCreationDate ($ts)
    {
        $this->_creationDate = $ts;
        return $this;
    }
    /**
     * Get comment timestamp
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
     * @return Default_Model_Comment
     */
    public function setOwner ($owner)
    {
        $this->_owner = $owner;
        return $this;
    }
    /**
     * Get comment owner
     * 
     * @return string
     */
    public function getOwner ()
    {
        return $this->_owner;
    }
    /**
     * Set comment id
     * 
     * @param  int $id 
     * @return Default_Model_Comment
     */
    public function setId ($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    /**
     * Retrieve comment id
     * 
     * @return null|int
     */
    public function getId ()
    {
        return $this->_id;
    }
    /**
	 * @return int
	 */
	public function getEntryId() {
		return $this->_entryId;
	}

	/**
	 * @param int $_entryId
	 */
	public function setEntryId($entryId) {
		$this->_entryId = $entryId;
		return $this;
	}
    /**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Default_Model_Comment
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * Get data mapper
     *
     * Lazy loads Default_Model_Mapper_CommentDbMapper / Default_Model_Mapper_CommentRestMapper instance if no mapper registered.
     * 
     * @return Default_Model_Mapper_CommentDbMapper / Default_Model_Mapper_CommentRestMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            if ('development' == APPLICATION_ENV)
                $this->setMapper(new Default_Model_Mapper_CommentDbMapper());
            else
                $this->setMapper(new Default_Model_Mapper_CommentRestMapper());
        }
        return $this->_mapper;
    }
    /**
     * Save the current comment
     * 
     * @return void
     */
    public function save ()
    {
        $this->getMapper()->save($this);
    }
    /**
     * Find an comment
     *
     * Resets comment state if matching id found.
     * 
     * @param  int $id 
     * @return Default_Model_Comment
     */
    public function find ($id)
    {
        $this->getMapper()->find($id, $this);
        return $this;
    }
    /**
     * Fetch all comments
     * 
     * @return array
     */
    public function fetchAll ($where)
    {
        return $this->getMapper()->fetchAll($where);
    }
    /**
     * delete comment
     * 
     * @return array
     */
    public function delete ($where)
    {
        return $this->getMapper()->delete($where);
    }
	/**
     * @return string
     */
    public function getDisplayedName ()
    {
        return $this->_displayedName;
    }

	/**
     * @param string $_displayedName
     */
    public function setDisplayedName ($_displayedName)
    {
        $this->_displayedName = $_displayedName;
        return $this;
    }

}