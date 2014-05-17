<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
/*
*@param $name : name of the css file without the extension
*@return css file url
*/
function css_url($name) {
	if(is_string($name) && !empty($name)) {
		$extension = end(explode('.',$name));
		if($extension=='css')
			return base_url().'assets/css/'.$name;
		else
			return base_url().'assets/css/'.$name.'.css';
	}
	
	return '';
}

/*
*@param $name : name of the js file without the extension
*@return js file url
*/
function js_url($name) {

	if(is_string($name) && !empty($name)) {
		$extension = end(explode('.',$name));
		if($extension=='js')
			return base_url().'assets/js/'.$name;
		else
			return base_url().'assets/js/'.$name.'.js';
	}
	
	return '';
}

/*
*@param $name : name of the image file. We need to provide the file extension
*@return image file url
*/
function image_url($name) {
	return base_url().'assets/images/'.$name;
}

/*
*@param $name : name of the image file. We need to provide the file extension
*@param $alt : Optional Image alt attribute
*@return image tag
*/
function image($name, $alt='',$attr='') {
	return '<img src="'.image_url($name).'" alt="'.$alt.'" '.$attr.' />';
}

/*
*@param $asset : name of the asset file. Relative location of the asset
*@return the asset url
*/
function plugin_asset_url($asset) {
	return base_url().'assets/'.$asset;
}
