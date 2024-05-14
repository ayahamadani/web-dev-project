function addProductToArray() {
  var selectedProducts = [];
  var checkboxes = document.getElementsByClassName("remove-checkbox");
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      selectedProducts.push(checkboxes[i].value);
    }
  }
  console.log(selectedProducts); // You can see the array in the browser console
}
