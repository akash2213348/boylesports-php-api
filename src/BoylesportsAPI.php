<?php
/**
 * Boylesports PHP implementation.
 *
 * (c) Alexander Sharapov <alexander@sharapov.biz>
 * http://sharapov.biz/
 *
 */

namespace Sharapov\BoylesportsPHP;

use GuzzleHttp\Client;

class BoylesportsAPI {

  /**
   * Default API options
   */
  private $_clientOptions = [
    'base_uri' => "http://cache.boylesports.com/feeds/",
    'timeout'  => 5
  ];

  private $_queryParams = [];

  private $_endpoint;

  /**
   * UnibetAPI constructor.
   *
   * @param array $params
   *
   * @throws \Sharapov\BoylesportsPHP\BoylesportsAPIException
   */
  public function __construct( array $params = [], $endpoint = null ) {
    if ( ! is_null( $endpoint ) ) {
      $this->_endpoint = $endpoint;
    }
  }

  /**
   * Set HTTP client options
   *
   * @param array $options
   */
  public function setClientOptions( array $options ) {
    $this->_clientOptions = $options;
  }

  /**
   * Get HTTP client options
   *
   * @param null $option
   *
   * @return array|mixed
   */
  public function getClientOptions( $option = null ) {
    return ( $option ) ? $this->_clientOptions[ $option ] : $this->_clientOptions;
  }

  /**
   * Catch undefined method and pass it to the url chain
   *
   * @param $endpoint
   *
   * @return \Sharapov\BoylesportsPHP\BoylesportsAPI
   */
  public function __call( $endpoint, $params ) {
    $this->_endpoint = $this->_endpoint . '/' . strtoupper( $endpoint );

    return new BoylesportsAPI( $this->_queryParams, $this->_endpoint );
  }

  /**
   * Get JSON response
   *
   * @return null|\Psr\Http\Message\ResponseInterface
   * @throws \Sharapov\BoylesportsPHP\BoylesportsAPIException
   */
  public function json() {
    return $this->_request();
  }

  /**
   * Set the full url to be requested from unibet
   *
   * @param            $url
   * @param array|null $b
   *
   * @return \Sharapov\BoylesportsPHP\BoylesportsAPI
   * @throws \Sharapov\BoylesportsPHP\BoylesportsAPIException
   */
  public function setRequestUrl( $url, array $b = null ) {
    if ( ! is_null( $this->_endpoint ) ) {
      throw new BoylesportsAPIException( "You can't loop this class by this method" );
    }

    return new BoylesportsAPI( $this->_queryParams, rtrim($url, '.json') );
  }

  /**
   * Clear endpoints chain
   *
   * @return \Sharapov\BoylesportsPHP\BoylesportsAPI
   */
  public function clear() {
    $this->_endpoint = null;

    return $this;
  }

  /**
   * Send request
   *
   * @param string $responseFormat
   *
   * @return null|\Psr\Http\Message\ResponseInterface
   * @throws \Sharapov\BoylesportsPHP\BoylesportsAPIException
   */
  private function _request( $responseFormat = 'json' ) {
    try {
      $client = new Client( $this->_clientOptions );

      $response = $client->get( $this->getClientOptions( 'base_uri' ) . trim( $this->_endpoint, '/' ) . '.' . ltrim( $responseFormat, '.' ), [ 'query' => $this->_queryParams ] );

      if ( $response->getStatusCode() == 200 ) {
        return $response;
      }

      return null;

    } catch ( \Exception $e ) {
      throw new BoylesportsAPIException( $e->getMessage() );
    }
  }
}