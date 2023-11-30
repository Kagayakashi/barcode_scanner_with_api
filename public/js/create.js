function play_sound() {
  console.log('Notification of scanning');
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
    volume: 0.3
  });
  
  navigator.vibrate(300);
}

function get_list_data(elem) {
  val = elem.value;
  
  if(val) {
    hidden = document.getElementById(elem.id + '_id');
    hidden.value = document.querySelector("#" + elem.id + "_list option[value='" + val + "']").dataset.value;
    
    // Сохранить в сессию для переиспользования
    sessionStorage.setItem('create_' + elem.id, val);
    sessionStorage.setItem('create_' + elem.id + '_id', hidden.value);
  }
  
  elem.blur();
}

function get_prev_data() {
  item_ean13 = sessionStorage.getItem('create_item_ean13');
  if(item_ean13) {
    document.getElementById('item_ean13').value = item_ean13;
  }
  
  item_name = sessionStorage.getItem('create_item_name');
  if(item_name) {
    document.getElementById('item_name').value = item_name;
  }
  
  item_name_id = sessionStorage.getItem('create_item_name_id');
  if(item_name_id) {
    document.getElementById('item_name_id').value = item_name_id;
  }
  
  item_part = sessionStorage.getItem('create_item_part');
  if(item_part) {
    document.getElementById('item_part').value = item_part;
  }
  
  item_part_id = sessionStorage.getItem('create_item_part_id');
  if(item_part_id) {
    document.getElementById('item_part_id').value = item_part_id;
  }
  
  //item_base = sessionStorage.getItem('create_item_base');
  //if(item_base) {
  //  document.getElementById('item_base').value = item_base;
  //}
  //
  //item_base_id = sessionStorage.getItem('create_item_base_id');
  //if(item_base_id) {
  //  document.getElementById('item_base_id').value = item_base_id;
  //}
  
  //item_details = sessionStorage.getItem('create_item_details');
  //if(item_details) {
  //  document.getElementById('item_details').value = item_details;
  //}
  
  
}

window.addEventListener('load', function () {
  get_prev_data();
  
  create_form = document.getElementById('create_form');
  
  item_ean13 = document.getElementById('item_ean13');
  item_name = document.getElementById('item_name');
  item_part = document.getElementById('item_part');
  //item_base = document.getElementById('item_base');
  //item_details = document.getElementById('item_details');
  
  // Очистить поля с выподающим списком при фокусе
  item_name.addEventListener('focus', function() { item_name.value = ''; });
  item_part.addEventListener('focus', function() { item_part.value = ''; });
  //item_base.addEventListener('focus', function() { item_base.value = ''; });
  
  // Записать значение в сессию при вводе, чтоб повторно переиспользовать
  item_name.addEventListener('change', function() { get_list_data(item_name); });
  item_part.addEventListener('change', function() { get_list_data(item_part); });
  //item_base.addEventListener('change', function() { get_list_data(item_base); });
  
  item_ean13.addEventListener('change', function()   { sessionStorage.setItem('create_item_ean13', item_ean13.value); });
  //item_details.addEventListener('change', function() { sessionStorage.setItem('create_item_details', item_details.value); });
  
  create_form.addEventListener('submit', function(event) {
    if(confirm('Вы уверен, что хотите зарегистрировать изделие?') == false) {
       event.preventDefault();
       return false;
    }
    else {
       sessionStorage.setItem('item_ean13', item_ean13.value)
       return true;
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
      //document.getElementById('error').textContent = err;
  })

  code_reader.decodeFromVideoDevice(selected_device_id, 'video', (result, err) => {
    if (result) {
      console.log('Barcode scanned. Decoding..');
      console.log(result);
      if(result.text.length == 13){
        console.log('It is ean13');
        if(item_ean13.value != result.text) {
          play_sound();
          item_ean13.value = result.text;
          sessionStorage.setItem('create_item_ean13', result.text);
        }
      }
    }
    if (err && !(err instanceof ZXing.NotFoundException)) {
      //document.getElementById('error').textContent = err;
    }
  })
})
