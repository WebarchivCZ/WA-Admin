<?php
/**
 * Trida reprezentujici akci, pouziva se napr. pro potvrzovani mazani apod.
 */
class Action {
	private $name;
	private $message;
	private $confirmed;

	public function __construct($name)
	{
		$this->name = $name;
		$this->confirm = FALSE;
	}

	/**
	 * Funkce vraci ano, pokud je akce potvrzena
	 *
	 * @return bool
	 */
	public function isConfirmed()
	{
		return (bool)$confirmed;
	}

	/**
	 * Potvrzuje akci
	 */
	public function confirm()
	{
		$this->confirmed = TRUE;
	}

	/**
	 * Anuluje akci
	 */
	public function cancel()
	{
		$this->confirmed = FALSE;
	}

	/**
	 * Funkce nastavuje hlasku, ktera je pridruzena k akci
	 */
	public function set_message($message)
	{
		$this->message = $message;
	}

	public function get_message()
	{
		return $this->message;
	}
}

?>