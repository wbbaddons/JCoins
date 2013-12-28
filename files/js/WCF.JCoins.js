/**
 * WCF.JCoins is a class, which contains a collection of functions for
 * the 'de.joshsboard.jCoins'-package.
 * 
 * @author 		Joshua Ruesweg
 * @copyright		JoshsBoard 2013
 * @package		de.joshsboard.jCoins	
 */
WCF.JCoins = {};

/**
 * Handles clicks on 'buyPremiumGroupButton'.
 */
WCF.JCoins.Buy = Class.extend({
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
			$(container).find('.jsPremiumGroupButton').click($.proxy(this._click, this));
		}, this));


	},
	/**
	 * Sends request after clicking on a button.
	 */
	_click: function(event) {
		var $button = $(event.target);
		var $premiumGroupID = $button.data('premiumGroupID');
		var $isMember = $button.data('isMember');

		this._proxy.setOption('data', {
			actionName: ($isMember ? 'updateGroup' : 'buyGroup'),
			className: 'wcf\\data\\user\\group\\premium\\UserGroupPremiumAction',
			objectIDs: [$premiumGroupID]
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
		location.reload();

		var $notification = new WCF.System.Notification(WCF.Language.get('wcf.global.success'));
		$notification.show();
	}
});