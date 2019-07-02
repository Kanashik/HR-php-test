<?php
namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Статусы заказов.
 *
 * @package App\Enums
 */
class OrderStatus extends Enum
{
	const NEW = 0;
	const CONFIRMED = 10;
	const COMPLETED = 20;
}