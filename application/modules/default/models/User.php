<?php
/**
 * User model
 * Is used in the auth session.
 *
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Model
 */
class Default_Model_User
{
    /**
     * @var string
     */
    protected $_cn;
    /**
     * @var string
     */
    protected $_firstName;
    /**
     * @var string
     */
    protected $_mail;
    /**
     * @var string
     */
    protected $_uid;
    /**
     * @var string
     */
    protected $_title;
    /**
     * @var string
     */
    protected $_lastName;
    /**
     * @var string
     */
    protected $_course;
    /**
     * @var string
     */
    protected $_faculty;
    /**
     * @var int
     */
    protected $_lastEntry;

    /**
	 * @return string
	 */
	public function getCn() {
		return $this->_cn;
	}
	/**
	 * @return string
	 */
	public function getFirstName() {
		return $this->_firstName;
	}
	/**
	 * @return string
	 */
	public function getMail() {
		return $this->_mail;
	}
	/**
	 * @return string
	 */
	public function getUid() {
		return $this->_uid;
	}
	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->_title;
	}
	/**
	 * @return string
	 */
	public function getLastName() {
		return $this->_lastName;
	}
	/**
	 * @return string
	 */
	public function getCourse() {
		return $this->_course;
	}
	/**
	 * @return string
	 */
	public function getFaculty() {
		return $this->_faculty;
	}
	/**
	 * @param string $_cn
	 */
	public function setCn($_cn) {
		$this->_cn = $_cn;
	}
	/**
	 * @param string $_firstName
	 */
	public function setFirstName($_firstName) {
		$this->_firstName = $_firstName;
		return $this;
	}
	/**
	 * @param string $_mail
	 */
	public function setMail($_mail) {
		$this->_mail = $_mail;
		return $this;		
	}
	/**
	 * @param string $_uid
	 */
	public function setUid($_uid) {
		$this->_uid = $_uid;
		return $this;		
	}
	/**
	 * @param string $_title
	 */
	public function setTitle($_title) {
		$this->_title = $_title;
		return $this;		
	}
	/**
	 * @param string $_lastName
	 */
	public function setLastName($_lastName) {
		$this->_lastName = $_lastName;
		return $this;
	}
	/**
	 * @param string $_course
	 */
	public function setCourse($_course) {
		$this->_course = $_course;
		return $this;		
	}
	/**
	 * @param string $_faculty
	 */
	public function setFaculty($_faculty) {
		$this->_faculty = $_faculty;
		return $this;		
	}
	/**
     * @return int
     */
    public function getLastEntry ()
    {
        return $this->_lastEntry;
    }

	/**
     * @param int $_lastEntry
     */
    public function setLastEntry ($_lastEntry)
    {
        $this->_lastEntry = $_lastEntry;
        return $this;
    }
}