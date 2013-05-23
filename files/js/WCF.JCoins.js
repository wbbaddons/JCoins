/**
 * WCF.JCoins is a class, which contains a collection of functions for
 * the 'de.joshsboard.jCoins'-package.
 * 
 * @author 		Joshua Ruesweg
 * @copyright	JoshsBoard 2013
 * @package		de.joshsboard.jCoins	
 */
WCF.JCoins = { };

/**
 * Handles clicks on 'buyPremiumGroupButton'.
 */
WCF.JCoins.Buy = Class.extend({
	/**
	 * action proxy
	 * @var	WCF.Action.Proxy
	 */
	_proxy: null,
	
	/**
	 * id of premium-group
	 * @var	integer
	 */
	_premiumGroupID: null,
	
	/**
	 * Creates a new object of this class.
	 */
	init: function(premiumGroupID) {
		this._premiumGroupID = premiumGroupID;
		
		this._proxy = new WCF.Action.Proxy({
			failure: $.proxy(this._failure, this),
			showLoadingOverlay: true,
			success: $.proxy(this._success, this)
		});
		
		// add eventlistener
		$('#buyPremiumGroupButton'+premiumGroupID).click($.proxy(this._click, this));
	},
	
	/**
	 * Sends request after clicking on a button.
	 */
	_click: function(event) {
		this._proxy.setOption('data', {
			actionName: 'buyGroup',
			className: 'wcf\\data\\jCoins\\premiumGroup\\PremiumGroupAction',
			objectIDs: [ this._premiumGroupID ]
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
		var $notification = new WCF.System.Notification(data.returnValues.successMessage);
		$notification.show();
	},
	
	/**
	 * Shows a notification on failure.
	 * @param	object		data
	 * @param	string		textStatus
	 * @param	jQuery		jqXHR
	 */
	_failure: function(data, textStatus, jqXHR) {
		var $notification = new WCF.System.Notification(data.returnValues.falseMessage);
		$notification.show();
	}
});