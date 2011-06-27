<?php
/**
 * This is the Spirit REST service.
 * 
 * @author	   Florian Schuhmann
 * @package    Default
 * @subpackage Service
 */
class Default_Service_Spirit extends Application_Rest_Client
{
    /**
     * @var string URL of the REST service
     */
    protected $_uri = 'https://212.201.64.226:8443/';
    /**
     * @var string suffix of the URL
     */
    protected $_suffix = '/fhs-spirit';

    // other server info
    //protected $_uri = 'http://spiritdev.fh-schmalkalden.de/';
    //protected $_suffix = '/database';
    
    /**
     * @var array
     */
    protected $_params = array();
    /**
     * @var string
     */
    protected $_data;
    /**
     * @var string
     */
    protected $_responseType = 'json';
    /**
     * @var string
     */
    protected $_encryptType = 'json';
    /**
     * @var array
     */
    protected $_types = array('xml', 'json');
    /**
     * 
     * @return void
     */
    public function __construct ()
    {
        $this->setUri($this->_uri);
        $client = self::getHttpClient();
        $client->setHeaders(array(
            	'Accept:application/'.$this->getResponseType(),
            	'Accept-Charset: utf-8'
            ));
    }
    /**
     * 
     * @param array $params
     */
    public function setParams($params)
    {

        foreach ($params as $key => $value) {
            switch (strtolower($key)) {
                case 'responseType':
                    $this->setResponseType($value);
                    break;
                case 'encryptType':
                    $this->setEncryptType($value);
                    break;
                case 'data':
                    $this->setData($value);
                    break;
                default:
                    $this->_params[$key] = $value;
                    break;
            }
        }

        return $this;
    }
    /**
     * 
     * @return array $_params
     */
    public function getParams()
    {
    	return $this->_params;
    }
    /**
     * 
     * @param string $responseType
     * @throws Default_Service_Spirit_Exception
     */
    public function setResponseType($responseType)
    {
        if (!in_array(strtolower($responseType), $this->_types)) {
            throw new Default_Service_Spirit_Exception('Invalid Response Type');
        }

        $this->_responseType = strtolower($responseType);
        return $this;
    }
    /**
     * 
     * @return string $_responseType
     */
    public function getResponseType()
    {
        return $this->_responseType;
    }
    /**
     * 
     * @param string $encryptType
     * @throws Default_Service_Spirit_Exception
     */
    public function setEncryptType($encryptType)
    {
        if (!in_array(strtolower($encryptType), $this->_types)) {
            throw new Default_Service_Spirit_Exception('Invalid Encrypt Type');
        }

        $this->_encryptType = strtolower($encryptType);
        return $this;
    }
    /**
     * 
     * @return string $_responseType
     */
    public function getEncryptType()
    {
        return $this->_encryptType;
    }
	/**
     * @param string $_data
     */
    public function setData ($_data)
    {
        $this->_data = $_data;
        return $this;
    }
	/**
     * @return string $_data
     */
    public function getData ()
    {
        return $this->_data;
    }
    /**
     * 
     * @param string $requestType
     * @param string $path
     * @return stdClass
     * @throws Default_Service_Spirit_Exception
     */
    public function sendRequest($requestType, $path)
    {
        $requestType = ucfirst(strtolower($requestType));

        if ($requestType !== 'Delete' && $requestType !== 'Get' 
            && $requestType !== 'Post' && $requestType !== 'Put'){
                throw new Default_Service_Spirit_Exception('Invalid request type: ' . $requestType);
        }
        try {
            $requestMethod = 'rest' . $requestType;
            
            if ($requestType === 'Put' || $requestType === 'Post') {
                $response = $this->{$requestMethod}($path, $this->getData(), 'application/'.$this->getEncryptType());
            }else{
                $response = $this->{$requestMethod}($path, $this->getParams());
            }
            
            return $this->formatResponse($response);
            
        } catch (Zend_Http_Client_Exception $e) {
            throw new Default_Service_Spirit_Exception($e->getMessage());
        }
    }
    
    /**
     * 
     * @return stdClass
     * @param Zend_Http_Response $response
     * @uses Zend_Json_Decoder
     * @uses Zend_Rest_Client_Result
     */
    public function formatResponse(Zend_Http_Response $response)
    {
        if ($this->getResponseType() === 'json')
            return Zend_Json_Decoder::decode($response->getBody(), Zend_Json::TYPE_OBJECT);
        else 
            return new Zend_Rest_Client_Result($response->getBody());        
    }
    /**
     * 
     * fetchs all news with comments
     * which passes the filter criteria
     * @param array $params
	 * @return stdClass
     */
    public function fetchAllNews(array $params = array()) {
        $this->setParams($params);
        
        $path = $this->_suffix . '/news';
        
        return $this->sendRequest('GET', $path);
    }
    /**
     * 
     * find one news with comments
     * @param int $id
     * @param array $params
     * @return stdClass
     */
    public function findNews($id, array $params = array()) {
        $this->setParams($params);
        
        $path = sprintf($this->_suffix . '/news/%s', trim(strtolower($id)));
        
        return $this->sendRequest('GET', $path);
    }
    /**
     * 
     * fetchs all degreeClasses
     * which passes the filter criteria
     * @param array $params
     * @return stdClass
     */
    public function fetchAllDegreeClasses(array $params = array()) {
        $this->setParams($params);
        
        $path = $this->_suffix . '/degreeClass';

        return $this->sendRequest('GET', $path);
    }
    /**
     * 
     * fetchs all appointments
     * which passes the filter criteria
     * @param array $params
     * @return stdClass
     */
    public function fetchAllAppointments(array $params = array()) {
        $this->setParams($params);
        
        $path = $this->_suffix . '/appointment';

        return $this->sendRequest('GET', $path);
    }
    /**
     * 
     * find one appointment
     * @param int $id
     * @param array $params
     * @return stdClass
     */
    public function findAppointment($id, array $params = array()) {
        $this->setParams($params);
        
        $path = sprintf($this->_suffix . '/appointment/%s', trim(strtolower($id)));
        
        return $this->sendRequest('GET', $path);
    }
    /**
     * 
     * find one comment
     * @param int $id
     * @param array $params
     * @return stdClass
     */
    public function findComment($id, array $params = array()) {
        $this->setParams($params);

        $path = sprintf($this->_suffix . '/news/comment/%s', trim(strtolower($id)));
        
        return $this->sendRequest('GET', $path);
    }
    /**
     * save a new comment
     * @param array $params
     * @return stdClass 
     */
    public function saveComment(array $params = array()){
        $this->setParams($params);

        $path = $this->_suffix . '/news/comment';

        return $this->sendRequest('PUT', $path);        
        // Debug with:
        //die(var_dump($this->getHttpClient()->getLastRequest()));
    }
    
    /**
     * 
     * delete one comment
     * @param int $id
     * @param array $params
     * @return stdClass
     */
    public function deleteComment($id, array $params = array()){
        $this->setParams($params);

        $path = sprintf($this->_suffix . '/news/comment/%s', trim(strtolower($id)));
        
        return $this->sendRequest('DELETE', $path);
    }
}
?>