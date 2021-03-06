<?php
/**
 * Entry model
 *
 * Utilizes the Data Mapper pattern to persist data. Represents a single 
 * entry.
 * @author	   Florian Schuhmann
 * @uses       Default_Model_Mapper_EntryDbMapper
 * @uses       Default_Model_Mapper_EntryRestMapper
 * @package    Default
 * @subpackage Model
 */
class Default_Model_Entry
{
    /**
     * @var int
     */
    protected $_news_id;
    /**
     * @var Default_Model_Owner
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
     * @var string
     */
    protected $_lastModified;
    /**
     * @var Array 
     */
    protected $_comments;
    /**
     * @var Default_Model_Mapper_EntryDbMapper / Default_Model_Mapper_EntryRestMapper
     */
    protected $_mapper;
    /**
     * @var array Default_Model_Class
     */
    protected $_degreeClass;
    /**
     * @return the $_comments
     */
    public function getComments ()
    {
        return $this->_comments;
    }
    /**
     * @param array $_comments
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
     * Set entry news_id
     * 
     * @param  int $news_id 
     * @return Default_Model_Entry
     */
    public function setNews_id ($news_id)
    {
        $this->_news_id = (int) $news_id;
        return $this;
    }
    /**
     * Retrieve entry news_id
     * 
     * @return null|int
     */
    public function getNews_id ()
    {
        return $this->_news_id;
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
     * Lazy loads Default_Model_Mapper_EntryDbMapper / Default_Model_Mapper_EntryRestMapper instance if no mapper registered.
     * 
     * @return Default_Model_Mapper_EntryDbMapper / Default_Model_Mapper_EntryRestMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            if ('development' == APPLICATION_ENV)
                $this->setMapper(new Default_Model_Mapper_EntryDbMapper());
            else
                $this->setMapper(new Default_Model_Mapper_EntryRestMapper());
        }
        return $this->_mapper;
    }
    /**
     * Find an entry
     *
     * Resets entry state if matching news_id found.
     * 
     * @param  int $news_id 
     * @return Default_Model_Entry
     */
    public function find ($news_id)
    {
        $this->getMapper()->find($news_id, $this);
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
    public function getDegreeClass ()
    {
        return $this->_degreeClass;
    }
    /**
     * @param string $_degreeClass
     * @return Default_Model_Entry
     */
    public function setDegreeClass ($_degreeClass)
    {
        $this->_degreeClass = $_degreeClass;
        return $this;
    }
	/**
     * @return string
     */
    public function getLastModified ()
    {
        return $this->_lastModified;
    }

	/**
     * @param string $_lastModified
     */
    public function setLastModified ($_lastModified)
    {
        $this->_lastModified = $_lastModified;
        return $this;
    }

}
