<?php

namespace app\models;

use \yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "order_items".
 *
 * @property string $id
 * @property string $order_id
 * @property string $product_id
 * @property string $name
 * @property double $price
 * @property integer $qty_item
 * @property double $sum_item
 */
class OrderItems extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_items';
    }
	
	public function getOrder(){
		return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'name', 'price', 'qty_item', 'sum_item'], 'required'],
            [['order_id', 'product_id', 'qty_item'], 'integer'],
            [['price', 'sum_item'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function saveOrderItems($items, $order_id) {
	    foreach ($items as $id => $item) {
			$order_items = new OrderItems();
		    $order_items->order_id = $order_id;
		    $order_items->product_id = $id;
		    $order_items->name = $item['name'];
		    $order_items->price = $item['price'];
		    $order_items->qty_item = $item['qty'];
		    $order_items->sum_item = $item['qty'] * $item['price'];
		    $order_items->save();
        }        	
    }
    
}
