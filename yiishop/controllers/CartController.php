<?php

namespace app\controllers;
use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
use Yii;

class CartController extends AppController {
	
	public function actionAdd() {
		
		$id = Yii::$app->request->get('id');
		$quantity = (int)Yii::$app->request->get('quantity');
		$quantity = !$quantity ? 1 : $quantity;
		
		$product = Product::findOne($id);
		
		if(empty($product)) return false;
		
		$session = Yii::$app->session;
		$session->open();
		
		$cart = new Cart();
		$cart->addToCart($product, $quantity);
		
		if(!Yii::$app->request->isAjax ){
			return $this->redirect(Yii::$app->request->referrer);
		}
		
//		debug($session['cart']);
//		debug($session['cart.qty']);
//		debug($session['cart.sum']);
		
		$this->layout = false;
		
		return $this->render('cart-modal', compact('session'));
	}
	
	public function actionClear() {
		$session = Yii::$app->session;
		$session->open();
		$session->remove('cart');
		$session->remove('cart.qty');
		$session->remove('cart.sum');
		
		$this->layout = false;
		
		return $this->render('cart-modal', compact('session'));
	}
	
	public function actionDelItem(){
		$id = Yii::$app->request->get('id');
		$session = Yii::$app->session;
		$session->open();
		$cart = new Cart();
		$cart->recalc($id);
		
		$this->layout = false;
		
		return $this->render('cart-modal', compact('session'));
	}
	
	public function actionShowCart() {
		$session = Yii::$app->session;
		
		$this->layout = false;
		
		return $this->render('cart-modal', compact('session'));
	}
	
	public function actionView() {
		
//		debug(Yii::$app->params['adminEmail']);
		
		$session = Yii::$app->session;
		$session->open();
		
		$this->setMeta('Корзина');
		
		$order = new Order();
				
		if($order->load(Yii::$app->request->post())){
//			debug(Yii::$app->request->post());
			$order->qty = $session['cart.qty'];
			$order->sum = $session['cart.sum'];
			
			if($order->save()){
				
				$orderItems = new OrderItems();
				$orderItems->saveOrderItems($session['cart'], $order->id);
				
				Yii::$app->session->setFlash('success', 'Ваш заказ принят. Менеджер вскоре свяжется с Вами.');
				// send email
				Yii::$app->mailer->compose('order', ['session' => $session])
					->setFrom(['sksm@mail.ua' => 'yiishop'])
					->setTo($order->email)
					->setSubject('Заказ')
					->send();
				
				// send email
				
				$session->remove('cart');
				$session->remove('cart.qty');
				$session->remove('cart.sum');
				
				return $this->refresh();
				
			}else{
				Yii::$app->session->setFlash('error', 'Ошибка оформления заказа!');
			}
		}
		
		return $this->render('view', compact('session', 'order'));
	}
	
}