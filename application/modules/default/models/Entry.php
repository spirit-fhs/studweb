<?php
/**
 * Entry model
 *
 * Utilizes the Data Mapper pattern to persist data. Represents a single 
 * entry.
 * @author	   Florian Schuhmann
 * @uses       Default_Model_EntryMapper
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
    protected $_user;
    /**
     * @var string
     */
    protected $_subject;
    /**
     * @var string
     */
    protected $_news;
    /**
     * @var string
     */
    protected $_crdate;
    /**
     * @var Array 
     */
    protected $_comments;
    /**
     * @var Default_Model_EntryMapper
     */
    protected $_mapper;

    protected $_displayName;
    protected $_semester;
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
     * Set entry news
     * 
     * @param  string $news 
     * @return Default_Model_Entry
     */
    public function setNews ($news)
    {
        $this->_news = (string) $news;
        return $this;
    }
    /**
     * Get entry news
     * 
     * @return null|string
     */
    public function getNews ()
    {
        return $this->_news;
    }
    /**
     * Set entry subject
     * 
     * @param  string $subject
     * @return Default_Model_Entry
     */
    public function setSubject ($subject)
    {
        $this->_subject = (string) $subject;
        return $this;
    }
    /**
     * Get entry subject
     * 
     * @return null|string
     */
    public function getSubject ()
    {
        return $this->_subject;
    }
    /**
     * Set created timestamp
     * 
     * @param  string $ts 
     * @return Default_Model_Entry
     */
    public function setCrdate ($ts)
    {
        $this->_crdate = $ts;
        return $this;
    }
    /**
     * Get entry timestamp
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
     * @return Default_Model_Entry
     */
    public function setUser ($user)
    {
        $this->_user = $user;
        return $this;
    }
    /**
     * Get entry user
     * 
     * @return string
     */
    public function getUser ()
    {
        return $this->_user;
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
     * Lazy loads Default_Model_EntryMapper instance if no mapper registered.
     * 
     * @return Default_Model_EntryMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Default_Model_EntryMapper());
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
    public function fetchAll ()
    {
        return $this->getMapper()->fetchAll();
    }
	/**
     * @return null|string
     */
    public function getDisplayName ()
    {
        return $this->_displayName;
    }

	/**
     * @param string $_displayName
     * @return Default_Model_Entry
     */
    public function setDisplayName ($_displayName)
    {
        $this->_displayName = $_displayName;
        return $this;
    }
	/**
     * @return null|string
     */
    public function getSemester ()
    {
        return $this->_semester;
    }

	/**
     * @param string $_semester
     * @return Default_Model_Entry
     */
    public function setSemester ($_semester)
    {
        $this->_semester = $_semester;
        return $this;
    }


}
