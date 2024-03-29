const resultBox = document.querySelector(".result-box");
const inputBox = document.getElementById("input-box");

inputBox.onkeyup = async function () {
  let result = [];

  const response = await fetch("suggestions.php");
  const data = await response.json(); // output an array

  let input = inputBox.value;

  if (input.length) {
    result = data.filter((keyword) => {
      return keyword.toLowerCase().includes(input.toLowerCase()); // correct

      //-----------------

      // let words = input.split(" ");
      // let resultendArray = words.filter((word) => {
      //   return keyword.toLowerCase().includes(word.toLowerCase());
      // });

      // (resultendArray) => {
      //   let outputArray = Array.from(new Set(resultendArray));
      //   return outputArray;
      // };

      // return _.uniq(resultendArray);

      //-------------------
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
