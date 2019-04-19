<?php declare(strict_types = 1);

namespace App\Model;

final class PaymentMethodDTO
{

	/** @var string */
	private $paymentMethodName;
	/** @var string */
	private $paymentIcon;
	/** @var bool */
	private $isPaymentByCard;

	public function __construct(
		string $paymentMethodName,
		string $paymentIcon,
		bool $isPaymentByCard
	)
	{
		$this->paymentMethodName = $paymentMethodName;
		$this->paymentIcon = $paymentIcon;
		$this->isPaymentByCard = $isPaymentByCard;
	}

	public function getPaymentMethodName(): string
	{
		return $this->paymentMethodName;
	}

	public function getPaymentIcon(): string
	{
		return $this->paymentIcon;
	}

	public function isPaymentByCard(): bool
	{
		return $this->isPaymentByCard;
	}

}
