<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	/**
	 * Связь с таблицей партнеров.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function partner()
	{
		return $this->belongsTo('App\Partner');
	}

	/**
	 * Связь с таблицей товаров.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function products()
	{
		return $this->belongsToMany('\App\Product', 'order_products')->withPivot('quantity', 'price');
	}

	/**
	 * Получает сумму заказа.
	 *
	 * @return int
	 */
	public function getTotalPrice()
	{
		return $this->products->sum(function ($product) {
			return $product->pivot->price * $product->pivot->quantity;
		});
	}
}
