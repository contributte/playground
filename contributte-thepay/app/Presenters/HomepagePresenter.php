<?php declare(strict_types = 1);

namespace App\Presenters;

use App\Model\PaymentMethodDTO;
use Contributte\ThePay\Helper\DataApi;
use Contributte\ThePay\Helper\IPaymentMethod;
use Contributte\ThePay\IPayment;
use Contributte\ThePay\IReturnedPayment;
use Contributte\ThePay\ReturnedPayment;
use Nette\Application\UI\Presenter;
use Tp\InvalidSignatureException;
use Tp\Payment;

class HomepagePresenter extends Presenter
{
	/**
	 * @var DataApi
	 * @inject
	 */
	public $thePayDataApi;
	/**
	 * @var IPayment
	 * @inject
	 */
	public $tpPayment;
	/**
	 * @var IReturnedPayment
	 * @inject
	 */
	public $tpReturnedPayment;

	public function actionPay(int $paymentMethodId)
	{
		// TODO use exist $cartId
		$cartId = 10;
		// TODO use exist $userId
		$userId = 1;

		$payment = $this->tpPayment->create();
		assert($payment instanceof Payment);

		$payment->setMethodId($paymentMethodId);
		$payment->setValue(1000.0);
		$payment->setCurrency('CZK');
		$payment->setMerchantData((string) $cartId);
		$payment->setMerchantSpecificSymbol((string) $userId);
		$payment->setReturnUrl($this->link('//onlineConfirmation', ['cartId' => $cartId]));
		$payment->setBackToEshopUrl(
			'offlineConfirmation',
			['cartId' => $cartId]
		);

		$payment->redirectOnlinePayment($this);
	}

	public function actionOfflineConfirmation(int $cartId)
	{
		// useless for demo gateway, required for real one (like Fio, and some others)
	}

	public function actionOnlineConfirmation(int $cartId)
	{
		// TODO validate exist $cartId
		// TODO load price of cart
		$cartTotalPrice = '1000.00';

		$returnedPayment = $this->tpReturnedPayment->create();

		try {// TODO mark cart as payed, send email, ...
			if ($returnedPayment->verifySignature()) {
				if (in_array($returnedPayment->getStatus(), [
					ReturnedPayment::STATUS_OK, // we have money
					ReturnedPayment::STATUS_WAITING, // some bank method are asynchronous, using this you believe nothing go wrong, see official docs
				], true)) {
					//Demo gate don't allow active check...
					if ($this->thePayDataApi->getMerchantConfig()->isDemo()) {
						//Do not load thePayDataApi->getPayment

						if (bccomp(number_format($returnedPayment->getValue(), 2, '.', ''), $cartTotalPrice, 2) === 0) {
							// everything is ok
							// TODO mark cart as payed, send email, ...

							$this->flashMessage('Payment received using demo gateway', 'success');
						}
					}
					else {
						$paymentId = $returnedPayment->getPaymentId();
						$payment = $this->thePayDataApi->getPayment($paymentId);

						if (bccomp(number_format($payment->getPayment()->getValue(), 2, '.', ''), $cartTotalPrice, 2) === 0) {
							// everything is ok
							// TODO mark cart as payed, send email, ...

							$this->flashMessage('Payment received', 'success');
						}
					}
				}
				else {
					$this->flashMessage('Payment not received, status ' . $returnedPayment->getStatus() . '. See constants ReturnedPayment::STATUS_*', 'error');
				}
			}
		} catch (InvalidSignatureException $e) {
			// TODO handle invalid request signature

			$this->flashMessage('Invalid payment signature', 'error');
		}

		$this->redirect('default');
	}

	public function renderListMethods()
	{
		$template = $this->getTemplate();
		$paymentMethods = [];

		foreach ($this->thePayDataApi->getPaymentMethods()->getMethods() as $_paymentMethod) {
			$paymentIcon = $this->thePayDataApi->getPaymentMethodIcon($_paymentMethod, '209x127');
			$isPaymentByCard = $_paymentMethod->getId() === IPaymentMethod::CREDIT_CARD_PAYMENT_ID;
			$paymentName = $_paymentMethod->getId();

			$paymentMethods[$_paymentMethod->getId()] = new PaymentMethodDTO(
				$_paymentMethod->getName(),
				$paymentIcon,
				$isPaymentByCard
			);
		}

		$template->paymentMethods = $paymentMethods;
	}
}
