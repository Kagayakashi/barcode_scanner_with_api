function ajax_simbase_api($code) {
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

function set_basic_data($data) {
  data = JSON.parse($data);
  
  if(data.item_ean13 == 'undefined') { return; }
  
  document.getElementById('item_ean13').value = data.item_ean13;
  document.getElementById('item_name').value = data.item_name;
  document.getElementById('item_part').value = data.item_part;
  document.getElementById('item_base').value = data.item_base;
  document.getElementById('item_date').value = data.item_date;
  if(data.item_details != 'null') {
    document.getElementById('item_details').value = data.item_details;
  }
  if(data.item_image != 'null') {
    document.getElementById('item_img').src = 'data:image/png;base64,' + data.item_image;
  }
  else {
    document.getElementById('item_img').src = '';
  }
  sessionStorage.setItem('item_ean13', data.item_ean13);
}

ajax_simbase_api(sessionStorage.getItem('item_ean13'));
