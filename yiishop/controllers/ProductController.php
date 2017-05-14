<?php
/**
 * Created by PhpStorm.
 * User: Serhio
 * Date: 16.03.2017
 * Time: 8:14
 */

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController {
	
	public function actionView($id){
//		$id = Yii::$app->request->get('id');
		
		$product = Product::findOne($id); // Linivaya zagryzca
//		$product = Product::find()->with('category')->where(['id' => $id])->limit(1)->one(); // Zadnayz zagryzca
		
		if(empty($product)){
			throw new \yii\web\HttpException(404, 'Товара нет!');
		}
		
		$hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
		
		$this->setMeta('E-SHOPPER | ' . $product->name, $product->keywords, $product->description);
		
		return $this->render('view', compact('product', 'hits'));
	}
}