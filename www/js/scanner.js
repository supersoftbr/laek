function Scanner() {
	cordova.plugins.barcodeScanner.scan(
		function (result) {			
			window.location.href = result.text;
		},
		function (error) {
			alert("Scanning failed: " + error);
		},
		{
			"preferFrontCamera" 	: false, 		// iOS and Android
			"showFlipCameraButton" 	: true, 		// iOS and Android
			"prompt" 				: "", 			// supported on Android only
			"formats" 				: "QR_CODE", 	// default: all but PDF_417 and RSS_EXPANDED
			"orientation" 			: "portrait" 	// Android only (portrait|landscape), default unset so it rotates with the device
		}		
	);
}