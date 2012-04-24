<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Hirudo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Models\Components\Restful;

class RequestCodes {

    const OK = 0;
//  UNSUPPORTED_PROTOCOL,    /* 1 */
//  FAILED_INIT,             /* 2 */
//  URL_MALFORMAT,           /* 3 */
//  OBSOLETE4,               /* 4 - NOT USED */
//  COULDNT_RESOLVE_PROXY,   /* 5 */
//  COULDNT_RESOLVE_HOST,    /* 6 */
    const COULDNT_CONNECT = 7;         /* 7 */
//  FTP_WEIRD_SERVER_REPLY,  /* 8 */
//  REMOTE_ACCESS_DENIED,    /* 9 a service was denied by the server
//                                    due to lack of access - when login fails
//                                    this is not returned. */
//  OBSOLETE10,              /* 10 - NOT USED */
//  FTP_WEIRD_PASS_REPLY,    /* 11 */
//  OBSOLETE12,              /* 12 - NOT USED */
//  FTP_WEIRD_PASV_REPLY,    /* 13 */
//  FTP_WEIRD_227_FORMAT,    /* 14 */
//  FTP_CANT_GET_HOST,       /* 15 */
//  OBSOLETE16,              /* 16 - NOT USED */
//  FTP_COULDNT_SET_TYPE,    /* 17 */
//  PARTIAL_FILE,            /* 18 */
//  FTP_COULDNT_RETR_FILE,   /* 19 */
//  OBSOLETE20,              /* 20 - NOT USED */
//  QUOTE_ERROR,             /* 21 - quote command failure */
//  HTTP_RETURNED_ERROR,     /* 22 */
//  WRITE_ERROR,             /* 23 */
//  OBSOLETE24,              /* 24 - NOT USED */
//  UPLOAD_FAILED,           /* 25 - failed upload "command" */
//  READ_ERROR,              /* 26 - couldn't open/read from file */
//  OUT_OF_MEMORY,           /* 27 */
//  /* Note: OUT_OF_MEMORY may sometimes indicate a conversion error
//           instead of a memory allocation error if CURL_DOES_CONVERSIONS
//           is defined
//  */
    /* 28 - the timeout time was reached */
    const OPERATION_TIMEDOUT = 28;
//  OBSOLETE29,              /* 29 - NOT USED */
//  FTP_PORT_FAILED,         /* 30 - FTP PORT operation failed */
//  FTP_COULDNT_USE_REST,    /* 31 - the REST command failed */
//  OBSOLETE32,              /* 32 - NOT USED */
//  RANGE_ERROR,             /* 33 - RANGE "command" didn't work */
//  HTTP_POST_ERROR,         /* 34 */
//  SSL_CONNECT_ERROR,       /* 35 - wrong when connecting with SSL */
//  BAD_DOWNLOAD_RESUME,     /* 36 - couldn't resume download */
//  FILE_COULDNT_READ_FILE,  /* 37 */
//  LDAP_CANNOT_BIND,        /* 38 */
//  LDAP_SEARCH_FAILED,      /* 39 */
//  OBSOLETE40,              /* 40 - NOT USED */
    const FUNCTION_NOT_FOUND = 41;
//  ABORTED_BY_CALLBACK,     /* 42 */
//  BAD_FUNCTION_ARGUMENT,   /* 43 */
//  OBSOLETE44,              /* 44 - NOT USED */
//  INTERFACE_FAILED,        /* 45 - CURLOPT_INTERFACE failed */
//  OBSOLETE46,              /* 46 - NOT USED */
//  TOO_MANY_REDIRECTS ,     /* 47 - catch endless re-direct loops */
//  UNKNOWN_TELNET_OPTION,   /* 48 - User specified an unknown option */
//  TELNET_OPTION_SYNTAX ,   /* 49 - Malformed telnet option */
//  OBSOLETE50,              /* 50 - NOT USED */
//  PEER_FAILED_VERIFICATION, /* 51 - peer's certificate or fingerprint
//                                     wasn't verified fine */
//  GOT_NOTHING,             /* 52 - when this is a specific error */
//  SSL_ENGINE_NOTFOUND,     /* 53 - SSL crypto engine not found */
//  SSL_ENGINE_SETFAILED,    /* 54 - can not set SSL crypto engine as
//                                    default */
//  SEND_ERROR,              /* 55 - failed sending network data */
//  RECV_ERROR,              /* 56 - failure in receiving network data */
//  OBSOLETE57,              /* 57 - NOT IN USE */
//  SSL_CERTPROBLEM,         /* 58 - problem with the local certificate */
//  SSL_CIPHER,              /* 59 - couldn't use specified cipher */
//  SSL_CACERT,              /* 60 - problem with the CA cert (path?) */
//  BAD_CONTENT_ENCODING,    /* 61 - Unrecognized transfer encoding */
//  LDAP_INVALID_URL,        /* 62 - Invalid LDAP URL */
//  FILESIZE_EXCEEDED,       /* 63 - Maximum file size exceeded */
//  USE_SSL_FAILED,          /* 64 - Requested FTP SSL level failed */
//  SEND_FAIL_REWIND,        /* 65 - Sending the data requires a rewind
//                                    that failed */
//  SSL_ENGINE_INITFAILED,   /* 66 - failed to initialise ENGINE */
//  LOGIN_DENIED,            /* 67 - user, password or similar was not
//                                    accepted and we failed to login */
//  TFTP_NOTFOUND,           /* 68 - file not found on server */
//  TFTP_PERM,               /* 69 - permission problem on server */
//  REMOTE_DISK_FULL,        /* 70 - out of disk space on server */
//  TFTP_ILLEGAL,            /* 71 - Illegal TFTP operation */
//  TFTP_UNKNOWNID,          /* 72 - Unknown transfer ID */
//  REMOTE_FILE_EXISTS,      /* 73 - File already exists */
//  TFTP_NOSUCHUSER,         /* 74 - No such user */
//  CONV_FAILED,             /* 75 - conversion failed */
//  CONV_REQD,               /* 76 - caller must register conversion
//                                    callbacks using curl_easy_setopt options
//                                    CURLOPT_CONV_FROM_NETWORK_FUNCTION,
//                                    CURLOPT_CONV_TO_NETWORK_FUNCTION, and
//                                    CURLOPT_CONV_FROM_UTF8_FUNCTION */
//  SSL_CACERT_BADFILE,      /* 77 - could not load CACERT file, missing
//                                    or wrong format */
    /**
     * remote file not found
     */
    const REMOTE_FILE_NOT_FOUND = 78;

//  SSH,                     /* 79 - error from the SSH layer, somewhat
//                                    generic so the error message will be of
//                                    interest when this has happened */
//
//  SSL_SHUTDOWN_FAILED,     /* 80 - Failed to shut down the SSL
//                                    connection */
//  AGAIN,                   /* 81 - socket is not ready for send/recv,
//                                    wait till it's ready and try again (Added
//                                    in 7.18.2) */
//  SSL_CRL_BADFILE,         /* 82 - could not load CRL file, missing or
//                                    wrong format (Added in 7.19.0) */
//  SSL_ISSUER_ERROR,        /* 83 - Issuer check failed.  (Added in
//                                    7.19.0) */
//  FTP_PRET_FAILED,         /* 84 - a PRET command failed */
//  RTSP_CSEQ_ERROR,         /* 85 - mismatch of RTSP CSeq numbers */
//  RTSP_SESSION_ERROR,      /* 86 - mismatch of RTSP Session Identifiers */
//  FTP_BAD_FILE_LIST,       /* 87 - unable to parse FTP file list */
//  CHUNK_FAILED,            /* 88 - chunk callback reported error */
}

/**
 * This class envelops the curl functions into an useful and easy-to-use class.
 */
class RestRequest {

    protected $url;
    protected $verb;
    protected $requestBody;
    protected $requestLength = 0;
    protected $username = null;
    protected $password = null;
    protected $responseBody = null;
    protected $responseInfo = null;
    protected $responseStatus = 0;
    private $header = array();

    /**
     * Creates a new instance of RestRequest
     * @param string $url [Optional] The service URL.
     * @param string $verb [Optional] The protocol for the request, GET by default.
     * @param string $requestBody [Optional] Any data sent to the request.
     */
    public function __construct($url = null, $verb = 'GET', $requestBody = null) {
        $this->url = $url;
        $this->verb = $verb;
        $this->requestBody = $requestBody;
    }

    /**
     * 
     */
    public function flush() {
        $this->requestBody = null;
        $this->requestLength = 0;
        $this->verb = 'GET';
        $this->responseBody = null;
        $this->responseInfo = null;
    }

    /**
     * 
     * @throws InvalidArgumentException Cuando el protocolo del request
     * no es GET, POST, PUT o DELETE.
     * @throws RequestFailedException When request fails.
     */
    public function execute() {
        $ch = curl_init();
        $this->setAuth($ch);

        try {
            switch (strtoupper($this->verb)) {
                case 'GET':
                    $this->executeGet($ch);
                    break;
                case 'POST':
                    $this->executePost($ch);
                    break;
                case 'PUT':
                    $this->executePut($ch);
                    break;
                case 'DELETE':
                    $this->executeDelete($ch);
                    break;
                default:
                    throw new InvalidArgumentException('Current verb (' . $this->verb . ') is an invalid REST verb.');
            }
        } catch (InvalidArgumentException $e) {
            curl_close($ch);
            throw $e;
        } catch (Exception $e) {
            curl_close($ch);
            throw $e;
        }
    }

    /**
     *
     * @param type $data 
     */
    private function buildPostBody($data = null) {
        $data = ($data !== null) ? $data : $this->requestBody;

        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data input '$data' for postBody.  Array expected");
        }

        $data = http_build_query($data, '', '&');
        $this->requestBody = $data;
    }

    //Internal functions.

    /**
     *
     * @param type $ch 
     */
    protected function executeGet($ch) {
        $this->doExecute($ch);
    }

    /**
     *
     * @param type $ch 
     */
    protected function executePost($ch) {
        if (is_array($this->requestBody)) {
            $this->buildPostBody();
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
        curl_setopt($ch, CURLOPT_POST, true);

        $this->doExecute($ch);
    }

    /**
     *
     * @param type $ch 
     */
    protected function executePut($ch) {
        if (is_array($this->requestBody)) {
            $this->buildPostBody();
        }

        $this->requestLength = strlen($this->requestBody);

        // use a max of 256KB of RAM before going to disk
        $tempFile = fopen('php://temp/maxmemory:256000', 'w');
        if (!$tempFile) {
            throw new Exception('could not open temp memory data');
        }
        fwrite($tempFile, $this->requestBody);
        fseek($tempFile, 0);

        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_INFILE, $tempFile); // file pointer
        curl_setopt($ch, CURLOPT_INFILESIZE, $this->requestLength);

        $this->doExecute($ch);
    }

    protected function executeDelete($ch) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $this->doExecute($ch);
    }

    protected function doExecute(&$curlHandle) {
        $this->setCurlOpts($curlHandle);
        $this->responseBody = curl_exec($curlHandle);
        $this->responseInfo = curl_getinfo($curlHandle);
        $this->responseStatus = curl_errno($curlHandle);

        if ($this->responseStatus != RequestCodes::OK) {
            throw new RequestFailedException($curlHandle, $this->responseInfo, $this->getUrl(), $this->responseStatus);
        }

        curl_close($curlHandle);
    }

    protected function setCurlOpts(&$curlHandle) {
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 10);
        curl_setopt($curlHandle, CURLOPT_URL, $this->url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $this->formatHeader());
    }

    protected function setAuth(&$curlHandle) {
        if ($this->username !== null && $this->password !== null) {
            curl_setopt($curlHandle, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            curl_setopt($curlHandle, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        }
    }

    //Getters and setters

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getResponseBody() {
        return $this->responseBody;
    }

    public function getResponseInfo() {
        return $this->responseInfo;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getVerb() {
        return $this->verb;
    }

    public function setVerb($verb) {
        $this->verb = $verb;
    }

    public function getRequestBody() {
        return $this->requestBody;
    }

    public function setRequestBody($requestBody) {
        $this->requestBody = $requestBody;
    }

    public function addHeaderVariable($name, $value) {
        $name = trim($name);
        $this->header[$name] = $value;
    }

    private function formatHeader() {
        $header = array();
        foreach ($this->header as $name => $value) {
            array_push($header, "$name: $value");
        }

        return $header;
    }

}

class RequestFailedException extends Exception {

    private $responseInfo;
    private $errorCode;

    function __construct(&$ch, $responseInfo, $url = "", $code = 7) {
        parent::__construct("[ $url ] " . curl_error($ch));
        $this->responseInfo = $responseInfo;
        $this->errorCode = $code;
    }

    public function getErrorCode() {
        return $this->errorCode;
    }

    public function getResponseInfo() {
        return $this->responseInfo;
    }

}
