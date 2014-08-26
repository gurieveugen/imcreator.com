<?php

class Visitors{
	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
	const FIELD_IPS = 'visitor_ips3';

	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	private $IP;

	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct($IP)
	{
		$this->IP = $IP;
	}

	/**
	 * Visitor registered or no
	 * @return boolean --- true if success | false if no
	 */
	public function isRegisterdIP()
	{
		$IPs = (array) $this->getIPs();
		return in_array($this->IP, $IPs);
	}

	/**
	 * Register current IP
	 */
	public function registerIP()
	{
		if(!$this->isRegisterdIP())
		{
			$IPs = (array) $this->getIPs();
			array_push($IPs, $this->IP);
			update_option(self::FIELD_IPS, $IPs);
		}
	}

	/**
	 * Get registered IP's
	 * @return mixed --- array if succes | false if not
	 */
	public function getIPs()
	{
		return get_option(self::FIELD_IPS);
	}

	/**
	 * Get client IP address
	 * @return string --- 0.0.0.0 ip address
	 */
	public static function getIP()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']) && ! empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} 
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} 
		else 
		{
		    $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
		}

		$ip = filter_var($ip, FILTER_VALIDATE_IP);
		return ($ip === false) ? '0.0.0.0' : $ip;	
	}
}