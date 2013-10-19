document.onkeydown = beono_yandexfotki_navigation;

function beono_yandexfotki_navigation(event) {
	
	if (window.event) event = window.event;
	
	if (event.ctrlKey) {
		var link = null;
		switch (event.keyCode ? event.keyCode : event.which ? event.which : null) {
		case 0x25:
			link = document.getElementById('beono_yandexfotki_prev_photo');
			break;
		case 0x27:
			link = document.getElementById('beono_yandexfotki_next_photo');
			break;
		}

		if (link && link.href) {
			if (link.getAttribute('rel') == 'ajax') {
				link.onclick();
			} else {
				document.location = link.href;
			}
		}
	}
}