<?php
/** 
 * @author Florian Schuhmann
 * 
 * 
 */
class Default_Service_Spirit extends Zend_Rest_Client
{
    protected $_uri = 'https://212.201.64.226:8443/';
    protected $_prefix = '/fhs-spirit';

    //protected $_uri = 'http://spiritdev.fh-schmalkalden.de/';
    //protected $_prefix = '/database';
    
    protected $_params = array();
    protected $_filterParams = array();
    protected $_responseType = 'json';
    protected $_responseTypes = array('xml', 'json');
    /**
     * 
     * @return void
     */
    public function __construct ()
    {
        $this->setUri($this->_uri);
        $client = self::getHttpClient();
        $client->setHeaders(array(
            'Accept' => 'application/'.$this->getResponseType(),
        	'Accept-Charset' => 'ISO-8859-1,utf-8'
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
                case 'type':
                    $this->setResponseType($value);
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
    	return $this->_filterParams;
    }
    /**
     * 
     * @param array $params
     */
    public function setFilterParams($params)
    {
        $this->_filterParams=$params;
        return $this;
    }
    /**
     * 
     * @return array $_params
     */
    public function getFilterParams()
    {
    	return $this->_filterParams;
    }
    /**
     * 
     * @param string $responseType
     * @throws Default_Service_Spirit_Exception
     */
    public function setResponseType($responseType)
    {
        if (!in_array(strtolower($responseType), $this->_responseTypes)) {
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
     * @param string $requestType
     * @param string $path
     * @throws Default_Service_Spirit_Exception
     */
    public function sendRequest($requestType, $path)
    {
        $requestType = ucfirst(strtolower($requestType));
        if ($requestType !== 'Post' && $requestType !== 'Get') {
            throw new Default_Service_Spirit_Exception('Invalid request type: ' . $requestType);
        }

        try {
            $requestMethod = 'rest' . $requestType;
            $response = $this->{$requestMethod}($path, $this->getParams(), $this->getFilterParams());
            return $this->formatResponse($response);
        } catch (Zend_Http_Client_Exception $e) {
            throw new Default_Service_Spirit_Exception($e->getMessage());
        }
    }
    
    /**
     * 
     * @return stdClass
     * @param Zend_Http_Response $response
     */
    public function formatResponse(Zend_Http_Response $response)
    {
        //die(var_dump($response));
        //$news = '{"news":[{"id":1,"title":"Heute ist Ausfall","content":"Heute scheint die Sonne so toll, weswegen wir heute keine Vorlesung machen.","displayedName":"Prof. Braun","classes":[{"title":"MAI3"}],"newsComments":[],"creationDate":"Mon May 09 00:00:00 CEST 2011"},{"id":2,"title":"Heute ist Party","content":"Heute ist Party am F Gebäude","displayedName":"Prof. Braun","classes":[{"title":"MAI3"}],"newsComments":[{"id":2,"content":"Für Bier ist gesorgt","displayedName":"Prof. Braun","creationDate":"Mon May 30 00:00:00 CEST 2011"},{"id":1,"content":"Juhu Party!!! Brauchen wir Bier?","displayedName":"Benjamin Lüdicke","creationDate":"Mon May 30 00:00:00 CEST 2011"}],"creationDate":"Mon May 09 00:00:00 CEST 2011"},{"id":3,"title":"DFT","content":"Am Mittwoch bringe ich euch allen die Diskrete Fourier-Transformation bei!","displayedName":"Prof. Golz","classes":[{"title":"MAI1"}],"newsComments":[{"id":3,"content":"DFT ist doch langweilig. Können wir nicht lernen, wie man als single-Informatiker durchs leben kommt?","displayedName":"Ronny Schleicher","creationDate":"Tue May 10 00:00:00 CEST 2011"}],"creationDate":"Mon May 09 00:00:00 CEST 2011"}]}';
        if ($this->getResponseType() === 'json')
            return Zend_Json_Decoder::decode($response->getBody(), Zend_Json::TYPE_OBJECT)->news;
        else 
            return new Zend_Rest_Client_Result($response->getBody());        
    }
    /**
     * 
     * fetchs all news with comments
     * which passes the filter criteria
     * @param array $params
     */
    public function fetchAllNews(array $filterParams = array(), array $params = array()) {
        $this->setParams($params);
        $this->setFilterParams($filterParams);
        
        $path = $this->_prefix . '/news';

        return $this->sendRequest('GET', $path);
    }
    /**
     * 
     * find one news with comments
     * @param array $params
     * @param int $id
     */
    public function findNews($id, array $params = array()) {
        $this->setParams($params);
        
        $path = sprintf($this->_prefix . '/news/%s', trim(strtolower($id)));
        return $this->sendRequest('GET', $path);
    }
    // TODO add some functions for comments
}
?>