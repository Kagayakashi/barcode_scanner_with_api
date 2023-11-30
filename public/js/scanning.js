function play_sound() {
  ion.sound({
    sounds: [
      {name: "computer_error"}
    ],
  
    // main config
    path: "sounds/",
    preload: true,
    multiplay: true,
    volume: 0.1 // default volume is 10%
  });
  ion.sound.play("computer_error", {
    volume: 1
  });
  
  navigator.vibrate(300);
}

function ajax_simbase_api($code) {
  console.log('trying to send - ' + $code)
  if($code == 'undefined' || $code == null || $code == '') { return; }
  
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      set_basic_data(this.responseText);
    }
  };
  xhttp.open("GET", "/?ajax=1&action=get_data&code=" + $code, true);
  xhttp.send();
}

function ajax_simbase_api_error($text) {
  console.log($text);
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "/?ajax=1&action=error&error_text=" + $text, true);
  xhttp.send();
}

function set_basic_data($data) {
  data = JSON.parse($data);
  
  if(data.item_ean13 == 'undefined' || data.item_ean13 == null || data.item_ean13 == '') {
    document.getElementById('item_ean13').value = '';
    document.getElementById('item_name').value = '';
    document.getElementById('item_part').value = '';
    document.getElementById('item_base').value = '';
    document.getElementById('item_date').value = '';
    document.getElementById('item_img').src = '';
    
    document.getElementById('details_block').style.display = 'none';
    alert('Изделие не найдено!');
    return;
  }
  
  document.getElementById('item_ean13').value = data.item_ean13;
  document.getElementById('item_name').value = data.item_name;
  document.getElementById('item_part').value = data.item_part;
  document.getElementById('item_base').value = data.item_base;
  document.getElementById('item_date').value = data.item_date;
  if(data.item_image != 'null') {
    document.getElementById('item_img').src = 'data:image/png;base64,' + data.item_image;
  }
  else {
    document.getElementById('item_img').src = '';
  }
  
  document.getElementById('details_block').style.display = 'block';
  
  sessionStorage.setItem('item_ean13', data.item_ean13);
}

window.addEventListener('load', function () {
    
  ajax_simbase_api_error(get_device_info());
    
  ajax_simbase_api(sessionStorage.getItem('item_ean13'));
  
  ean13 = document.getElementById('item_ean13');
  ean13.addEventListener('change', function() {
    if(ean13.value.length == 13) {
      // EAN13 autorecalc
      ajax_simbase_api(ean13.value);
    }
  });
  
  let selected_device_id;
  const formats = [
    //ZXing.AZTEC,
    //ZXing.CODABAR,
    //ZXing.BarcodeFormat.EAN_8,
    ZXing.BarcodeFormat.EAN_13
    //ZXing.BarcodeFormat.CODE_39,
    //ZXing.BarcodeFormat.CODE_93,
    //ZXing.BarcodeFormat.CODE_128,
    //ZXing.DATA_MATRIX,
    //ZXing.ITF,
    //ZXing.MAXICODE,
    //ZXing.PDF_417,
    //ZXing.RSS_14,
    //ZXing.RSS_EXPANDED,
    //ZXing.UPC_A,
    //ZXing.UPC_E,
    //ZXing.UPC_EAN_EXTENSION,
    //ZXing.BarcodeFormat.QR_CODE
  ]
  const hints = new Map()
  hints.set(ZXing.DecodeHintType.POSSIBLE_FORMATS, formats)

  const code_reader = new ZXing.BrowserMultiFormatReader(hints)
  
  // Выбрать заднюю камеру
  code_reader.listVideoInputDevices().then(videoInputDevices => {
    videoInputDevices.forEach(device => {
      if(!device.label.indexOf('front')) {
        selected_device_id = device.deviceId;
        throw BreakException;
      }
    });
  })
  .catch((err) => {
    //
  })

  code_reader.decodeFromVideoDevice(selected_device_id, 'video', (result, err) => {
    if (result) {
      console.log(result)
      if(result.text.length == 13){
        console.log('It is ean13')
        if(ean13.value != result.text) {
          console.log('Sending to API...')
          play_sound();
          ajax_simbase_api(result.text);
        }
      }
    }
    if (err && !(err instanceof ZXing.NotFoundException)) {
      //
    }
  })
})
