<?php
namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Order;
use App\Partner;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
	/**
	 * Отображает страницу с информацией о заказах.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Exception
	 */
	public function index()
	{
		$now = new DateTime();
		$currentOrdersTimeLimit = clone $now;
		$currentOrdersTimeLimit->add(new DateInterval('P1D'));

		$query = Order::with(['partner', 'products']);

		$ordersExpired = (clone $query)->where('delivery_dt', '<', $now->format('Y-m-d H:i:s'))
								->where('status', '=', OrderStatus::CONFIRMED)
								->orderByDesc('delivery_dt')
								->take(50)
								->get();
		$ordersCurrent = (clone $query)->where('delivery_dt', '>=', $currentOrdersTimeLimit->format('Y-m-d H:i:s'))
			->where('status', '=', OrderStatus::CONFIRMED)
			->orderBy('delivery_dt')
			->get();
		$ordersNew = (clone $query)->where('delivery_dt', '>', $now->format('Y-m-d H:i:s'))
			->where('status', '=', OrderStatus::NEW)
			->orderBy('delivery_dt')
			->take(50)
			->get();
		$ordersCompleted = (clone $query)->where('delivery_dt', '>', $now->format('Y-m-d 00:00:00'))
			->where('delivery_dt', '<=', $now->format('Y-m-d 23:59:59'))
			->where('status', '=', OrderStatus::COMPLETED)
			->orderByDesc('delivery_dt')
			->take(50)
			->get();

		return view('orders.index', [
			'ordersExpired' => $ordersExpired,
			'ordersCurrent' => $ordersCurrent,
			'ordersNew' => $ordersNew,
			'ordersCompleted' => $ordersCompleted,
		]);
	}

	/**
	 * Отображает страницу для редактирования заказа.
	 *
	 * @param Request $request Запрос
	 * @param int $id Идентификатор заказа
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Request $request, $id)
	{
		$order = Order::with('products')->findOrFail($id);
		$partners = Partner::get();

		return view('orders.edit', [
			'order' => $order,
			'partners' => $partners,
		]);
	}

	/**
	 * Обновляет данные заказа.
	 *
	 * @param Request $request Запрос
	 * @param int $id Идентификатор заказа
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'client_email' => 'required|email',
			'partner_id' => 'required|integer|exists:partners,id',
			'status' => [
				'required',
				Rule::in(OrderStatus::getValues()),
			],
		]);

		$order = Order::findOrFail($id);
		$order->client_email = $request->input('client_email');
		$order->partner_id = $request->input('partner_id');
		$order->status = $request->input('status');
		$order->save();

		return redirect()->route('orders.edit', $id)->with('status_message', 'Данные заказа успешно обновлены');
	}
}