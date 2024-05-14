// Assigning the regex variables
const sku_regex = /^(?=.*\d)(?=.*[A-Z])[A-Z\d]{8}$/,
  name_regex = /^[A-Za-z]?[A-Za-z0-9-_]{3,15}$/,
  price_regex = /^(?:[1-9]\d*(?:\.\d{2})?)$/,
  hwl_regex = /^[0-9]*$/;

// Assigning the input and saveBtn variables
const sku_input = document.getElementById("sku"),
  name_input = document.getElementById("name"),
  price_input = document.getElementById("price"),
  size_input = document.getElementById("size"),
  weight_input = document.getElementById("weight"),
  height_input = document.getElementById("height"),
  width_input = document.getElementById("width"),
  length_input = document.getElementById("length"),
  saveBtn = document.getElementById("saveBtn"),
  sku_error_msg = document.getElementById("sku_error_msg"),
  name_error_msg = document.getElementById("name_error_msg"),
  price_error_msg = document.getElementById("price_error_msg"),
  size_error_msg = document.getElementById("size_error_msg"),
  weight_error_msg = document.getElementById("weight_error_msg"),
  height_error_msg = document.getElementById("height_error_msg"),
  width_error_msg = document.getElementById("width_error_msg"),
  length_error_msg = document.getElementById("length_error_msg"),
  cancelBtn = document.getElementById("cancelBtn"),
  add_form = document.getElementById("addForm");

// Assigning a variable for the value of the switch, furnitureField, bookField, and dvdField
var type = document.getElementById("productType"),
  furnitureField = document.getElementById("furnitureField"),
  bookField = document.getElementById("bookField"),
  dvdField = document.getElementById("dvdField");

// Assigning a variable to keep the selected option selected
let selectedType = "";

// Adding the showFields function
const showFields = () => {
  // Hiding the fields upon selecting a different type
  furnitureField.style.display = "none";
  bookField.style.display = "none";
  dvdField.style.display = "none";

  // Displaying fields based on selection
  const selected = type.value;
  if (selected === "Furniture") {
    // Display the message if the height input regex is wrong
    height_input.addEventListener("blur", () => {
      const hasValidValue = hwl_regex.test(height_input.value);
      const isEmptyValue = height_input.value === "";

      height_regex_msg.style.display =
        !hasValidValue && !isEmptyValue ? "block" : "none";
      height_error_msg.style.display = isEmptyValue ? "block" : "none";
    });

    // Display the message if the width input regex is wrong
    width_input.addEventListener("blur", () => {
      const hasValidValue = hwl_regex.test(width_input.value);
      const isEmptyValue = width_input.value === "";

      width_regex_msg.style.display =
        !hasValidValue && !isEmptyValue ? "block" : "none";
      width_error_msg.style.display = isEmptyValue ? "block" : "none";
    });

    // Display the message if the length input regex is wrong
    length_input.addEventListener("blur", () => {
      const hasValidValue = hwl_regex.test(length_input.value);
      const isEmptyValue = length_input.value === "";

      length_regex_msg.style.display =
        !hasValidValue && !isEmptyValue ? "block" : "none";
      length_error_msg.style.display = isEmptyValue ? "block" : "none";
    });

    // Display the furniture field
    furnitureField.style.display = "block";
    // Reassigning the selectedType var
    selectedType = "furniture";
  } else if (selected === "Book") {
    // Display the message if the weight input regex is wrong
    weight_input.addEventListener("blur", () => {
      const hasValidValue = hwl_regex.test(weight_input.value);
      const isEmptyValue = weight_input.value === "";

      weight_regex_msg.style.display =
        !hasValidValue && !isEmptyValue ? "block" : "none";
      weight_error_msg.style.display = isEmptyValue ? "block" : "none";
    });

    // Display the book field
    bookField.style.display = "block";

    // Reassigning the selectedType var
    selectedType = "book";
  } else if (selected === "DVD") {
    // Display the message if the size input regex is wrong
    size_input.addEventListener("blur", () => {
      const hasValidValue = hwl_regex.test(size_input.value);
      const isEmptyValue = size_input.value === "";

      size_regex_msg.style.display =
        !hasValidValue && !isEmptyValue ? "block" : "none";
      size_error_msg.style.display = isEmptyValue ? "block" : "none";
    });

    // Display the dvd field
    dvdField.style.display = "block";

    // Reassigning the selectedType var
    selectedType = "dvd";
  }
};

// The JavaScript code runs after the HTML elements have fully loaded
window.addEventListener("load", () => {
  const selected = type.value;

  // Display the message if the SKU input regex is wrong
  sku_input.addEventListener("blur", () => {
    const hasValidValue = sku_regex.test(sku_input.value);
    const isEmptyValue = sku_input.value === "";

    sku_regex_msg.style.display =
      !hasValidValue && !isEmptyValue ? "block" : "none";
    sku_error_msg.style.display = isEmptyValue ? "block" : "none";
  });

  // Display the message if the name input regex is wrong
  name_input.addEventListener("blur", () => {
    const hasValidValue = name_regex.test(name_input.value);
    const isEmptyValue = name_input.value === "";

    name_regex_msg.style.display =
      !hasValidValue && !isEmptyValue ? "block" : "none";
    name_error_msg.style.display = isEmptyValue ? "block" : "none";
  });

  // Display the message if the price input regex is wrong
  price_input.addEventListener("blur", () => {
    const hasValidValue = price_regex.test(price_input.value);
    const isEmptyValue = price_input.value === "";

    price_regex_msg.style.display =
      !hasValidValue && !isEmptyValue ? "block" : "none";
    price_error_msg.style.display = isEmptyValue ? "block" : "none";
  });

  // Add functionality to cancelBtn
  cancelBtn.addEventListener("click", () => {
    window.location.replace("index.php");
  });
});

// Make the save Btn accessable only if all inputs are properly filled
