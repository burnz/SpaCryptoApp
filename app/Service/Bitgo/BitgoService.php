<?php

namespace App\Service\Bitgo;

use App\Models\User;
use App\Models\Wallet;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BitgoService
{

	public $url = 'https://test.bitgo.com/api/v2';
	public $expressUrl = 'localhost:3080/api/v2';
	protected $client;

	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	public function createWallet(Request $request, Wallet $wallet)
	{
		try {
			$response = $this->client->request(
				'POST', $this->expressUrl . "/{$request->coin}/wallet/generate", [
					'headers' => $this->getBitgoHeaders(),
					'json' => [
						'label' => "{$wallet->label}",
						'passphrase' => "{$wallet->passphrase}"
					]
				]
			);
			
		} catch (Exception $e) {
			dd($e->getMessage());
		}

		return json_decode($response->getBody(), false);
	}

	public function listWallets()
	{
		try {
			$response = $this->client->request(
				'GET', $this->expressUrl . '/tltc/wallet', [
					'headers' => $this->getBitgoHeaders()
				]
			);
			
		} catch (Exception $e) {
			dd($e->getMessage());
		}

		return json_decode($response->getBody(), false);
	}

	public function allTransactions(Request $request, Wallet $wallet)
	{
		try {
			$response = $this->client->request(
				'GET', $this->expressUrl . "/{$wallet->coin}/wallet/{$wallet->wallet_id}/transfer", [
					'headers' => $this->getBitgoHeaders()
				]
			);
			
		} catch (Exception $e) {
			dd($e->getMessage());
		}

		return json_decode($response->getBody(), false);
	}


	public function getWallet(Request $request, Wallet $wallet)
	{
		try {
			$response = $this->client->request(
				'GET', $this->expressUrl . "/{$wallet->coin}/wallet/{$wallet->wallet_id}", [
					'headers' => $this->getBitgoHeaders()
				]
			);
			
		} catch (Exception $e) {
			dd($e->getMessage());
		}

		return json_decode($response->getBody(), false);
	}

	public function checkBalance()
	{
		
	}

	public function createWalletAddress()
	{
		try {
			$response = $this->client->request(
				'POST', $this->expressUrl . '/tltc/wallet/5e175d6f8e90d31c06b1c143ef97bd34/address', [
					'headers' => $this->getBitgoHeaders(),
					'json' => [
						'label' => 'somewalletlabel',
					]
				]
			);
			
		} catch (Exception $e) {
			dd($e->getMessage());
		}

		return json_decode($response->getBody(), false);
	}

	public function sendMoney()
	{
		try {
			$response = $this->client->request(
				'POST', $this->expressUrl . '/tltc/wallet/5e175d6f8e90d31c06b1c143ef97bd34/sendcoins', [
					'headers' => $this->getBitgoHeaders(),
					'json' => [
						'amount' => 0.01 * 1e8,
						'address' => 'QQwosoDasHs7RDYfXDaMXHtup2hszEPCFn',
						'walletPassphrase' => 'somesuperlongphraseforthewallet'
					]
				]
			);
			
		} catch (Exception $e) {
			dd($e->getMessage());
		}

		return json_decode($response->getBody(), false);
	}

	protected function getBitgoHeaders()
	{
		return [
			"Accept"     => "application/json",
			"Authorization" => "Bearer " .config('services.bitgo.secret'),
			// "Content-Type" => "application/x-www-form-urlencoded",
			// "Content-Type" => "application/json"
		];
	}

	protected function getWalletCredntials()
	{
		return json_encode([
			'label' => 'somewalletlabel',
			'passphrase' => 'somesuperlongphraseforthewallet'
		]);
	}
}