WCF.JCoins = { };

WCF.JCoins.Transfer = Class.extend({
	/**
	 * action proxy
	 * @var	WCF.Action.Proxy
	 */
	_proxy: null,
	_userID: null,
	init: function(userID, link) {
		this._proxy = new WCF.Action.Proxy({
			showLoadingOverlay: true
		});
                
                    var clicks = 0;
                    var _this = this; 
                    $('#transferButton').live({
                      click: function() {
                        node = $(this);
                        clicks++;
                        if (clicks == 1) {
                          setTimeout(function() {
                            if(clicks == 1) {
                              window.location=link;
                            } else {
                                _this._click();
                            }
                            clicks = 0;
                          }, 300);
                        }
                      }      
                    });
	}, 
	
	_click: function() {
		this._proxy.setOption('data', {
			actionName: 'mark',
			className: 'wcf\\action\\TransferMarkUserAction',
			objectIDs: [ this._userID ]
		});
		
		this._proxy.sendRequest();
	}
});

WCF.JCoins.Buy = Class.extend({
	/**
	 * action proxy
	 * @var	WCF.Action.Proxy
	 */
	_proxy: null,
	_premiumGroupID: null,
	
	init: function(premiumGroupID) {
		this._premiumGroupID = premiumGroupID;
		
		this._proxy = new WCF.Action.Proxy({
			failure: $.proxy(this._failure, this),
			showLoadingOverlay: true,
			success: $.proxy(this._success, this)
		});
                
		$('#buyPremiumGroupButton'+premiumGroupID).click($.proxy(this._click, this));
	},
	
	_click: function(event) {
		this._proxy.setOption('data', {
			actionName: 'buyGroup',
			className: 'wcf\\data\\jCoins\\premiumGroup\\PremiumGroupAction',
			objectIDs: [ this._premiumGroupID ]
		});
		
		this._proxy.sendRequest();
	},
	
	_success: function(data, textStatus, jqXHR) {
		var $notification = new WCF.System.Notification('data.returnValues.successMessage');
		$notification.show();
	},
	
	_failure: function(data, textStatus, jqXHR) {
		var $notification = new WCF.System.Notification('data.returnValues.falseMessage');
		$notification.show();
	}
});