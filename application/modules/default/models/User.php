<?php
class Default_Model_User
{
protected $_cn;
protected $_firstName;
protected $_mail;
protected $_uid;
protected $_title;
protected $_lastName;
protected $_course;
protected $_faculty;
protected $_lastEntry;
/**
	 * @return the $_cn
	 */
	public function getCn() {
		return $this->_cn;
	}

/**
	 * @return the $_firstName
	 */
	public function getFirstName() {
		return $this->_firstName;
	}

/**
	 * @return the $_mail
	 */
	public function getMail() {
		return $this->_mail;
	}

/**
	 * @return the $_uid
	 */
	public function getUid() {
		return $this->_uid;
	}

/**
	 * @return the $_title
	 */
	public function getTitle() {
		return $this->_title;
	}

/**
	 * @return the $_lastName
	 */
	public function getLastName() {
		return $this->_lastName;
	}

/**
	 * @return the $_course
	 */
	public function getCourse() {
		return $this->_course;
	}

/**
	 * @return the $_faculty
	 */
	public function getFaculty() {
		return $this->_faculty;
	}

/**
	 * @param field_type $_cn
	 */
	public function setCn($_cn) {
		$this->_cn = $_cn;
	}

/**
	 * @param field_type $_firstName
	 */
	public function setFirstName($_firstName) {
		$this->_firstName = $_firstName;
		return $this;
	}

/**
	 * @param field_type $_mail
	 */
	public function setMail($_mail) {
		$this->_mail = $_mail;
		return $this;		
	}

/**
	 * @param field_type $_uid
	 */
	public function setUid($_uid) {
		$this->_uid = $_uid;
		return $this;		
	}

/**
	 * @param field_type $_title
	 */
	public function setTitle($_title) {
		$this->_title = $_title;
		return $this;		
	}

/**
	 * @param field_type $_lastName
	 */
	public function setLastName($_lastName) {
		$this->_lastName = $_lastName;
		return $this;
	}

/**
	 * @param field_type $_course
	 */
	public function setCourse($_course) {
		$this->_course = $_course;
		return $this;		
	}

/**
	 * @param field_type $_faculty
	 */
	public function setFaculty($_faculty) {
		$this->_faculty = $_faculty;
		return $this;		
	}
	/**
     * @return the $_lastEntry
     */
    public function getLastEntry ()
    {
        return $this->_lastEntry;
    }

	/**
     * @param field_type $_lastEntry
     */
    public function setLastEntry ($_lastEntry)
    {
        $this->_lastEntry = $_lastEntry;
        return $this;
    }


}