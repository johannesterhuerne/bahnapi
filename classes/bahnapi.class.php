<?php

/**
 * Project:     bahnapi
 * File:        classes/bahnapi.class.php
 *
 * @link http://www.terhuerne.org/
 * @copyright 2013 Johannes Terhuerne
 * @author Johannes Terhuerne <johannes[at]terhuerne.org>
 * @package bahnapi
 * @version 0.1 alpha
 * @revision 2013-07-16
 */

class bahnapi{
	private $requestUrl;
	private $requestData;
	private $request;
	public $station;
	public $trains; 
	
	private function doRequest(){
		$this->request = curl_init($this->requestUrl);
		curl_setopt($this->request, CURLOPT_MUTE, 1);
		curl_setopt($this->request, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->request, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->request, CURLOPT_POST, 1);
		curl_setopt($this->request, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		curl_setopt($this->request, CURLOPT_POSTFIELDS, $this->requestData);
		curl_setopt($this->request, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($this->request);
		curl_close($this->request);
		return $result;
	}
	
	public function searchStation($stationName){
		$this->requestData = '<?xml version="1.0" encoding="utf-8" ?><ReqC ver="1.1" prod="String" lang="DE"><LocValReq id="001" maxNr="20" sMode="1"><ReqLoc type="ST" match="'.utf8_encode($stationName).'" /></LocValReq></ReqC>';
		$this->requestUrl = 'http://reiseauskunft.bahn.de/bin/query.exe/dn';
		$this->station = simplexml_load_string($this->doRequest());
		if(isset($this->station)){
			return $this->station;
		}else{
			return false;
		}
	}
	
	public function searchNextTrains($time, $dateBegin, $dateEnd, $stationId, $productFilter = '1111100000000000'){
		$this->requestData = '<?xml version="1.0" encoding="UTF-8" ?><ReqC ver="1.1" prod="JP" lang="DE" clientVersion="2.2.11"><STBReq boardType="DEP" detailLevel="2"><Time>'.date('H:i', $time).'</Time><Period><DateBegin>'.date('Ymd', $dateBegin).'</DateBegin><DateEnd>'.date('Ymd', $dateEnd).'</DateEnd></Period><TableStation externalId="'.utf8_encode($stationId).'"/><ProductFilter>'.utf8_encode($productFilter).'</ProductFilter></STBReq></ReqC>';
		$this->requestUrl = 'http://reiseauskunft.bahn.de/bin/mgate.exe';
		var_dump($this->doRequest());
		$this->trains = simplexml_load_string($this->doRequest());
		if(isset($this->trains)){
			return $this->trains;
		}else{
			return false;
		}
	}
}
?>