<?php


namespace Enpii\Wp\EnpiiBase\Controllers;


use yii\web\Controller;

class SiteController extends Controller {
	public function actionError() {
		die( 'error here' );
	}

	public function actionIndex(){
		die('index here');
	}
}
