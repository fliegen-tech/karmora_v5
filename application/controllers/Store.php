<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Store extends karmora {
	
	public $data = array ();
	
	public function __construct() {
		parent::__construct();
		$this->data['themeUrl'] = $this->themeUrl;
		$this->load->model( array ( 'storemodel', 'commonmodel', 'homemodel','bannermodel' ) );
	}
	
	public function allStore( $store_alias = null, $username = null ) {
		$storeArray = array ();
		$this->verifyUser( $username );
		$detail                       = $this->currentUser;
        $detail = reset($detail);
		$this->data['store_alis_url'] = $store_alias;
		$categories                   = $this->storemodel->getATCategory( $detail['user_account_type_id'] );
		$this->data['categories']     = $categories;
		if ( isset( $this->session->userdata['front_data']['id'] ) && ( $store_alias === 'favourtie' ) ) {
			$this->data['category_all_stores'] = $this->storemodel->GetfavourtieStore( $detail['userid'] );
			$alias                             = 'favourtie';
		} else {
			$alias                             = $this->storemodel->CheckCatAlias( $store_alias );
			$this->data['category_all_stores'] = $this->storemodel->GetStore( $detail['user_account_type_id'], $alias, $detail['userid'] );
		}
		if ( $alias === 'all' ) {
			$this->data['category_title'] = 'All';
		} else if ( $alias === 'favourtie' ) {
			$this->data['category_title'] = 'Favortie';
		} else {
			! empty( $this->data['category_all_stores'] ) ? $this->data['category_title'] = $this->data['category_all_stores'][0]['category_title'] : '';
		}
		if ( ! empty( $this->data['category_all_stores'] ) ) {
			$this->data['StoreArry'] = $this->data['category_all_stores'];
			foreach ( $this->data['StoreArry'] as $store ) {
				$store_title = $store['store_title'] . "<br />";
				$curr        = current( str_split( $store_title ) );
				if ( ! preg_match( "/^[a-zA-Z]$/", $curr ) ) {
					$storeArray['0-9'][ $store_title ] = $store;
				} else {
					$storeArray[ strtoupper( $curr ) ][ $store_title ] = $store;
				}
			}
			$this->data['storeArray'] = $storeArray;
		}
		$categories_top_stores = $this->storemodel->getTopCategoryStores( $detail['user_account_type_id'] );
		if ( empty( $categories_top_stores ) ) {
			$this->data['top_stores'] = false;
		} else {
			$this->data['top_stores'] = $this->sortStoreByCategory( $categories_top_stores );
		}
		$this->loadLayout( $this->data, 'frontend/store/storelist' );
	}
	
	public function array_sort( $array, $type = 'asc' ) {
		$result = array ();
		foreach ( $array as $var => $val ) {
			$set = false;
			foreach ( $result as $var2 => $val2 ) {
				if ( $set == false ) {
					if ( $val > $val2 && $type == 'desc' || $val < $val2 && $type == 'asc' ) {
						$temp = array ();
						foreach ( $result as $var3 => $val3 ) {
							if ( $var3 == $var2 ) {
								$set = true;
							}
							if ( $set ) {
								$temp[ $var3 ] = $val3;
								unset( $result[ $var3 ] );
							}
						}
						$result[ $var ] = $val;
						foreach ( $temp as $var3 => $val3 ) {
							$result[ $var3 ] = $val3;
						}
					}
				}
			}
			if ( ! $set ) {
				$result[ $var ] = $val;
			}
		}
		
		return $result;
	}
	
	public function storeVisit( $store_id = null, $username = null ) {
		
		$this->verifyUser( $username );
		$detail = $this->currentUser;
        $detail = reset($detail);
        $this->checklogin();
		$storeTitle = $this->storemodel->GetStoreInfo( $store_id, $detail['user_account_type_id'] );
		if ( $storeTitle != false ) {
			$this->data['title']              = $storeTitle->store_title;
			$this->data['url']                = $storeTitle->store_url;
			$this->data['affiliateNetworkId'] = $storeTitle->fk_affiliate_network_id;
		} else {
			redirect( base_url() );
		}
		$this->data['url'] = $this->prepURL( $this->data['affiliateNetworkId'], $this->data['url'] );
		
		//record members exiting Karmora to adevertizer
		$memberIP = $_SERVER['REMOTE_ADDR'];
		$this->storemodel->insertKarmoraMemberExfil( $detail["userid"], $store_id, $this->data['title'], $this->data['url'], $memberIP );
		$this->loadLayout( $this->data, 'frontend/store/thanku' );
	}
	
	// function for store details
	public function storeDetail( $storeId, $username = null, $type = null, $advertisement_id = null ) {
		$this->verifyUser( $username );
		$detail                      = $this->currentUser;
        $detail = reset($detail);
        $this->data['favoutieStore'] = $this->storemodel->GetfavourtiesStores( $storeId, $detail['userid'] );
		$categories                  = $this->storemodel->getATCategory( $detail['user_account_type_id'] );
		$this->data['categories']    = $categories;
		$categories_top_stores       = $this->storemodel->getTopCategoryStores( $detail['user_account_type_id'] );
		if ( empty( $categories_top_stores ) ) {
			$this->data['top_stores'] = false;
		} else {
			$this->data['top_stores'] = $this->sortStoreByCategory( $categories_top_stores );
		}
		$this->data['store_detail'] = $this->storemodel->GetStoreInfo( $storeId, $detail['user_account_type_id'] );
		if ( empty( $this->data['store_detail'] ) ) {
			redirect( base_url( 'store' ) );
		}
		$this->getFaceBookTags( $type, $advertisement_id, $storeId );
		$commission                    = $this->storemodel->getCommissionPercentage( $storeId, $detail['user_account_type_id'] );
		$this->data['comm_percentage'] = $commission[0]['store_to_user_account_type_commission_percentage'];
		$this->loadLayout( $this->data, 'frontend/store/store_detail' );
	}
	
	// function for store search
	public function storeSearch( $storeTitleA = null, $username = null ) {
		$storeTitle = str_replace( 33, '\\', str_replace( 22, '/', urldecode( $storeTitleA ) ) );
		$html       = '';
		$response   = array (
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash()
		);
		$this->verifyUser( $username );
		$detail              = $this->currentUser;
        $detail = reset($detail);
        $category_all_stores = $this->storemodel->GetsearchStore( $detail['user_account_type_id'], $storeTitle );
		if ( ! empty( $category_all_stores ) ) {
			$html .= '<br>';
			foreach ( $category_all_stores as $search ) {
				if ( ! $this->session->userdata( 'front_data' ) ) {
					$percantage = 'Up to 30%';
				} else {
					$percantage = $search['cash_back_percentage'];
				}
				$html .= '<a href="' . base_url( 'store-detail' ) . '/' . $search['store_id'] . '" class="pull-left" target="_blank"><li class="search_list_rzlt"><span class="store-title">' . $search['store_title'] . '</span>&nbsp; &nbsp;<span class="store-cashback">' . $percantage . '</span></li></a>';
			}
		} else {
			$html .= "No search results";
		}
		$response['html'] = $html;
		echo json_encode( $response );
		die;
	}
	
	public function sortStoreByCategory( $storesArray ) {
		$sortedStoreArray = array ();
		foreach ( $storesArray as $store ) {
			if ( ! isset( $sortedStoreArray[ $store['category_alias'] ] ) ) {
				$sortedStoreArray[ $store['category_alias'] ] = array ();
			}
			
			array_push( $sortedStoreArray[ $store['category_alias'] ], $store );
		}
		
		return $sortedStoreArray;
	}
	
	public function specialDeals( $alias = null, $username = null ) {
		
		$this->verifyUser( $username );
		$detail = $this->currentUser;
        $detail = reset($detail);
        // for Trending Store
		$this->data['deals']      = $this->storemodel->getSpecialStores( $detail['user_account_type_id'], $alias );
		$this->data['categories'] = $this->storemodel->getATCategory( $detail['user_account_type_id'] );
		// category top stores
		$categories_top_stores = $this->storemodel->getTopCategoryStores( $detail['user_account_type_id'] );
		if ( empty( $categories_top_stores ) ) {
			$this->data['top_stores'] = false;
		} else {
			$this->data['top_stores'] = $this->sortStoreByCategory( $categories_top_stores );
		}
		$this->data['category_detail'] = $this->storemodel->categoryDetails( $alias );
		$this->loadLayout( $this->data, 'frontend/store/offers' );
	}
	
	public function storefavourtie( $storeId = null, $type = null, $username = null ) {
		$this->verifyUser( $username );
		$detail   = $this->currentUser;
		$response = array (
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash()
		);
		if ( $type == 'fvrt' ) {
			$datas = array (
				'fk_user_id'         => $detail['userid'],
				'fk_store_id'        => $storeId,
				'creation_date_time' => date( 'Y-m-d H:i:s' )
			);
			$this->db->insert( 'tbl_favorties', $datas );
		} else {
			$where = array ( 'fk_user_id ' => $detail['userid'], 'fk_store_id ' => $storeId );
			$this->db->where( $where );
			$this->db->delete( 'tbl_favorties' );
		}
		echo json_encode( $response );
		die;
	}
	
	public function getFaceBookTags( $type, $advertisement_id, $storeId ) {
		
		if ( isset( $type ) ) {
			if ( $type == 'banner' ) {
				$banner                 = $this->bannermodel->getEditBanner( $advertisement_id );
				$tracker_advertisement  = $this->themeUrl . '/images/banner/' . $banner->banner_ads_image;
				$title                  = $banner->banner_ads_title;
				$description            = $banner->banner_description;
				$this->data['fb_image'] = $tracker_advertisement;
			}
			
			if ( $type == 'product' ) {
				$banner                 = $this->bannermodel->getEditBanner( $advertisement_id );
				$tracker_advertisement  = $this->themeUrl . '/images/banner/' . $banner->banner_ads_image;
				$title                  = $banner->banner_ads_title;
				$description            = $banner->banner_description;
				$this->data['fb_image'] = $tracker_advertisement;
			}
			
			if ( $type == 'store-ad' ) {
				
				$title                  = "EARN UP TO 30% CASH BACK!";
				$description            = 'Earn up to 30% Cash Back at over 2,000 Name Brand Stores at Karmora.com!  Karmora offers much more than just Cash Back for our Shoppers. Click the Ad to learn more about the next generation of online shopping at Karmora.com!';
				$this->data['fb_image'] = base_url() . 'share/karmora-ad-image/' . $storeId;
				
			}
			
			$this->data['fb_title']       = $title;
			$this->data['fb_description'] = $description;
			
			$this->data['fb_url'] = $type . '/' . $advertisement_id;
		}
		
		return $this->data;
	}
}
