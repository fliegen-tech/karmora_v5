<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Statichtml extends karmora {
	
	public $data = array ();
	
	public function __construct() {
		parent::__construct();
		$this->data['themeUrl'] = $this->themeUrl;
		$this->load->model( array ( 'usermodel', 'commonmodel', 'pagemodel' ) );
	}
	
	public function karmoracares( $username = null ) {
		$this->verifyUser( $username );
		$this->data['modals'][] = 'karmora-kash-video';
		$this->data['video'] = 'https://www.youtube.com/embed/jFUEyXSulnA?rel=0';
		$this->loadLayout( $this->data, 'frontend/statichtml/karmora-cares' );
		
	}
	
	public function contactus( $username = null ) {
		$this->verifyUser( $username );
		$this->loadLayout( $this->data, 'frontend/statichtml/contactus' );
	}
	
	public function profitsharingprogram( $username = null ) {
		$this->verifyUser( $username );
		$this->loadLayout( $this->data, 'frontend/statichtml/profitsharingprogram' );
	}
	
	public function footerpages( $alias, $username = null ) {
		$this->verifyUser( $username );
		$this->data['footerpages'] = $this->pagemodel->getpagedetail( $alias );
		$this->loadLayout( $this->data, 'frontend/statichtml/karmorafooterpages' );
		
	}
	
	public function compensationplan( $username = null ) {
		$this->verifyUser( $username );
		$this->loadLayout( $this->data, 'frontend/statichtml/compensationplan' );
		
	}
	
	public function howcashbackworks( $username = null ) {
		$this->verifyUser( $username );
		$this->loadLayout( $this->data, 'frontend/statichtml/howcashbackworks' );
	}
	
	public function kashbacktoolbar( $username = null ) {
		$this->verifyUser( $username );
		$this->data['broswer_detail'] = $this->getBrowser();
		$this->data['modals'][]       = 'karmora-kash-video';
		$this->data['video']          = 'https://www.youtube.com/embed/jQX2WdJXqzU?rel=0';
		$this->loadLayout( $this->data, 'frontend/statichtml/kash-back-toolbar' );
		
	}
	
	public function karmorakash( $username = null ) {
		$this->verifyUser( $username );
		$this->data['modals'][] = 'karmora-kash-video';
		$this->data['video']    = 'https://www.youtube.com/embed/1g37DRMXNLk?rel=0';
		$this->loadLayout( $this->data, 'frontend/statichtml/karmorakash' );
		
	}
	
	public function aboutus( $username = null ) {
		$this->verifyUser( $username );
		$this->loadLayout( $this->data, 'frontend/statichtml/aboutus' );
	}
	
	public function getBrowser() {
		$u_agent  = $_SERVER['HTTP_USER_AGENT'];
		$bname    = 'Unknown';
		$platform = 'Unknown';
		$version  = "";
		//First get the platform?
		if ( preg_match( '/linux/i', $u_agent ) ) {
			$platform = 'linux';
		} elseif ( preg_match( '/macintosh|mac os x/i', $u_agent ) ) {
			$platform = 'mac';
		} elseif ( preg_match( '/windows|win32/i', $u_agent ) ) {
			$platform = 'windows';
		}
		// Next get the name of the useragent yes seperately and for good reason
		if ( preg_match( '/MSIE/i', $u_agent ) && ! preg_match( '/Opera/i', $u_agent ) ) {
			$bname = 'Internet Explorer';
			$ub    = "MSIE";
		} elseif ( preg_match( '/Firefox/i', $u_agent ) ) {
			$bname = 'Mozilla Firefox';
			$ub    = "Firefox";
		} elseif ( preg_match( '/Chrome/i', $u_agent ) ) {
			$bname = 'Google Chrome';
			$ub    = "Chrome";
		} elseif ( preg_match( '/Safari/i', $u_agent ) ) {
			$bname = 'Apple Safari';
			$ub    = "Safari";
		} elseif ( preg_match( '/Opera/i', $u_agent ) ) {
			$bname = 'Opera';
			$ub    = "Opera";
		} elseif ( preg_match( '/Netscape/i', $u_agent ) ) {
			$bname = 'Netscape';
			$ub    = "Netscape";
		}
		
		// finally get the correct version number
		$known   = array ( 'Version', $ub, 'other' );
		$pattern = '#(?<browser>' . join( '|', $known ) .
		           ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if ( ! preg_match_all( $pattern, $u_agent, $matches ) ) {
			// we have no matching number just continue
		}
		
		// see how many we have
		$i = count( $matches['browser'] );
		if ( $i != 1 ) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if ( strripos( $u_agent, "Version" ) < strripos( $u_agent, $ub ) ) {
				$version = $matches['version'][0];
			} else {
				$version = $matches['version'][1];
			}
		} else {
			$version = $matches['version'][0];
		}
		
		// check if we have a number
		if ( $version == null || $version == "" ) {
			$version = "?";
		}
		
		return array (
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'   => $pattern
		);
	}
	
	public function downloadextension( $username = null, $type = null ) {
		$this->verifyUser( $username );
		$userId      = $this->session->userdata['front_data']['id'];
		$bounsamount = $this->usermodel->getextensionalreadydata( $userId );
		if ( empty( $bounsamount ) ) {
			$dataLog = array (
				'fk_user_id'       => $userId,
				'fk_user_id_from'  => $userId,
				'kash_amount'      => 5,
				'kash_type'        => 'Deposit',
				'kash_description' => 'kash back toolbar'
			);
			$this->db->insert( 'tbl_karmora_kash_account', $dataLog );
			if ( $type == 'chorme' ) {
				redirect( 'https://chrome.google.com/webstore/detail/karmora-cash-back/fdlpnajloaankllhodpelkolokpnlflp' );
			} else {
				redirect( 'https://addons.mozilla.org/en-US/firefox/addon/karmora-cash-back/' );
			}
		} else {
			if ( $type == 'chorme' ) {
				redirect( 'https://chrome.google.com/webstore/detail/karmora-cash-back/fdlpnajloaankllhodpelkolokpnlflp' );
			} else {
				redirect( 'https://addons.mozilla.org/en-US/firefox/addon/karmora-cash-back/' );
			}
		}
	}
	
}

/* Location: ./application/controllers/welcome.php */