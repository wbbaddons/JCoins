/**
 * WCF.JCoins is a class, which contains a collection of functions for
 * the 'de.joshsboard.jCoins'-package.
 * 
 * @author 		Joshua Ruesweg
 * @copyright		JoshsBoard 2013
 * @package		de.joshsboard.jCoins	
 */
WCF.JCoins = {};
WCF.JCoins.Shop = {};

/**
 * Handles shopping
 */
WCF.JCoins.Shop.Buy = Class.extend({
	/**
	 * action proxy
	 * @var	WCF.Action.Proxy
	 */
	_proxy: null,
	_container: null,
	/**
	 * Creates a new object of this class.
	 */
	init: function(container) {
		this._container = container;

		this._proxy = new WCF.Action.Proxy({
			success: $.proxy(this._success, this)
		});

		this._container.each($.proxy(function(index, container) {
			$(container).find('.buttonBuy').click($.proxy(this._buy, this));
		}, this));
		
		this._container.each($.proxy(function(index, container) {
			$(container).find('.buttonBought').click($.proxy(this._bought, this));
		}, this));
	},
	
	/**
	 * Sends request after clicking on a button.
	 */
	_buy: function(event) {
		var $button = $(event.target);
		var $itemID = $button.data('itemID');

		this._proxy.setOption('data', {
			actionName: 'buy',
			className: 'wcf\\data\\jcoins\\shop\\item\\JCoinsShopItemAction',
			objectIDs: [$itemID]
		});

		this._proxy.sendRequest();
	},
	
	/**
	 * Sends request after clicking on a button.
	 */
	_bought: function(event) {
		var $button = $(event.target);
		var $itemID = $button.data('itemID');

		this._proxy.setOption('data', {
			actionName: ('bought'),
			className: 'wcf\\data\\jcoins\\shop\\item\\JCoinsShopItemAction',
			objectIDs: [$itemID]
		});

		this._proxy.sendRequest();
	},
	
	/**
	 * Shows a notification on success.
	 * @param	object		data
	 * @param	string		textStatus
	 * @param	jQuery		jqXHR
	 */
	_success: function(data, textStatus, jqXHR) {
		// data
		if (typeof data.returnValues.showSuccess !== 'undefined' && data.returnValues.showSuccess) {
			var $notification = new WCF.System.Notification(WCF.Language.get('wcf.global.success'));
			$notification.show();
		}
		
		if (typeof data.returnValues.location !== 'undefined') {
			window.location.href = data.returnValues.location;
		}
	}
});