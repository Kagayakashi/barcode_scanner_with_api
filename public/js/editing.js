function get_list_data(elem) {
  val = elem.value;
  
  if(val) {
    hidden = document.getElementById(elem.id + '_id');
    hidden.value = document.querySelector("#" + elem.id + "_list option[value='" + val + "']").dataset.value;
  }
  
  elem.blur();
}

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
  
  if(data.item_ean13 == 'undefined' || data.item_ean13 == null || data.item_ean13 == '') { return; }
  
  document.getElementById('item_ean13').value = data.item_ean13;
  document.getElementById('item_name').value = data.item_name;
  document.getElementById('item_part').value = data.item_part;
  document.getElementById('item_base').value = data.item_base;
  document.getElementById('item_date').value = data.item_date;
  //if(data.item_details != 'null') {
  //  document.getElementById('item_details').textContent = data.item_details;
  //}
  if(data.item_image != 'null') {
    document.getElementById('item_img').src = 'data:image/png;base64,' + data.item_image;
  }
  else {
    document.getElementById('item_img').src = '';
  }
  document.getElementById('item_name_id').value = data.item_name_id;
  document.getElementById('item_part_id').value = data.item_part_id;
  document.getElementById('item_base_id').value = data.item_base_id;
  
  sessionStorage.setItem('item_ean13', data.item_ean13);
}

window.addEventListener('load', function () {
  ajax_simbase_api(sessionStorage.getItem('item_ean13'));
  
  item_name = document.getElementById('item_name');
  item_part = document.getElementById('item_part');
  //item_base = document.getElementById('item_base');
  
  // On Focus clear
  item_name.addEventListener('focus', function() {
    item_name.value = '';
  });
  item_part.addEventListener('focus', function() {
    item_part.value = '';
  });
  //item_base.addEventListener('focus', function() {
  //  item_base.value = '';
  //});
  
  // On change. Change hidden field - ID
  item_name.addEventListener('change', function() {
    get_list_data(item_name);
  });
  item_part.addEventListener('change', function() {
    get_list_data(item_part);
  });
  //item_base.addEventListener('change', function() {
  //  get_list_data(item_base);
  //});
})
