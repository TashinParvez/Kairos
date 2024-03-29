console.log("ASSA");

// Given string
let givenString = "This is a sample string for testing";

// Array of strings in storage
let storage = ["sample input of elements", "testing the program"];

// Split the given string into an array of words
let words = givenString.split(" ");

// Array to store matched words
let matchedWords = [];

// Check each word against the elements in the storage array
words.forEach(word => {
    // Check each element in the storage array
    storage.forEach(element => {
        // Split the element into individual words
        let elementWords = element.split(" ");
        // Check if any of the words in the element match the current word
        if (elementWords.includes(word)) {
            matchedWords.push(word);
        }
    });
});

// Output the matched words
console.log("Matched words:", matchedWords);
