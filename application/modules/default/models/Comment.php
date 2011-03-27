<?php
/**
 * Comment model
 *
 * Utilizes the Data Mapper pattern to persist data. Represents a single 
 * comment.
 * @author	   Florian Schuhmann
 * @uses       Default_Model_CommentMapper
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
    protected $_cruser;
    /**
     * @var string
     */
    protected $_text;
    /**
     * @var string
     */
    protected $_crdate;
    /**
     * @var Default_Model_CommentMapper
     */
    protected $_mapper;

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
     * Set text
     * 
     * @param  string $text 
     * @return Default_Model_Comment
     */
    public function setText ($text)
    {
        $this->_text = (string) $text;
        return $this;
    }
    /**
     * Get comment
     * 
     * @return null|string
     */
    public function getText ()
    {
        return $this->_text;
    }
    /**
     * Set created timestamp
     * 
     * @param  string $ts 
     * @return Default_Model_Comment
     */
    public function setCrdate ($ts)
    {
        $this->_crdate = $ts;
        return $this;
    }
    /**
     * Get comment timestamp
     * 
     * @return string
     */
    public function getCrdate ()
    {
        return $this->_crdate;
    }
    /**
     * Set created user
     * 
     * @param  string $user 
     * @return Default_Model_Comment
     */
    public function setCruser ($user)
    {
        $this->_cruser = $user;
        return $this;
    }
    /**
     * Get comment user
     * 
     * @return string
     */
    public function getCruser ()
    {
        return $this->_cruser;
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
	 * @return the $_entryId
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
     * Lazy loads Default_Model_CommentMapper instance if no mapper registered.
     * 
     * @return Default_Model_CommentMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Default_Model_CommentMapper());
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
        $where = 'entryId = ' . $where;
        return $this->getMapper()->fetchAll($where);
    }
}
