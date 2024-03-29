const resultBox = document.querySelector(".result-box");
const inputBox = document.getElementById("input-box");

inputBox.onkeyup = async function () {
  let result = [];

  const response = await fetch("suggestions.php");
  const data = await response.json(); // output an array

  let input = inputBox.value.trim();



  if (input.length) {

    result = data.filter((keyword) => {
      return keyword.toLowerCase().includes(input.toLowerCase()); // exact match
    });
    

    result = data.filter((keyword) => {   // complex match
      let words = input.split(" ");  
      let matchWords = words.filter((word) => {
        return keyword.toLowerCase().includes(word.toLowerCase());
      });
      return matchWords.length > 0;  
    });

    console.log(result);
  }



  display(result);

  if (!result.length) {
    result.innerHTML = "";
  }
};

// how

// how bangladesh

// how tashin rifat bangladesh
// how tashin rifat bangladesh

function display(result) {
  const content = result.map((list) => {
    return list;
  });

  resultBox.innerHTML =
    '<div class="list-group-item list-group-item-action">' +
    content.join("<br>") +
    "</div>";
}

function selectInput(list) {
  inputBox.value = list.innerHTML;
  resultBox.innerHTML = "";
}
