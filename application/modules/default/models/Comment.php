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
    protected $_comment_id;
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
     * Set comment comment_id
     * 
     * @param  int $comment_id 
     * @return Default_Model_Comment
     */
    public function setComment_id ($comment_id)
    {
        $this->_comment_id = (int) $comment_id;
        return $this;
    }
    /**
     * Retrieve comment comment_id
     * 
     * @return null|int
     */
    public function getComment_id ()
    {
        return $this->_comment_id;
    }
    /**
	 * @return int
	 */
	public function getNews_id() {
		return $this->_news_id;
	}

	/**
	 * @param int $_news_id
	 */
	public function setNews_id($news_id) {
		$this->_news_id = $news_id;
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
}